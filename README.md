<h1>Project Title - <b>RFID</b> Attendance System with <i>Website UI</i> & <i>SQL Database</i></h1>
<p>My project is to develop a remote site low-cost <b>RFID</b> Attendance System with <i>Website UI</i> & <i>SQL Database</i></p>
<a href="https://drive.google.com/file/d/1R86DgxyE7ceJuXDggssVAlm5G_Mpak7-/view" target="_blank">> Software & <i>Entire Operation</i> Review</a> <br>
<a href="https://drive.google.com/file/d/1EaAlEutcbHNaETe_XokqCBr1suZM9gVW/view" target="_blank">> Hardware (<i>Microcontroller & Reader</i>) Review</a>
<h2>Need of the Project</h2>
<p>Since my company seeks to replace inefficient manual recording methods such as roll-calling or signing in on paper, with a reliable & accurate solution, as a system can automatically generate attendance record by using Radio Frequency Identification (RFID reader) and web application tech, instead of traditional manual records, to allow the company's frontline staff can effectively take attendance when arrived & started working on site.</p>
<h2>Project Objectives</h2>
<p>My project is to harness IoT tech, incorporating RFID tech seamlessly, to facilitate the transmission of real-time data from RFID readers to a Google application as Google Sheets for technical verification, and even a website user-interface operating in Local Server & Database. By using the interconnected nature of IoT devices and the unique identification capabilities of RFID IC cards, to implement when frontline staff tagging their cards on RFID readers, attendance records would be instantly relayed to a computer terminal through a Wi-Fi network.</p> 
<p>Also, my system would ensure the prompt generation of accurate attendance records, including time-in, time-out and duration data on the terminal interface, to provide management and HR teams with up-to-date information for pair decision-making, for example, to allow them to calculate each frontline staff’s wage conveniently.</p>
<p>Ideally, the developing cost of my attendance system would be at a cost not exceeding $200 per site. By keeping the implementation of low-cost, my company can achieve enhanced operational efficiency without incurring significant expenses and allows company’s businesses to adopt modern tracking systems without straining over budgets.</p>
<h2>System Overview</h2>
<p>My attendance system is necessary to enhance operating seamlessly through a website user- interface hosted on a simulated local server with Apache HTTP Server & MySQL Server, utilizing web make-up & programming language including PHP, CSS & JavaScript for dynamic functionality, to
facilitating effectively the automatic registration of attendance for each frontline staff.</p>
<p>My enhanced system will operate as when their individual RFID IC cards tap on the reader, the system captures the card's UID and transmits it to the ESP32 microcontroller. The microcontroller processes this data of the action. This processed data is then sent to an API written by PHP, which interfaces within the system server of web application.</p>
<p>Once received, the API would store the attendance records in a secure database. Then, the website user-interface displays real-time attendance records, showing staff-information including staff-name, staff-id, card’s UID, staff-department, date, on-duty-time, off-duty-time & duration between on-duty-time & off-duty-time in an organized format, so that my system will allow management team & HR team effectively review and track attendance records of our frontline staff daily. By integrating IoT tech with a web application, my attendance system provides a user-friendly & coordinated solution that streamlines attendance management, ensuring reliability and efficiency in record-keeping.</p>
<h2>System Deployment</h2>
<h3>Hardware Setup</h3>
<h3>Step 1: </h3>
<a href="https://www.electronicwings.com/esp32/rfid-rc522-interfacing-with-esp32" target="_blank"><i>RFID RC522 Interfacing with ESP32</i></a> 
<br>
<h3>Step 2: </h3>
<p>Connect the power supply to the ESP32 with a USB Data Cable to ensure it is powered on. Then, install the Virtual COM Port (VCP) driver to allow ESP32 activate matching with computer and functioning properly by checking in “Device Manger”.</p>
<a href="https://www.silabs.com/developer-tools/usb-to-uart-bridge-vcp-drivers?tab=downloads" target="_blank">> Download CP210x USB to UART Bridge VCP Drivers</a> 
<h3>Step 3</h3>
<p>Open Arduino IDE to setup hardware program, connect ESP32 to computer and select the appropriate COM port by going to “Tools -> -> Port. COM (4)”. COM (4) is from checking the Device Manager to identify. Then, select the NodeMCU 1.0 (ESP32 Dev Module) by clicking “Tools -> Board” and scrolling down to find it. After that, download and install the MFRC522 library and Wifi library on "Manage Library", which are essential for interfacing with the ESP32 & RFID reader. Place the libraries on the codes of the below program, that scans RFID cards, adds SSID, SSID's password and device_tokens* and an ip-address, that is found by entering ipconfig on CMD, to local server & database, and trigger attendance records while tagging cards with Wi-Fi connectivity. Finally, start uploading the program to ESP32 and the <b>Hardware Part</b> is set up!</p>
<i>* Create & Add device_token on website UI on the Software Part</i>
<h3>Software Setup</h3>
<h3>Step 1: </h3>
<a href="https://www.apachefriends.org" target="_blank">> Download XAMPP application to setup the system environment</a> 
<h3>Step 2: </h3>
<p>Launch the application, then click to start both Apache & MySQL services on the interface to enable simulated local server and database. Secondly, put all the php, css & js documents into the C:\xampp\htdocs\ directory.</p>
<h3>Step 3: </h3>
<p>Open a browser & enter the URL “127.0.0.1/rfidattendance”. The System's Login Page will be displayed, and then enter the Admin Email as admin@gmail.com, and password as 123, to access the system. Once logged in, a dashboard will be gained access, where you can manage staff, view attendance records & add cards.</p>
<h3>Step 4: </h3>
<p>On the database side, to connect the MySQL database to attendance system, enter “127.0.0.1/phpmyadmin” to reach the “phpmyadmin” page. Click on the database tab and create a new database named “rfidattendance.” After that, select the import tab, and click on the browse file button to locate the “rfidattendance.sql” file within the rfidattendance folder. Once selected, click on Go to import the SQL file. This step sets up the necessary tables and structures in the database, enabling attendance system to store and manage data effectively, and the <b>Software Part</b> is set up!</p>
<h2>Testing & Result</h2>
<h3>Step 1: </h3>
<p>On the website UI, we click and enter to Add Cards Page. Then, click the “Create Staff” Button. After that, enter Staff Name & Staff Department and finsh by clicking “Create new Card”. Then, the page generates a unique Card UID, which will be displayed in the list along with other staff details.</p>
<h3>Step 2: </h3>
<p>Copy one Card UID from the displayed list and paste it into the device_tokens section of your ESP32 program, also enter Wi-Fi SSID and password. Then, open the Command Prompt (CMD) and type “ipconfig” to find own computer’s private IP address. Paste this IP address to update the URL of the triggering API within the program. Finally, click the right arrow icon to upload the updated code to the ESP32, enabling it to communicate with API.</p>
<h3>Step 3: </h3>
<p>After uploading the program to the ESP32, open the Serial Monitor and reset the ESP32. Once it successfully connects to Wi-Fi, hold an RFID IC card and tag it on the RFID RC522 Reader. Monitor the Serial output to verify if the Card UID is matched from the generated list and is allowed for use. If authorized, return to the website UI and navigate to the Manage Staff Page. If the UID from RFID IC card is generated, we can add new staff members or update existing staff information by entering details.</p>
<h3>Step 4: </h3>
<p>When completing the staff information updates, navigate back to the Add Cards Page and click the “Active” button to activate the staff. Next, tag the same RFID card on the reader to generate attendance records. Monitor the Serial output for a response if the card is authorized. If allowed, the system will display attendance details, including the staff’s name, ID, department, and on-duty times on the Staff Attendance Page. To mark off-duty times, tag the card a second time. The system will then calculate and display the duration between the two times. In summary, my system is successfully created and achieved operating to make real-time attendance records for all frontline staff & provide management and HR teams with up-to-date information for pair decision-making.</p>
<a href="https://drive.google.com/file/d/1R86DgxyE7ceJuXDggssVAlm5G_Mpak7-/view" target="_blank">> Testing Demo Video </a> 
<h2>Conclusion</h2>
<p>My system offers a robust solution for efficient attendance management. By integrating RFID technology, the system ensures accurate tracking of staff attendance while maintaining a user-friendly interface. My system will empower my company’s management & HR team with real-time attendance tracking, streamlining operations and enhancing efficiency for frontline-staff, management & HR team. Overall, my system successfully gives a reliable solution for modern attendance management needs.</p>
