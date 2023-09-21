<?php
include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";
ini_set('display_errors', '0');
if (isset($_GET["Genre"])) 
{
    //Genre Data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/List/Genre");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $GenreData = json_decode($output, true);
    curl_close ($ch);

    //Genre releted game Data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/List/Genre/".$_GET["Genre"]."");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $GenreGameData = json_decode($output, true);
    curl_close ($ch);
}
// class GenreList
// {
//     function GetGameByGenre()
//     {
//         global $conn;
//         $sql = "SELECT * FROM genre INNER JOIN genre_and_game on genre.genre_name = genre_and_game.genre_name INNER JOIN game on game.game_id = genre_and_game.game_id WHERE genre.genre_name = "."'".$_GET["Genre"]."'"."";
//         $result = $conn->query($sql);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
//     function GetGenres()
//     {
//         global $conn;
//         $sql = "SELECT * FROM genre";
//         $result = $conn->query($sql);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
// }
// $get = new GenreList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/Lists.css">
</head>
<body >
<table class="Table">
    <tbody>
        <tr>
            <td>
                <table  >  
                    <tr class="OrderSelector">
                        <?php
                            if (isset($_GET["Genre"])) 
                            {
                                for($i=0;$i<count($GenreData);$i++)
                                {
                                    if($GenreData[$i]["genre_id"] == $_GET["Genre"]){
                                        echo('<td class="selectedtd"><a class="selected" href="/Genres/'.$GenreData[$i]["genre_id"].'">'.$GenreData[$i]["genre_name"].'</a></td>');
                                    }
                                    else{
                                        echo('<td><a href="/Genres/'.$GenreData[$i]["genre_id"].'">'.$GenreData[$i]["genre_name"].'</a></td>');
                                    }
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
                        <td>Cover image</td>
                        <td>Title</td>
                        <td>Rating</td>
                    </tr>
                            <?php
                                if (isset($_GET["Genre"])) 
                                {
                                    echo("");
                                        for ($i=0; $i < count($GenreGameData); $i++) 
                                        { 
                                            $rank = $i+1;
                                            echo(
                                            "<tr>                                                
                                                <td><big>$rank</big></td>
                                                <td class='gameimagetd' ><a href=/Game/".$GenreGameData[$i]["game_id"]."><img class='gameimage'  src='/images/game/".$GenreGameData[$i]["game_cover_image"]."' class='mylistimage'></a></td>
                                                <td><a href=/Game/".$GenreGameData[$i]["game_id"].">".$GenreGameData[$i]["game_name"]."</a></td>
                                                <td>".$GenreGameData[$i]["game_average_rating"]."</td>                                                
                                            </tr>");
                                        }
                                }    
                            ?>
                </table>     
            </td>           
        </tr>   
    </tbody>     
</table>


</body>
</html>