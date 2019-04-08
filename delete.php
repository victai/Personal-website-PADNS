<?php
    include 'connect.php';
    $conn = OpenCon();
    $id = $_GET['id'];
    $data = $conn->query("select * from guest where guestID = $id");
    $right_user = 0;
    while ($row = $data->fetch_array()) {
        foreach ($row as $field => $value) {
            if (isset($_COOKIE['unique_ID']) AND $_COOKIE['unique_ID'] == $value) {
                $right_user = 1;
            }
        }
    }
    if ($right_user == 1) {
        $conn->query("delete from guest where guestID = '$id'");
        echo "deleted";
    }
    else {
        echo "NICE TRY<br>";
        echo "<script type='text/javascript'> alert('nono'); </script>";
    }
    header("location:message_board.php");
?>
