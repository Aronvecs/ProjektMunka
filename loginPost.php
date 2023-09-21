<?php
session_start();

if (CheckLogInInfo($_POST['email'], $_POST['password'])) {
    $_SESSION["signedUp"] = true;
    $_SESSION["email"] = $_POST['email'];
    echo json_encode(array("statusCode"=>200));
}
else{
    echo json_encode(array("statusCode"=>201));
}


function CheckLogInInfo($email, $password){
    $conn = mysqli_connect("localhost","root","",'nagyprojekt');
    $password = md5($password);
    $sql = "SELECT email, passwords FROM users WHERE email = '$email' AND passwords = '$password'";
    return mysqli_num_rows($conn->query($sql));
}
?>