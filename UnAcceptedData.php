<?php

include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";
include $_SERVER['DOCUMENT_ROOT']."/uploadImages.php";
$images = new Images();

//Character

//Character end

//Game

//Game end

if (isset($_GET["UnacceptedData"]) && $_SESSION["email"] !="" && isset($_SESSION["email"])) {
    if ($_GET["UnacceptedData"] == "CharacterId") {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/characters_request");
        curl_setopt($ch, CURLOPT_POST, 1);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $output = curl_exec($ch);
        $tableData = json_decode($output, true);
        if (empty($tableData)) {
            $tableData = array();
        }
        curl_close($ch);
    
        if (isset($_POST['A'.$tableData[$_GET["UDataIdx"]]["character_id"].''])) {
            if ($_POST["character_name"]) {
                $sql = "INSERT INTO characters(character_name, character_picture, character_description) 
                    VALUES ("."'".$_POST["character_name"]."'".",
                    "."'".$_POST["character_picture"]."'".", 
                    "."'".$_POST["character_description"]."'".")";
                mysqli_query($conn, $sql);
    
                if ($_FILES["character_picture_file"]['size'] != 0) {
                    $images->Upload("character", "characters_request", "character_picture_file", "character_id");
                }
    
                $sql="DELETE FROM characters_request WHERE character_id=".$tableData[$_GET["UDataIdx"]]["character_id"].".";
                mysqli_query($conn, $sql);
    
                echo "<script>window.location.href='/ListOfUnaccepted/Character';</script>";
            }
        }
        elseif (isset($_POST['R'.$tableData[$_GET["UDataIdx"]]["character_id"].''])) {
            $sql="DELETE FROM characters_request WHERE character_id=".$tableData[$_GET["UDataIdx"]]["character_id"].".";
            mysqli_query($conn, $sql);
            echo "<script>window.location.href='/ListOfUnaccepted/Character';</script>";
        }
        $data=
            '
            <div class="main-block">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="info">
                        <img class="pictures" src="/images/character/'.$tableData[$_GET["UDataIdx"]]["character_picture"].'">
                        <input value="'.$tableData[$_GET["UDataIdx"]]["character_name"].'" class="names" type="text" name="character_name" id="character_name" placeholder="Character Name">
                        <textarea rows="4" name="character_description" id="character_description" placeholder="Character description">'.$tableData[$_GET["UDataIdx"]]["character_description"].'</textarea>
                        <input type="hidden" name="character_picture" id="character_picture" value="'.$tableData[$_GET["UDataIdx"]]["character_picture"].'">
                        <input type="file" name="character_picture_file">
                    </div>
                    <div class="name">
                        <input type="submit" value="Accept" id="AcceptCharacter" name="A'.$tableData[$_GET["UDataIdx"]]["character_id"].'">
                        <input type="submit" value="Reject" id="RejectCharacter" name="R'.$tableData[$_GET["UDataIdx"]]["character_id"].'">
                    </div>
                </form>
            </div>
    
            <script src="/javascript/DataSend.js"></script>
            <script>
            $(document).ready(function(){
                $("input[type=\'file\']").change(function(e){
                    var fileName = e.target.files[0].name;
                    $("#character_picture").val(fileName);
                });
            });
            </script>
            ';
    }
    elseif ($_GET["UnacceptedData"] == "GameId") {
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/game_request");
            curl_setopt($ch, CURLOPT_POST, 1);
    
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            $output = curl_exec($ch);
            $tableData = json_decode($output, true);
            if (empty($tableData)) {
                $tableData = array();
            }
    
    
            curl_close($ch);
    
            if (isset($_POST['A'.$tableData[$_GET["UDataIdx"]]["game_id"].''])) {
                $sql = "INSERT INTO game(game_name, game_release_date, game_cover_image, game_trailer, game_description, game_status) 
                            VALUES (
                            "."'".$_POST["game_name"]."'".",
                            "."'".$_POST["game_release_date"]."'".",
                            "."'".$_POST["game_cover_image"]."'".",
                            "."'".$_POST["game_trailer"]."'".",
                            "."'".$_POST["game_description"]."'".",
                            "."'".$_POST["game_status"]."'".")";
                mysqli_query($conn, $sql);
    
                if ($_FILES["game_cover_image_file"]['size'] != 0) {
                    $images->Upload("game", "game_request", "game_cover_image_file", "game_id");
                }
    
                $sql="DELETE FROM game_request WHERE game_id=".$tableData[$_GET["UDataIdx"]]["game_id"].".";
                mysqli_query($conn, $sql);
    
                echo "<script>window.location.href='/ListOfUnaccepted/Game';</script>";
            }
            elseif (isset($_POST['R'.$tableData[$_GET["UDataIdx"]]["game_id"].''])) {
                $sql="DELETE FROM game_request WHERE game_id=".$tableData[$_GET["UDataIdx"]]["game_id"].".";
                mysqli_query($conn, $sql);
                echo "<script>window.location.href='/ListOfUnaccepted/Game';</script>";
            }
            $date=$tableData[$_GET["UDataIdx"]]["game_release_date"];
            if ($date == "0000-00-00") {
                $date = "";
            }
            $data=
            '
            <div class="main-block">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="info">
                        <img class="pictures" src="/images/game/'.$tableData[$_GET["UDataIdx"]]["game_cover_image"].'">
                        <div class="name">
                            <input value="'.$tableData[$_GET["UDataIdx"]]["game_name"].'" class="names" type="text" name="game_name" id="game_name" placeholder="Game Name">
                            <select name="game_status" id="game_status">
                                <option value="'.$tableData[$_GET["UDataIdx"]]["game_status"].'">'.$tableData[$_GET["UDataIdx"]]["game_status"].'</option>
                                <option value="Not_out_yet">Not out yet</option>
                                <option value="Out_in_early_acces">Out in early acces</option>
                                <option value="Released">Released</option>
                                <option value="Canceled">Canceled</option>
                            </select> 
                        </div>
                        <input value="'.$date.'" type="text" placeholder="Game release date" name="game_release_date" id="game_release_date" onfocus='."(this.type='date')".' onblur='."(this.type='text')".'>
                        <textarea rows="4" name="game_trailer" id="game_trailer" placeholder="Game trailer link">'.$tableData[$_GET["UDataIdx"]]["game_trailer"].'</textarea>
                        <iframe id="iframe" class="GameTrailer" src="'.$tableData[$_GET["UDataIdx"]]["game_trailer"].'" frameborder="1"></iframe>
                        <textarea rows="4" name="game_description" id="game_description" placeholder="Game description">'.$tableData[$_GET["UDataIdx"]]["game_description"].'</textarea>
    
                        <input type="hidden" name="game_cover_image" id="game_cover_image" value="'.$tableData[$_GET["UDataIdx"]]["game_cover_image"].'">
                        
                        <input type="file" name="game_cover_image_file">
                            
                    </div>
                    <div class="name">
                        <input type="submit" value="Accept" id="Gameaccept" name="A'.$tableData[$_GET["UDataIdx"]]["game_id"].'">
                        <input type="submit" value="Reject" id="Gamereject" name="R'.$tableData[$_GET["UDataIdx"]]["game_id"].'">
                    </div>
                </form>
            </div>
            <script src="/javascript/DataSend.js"></script>
            <script>
                $(document).ready(function(){
                    $("input[type=\'file\']").change(function(e){
                        var fileName = e.target.files[0].name;
                        $("#game_cover_image").val(fileName);
                    });
                    $("#game_trailer").change(function(e){
                        $("#iframe").attr("src",$("#game_trailer").val());
                    });
                });
            </script>
            ';
    }
    elseif ($_GET["UnacceptedData"] == "VoiceActorId") {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/voice_actor_request");
        curl_setopt($ch, CURLOPT_POST, 1);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $output = curl_exec($ch);
        $tableData = json_decode($output, true);
        if (empty($tableData)) {
            $tableData = array();
        }
        curl_close($ch);
    
        if (isset($_POST['A'.$tableData[$_GET["UDataIdx"]]["voice_actor_id"].''])) {
            $sql = "INSERT INTO voice_actor(voice_actor_name, voice_actor_picture, voice_actor_description) 
                    VALUES ("."'".$_POST["voice_actor_name"]."'".",
                    "."'".$_POST["voice_actor_picture"]."'".", 
                    "."'".$_POST["voice_actor_description"]."'".")";
            mysqli_query($conn, $sql);
            
            if ($_FILES["voice_actor_picture_file"]['size'] != 0) {
                $images->Upload("voiceactor", "voice_actor_request", "voice_actor_picture_file", "voice_actor_id");
            }

            $sql="DELETE FROM voice_actor_request WHERE voice_actor_id=".$tableData[$_GET["UDataIdx"]]["voice_actor_id"].".";
            mysqli_query($conn, $sql);

            echo "<script>window.location.href='/ListOfUnaccepted/VoiceActor';</script>";
        }
        elseif (isset($_POST['R'.$tableData[$_GET["UDataIdx"]]["voice_actor_id"].''])) {
            $sql="DELETE FROM voice_actor_request WHERE voice_actor_id=".$tableData[$_GET["UDataIdx"]]["voice_actor_id"].".";
                mysqli_query($conn, $sql);
    
                echo "<script>window.location.href='/ListOfUnaccepted/VoiceActor';</script>";
        }
        $data=
        '
        <div class="main-block">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="info">
                    <img class="pictures" src="/images/voiceactor/'.$tableData[$_GET["UDataIdx"]]["voice_actor_picture"].'">
                    <input value="'.$tableData[$_GET["UDataIdx"]]["voice_actor_name"].'" class="names" type="text" name="voice_actor_name" id="voice_actor_name" placeholder="Voice actor name">
                    <textarea rows="4" name="voice_actor_description" id="voice_actor_description" placeholder="Game description">'.$tableData[$_GET["UDataIdx"]]["voice_actor_description"].'</textarea>
                    <input type="hidden" name="voice_actor_picture" id="voice_actor_picture" value="'.$tableData[$_GET["UDataIdx"]]["voice_actor_picture"].'">
                    <input type="file" name="voice_actor_picture_file">
                </div>
                <div class="name">
                    <input type="submit" value="Accept" id="AcceptVoiceActor" name="A'.$tableData[$_GET["UDataIdx"]]["voice_actor_id"].'">
                    <input type="submit" value="Reject" id="RejectVoiceActor" name="R'.$tableData[$_GET["UDataIdx"]]["voice_actor_id"].'">
                </div>
            </form>
        </div>
        <script src="/javascript/DataSend.js"></script>
        <script>
            $(document).ready(function(){
                $("input[type=\'file\']").change(function(e){
                    var fileName = e.target.files[0].name;
                    $("#voice_actor_picture").val(fileName);
                });
            });
        </script>
        ';
    }
    elseif ($_GET["UnacceptedData"] == "PublisherId") {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/publisher_request");
        curl_setopt($ch, CURLOPT_POST, 1);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $output = curl_exec($ch);
        $tableData = json_decode($output, true);
        if (empty($tableData)) {
            $tableData = array();
        }
        curl_close($ch);
    
        if (isset($_POST['A'.$tableData[$_GET["UDataIdx"]]["publisher_id"].''])) {
            $sql = "INSERT INTO publisher(publisher_name, publisher_logo, publisher_description) 
                    VALUES ("."'".$_POST["publisher_name"]."'".",
                    "."'".$_POST["publisher_logo"]."'".", 
                    "."'".$_POST["publisher_description"]."'".")";
            mysqli_query($conn, $sql);
            
            if ($_FILES["publisher_logo_file"]['size'] != 0) {
                $images->Upload("publisher", "publisher_request", "publisher_logo_file", "publisher_id");
            }

            $sql="DELETE FROM publisher_request WHERE publisher_id=".$tableData[$_GET["UDataIdx"]]["publisher_id"].".";
            mysqli_query($conn, $sql);

            echo "<script>window.location.href='/ListOfUnaccepted/Publisher';</script>";
        }
        elseif (isset($_POST['R'.$tableData[$_GET["UDataIdx"]]["publisher_id"].''])) {
            $sql="DELETE FROM publisher_request WHERE publisher_id=".$tableData[$_GET["UDataIdx"]]["publisher_id"].".";
                mysqli_query($conn, $sql);
    
                echo "<script>window.location.href='/ListOfUnaccepted/Publisher';</script>";
        }
        $data=
        '
        <div class="main-block">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="info">
                    <img class="pictures" src="/images/publisher/'.$tableData[$_GET["UDataIdx"]]["publisher_logo"].'">
                    <input value="'.$tableData[$_GET["UDataIdx"]]["publisher_name"].'" class="names" type="text" name="publisher_name" id="publisher_name" placeholder="Voice actor name">
                    <textarea rows="4" name="publisher_description" id="publisher_description" placeholder="Game description">'.$tableData[$_GET["UDataIdx"]]["publisher_description"].'</textarea>
                    <input type="hidden" name="publisher_logo" id="publisher_logo" value="'.$tableData[$_GET["UDataIdx"]]["publisher_logo"].'">
                    <input type="file" name="publisher_logo_file">
                </div>
                <div class="name">
                    <input type="submit" value="Accept" id="AcceptPublisher" name="A'.$tableData[$_GET["UDataIdx"]]["publisher_id"].'">
                    <input type="submit" value="Reject" id="RejectPublisher" name="R'.$tableData[$_GET["UDataIdx"]]["publisher_id"].'">
                </div>
            </form>
        </div>
        <script src="/javascript/DataSend.js"></script>
        <script>
            $(document).ready(function(){
                $("input[type=\'file\']").change(function(e){
                    var fileName = e.target.files[0].name;
                    $("#publisher_logo").val(fileName);
                });
            });
        </script>
        ';
    }
    elseif ($_GET["UnacceptedData"] == "DeveloperId") {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/developer_request");
        curl_setopt($ch, CURLOPT_POST, 1);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $output = curl_exec($ch);
        $tableData = json_decode($output, true);
        if (empty($tableData)) {
            $tableData = array();
        }
        curl_close($ch);
    
        if (isset($_POST['A'.$tableData[$_GET["UDataIdx"]]["developer_id"].''])) {
            $sql = "INSERT INTO developer(developer_name, developer_logo, developer_description) 
                    VALUES ("."'".$_POST["developer_name"]."'".",
                    "."'".$_POST["developer_logo"]."'".", 
                    "."'".$_POST["developer_description"]."'".")";
            mysqli_query($conn, $sql);
            
            if ($_FILES["developer_logo_file"]['size'] != 0) {
                $images->Upload("developer", "developer_request", "developer_logo_file", "developer_id");
            }

            $sql="DELETE FROM developer_request WHERE developer_id=".$tableData[$_GET["UDataIdx"]]["developer_id"].".";
            mysqli_query($conn, $sql);

            echo "<script>window.location.href='/ListOfUnaccepted/Developer';</script>";
        }
        elseif (isset($_POST['R'.$tableData[$_GET["UDataIdx"]]["developer_id"].''])) {
            $sql="DELETE FROM developer_request WHERE developer_id=".$tableData[$_GET["UDataIdx"]]["developer_id"].".";
                mysqli_query($conn, $sql);
    
                echo "<script>window.location.href='/ListOfUnaccepted/Developer';</script>";
        }
        $data=
        '
        <div class="main-block">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="info">
                    <img class="pictures" src="/images/developer/'.$tableData[$_GET["UDataIdx"]]["developer_logo"].'">
                    <input value="'.$tableData[$_GET["UDataIdx"]]["developer_name"].'" class="names" type="text" name="developer_name" id="developer_name" placeholder="Voice actor name">
                    <textarea rows="4" name="developer_description" id="developer_description" placeholder="Game description">'.$tableData[$_GET["UDataIdx"]]["developer_description"].'</textarea>
                    <input type="hidden" name="developer_logo" id="developer_logo" value="'.$tableData[$_GET["UDataIdx"]]["developer_logo"].'">
                    <input type="file" name="developer_logo_file">
                </div>
                <div class="name">
                    <input type="submit" value="Accept" id="AcceptDeveloper" name="A'.$tableData[$_GET["UDataIdx"]]["developer_id"].'">
                    <input type="submit" value="Reject" id="RejectDeveloper" name="R'.$tableData[$_GET["UDataIdx"]]["developer_id"].'">
                </div>
            </form>
        </div>
        <script src="/javascript/DataSend.js"></script>
        <script>
            $(document).ready(function(){
                $("input[type=\'file\']").change(function(e){
                    var fileName = e.target.files[0].name;
                    $("#developer_logo").val(fileName);
                });
            });
        </script>
        ';
    }
}
else {
    echo "<script>window.location.href='/Error';</script>";
}
function asd($buffer){
    if (isset($GLOBALS['data'])) {
        return str_replace("%%UnnacceptedData%%", $GLOBALS['data'], $buffer);
    }
}
ob_start("asd");
include $_SERVER['DOCUMENT_ROOT']."/html/UnAcceptedData.html";
ob_end_flush();
?>
