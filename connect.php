<?php
    function OpenCon() {
        $dbhost = "127.0.0.1";
        $dbuser = "phpmyadmin";
        $dbpass = "b04902105";
        $db = "guest";

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $db);# or die("Connect failed: %s\n", $conn->error);
        if (!$conn) {
            echo "failed";
        }
        return $conn;
    }

    function CloseCon($conn) {
        $conn->close();
    }
?>
