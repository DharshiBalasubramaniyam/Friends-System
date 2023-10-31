<?php
    include('dbconnection.php');
    session_start();

    $email = $password = "";
    $error = "";

    if (isset($_POST['submit'])) {

        if ($result = validateUser($connection, $_POST['email'], $_POST['password'])){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['no_of_friends'] = $row['no_of_friends'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['offset'] = 0;
            header('location: home.php');
            exit();

        }
        else {
            $error = "invalid email/password";
        }
    }

    if (isset($_POST['back'])) header('location: index.php');




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
    <?php include('header.html') ?>

    <div class="container">   
        <form action="login.php" method="post">
        <h2>Login page</h2>
            <div class="input-box">
                <label for="email">Email</label>
                <input type="text" name="email">
                <small><?php echo $error ?></small>
            </div>
            
            <div class="input-box">
                <label for="password">Password</label>
                <input type="password" name="password">
            </div>
            
            <div class="btns">
                <button type="submit" name="back">Back to home</button>
                <button type="submit" name="submit">Login</button>
            </div>
            
        </form>

    </div>

    <?php include('footer.html'); ?>

</body>
</html>

<?php

    function validateUser($con, $e, $p) {
        $query = "select * from friends where email = '$e' and password = '$p'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result)>0) {
                return $result;
            }
    }
?>