<?php
    include('dbconnection.php');

    $email = $name = $password = $cpassword = "";
    $nameError = $emailError = $passwordError = $cpasswordError = "";

    if (isset($_POST['submit'])) {

        if ($_POST['name'] == "") $nameError = "name is required!";
        else {
            $name = $_POST['name'];
        }

        $emailError = validateEmail($connection, $_POST['email']);
        if ($emailError == "") $email = $_POST['email'];

        if ($_POST['password'] == "") $passwordError = "password is required!";
        else {
            $password = $_POST['password'];
        }

        if ($_POST['cpassword'] == "") $cpasswordError = "confirm is required!";
        else if ($_POST['cpassword'] != $_POST['password']) {
            $cpasswordError = "password not match!";
        }
        else {
            $cpassword = $_POST['cpassword'];
        } 


        if ($nameError =="" && $emailError == "" && $passwordError == "" && $cpasswordError=="") {
            if(addUser($connection, $name, $email, $password)) {
                header('location: index.php');
                exit();
            };
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
    <title>Register</title>
</head>
<body>
    <?php include('header.html') ?>

    <div class="container">   
        <form action="register.php" method="post">
        <h2>Register page</h2>
            <div class="input-box">
                <label for="email">Email</label>
                <input type="text" name="email">
                <small><?php echo $emailError ?></small>
            </div>
            <div class="input-box">
                <label for="name">Profile name</label>
                <input type="text" name="name">
                <small><?php echo $nameError ?></small>
            </div>
            <div class="input-box">
                <label for="password">Password</label>
                <input type="password" name="password">
                <small><?php echo $passwordError ?></small>
            </div>
            <div class="input-box">
                <label for="cpassword">Confirm password</label>
                <input type="password" name="cpassword">
                <small><?php echo $cpasswordError ?></small>
            </div>
            <div class="btns">
                <button type="submit" name="back">Back to home</button>
                <button type="submit" name="submit">Register</button>
            </div>
            
        </form>

    </div>

    <?php include('footer.html'); ?>

</body>
</html>

<?php
    function validateEmail($connection, $email) {
        if ($email == "") return"Email is required!";
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Invalid email format!";
        else {
            $query = "select * from friends where email = '$email'";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result)>0) {
                return "Email already exists!";
            }
        }
        return "";
    }

    function addUser($connection, $n, $e, $p) {
            $query = "insert into friends (email, password, name) values ('$e', '$p', '$n')";
            $result = mysqli_query($connection, $query);
            return $result;
    }
?>