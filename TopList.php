<?php
include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";
if (isset($_GET["Order"])) 
{
    // OrderByNumberOfRating Data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/List/TopList/OrderByNumberOfRating");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $OrderByNumberOfRatingData = json_decode($output, true);
    curl_close ($ch);

    // OrderByNumberOfRating Data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/List//TopList/OrderByRating");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $OrderByRatingData = json_decode($output, true);
    curl_close ($ch);
}
// class TopList
// {
//     function GetGameByRating()
//     {
//         global $conn;
//         $sql = "SELECT * FROM game ORDER BY game_average_rating DESC";
//         $result = $conn->query($sql);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
//     function  GetGameByNumberOfRating()
//     {
//         global $conn;
//         $sql = "SELECT * FROM game ORDER BY game_number_of_ratings DESC";
//         $result = $conn->query($sql);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
//     // function  GetGameBy()
//     // {
//     //     global $conn;
//     //     $sql = "SELECT * FROM game ORDER BY game_avarage_rating";
//     //     $result = $conn->query($sql);
//     //     return $result->fetch_all(MYSQLI_ASSOC);
//     // }
//     // function  GetGameBy()
//     // {
//     //     global $conn;
//     //     $sql = "SELECT * FROM game ORDER BY game_avarage_rating";
//     //     $result = $conn->query($sql);
//     //     return $result->fetch_all(MYSQLI_ASSOC);
//     // }
// }
// $get = new TopList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/Lists.css">
</head>
<body>
<table class="Table">
    <tbody>
        <tr>
            <td>
                <table  >  
                    <tr class="OrderSelector">
                        <?php
                            if (isset($_GET["Order"]))
                            {
                                if($_GET["Order"] == "OrderByRating")
                                {
                                    echo('<td class="selectedtd"><a class="selected" href="/TopList/OrderByRating">Top rated games</a></td>');
                                    echo('<td><a href="/TopList/OrderByNumberOfRating">Most rated games</a></td>');
                                }
                                else if($_GET["Order"] == "OrderByNumberOfRating")
                                {
                                    echo('<td><a href="/TopList/OrderByRating">Top rated games</a></td>');
                                    echo('<td class="selectedtd"><a class="selected" href="/TopList/OrderByNumberOfRating">Most rated games</a></td>');
                                }   
                            }
                        ?>
                    </tr>
                </table>  
            </td>                 
        </tr>
        <tr>
            <td>
                <table>
                    <tr class="TableHeader">
                        <td>Rank</td>
                        <td>Cover Image</td>
                        <td>Game Title</td>
                        
                        <?php
                            if (isset($_GET["Order"])) 
                            {
                                if($_GET["Order"] == "OrderByRating")
                                {
                                    echo "<td>Avarage Rating</td>";
                                }
                                else if($_GET["Order"] == "OrderByNumberOfRating")
                                {
                                    echo "<td>Number Of Rating</td>";
                                }
                            }
                        ?>
                    </tr>
                    
                    <tr>
                        <td>
                            <?php
                            if (isset($_GET["Order"])) 
                            {
                                if($_GET["Order"] == "OrderByRating")
                                {
                                    for ($i=0; $i < count($OrderByRatingData); $i++) 
                                    { 
                                        $rank = $i+1;
                                        echo(
                                        "<tr>                                                
                                        <td><big>$rank</big></td>
                                        <td class='gameimagetd' ><a href=/Game/".$OrderByRatingData[$i]["game_id"]."><img class='gameimage'  src='/images/game/".$OrderByRatingData[$i]["game_cover_image"]."' class='mylistimage'></a></td>
                                        <td><a href=/Game/".$OrderByRatingData[$i]["game_id"].">".$OrderByRatingData[$i]["game_name"]."</a></td>
                                        <td>".$OrderByRatingData[$i]["game_average_rating"]."</td>
                                        </tr>");            
                                    }
                                }            
                                else if($_GET["Order"] == "OrderByNumberOfRating")
                                {
                                    for ($i=0; $i < count($OrderByNumberOfRatingData); $i++) 
                                    { 
                                        $rank = $i+1;
                                        echo(
                                            "<tr>                                                
                                            <td><big>$rank</big></td>
                                            <td class='gameimagetd' ><a href=/Game/".$OrderByNumberOfRatingData[$i]["game_id"]."><img class='gameimage'  src='/images/game/".$OrderByNumberOfRatingData[$i]["game_cover_image"]."' class='mylistimage'></a></td>
                                            <td><a href=/Game/".$OrderByNumberOfRatingData[$i]["game_id"].">".$OrderByNumberOfRatingData[$i]["game_name"]."</a></td>
                                            <td>".$OrderByNumberOfRatingData[$i]["game_number_of_ratings"]."</td>
                                            </tr>");   
                                    }
                                }
                            } 
                            ?>
                        </td>
                    </tr>
                </table>     
            </td>           
        </tr>   
    </tbody>     
</table>
</table>
</body>
</html>