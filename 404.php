
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Error - Page Not Found</title>
    <style>
        .Error404{
    z-index: 1;
    margin: 0;
    position: absolute;
    width: 100%;
    left: 0;
    top: 50%;
    transform: translateY(-50%);     
    text-align: center;
    font-size: 90px;
    color: rgba(229, 25, 28, 1);
    text-shadow: 0 0 5px black,
                0 0 5px black,
                0 0 5px black,
                0 0 5px black;

}
    </style>
    <?php
        include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";
    ?>
</head>
<body>  
<div class="Error404">
    <div>
        404
    </div>
    <div>
        PAGE NOT FOUND
    </div>
</div> 
</body>
</html>
