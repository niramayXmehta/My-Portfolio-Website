<?php
    // Starting session
    session_start();
?>


<?php
/////////////////////////////////////////////////////////////////
$servername = "localhost";
$dbUser = "root";
$dbPwd = "";
$db = "miniproject";

$conn = mysqli_connect($servername, $dbUser, $dbPwd, $db);

if(!$conn)
{
    die("Failed to connect".mysqli_connect_error());
}
/////////////////////////////////////////////////////////////////

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleRules.css">
    <!--<link rel="stylesheet" type="text/css" href="reset.css">-->
    <title>Login</title>
</head>

<body>
    <?php  include('navi.php'); ?>

    <form method="POST" id="loginForm" name="loginForm">
        <fieldset class="login">
            <legend>Login</legend>
            <p>
                <label>Username</label> <br />
                <input type="text" id="username" placeholder="Username" name="username">
            </p>
            <p>
                <label>Password</label> <br />
                <input type="password" id="pwd" placeholder="Password" name="pwd">
            </p>

            <input type="button" value='Submit' id="btn" name='submitBtn' class="buttons" onClick="checkInput()">
        </fieldset>
    </form>

    <?php
    if (isset($_POST['username'])){
        $sql = "SELECT * FROM `users` WHERE username = '".$_POST["username"]."' and pwd = '".$_POST["pwd"]."'";
        $result = mysqli_query($conn, $sql);
        
        //$arrayKeys = array_values($arrayData);
        //print_r($arrayKeys);
        $count = mysqli_num_rows($result);
        ?>

    <?php    
        if($count == 0){
            echo("<br>No such user exist");
        }
        else 
        {
            $arrayData = mysqli_fetch_all($result);
            $userName = $arrayData[0][1];
            $userType = $arrayData[0][2]; // fetching the userType
            printf(' and the role is:'. $userType);

            // Storing session data
            $_SESSION["username"] = $userName;
            $_SESSION["userType"] = $userType;

            header("Location: index.php");
            exit();
        }
    }
    ?>

    <footer>
        Contact Me:
        <a href="https://www.linkedin.com/in/niramay/"><img src="images/linkedin.png" alt="linkedin" width="4%"
                height="4%"></a>
        <a href="https://www.instagram.com/oh_niramay17/"><img src="images/instagram.png" alt="instagram" width="4%"
                height="4%"></a>
        <a href="mailto://n.mehta@se21.qmul.ac.uk"><img src="images/mail.png" alt="mail" width="4%" height="4%"></a>
        <p>
            <i>Copyright &#169 2022 Niramay Mehta</i>
        </p>
    </footer>
</body>

</html>