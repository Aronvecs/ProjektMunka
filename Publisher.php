<?php
ini_set('display_errors', '0');
include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";    

// Publisher Data
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Publisher/".$_GET["Publisher"]."");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
$PublisherData = json_decode($output, true);
curl_close ($ch);

 // Related Games Data
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/RelatedGames/Publisher/".$_GET["Publisher"]."");
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $output = curl_exec($ch);
 $RelatedGamesData = json_decode($output, true);
 curl_close ($ch);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MGL Publisher</title>
    <link rel="stylesheet" href="../css/DeveloperPublisher.css">
</head>
<body>
    <table class="Table">
        <tbody>
            <tr>
                <td >
                    <h1 class="Name">
                        <?php echo $PublisherData[0]["publisher_name"];?>
                    </h1>          
                </td>   
                <td></td>      
            </tr>
            <tr class="LogoGameTr">
                <td class="LogoTd">
                    <div class="LogoDiv">
                        <img src='/images/publisher/<?php echo $PublisherData[0]["publisher_logo"];?>' class="Logo" alt="">
                    </div>
                </td>
                <td class="GameTd">
                    <div class="GameDiv">
                        Top 5 Game by the publisher:
                        <ul class="games_ul">
                        <?php 
                            $k = 0;                      
                            while ($RelatedGamesData[$k]["game_name"] != null )
                            {
                                echo('<li ><a class="game_name" href="/Game/'.$RelatedGamesData[$k]["game_id"].'">'.$RelatedGamesData[$k]["game_name"].'</a></li>');
                                $k++;
                            }                                                              
                        ?>
                        </ul>
                    </div>
                    
                </td>
            </tr>
            <tr>
                <td class="Description">
                    <h3>Description:</h3>     
                </td>
                <td></td> 
            </tr>
            <tr>
                <td class="DescriptionContent" >
                    <?php echo $PublisherData[0]["publisher_description"]?>      
                </td>
                <td></td> 
            </tr>
        </tbody>
    </table>
</body>
</html>