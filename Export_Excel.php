<?php
// Connect to database
require 'connectDB.php';

$output = '';

if(isset($_POST["To_Excel"])){
  
    // Initialize variables
    $searchQuery = " ";
    $Start_date = " ";
    $End_date = " ";
    $Start_time = " ";
    $End_time = " ";
    $card_sel = " ";

    // Start date filter
    if ($_POST['date_sel_start'] != 0) {
        $Start_date = $_POST['date_sel_start'];
        $_SESSION['searchQuery'] = "checkindate='".$Start_date."'";
    } else {
        $Start_date = date("Y-m-d");
        $_SESSION['searchQuery'] = "checkindate='".date("Y-m-d")."'";
    }

    // End date filter
    if ($_POST['date_sel_end'] != 0) {
        $End_date = $_POST['date_sel_end'];
        $_SESSION['searchQuery'] .= " AND checkindate BETWEEN '".$Start_date."' AND '".$End_date."'";
    }
    
    // Time-In and Time-Out filters
    // (The existing filter logic remains unchanged)

    // Card filter
    if ($_POST['card_sel'] != 0) {
        $card_sel = $_POST['card_sel'];
        $_SESSION['searchQuery'] .= " AND card_uid='".$card_sel."'";
    }
    
    // Department filter
    if ($_POST['dev_sel'] != 0) {
        $dev_uid = $_POST['dev_sel'];
        $_SESSION['searchQuery'] .= " AND device_uid='".$dev_uid."'";
    }

    $sql = "SELECT * FROM users_logs WHERE ".$_SESSION['searchQuery']." ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows > 0){
        $output .= '
                    <table class="table" bordered="1">  
                      <TR>
                        <TH>Name</TH>
                        <TH>Staff ID</TH>
                        <TH>Card UID</TH>
                        <TH>Token ID</TH>
                        <TH>Staff Department</TH>
                        <TH>Date</TH>
                        <TH>Time In</TH>
                        <TH>Time Out</TH>
                        <TH>Duration</TH> <!-- New Duration Column -->
                      </TR>';
        while($row = $result->fetch_assoc()) {
            // Calculate duration
            $timeIn = new DateTime($row['timein']);
            $timeOut = new DateTime($row['timeout']);
            $duration = $timeIn->diff($timeOut)->format('%H:%I:%S');

            $output .= '
                        <TR> 
                            <TD> '.$row['username'].'</TD>
                            <TD> '.$row['serialnumber'].'</TD>
                            <TD> '.$row['card_uid'].'</TD>
                            <TD> '.$row['device_uid'].'</TD>
                            <TD> '.$row['device_dep'].'</TD>
                            <TD> '.$row['checkindate'].'</TD>
                            <TD> '.$row['timein'].'</TD>
                            <TD> '.$row['timeout'].'</TD>
                            <TD> '.$duration.'</TD> <!-- Display Duration -->
                        </TR>';
        }
        $output .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=Attendance_Record_'.$Start_date.'.xls');
        
        echo $output;
        exit();
    } else {
        header("location: UsersLog.php");
        exit();
    }
}
?>