<?php
include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/login.css">
</head>
<body> 

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form method="post" class="box">
                    <h1>Login</h1>
                    <p class="text-muted"> Please enter your email and password.</p> 
                    <input type="text" name="email" id="email" placeholder="Email" autocomplete="off"> 
                    <input type="password" name="password" id = "password" placeholder="Password" autocomplete="off"> 
                    <input type="button"  name = "loginbutton" id = "loginbutton" value="Login" autocomplete="off">
                    <a href="signUp.php">Sign up</a>
                </form>
                
            </div>
        </div>
    </div>
</div>

<script>
    $('#loginbutton').click(function(evt) {
        var email = $('#email').val();
        var password = $('#password').val();
        if(email!="" && password!="" ){
            $.ajax({
                url: 'loginPost.php',
                type: 'POST',
                data: {
                    email: email,
                    password: password
                },
                cache: false,
                success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            location.href = "/";						
                        }
                        else if(dataResult.statusCode==201){
                            alert("Email or password doesn't match");
                        }
                    }     
            });
        }
        else{
        alert('Please fill all the field !');
        }
        evt.stopImmediatePropagation();
    });
</script>
</body>
</html>
