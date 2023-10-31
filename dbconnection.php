<?php

    try {
        $connection = mysqli_connect("localhost", "root", "", "friends");
    }
    catch(mysqli_sql_exception) {
        echo 'coloud not connect!';
    }

?>