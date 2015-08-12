<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["name"] = test_input($_POST["name"]);
    $_SESSION["pass"] = test_input($_POST["pass"]);
    $_SESSION["database"] = "eos";
    $conn = new mysqli("localhost", $_SESSION["name"], $_SESSION["pass"], $_SESSION["database"]);

    if ($conn->connect_error) {
        $_SESSION["errorType"] = "invalidLogin";
        $_SESSION["errorMessage"] = "The email and password you entered don't match.";
        header("location: login.php", true, 303);
        exit();
    }


    // for two submissions with the same time stamp
    if (isset($_SESSION["hash"]) && is_array($_SESSION["hash"])) {
        if (in_array($_POST['hash'], $_SESSION["hash"])) {
            // TODO duplicate form submission-------------------------rafiner les pages derreurs
            header("location: http://androiddev101.com/404notfound");
            exit();
        } else {
            if (sizeof($_SESSION["hash"]) > 4) {
                array_shift($_SESSION["hash"]);
            }
            array_push($_SESSION["hash"], ($_POST['hash']));
        }
    } else {
        $_SESSION["hash"] = array($_POST['hash']);
    }
    header("location: inventory.php", true, 303);
    $conn->close();

}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
