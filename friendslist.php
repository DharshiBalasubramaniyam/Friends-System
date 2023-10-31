<?php

    session_start();
    include('dbconnection.php');


    $name = strtoupper($_SESSION['name']);
    $offset=0; $next = 0; $prev = 0;

    if (isset($_GET['offset'])) {
        $offset = $_GET['offset'];
    }

    $sql = "select * from friends where id!=" . $_SESSION['id'] . 
    " and id not in ( select friend_2 from myfriends where friend_1 = "
    . $_SESSION['id'] .')' . ' limit 5' . ' offset '. $offset;

    $sql2 = "select * from friends where id!=" . $_SESSION['id'] . 
    " and id not in ( select friend_2 from myfriends where friend_1 = "
    . $_SESSION['id'] .')';

    $result = mysqli_query($connection, $sql);
    $result2 = mysqli_query($connection, $sql2);
    $all = mysqli_num_rows($result2);
    $prev = $offset-5;
    $next = $offset + 5;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My friends</title>
</head>
<body>

<?php include('header.html') ?>

    <div class="container">
        <div class="content">
            <h3><?php echo $name . "'s non friends list page" ?></h3>
            <h4><?php echo "Total number of friends " . $_SESSION['no_of_friends'] ?></h4>

            <div class="table">
                <table border="1px">
                    <?php   
                        while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>". $row['name']. "</td>   <td><a href=". "addfriend.php?f1=". $_SESSION['id'] . "&f2=" .  $row['id'] . "><button>add as friend</button></td> </tr>";
                        }
                    ?>
                </table>
            </div>
            
            <div class="btns next-prev">
                    <?php if ($offset!=0) {
                        echo "<a href='friendslist.php?offset=$prev' class='prev'><button>Prev</button></a>";
                    } ?>

                    <?php if ($all>$next) {
                        echo "<a href='friendslist.php?offset=$next' class='next'><button>Next</button></a>";
                    } ?>
            </div><br><br>
            <div class="btns">
                <a href="home.php"><button>Friends list</button></a>
                <a href="logout.php"><button>Logout</button></a>
            </div>
        </div>
    </div>
    
    <?php include('footer.html'); ?>

    
</body>
</html>