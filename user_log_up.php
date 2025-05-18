<?php  
session_start();
?>
<div class="table-responsive" style="overflow-x: initial"> 
  <table class="table">
    <thead class="table-primary">
      <tr>
        <th>Name</th>
        <th>Staff ID</th>
        <th>Card UID</th>
        <th>Department</th>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Duration</th> <!-- Added Duration Column -->
      </tr>
    </thead>
    <tbody class="table-secondary">
      <?php

        // Connect to database
        require 'connectDB.php';
        $searchQuery = " ";
        $Start_date = " ";
        $End_date = " ";
        $Start_time = " ";
        $End_time = " ";
        $Card_sel = " ";

        if (isset($_POST['log_date'])) {
          // Start date filter
          if ($_POST['date_sel_start'] != 0) {
              $Start_date = $_POST['date_sel_start'];
              $_SESSION['searchQuery'] = "checkindate='" . $Start_date . "'";
          } else {
              $Start_date = date("Y-m-d");
              $_SESSION['searchQuery'] = "checkindate='" . date("Y-m-d") . "'";
          }
          
          // End date filter
          if ($_POST['date_sel_end'] != 0) {
              $End_date = $_POST['date_sel_end'];
              $_SESSION['searchQuery'] = "checkindate BETWEEN '" . $Start_date . "' AND '" . $End_date . "'";
          }
          
          // Time-In filter
          if ($_POST['time_sel'] == "Time_in") {
            // Start time filter
            if ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] == 0) {
                $Start_time = $_POST['time_sel_start'];
                $_SESSION['searchQuery'] .= " AND timein='" . $Start_time . "'";
            } elseif ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] != 0) {
                $Start_time = $_POST['time_sel_start'];
            }
            // End time filter
            if ($_POST['time_sel_end'] != 0) {
                $End_time = $_POST['time_sel_end'];
                $_SESSION['searchQuery'] .= " AND timein BETWEEN '" . $Start_time . "' AND '" . $End_time . "'";
            }
          }
          
          // Time-out filter
          if ($_POST['time_sel'] == "Time_out") {
            // Start time filter
            if ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] == 0) {
                $Start_time = $_POST['time_sel_start'];
                $_SESSION['searchQuery'] .= " AND timeout='" . $Start_time . "'";
            } elseif ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] != 0) {
                $Start_time = $_POST['time_sel_start'];
            }
            // End time filter
            if ($_POST['time_sel_end'] != 0) {
                $End_time = $_POST['time_sel_end'];
                $_SESSION['searchQuery'] .= " AND timeout BETWEEN '" . $Start_time . "' AND '" . $End_time . "'";
            }
          }
          
          // Card filter
          if ($_POST['card_sel'] != 0) {
              $Card_sel = $_POST['card_sel'];
              $_SESSION['searchQuery'] .= " AND card_uid='" . $Card_sel . "'";
          }
          
          // Department filter
          if ($_POST['dev_uid'] != 0) {
              $dev_uid = $_POST['dev_uid'];
              $_SESSION['searchQuery'] .= " AND device_uid='" . $dev_uid . "'";
          }
        }
        
        if ($_POST['select_date'] == 1) {
            $Start_date = date("Y-m-d");
            $_SESSION['searchQuery'] = "checkindate='" . $Start_date . "'";
        }

        // SQL query to fetch logs
        $sql = "SELECT * FROM users_logs WHERE " . $_SESSION['searchQuery'] . " ORDER BY id DESC";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo '<p class="error">SQL Error</p>';
        } else {
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);
            if (mysqli_num_rows($resultl) > 0) {
                while ($row = mysqli_fetch_assoc($resultl)) {
                    // Initialize duration to 00:00:00
                    $durationFormatted = '00:00:00';

                    // Check if timeOut is valid and greater than timeIn
                    if (!empty($row['timeout'])) {
                        $timeIn = strtotime($row['timein']);
                        $timeOut = strtotime($row['timeout']);
                        
                        if ($timeOut >= $timeIn) { // Ensure timeOut is not earlier than timeIn
                            $duration = $timeOut - $timeIn; // Duration in seconds
                            $hours = floor($duration / 3600);
                            $minutes = floor(($duration % 3600) / 60);
                            $seconds = $duration % 60;
                            $durationFormatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Format as HH:MM:SS
                        }
                    }
        ?>
                  <tr>
                  <td><?php echo $row['username']; ?></td>
                  <td><?php echo $row['serialnumber']; ?></td>
                  <td><?php echo $row['card_uid']; ?></td>
                  <td><?php echo $row['device_dep']; ?></td>
                  <td><?php echo $row['checkindate']; ?></td>
                  <td><?php echo $row['timein']; ?></td>
                  <td><?php echo $row['timeout']; ?></td>
                  <td><?php echo $durationFormatted; ?></td> <!-- Display Duration -->
                  </tr>
      <?php
                }
            }
        }
        // echo $sql;
      ?>
    </tbody>
  </table>
</div>

