<?php
session_start();

if($_POST['type']==1){
    $_SESSION['username'] = $_POST["username"];
    $_SESSION['email'] = $_POST["email"];
    $_SESSION['password'] = $_POST["password"];
    $bruh = $_SESSION['password'];
    if(filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)){
        if (!UsernameIsTaken($_SESSION['username']) && !EmailIsTaken($_SESSION['email'])) {
            VerificationSend();
            echo json_encode(array("statusCode"=>200));
        }
        else{
            echo json_encode(array("statusCode"=>201));
        }
    }
    else{
        echo json_encode(array("statusCode"=>202));
    }
}
if($_POST['type']==2){
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $password = md5($_SESSION['password']);
        $date = date('Y-m-d H:i:s');
        $profile_picture = "basicprofilepicture.png";
        if ($_POST['verificationCode'] == $_SESSION["verification"]) {
            $_SESSION["signedUp"] = true;
            $conn = mysqli_connect("localhost","root","",'nagyprojekt');
            $sql = "INSERT INTO users (username, email, passwords, joined_date, profile_picture, permission) VALUES ('$username','$email','$password', '$date', '$profile_picture' , 'Basic')";
            mysqli_query($conn, $sql);
            echo json_encode(array("statusCode"=>200));
        }
        else
        {
            echo json_encode(array("statusCode"=>201));
        }
}

function EmailIsTaken($email){
    $conn = mysqli_connect("localhost","root","",'nagyprojekt');
    $sql = "SELECT email FROM users WHERE email = '$email'";
    return mysqli_num_rows($conn->query($sql));
}
function UsernameIsTaken($username){
    $conn = mysqli_connect("localhost","root","",'nagyprojekt');
    $sql = "SELECT username FROM users WHERE username = '$username'";
    return mysqli_num_rows($conn->query($sql));
}

use PHPMailer\PHPMailer\PHPMailer;
function VerificationSend(){

    $email = $_POST['email'];

    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();

    //SMTP Settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "mygamelist.help@gmail.com";
    $mail->Password = 'DkNHhdQD727CX9Q';
    $mail->Port = 465; //587
    $mail->SMTPSecure = "ssl"; //tls

    //Email Settings
    $mail->isHTML(true);
    $mail->setFrom($email, "mygamelist.com");
    $mail->addAddress($email);
    $mail->Subject = "Verifaction Code";
    $_SESSION["verification"] = rand(10000,100000);
    $mail->Body = "Your Verifaction Code: ".$_SESSION["verification"];

    $mail->send();

       
}
?>