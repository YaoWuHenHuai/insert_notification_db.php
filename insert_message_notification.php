<?php
session_start();

//the purpose is to save the address of the message content here, same we will be getting when we need it. 

//get the address_name  >> reuse it to insert message content.. 


//acse there is no session, will take user back to log in
if (!isset($_SESSION['loggedin'])); {
        header('Location: ../../../login.php');
}

///insert into db,
//log into db , please verify the user has privileges for this matter , otherwise wont work,
        echo "WIll verify bef inset not ";
        $dbserver ="domain";
        $dbusername = $_SESSION['user']; //same fomr the login
        $dbpassword = $_SESSION['password']; ///same from the login
        $dbname = "NOTIFICATIONS";
        $conn = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbname);
        if (!$conn){
                echo "not connecting, should log this right away ";
        } else {
                echo "\n connection established";
                //read number of rows, in order to give ID for message addresses,
                $LAST_ID = "SELECT MAX(id) FROM " . $dbusername . " limit 1";
                $RUN_LAST_ID = mysqli_query($conn, $LAST_ID);
                $LAST_ID_OUTPUT = mysqli_fetch_array($RUN_LAST_ID);
                echo "\n Count: " . $LAST_ID_OUTPUT[0];
                $NEW_COUNT = $LAST_ID_OUTPUT[0];
                $NEW_COUNT++;
                echo "\n " . $NEW_COUNT;

                //if want to access thisfile , is , DIR + MESSAGE_ADDRESS
                $MESSAGE_ADDRESS = $_SESSION['MariaDB_user'] . "_" . $NEW_COUNT;
                $_SESSION['message_address'] = $MESSAGE_ADDRESS;
                echo "\n message_address:" . $MESSAGE_ADDRESS;
                $code_number = "1";
                echo "\n";
                $INSERT_QUERY = "INSERT INTO " . $dbusername . "(code, datetime, content_address, DISPLAYED) VALUES("
                . "'" . $code_number . "'" . ",(SELECT CURRENT_TIMESTAMP)," . "'" . $MESSAGE_ADDRESS . "'" . ", 'NO');";
                echo $INSERT_QUERY;
                $RUN_INSERT_QUERY = mysqli_query($conn , $INSERT_QUERY);

                mysqli_close($conn);
        }
?>
