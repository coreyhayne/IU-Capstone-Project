<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if (trim($_POST['email']) != "") {
            $email = $_POST['email'];
            $_SESSION['email'] = $email;

            $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
            // Check Connection
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error() . "<br>");
            }
            $sql = mysqli_query($con,"SELECT fname FROM User WHERE email='$email';");
            
            if (mysqli_num_rows($sql) > 0){
                '<script>window.location.href = "index.php"</script>';
                header("Location: home.php");
            } else{
                '<script>window.location.href = "createUser.php"</script>';
                header("Location: createUser.php");
            }
        } else {
            header("Location: login.html");
        }

    ?>
</body>
</html>
