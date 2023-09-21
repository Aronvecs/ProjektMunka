<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["DataSend"])) {
    $_SESSION["DataSend"] = "";
}
if (!isset($_SESSION["signedUp"])) {
    $_SESSION["signedUp"] = false;
}

$conn = mysqli_connect("localhost","root","",'nagyprojekt');

if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = "";
}

if (!isset($_GET["menus"])) {
    $_GET["menus"] = "";
}

if($_GET["menus"] == "logout")
{
    session_destroy();
    header("Location: /");
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/users/email/".$_SESSION["email"]."");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
$SablonUserData = json_decode($output, true);
if (empty($SablonUserData)) {
    $username = "InvalidUser";
}
else {
    $username = $SablonUserData[0]["username"];
}
curl_close ($ch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyGameList</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
   
    <script>
    $(document).ready(function(){
        $('.search-box input[type="text"]').on("keyup input", function(){
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if(inputVal.length)
            {
                $.get("/search.php", {term: inputVal}).done(function(data)
                {
                    resultDropdown.html(data);
                });
            }
        });
    });
    </script>
    <script>
    function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    }
</script>
</head>
<body> 

    <div class="menu">
        <a href="/">
        <img src="/sablon/Mygamelist.png" class = "mgl" alt=""></a>
        <div class="search-box">
                <i class="fa fa-search" style="height: 0px;" aria-hidden="true"></i>
                <input type="text" autocomplete="off" placeholder="Search..." />
        <div class="result"></div>
        </div>
        <?php
            if($_SESSION["signedUp"] == false)
            {
                echo "<div class='profil'><a href='/Login' >Login</a> <small>or</small>  <a href='/SignUp'>Sing up</a></div>";
            }
            else
            {
                echo "<a href='/profile/".$username."'> <img class = 'pkep' src='/images/user/".$SablonUserData[0]["profile_picture"]."' class ='profilep'> </a> <a href='/profile/".$username."' class= 'profil'> ".$username."</a>";
            }
        ?>
    </div>
    <div class="main-menu">
        <nav>
                    <ul>     
                        <li>
                            <button class ="ToTheTop" onclick="topFunction()" >
                                <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                <span  class="nav-text">
                                    Click here to scroll back
                                </span>
                            </button>                                                                                            
                        </li>         
                        <li>
                            <a href="/TopList/OrderByRating" id = "topNav">
                            <i class="fa fa-trophy" aria-hidden="true"></i>
                                <span class="nav-text">
                                    Top list
                                </span>
                            </a>
                            
                        </li>
                        <li>
                            <a href="/Genres/1">
                            <i class="fa fa-tags" aria-hidden="true"></i>
                                <span class="nav-text">
                                    Genres
                                </span>
                            </a>
                        </li>                       
                        <?php
                            if($_SESSION["signedUp"] == TRUE){
                                echo('<li>
                                <a href="/MyList/'.$username.'/all">
                                <i class="fa fa-bar-chart-o fa-2x"></i>
                                    <span class="nav-text">
                                        My List
                                    </span>
                                </a>
                            </li>');
                            }
                        ?>
                        <li>
                            <a href="/DeveloperAndPublisherList/Developer">
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                                <span class="nav-text">
                                    Developers
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="/DeveloperAndPublisherList/Publisher">
                            <i class="fa fa-building-o" aria-hidden="true"></i>
                                <span class="nav-text">
                                    Publishers
                                </span>
                            </a>
                        </li>
                        <?php
                            if($_SESSION["signedUp"] == TRUE){
                                echo('<li>
                                <a href="/DataSend/Game">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    <span class="nav-text">
                                        Data Send
                                    </span>
                                </a>
                            </li>');
                            }
                        ?>
                        <?php
                        if($username != "InvalidUser" )
                        {
                            if($SablonUserData[0]["permission"] == "Admin")
                            {
                                echo('<li>
                                <a href="/ListOfUnaccepted/Game">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    <span class="nav-text">
                                        List of unaccepted data
                                    </span>
                                </a>
                            </li>');
                            }
                        }                       
                    ?>
                    </ul>
                    <?php 
                        if($_SESSION["signedUp"] == true)
                        {
                            echo('
                                <ul class="logout">
                                <li>
                                <a href="?menus=logout">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                        <span class="nav-text">
                                            Logout
                                        </span>
                                    </a>
                                </li>  
                                </ul>
                                ');                           
                        }
                        
                    ?>
                    
                </nav>
    </div>
    