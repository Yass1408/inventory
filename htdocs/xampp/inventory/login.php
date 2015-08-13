<?php
session_start();

//already connected
if (isset($_SESSION["hash"]) && is_array($_SESSION["hash"]) && empty($_SESSION["errorMessage"])) {
    header('location: inventory.php');
    exit();
}
//fatal error (MySQL error)
elseif (isset($_SESSION["errorMessage"]) && $_SESSION["errorType"] == "invalidQuery") {
    echo '<script>window.onload = function(){alert("' . $_SESSION["errorMessage"] . '");};</script>';
}
//user login error
elseif (isset($_SESSION["errorMessage"]) && $_SESSION["errorType"] == "invalidLogin") {
    echo '<script>alert("invalid username password combination!");</script>'; // TODO better login validation
}
unset($_SESSION["errorMessage"]);
unset($_SESSION["errorType"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!--    http://getbootstrap.com/examples/signin/-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="InventorIt Login Page">
    <meta name="author" content="Yassine">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="_css/signin.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="vendor/components/jquery/jquery.min.js"></script>

</head>

<body>

<div class="container">

    <form class="form-signin" method="post" action="<?php echo 'connexionProcess.php';?>">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="hidden" name="hash" id="hash" value="<?php echo microtime(); ?>" />

        <label for="inputUserName" class="sr-only">UserName</label>
        <input type="text" id="inputUserName" name="name" class="form-control" placeholder="UserName" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Password">

<!--        <div class="checkbox">-->
<!--            <label>-->
<!--                <input type="checkbox" value="remember-me"> Remember me-->
<!--            </label>-->
<!--        </div>-->
        <label id="labelError"></label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

</div> <!-- /container -->


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
</body>
</html>
