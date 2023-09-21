<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/profil.css">
    <title>Document</title>
</head>
    <body class="body">
        <?php
            function GetUserImg()
            {
                $name = $_GET["name"];
                $conn = mysqli_connect("localhost","root","","nagyprojekt");
                $profile_picture = "SELECT profile_picture FROM users WHERE username = '$name'";
                $result = $conn->query($profile_picture);
                $UserImgLink = "";
                while($row = $result->fetch_assoc()) {
                    $UserImgLink = $row["profile_picture"];
                }
                return $UserImgLink;
            }

            include("../sablon/sablon.php");
        ?>
        <div class="userTable">   
        <table class="tg">
        <tr>
            <th class = profilnev><?php echo $_GET["name"]?></th>
        </tr>
        <tr>
            <td>
                <img class=profilkep src="<?php echo GetUserImg();?>" class="userimg" alt="">
            </td>
        </tr>
        </table>
        </div>
    </body>
</html>