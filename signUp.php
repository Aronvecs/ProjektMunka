<?php
include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/signup.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form method="post" class="box">
                    <h1>Sign up</h1>
                    <input type="text" name="username" id="username" placeholder="Username" autocomplete="off">
                    <input type="email" name="email" id="email" placeholder="Email" autocomplete="off">
                    <input type="password" name="password" id="password"  placeholder="Password" autocomplete="off">
                    <p id = "instruction">*Your password must be at least 6 characters, must have at least 1 number, and must have 1 special character </p>
                    <input type="button" value="Sign up" name="signupbutton" id="signupbutton" class= "signupbutton">
                    <a href="login.php">Log in</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var strong
        $('#password').keyup(function(){
            var number = (/[0-9]/);
            var alphabets = (/[a-zA-Z]/);
            var special_characters = (/[~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<]/);
            if ($('#password').val().length < 6) 
            {
                $(this).css('color', 'red');
                strong = false;
            } 
            else 
            {
                if ($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) {
                    $(this).css('color', 'green');
                    strong = true;
                }
                else
                {
                    $(this).css('color', 'red');
                    strong = false;
                }
            }
        });

                 
        $('#signupbutton').click(function(evt) {
                        var username = $('#username').val();
                        var email = $('#email').val();
                        var password = $('#password').val();
                        if(username!="" && email!="" && password!="" ){
                            if(strong){
                            $.ajax({
                                url: 'signUpPost.php',
                                type: 'POST',
                                data: {
                                    type: 1,
                                    username: username,
                                    email: email,
                                    password: password
                                },
                                cache: false,
                                success: function(dataResult){
                                        var dataResult = JSON.parse(dataResult);
                                        if(dataResult.statusCode==200){
                                            location.href = "verify.php";						
                                        }
                                        else if(dataResult.statusCode==201){
                                            alert("Email or username is already taken!");
                                        }
                                        else if(dataResult.statusCode==202){
                                            alert("Your email address is not valid!");
                                        }
                                    }     
                            });
                        }
                        else{
                        alert("Password is not strong enough!");
                        }
                        evt.stopImmediatePropagation();
                    }
                    else{
                        alert('Please fill out all the fields!');
                    }
                    });

</script>
</body>
</html>