
<!DOCTYPE html>
<div id="wrapper">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MGL Game Page</title>
    <link rel="stylesheet" href="../css/GamePage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<?php
ini_set('display_errors', '0');
include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";

if (isset($_GET["GameId"])) {
    // GameData
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Game/GameData/".$_GET["GameId"]."");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $GameData = json_decode($output, true);
    curl_close ($ch);

    // CharacterData
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Game/CharacterAndVoiceActorData/".$_GET["GameId"]."");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $CharacterAndVoiceActorData = json_decode($output, true);
    curl_close ($ch);

    // // VoiceActorData
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Game/VoiceActorData/".$_GET["GameId"]."");
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $output = curl_exec($ch);
    // $VoiceActorData = json_decode($output, true);
    // curl_close ($ch);

    // GenreData
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Game/GenreData/".$_GET["GameId"]."");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $GenreData = json_decode($output, true);
    curl_close ($ch);

    // DeveloperData
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Game/DeveloperData/".$_GET["GameId"]."");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $DeveloperData = json_decode($output, true);
    curl_close ($ch);

    // PublisherData
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Game/PublisherData/".$_GET["GameId"]."");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $PublisherData = json_decode($output, true);
    curl_close ($ch);

    //user data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/users/email/".$_SESSION["email"]."");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $GamePageUserData = json_decode($output, true);
    if (empty($SablonUserData)) {
        $username = "InvalidUser";
    }
    else {
        $username = $SablonUserData[0]["username"];
    }
    curl_close ($ch);
}
// class GameData{
//     function GetGameData($neededData)
//     {
//         global $conn;
//         $data = "SELECT $neededData FROM game WHERE game_id = "."'".$_GET["GameId"]."'"."";
//         $result = $conn->query($data);
//         $data = "";
//         while($row = $result->fetch_assoc()) {
//            $data = $row["$neededData"];
//        }
//        return $data;
//     }
//     function CheckIfItsAddedAlready()
//     {
//         global $conn;
//         $data = "SELECT game_id , email FROM gamelist WHERE game_id = "."'".$_GET["GameId"]."'"." AND email = "."'".$_SESSION["email"]."'"." ";
//         $result = $conn->query($data);
//         return mysqli_num_rows($result);
//     }
//     function GetGameCharacterData()
//     {
//         global $conn;
//         $data = "SELECT characters.* FROM gameandcharacters INNER JOIN game on game.game_id = gameandcharacters.game_id INNER JOIN characters on characters.character_id = gameandcharacters.character_id WHERE gameandcharacters.game_id = "."'".$_GET["GameId"]."'"."";
//         $result = $conn->query($data);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }

//     function GetGameVoiceActorData()
//     {
//         global $conn;
//         $data = "SELECT voice_actor.* FROM gameandcharacters INNER JOIN game on game.game_id = gameandcharacters.game_id INNER JOIN voice_actor on voice_actor.voice_actor_id = gameandcharacters.voice_actor_id WHERE gameandcharacters.game_id = "."'".$_GET["GameId"]."'"."";
//         $result = $conn->query($data);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
//
//     function GetGameGenre()
//     {
//         global $conn;
//         $data = "SELECT * FROM genre INNER JOIN genre_and_game on genre.genre_name = genre_and_game.genre_name INNER JOIN game on game.game_id = genre_and_game.game_id WHERE genre_and_game.game_id = "."'".$_GET["GameId"]."'"."";
//         $result = $conn->query($data);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
//     function GetGameDeveloper(){
//         global $conn;
//         $data = "SELECT * FROM gameanddeveloper  WHERE game_id = "."'".$_GET["GameId"]."'"."";
//         $result = $conn->query($data);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
//     function GetGamePublisher(){
//         global $conn;
//         $data = "SELECT * FROM gameandpublisher  WHERE game_id = "."'".$_GET["GameId"]."'"."";
//         $result = $conn->query($data);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
// }
// $gamedata = new GameData();

function CheckIfItsAddedAlready()
    {
        global $conn;
        $data = "SELECT * FROM gamelist WHERE game_id = "."'".$_GET["GameId"]."'"." AND email = "."'".$_SESSION["email"]."'"." ";
        $result = $conn->query($data);
        if(mysqli_num_rows($result) == 1)
        {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        else
        {
            return mysqli_num_rows($result);
        }
    }

function CheckIfItsAddedToFav()
    {
        if($_SESSION["signedUp"] != true)
        {
            return "Add to favourite";
        }
        else{
            global $conn;
            $data = "SELECT game_id , email FROM userfavgame WHERE game_id = "."'".$_GET["GameId"]."'"." AND email = "."'".$_SESSION["email"]."'"." ";
            $result = $conn->query($data);
            if(mysqli_num_rows($result) == 0)
            {
                return "Add to favourite";
            }
            else
            {
                return "Remove from favourite";
            }

        }
    }

if(isset($_POST["AddToFav"])){
    if($_SESSION["signedUp"] == true)
    {
        global $conn;
        $data = "SELECT game_id , email FROM userfavgame WHERE (game_id =  "."'".$_GET["GameId"]."'"." AND email = "."'".$_SESSION["email"]."'".") ";
        $result = $conn->query($data);
        if(mysqli_num_rows($result) == 0)
        {
            global $conn;
            $data = "SELECT email FROM userfavgame WHERE email= '{$_SESSION["email"]}' ";
            $result = $conn->query($data);
            if(mysqli_num_rows($result) == 0)
            {

                global $conn;
                $sql = "INSERT INTO userfavgame(game_id, email) VALUES ( ".$_GET["GameId"]." , "."'".$_SESSION["email"]."'"." ) ";
                if ($conn->query($sql) === TRUE)
                {

                }
            }
            else
            {
                global $conn;
                $sql = "UPDATE userfavgame SET game_id = "."'".$_GET["GameId"]."'"." WHERE email = "."'".$_SESSION["email"]."'"." ";
                if ($conn->query($sql) === TRUE)
                {

                }

            }
        }
        else{
            global $conn;
            $sql = "DELETE FROM userfavgame WHERE email = "."'".$_SESSION["email"]."'"." ";
            if ($conn->query($sql) === TRUE)
            {

            }
        }
    }
    else
    {
        header("Location: /Login");
        exit();
    }


}

if (isset($_POST["AddToList"]))
{
    if($_SESSION["signedUp"] == true)
    {
        $rating = $_POST["rating"];
        if($rating == 0)
        {
            global $conn;
            $updateList = "DELETE FROM gamelist WHERE email = '{$_SESSION['email']}' AND game_id = {$_GET["GameId"]}";
            if ($conn->query($updateList) == TRUE) {
                echo ("<script>alert('Deleted from your list');</script>");
            }
            else {
                echo ("<script>alert('Operation failed!');</script>");
            }
        }
        else if(!CheckIfItsAddedAlready())
        {
            global $conn;
            $updateList = "INSERT INTO gamelist (email , game_id , rating , status) VALUES ('{$_SESSION['email']}' ,'{$_GET["GameId"]}','{$rating}','{$_POST['statusList']}')";
            if ($conn->query($updateList) == TRUE)
            {
                echo ("<script> alert('Game has been added to your list!'); </script>");
            }
            else
            {
                echo("<script>alert('Operation failed!');</script>");
            }
        }
        else
        {
            global $conn;
            $updateList = "UPDATE gamelist SET rating = $rating , status = '{$_POST['statusList']}' WHERE email = '{$_SESSION['email']}' AND game_id = '{$_GET["GameId"]}'";
            if ($conn->query($updateList) == TRUE) {
                echo ("<script>alert('Game rating has been updated!');</script>");
            }
            else
            {
                echo ("<script>alert('Operation failed!');</script>");
            }
        }
    }
    else
    {
        header("Location:  /Login");
        exit();
    }

}
?>
 <!-- Game Table -->
<div class="GameTable">
    <!-- Game Name -->
    <div Class="GameNameWrapper">
        <?php echo $GameData[0]["game_name"]; ?>
        <!-- Ha akarjuk fejleszteni az oldalt majd akkor ez kell: <a href="#" style="float:right;" type="button" class="btn btn-primary"><i style="height:20px;"  class="fa fa-pencil" aria-hidden="true"> edit</i></a>      -->

    </div>
    <!-- Game Table Wrapper -->
    <div class="GameTableWrapper">
        <!-- Game Table Content -->
        <div class="GameContentWrapper">
            <table>
                <tbody>
                    <tr class="GameContentWrapperTr">
                        <!-- Left Side -->
                        <td class = "LeftSideContent" class="w-25 p-3">
                            <!-- Game Picture and Game Details -->
                            <div class="LeftSideContentWrapper">
                                <table>
                                    <tbody>
                                        <tr >
                                            <td >
                                                <!-- Game Picture-->
                                                <div class="GameImageDiv" >
                                                    <img src='/images/game/<?php  echo $GameData[0]["game_cover_image"];?>' class="gameimg" >
                                                </div>

                                                <!-- Game Fav-->
                                                <div class = "AddToFav">
                                                    <form action="" method="post">
                                                        <input class="FavButton" type="submit" name="AddToFav" value="<?php echo CheckIfItsAddedToFav()?>">
                                                    </form>
                                                </div>

                                                <!-- Game Details -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>


                        <!-- Right Side -->
                        <td class = "RightSideContent" class="w-75 p-3">
                            <!-- Game Datas, Add to list , trailer ...-->
                            <div class="RightSideContentWrapper">
                                <table class="RightSideTable">
                                    <tbody class="RightSideTableTbody">
                                        <!--  Add to list, trailer, Description -->
                                        <tr class="RightSideTRContentWrapper">
                                            <!--  Add to list and trailer TD -->
                                            <td Class="ListTrailerDesWrapper">
                                                <!--  Add to list and trailer DIV -->
                                                <div Class="TrailerAddToListWrapper">
                                                    <!--  Add to list -->
                                                    <div Class="AddToListAvgRatingWrapper">
                                                        <div Class="AddToListWrapper">
                                                            <div class="SelectRatingWrap">
                                                                Select rating:
                                                            </div>
                                                            <form action="" method="post">
                                                                <div class="SelectRatingSelectWrap">
                                                                    <select id="ratingList"  class="form-select form-select-sm" aria-label=".form-select-sm example" name = "rating">
                                                                    <?php
                                                                    if(CheckIfItsAddedAlready())
                                                                    {
                                                                        echo ("
                                                                        <option value=".CheckIfItsAddedAlready()[0]["rating"].">
                                                                            Current rating: ".CheckIfItsAddedAlready()[0]["rating"]."
                                                                        </option>
                                                                        <option value='0'>Remove</option>");
                                                                    }
                                                                    else{
                                                                        echo("<option value=''>Select Rating</option>");
                                                                    }
                                                                    ?>
                                                                    <option value="10">(10) Masterpiece</option>
                                                                    <option value="9">(9) Great</option>
                                                                    <option value="8">(8) Very good</option>
                                                                    <option value="7">(7) Good</option>
                                                                    <option value="6">(6) Fine</option>
                                                                    <option value="5">(5) Avarage</option>
                                                                    <option value="4">(4) Bad</option>
                                                                    <option value="3">(3) Very Bad</option>
                                                                    <option value="2">(2) Horrible</option>
                                                                    <option value="1">(1) Appalling</option>
                                                                    </select>
                                                                </div>
                                                                <div class="SelectRatingSelectStatusWrap">
                                                                    <select id="statusList" class="form-select form-select-sm" aria-label=".form-select-sm example" name ="statusList">
                                                                    <?php
                                                                    if(CheckIfItsAddedAlready())
                                                                    {
                                                                        echo ("
                                                                        <option value=".CheckIfItsAddedAlready()[0]["status"].">
                                                                            Currently: ".CheckIfItsAddedAlready()[0]["status"]."
                                                                        </option>");
                                                                    }
                                                                    ?>
                                                                    <option value="plan to play">Plan to play</option>
                                                                    <option value="playing">Playing</option>
                                                                    <option value="completed">Completed</option>
                                                                    <option value="dropped">Dropped</option>
                                                                    <option value="on hold">On hold</option>
                                                                </select>
                                                                </div>
                                                                <div class="SelectRatingSelectButtonWrap">
                                                                    <input type="submit" class="RatButton"  value="Add" name="AddToList">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="RatingWrapper">
                                                            <div class="AvgRatingWrapper">
                                                                Avarage rating:
                                                                <br>
                                                                <div class="AvgRating">
                                                                    <?php  echo $GameData[0]["game_average_rating"];?>
                                                                </div>
                                                            </div>
                                                            <div class="NumberOfRatingsWrapper">
                                                                Number of ratings:
                                                                <br>
                                                                <div class="NumberOfRatings">
                                                                    <?php  echo $GameData[0]["game_number_of_ratings"];?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!--  Trailer -->
                                                    <div class="TrailerWrapper" class="ratio ratio-16x9">
                                                        <iframe  class="GameTrailer" src="<?php  echo $GameData[0]["game_trailer"];?>" frameborder="1"></iframe>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <table class="DetailsDescripionTable">
        <tbody>
                <tr>
                    <td class="Details">
                        <h2 >Details:</h2>
                    </td>
                    <td class="Description">
                        <h2>Description:</h2>
                    </td>
                </tr>
                <tr class = "DetailsDescriptionContentWrapper">
                    <td class = "DetailsContentWrapper">
                        <div>Release date: <br><?php  echo $GameData[0]["game_release_date"];?></div>
                        <div>Publisher:
                        <?php
                            $k = 0;
                            echo('<ul class="genre_ul">');
                            while ($PublisherData[$k]["publisher_name"] != null)
                            {
                                echo('<li ><a class="genre" href="/Publisher/'.$PublisherData[$k]["publisher_id"].'">'.$PublisherData[$k]["publisher_name"].'</a></li>');
                                $k++;
                            }
                            if($GamePageUserData[0]["permission"] == "Admin")
                            {
                                echo('<li><a class="genre" href="/DataSend/Publisher/GameId-'.$_GET["GameId"].'">+ Add publisher</a></li>');
                            }
                            echo('</ul>');
                        ?>
                        </div>
                        <div>Developer:
                        <?php
                            $k = 0;
                            echo('<ul class="genre_ul">');
                            while ($DeveloperData[$k]["developer_name"] != null)
                            {
                                echo('<li ><a class="genre" href="/Developer/'.$DeveloperData[$k]["developer_id"].'">'.$DeveloperData[$k]["developer_name"].'</a></li>');
                                $k++;
                            }
                            if($GamePageUserData[0]["permission"] == "Admin")
                            {
                                echo('<li><a class="genre" href="/DataSend/Developer/GameId-'.$_GET["GameId"].'">+ Add developer</a></li>');
                            }
                            echo('</ul>');
                        ?>
                        </div>
                        <div>Status:<br><?php  echo $GameData[0]["game_status"];?></div>
                        <div>Genre:
                        <?php

                        $k = 0;
                        echo('<ul class="genre_ul">');
                        while ($GenreData[$k]["genre_name"] != null)
                        {
                            echo('<li><a class="genre" href="/Genres/'.$GenreData[$k]["genre_id"].'">'.$GenreData[$k]["genre_name"].'</a></li>');
                            $k++;
                        }
                        if($GamePageUserData[0]["permission"] == "Admin")
                        {
                            echo('<li><a class="genre" href="/DataSend/Genre/GameId-'.$_GET["GameId"].'">+ Add genre</a></li>');
                        }
                        echo('</ul>');
                        ?>
                        </div>
                    </td>
                    <td class= "DescriptionContentWrapper">
                        <?php echo $GameData[0]["game_description"]?>
                    </td>
                </tr>

        </tbody>
    </table>
<table class ="CharVoiceTable">
    <tr class='CharVoiceTableHeader'>
    <td class='Character'>Characters</td>
    <td class='VoiceActor'>Voice Actors</td>
    </tr>
</table>
<table class ="CharVoiceTable">
<?php
    $i = 0;
    while($CharacterAndVoiceActorData[$i]["character_name"] != null)
    {
        echo  '<tr class="CharVoiceTableRow">';
        echo ("<td style='width: 100px;' ><img class='Characterimage' class='ratio ratio-1x1' src='/images/character/".$CharacterAndVoiceActorData[$i]["character_picture"]."' alt=''> </td> ");
        echo("<td class='Charactername'> <div>".$CharacterAndVoiceActorData[$i]["character_name"]."</div></td >");
        if($CharacterAndVoiceActorData[$i]["voice_actor_id"] != null)
        {
            echo("<td class='VoiceActorName'><div>".$CharacterAndVoiceActorData[$i]["voice_actor_name"]."</div></td >");
            echo ("<td style='width: 100px;'><img class='VoiceActorimage' class='ratio ratio-1x1' src='/images/voiceactor/".$CharacterAndVoiceActorData[$i]["voice_actor_picture"]."' alt=''></td> ");
        }
        else if($GamePageUserData[0]["permission"] == "Admin"){
            echo('<td class="VoiceActorimage"><a class="btn btn-primary" href="/DataSend/VoiceActor/GameId-'.$_GET["GameId"].'/CharacterId-'.$CharacterAndVoiceActorData[$i]["character_id"].'" role="button">Add voice actor</a></td>');
        }
        else{
            echo('<td></td><td></td>');
        }
        echo '</tr>';
        $i++;
    }
?>
</table>
<?php
if($GamePageUserData[0]["permission"] == "Admin")
{
    print('<table >
    <tr class="CharVoiceTableRow" >
            <div style="padding-top: 10px;" class="d-grid gap-2 col-6 mx-auto" >
                <a class="btn btn-primary" href="/DataSend/Character/GameId-'.$_GET["GameId"].'" role="button">Add character</a>
            </div>
    </tr></table>');
}
?>
</div>
</div>
</body>
</html>
</div>
<div id="warning-message" class="warning">this website is only viewable in landscape mode</div>