<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/verify.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form method="post" class="box">
                    <h1>Verify</h1>
                    <input type="text" name="verificationCode" id="verificationCode" placeholder="Verification Code">
                    <p id = "instruction">*An email has been sent to your inbox, please insert it in the field above</p>
                    <input type="button" value="Verify" name="signupbutton" id="signupbutton" class= "signupbutton">                    
                </form>

                <script>$('#signupbutton').click(function(evt) {
                            var verificationCode = $('#verificationCode').val();
                            if(verificationCode!="" ){
                                $.ajax({
                                    url: 'signUpPost.php',
                                    type: 'POST',
                                    data: {
                                        type: 2,
                                        verificationCode: verificationCode
                                    },
                                    cache: false,
                                    success: function(dataResult){
                                            var dataResult = JSON.parse(dataResult);
                                            if(dataResult.statusCode==200){
                                                alert("You have successfully registered");
                                                location.href = "/MainPage";						
                                            }
                                            else if(dataResult.statusCode==201){
                                                alert("Verification code is invalid");
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
            </div>
        </div>
    </div>
</div>
</body>
</html>