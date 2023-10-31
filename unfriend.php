<?php

session_start();

    include('dbconnection.php');


    if (isset($_GET['f1']) && isset($_GET['f2'])) {
            $sql2 = "delete from myfriends where friend_1 = " . $_GET['f1'] . " and friend_2 = " . $_GET['f2'];
            $result2 = mysqli_query($connection, $sql2);

            $sql3 = "select count(*) as c from myfriends where friend_1 = " . $_GET['f1'];
            $result3 = mysqli_query($connection, $sql3);
            print_r($result3);
            $n = mysqli_fetch_assoc(($result3))['c'];

            $sql4 = "update friends set no_of_friends = " . $n . " where id = " .   $_GET['f1'];
            $result4 = mysqli_query($connection, $sql4);
            $_SESSION['no_of_friends'] = $n;
            if ($result2 && $result3 && $result4) {
                header('location: home.php');
            }
        }

?>