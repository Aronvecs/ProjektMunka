<?php

include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";
include $_SERVER['DOCUMENT_ROOT']."/uploadImages.php";

$images = new Images();

if (isset($_GET["character"])) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Character/".$_GET["character"]."");
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    $characterDatas = json_decode($output, true);

    curl_close ($ch);
}
elseif (isset($_GET["VoiceActor"])) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/VoiceActor/".$_GET["VoiceActor"]."");
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    $voiceActor = json_decode($output, true);

    curl_close ($ch);
}
elseif (isset($_GET["Publisher"])) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Publisher/".$_GET["Publisher"]."");
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    $publisher = json_decode($output, true);

    curl_close ($ch);
}
elseif (isset($_GET["Developer"])) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Developer/".$_GET["Developer"]."");
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    $developer = json_decode($output, true);

    curl_close ($ch);
}
elseif (isset($_GET["Genre"])) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Genre/".$_GET["Genre"]."");
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    $genre = json_decode($output, true);

    curl_close ($ch);
}

//Character
function CURL($url){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    return json_decode($output, true);
}

$data="";
if (isset($_GET["dataType"]) && $_SESSION["email"] !="" && isset($_SESSION["email"])) {
    if ($_GET["dataType"] == "Character") {
        if (isset($_POST["CSendButton"]) && !isset($_GET["character"])) {
            if ($_POST["character_name"]) {
                $sql = "INSERT INTO characters_request(character_name, character_picture, character_description) 
                    VALUES ("."'".$_POST["character_name"]."'".",
                    "."'".$_FILES["character_picture"]["name"]."'".", 
                    "."'".$_POST["character_description"]."'".")";
                mysqli_query($conn, $sql);
                $images->Upload("character", "characters_request", "character_picture", "character_id");
                echo '<script>alert("We recevied your request. We will check it soon")</script>';
            }
            else {
                echo '<script>alert("Character Name is required")</script>';
            }
        }
        else if (isset($_POST["CSendButton"]) && isset($_GET["character"])) {

            if (empty(CURL("http://rest-api.com/GameAndCharacter/".$_GET["GameId"]."/".$characterDatas[0]["character_id"].""))) {
                $sql = "INSERT INTO gameandcharacters(character_id, game_id) 
                    VALUES('".$characterDatas[0]["character_id"]."', '".$_GET["GameId"]."')";
                mysqli_query($conn, $sql);
                echo "<script>window.location.href='/Game/".$_GET["GameId"]."';</script>";
            }
            else {
                echo '<script>alert("This pair is already exists")</script>';
            }
        }
        $data.=
            '
            <div class="main-block">
                <form action="#" method="post" enctype="multipart/form-data">';
        if (isset($_GET["GameId"])) {
                $data .= '<select name="game_status" id="select"  onchange="location = this.value;">';
                $data .= '<option>Choose a character...</option>';

            $sql = "SELECT * FROM characters ORDER BY character_name";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                $data .= '<option value="?character='.$row["character_id"].'">'.$row["character_name"].'</option>';
            }

            $data .='
                </select>
            ';
            if (isset($_GET["character"])) {
                $data.=
                '
                        <div class="info">
                            <img class="pictures" src="/images/character/'.$characterDatas[0]["character_picture"].'">
                            <input value="'.$characterDatas[0]["character_name"].'" class="names" type="text" name="character_name" placeholder="Character Name" readonly>
                            <textarea rows="4" name="character_description" id="character_description" placeholder="Character description" readonly>'.$characterDatas[0]["character_description"].'</textarea>
                        </div>
                        <div><input type="submit" value="Send" name="CSendButton"></div>
                        <a class="btn btn-primary" href="/DataSend/Character" role="button">Add new character</a>
                    </form>
                </div>';
            }
            else {
                $data.=
                '
                        <div class="info">
                            <input class="names" type="text" name="character_name" placeholder="Character Name" readonly>
                            <textarea rows="4" name="character_description" id="character_description" placeholder="Character description" readonly></textarea>
                            <a class="btn btn-primary" href="/DataSend/Character" role="button">Add new character</a>
                        </div>
                    </form>
                </div>';
            }
        }
        else {
            $data.=
            '
                    <div class="info">
                        <input class="names" type="text" name="character_name" id="character_name" placeholder="Character Name">
                        <textarea rows="4" name="character_description" id="character_description" placeholder="Character description"></textarea>
                        <input type="file" name="character_picture" id="character_picture" placeholder="Character cover image">
                    </div>
                    <div><input type="submit" value="Send" id="AcceptCharacter" name="CSendButton"></div>
                </form>
            </div>
            <script src="/javascript/DataSend.js"></script>
            ';
        }
    }
    elseif ($_GET["dataType"] == "Game") {
        if (isset($_POST["GSendButton"])) {
            if ($_POST["game_name"] && strpos($_POST["game_trailer"], 'embed') && $_POST["game_description"] && $_POST["game_status"] && $_FILES["game_cover_image"]["name"]) {
                $sql = "INSERT INTO game_request (game_name, game_release_date, game_cover_image, game_trailer, game_description, game_status) 
                VALUES (
                "."'".$_POST["game_name"]."'".",
                "."'".$_POST["game_release_date"]."'".",
                "."'".$_FILES["game_cover_image"]["name"]."'".",
                "."'".$_POST["game_trailer"]."'".",
                "."'".$_POST["game_description"]."'".",
                "."'".$_POST["game_status"]."'".")";
                mysqli_query($conn, $sql);
                $images->Upload("game", "game_request", "game_cover_image", "game_id");
                echo '<script>alert("We recevied your request. We will check it soon")</script>';
            }
                
        }

        $data=
        '
        <div class="main-block">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="info">
                    <div class="name">
                        <input class="names" type="text" name="game_name" id="game_name" placeholder="Game Name">
                        <select name="game_status" id="game_status">
                            <option value="Not out yet">Not out yet</option>
                            <option value="Out in early acces">Out in early acces</option>
                            <option value="Released">Released</option>
                            <option value="Canceled">Canceled</option>
                        </select> 
                    </div>
                    <input type="text" id="game_release_date" placeholder="Game release date" name="game_release_date" onfocus='."(this.type='date')".' onblur='."(this.type='text')".'>
                    <textarea rows="4" name="game_trailer" id="game_trailer" placeholder="Game trailer link. The link must be embeded"></textarea>
                    <textarea rows="4" name="game_description" id="game_description" placeholder="Game description"></textarea>
                    <input type="file" name="game_cover_image" id="game_cover_image" placeholder="Game cover image">
                     
                </div>
                <div><input type="submit" value="Send" id="Gameaccept" name="GSendButton" id="GSendButton"></div>
            </form>
        </div>

        <script src="/javascript/DataSend.js"></script>
        ';
    }
    elseif ($_GET["dataType"] == "VoiceActor") {
        if (isset($_POST["VSendButton"]) && !isset($_GET["VoiceActor"])) {
            $sql = "INSERT INTO voice_actor_request(voice_actor_name, voice_actor_picture, voice_actor_description) 
                    VALUES ("."'".$_POST["voice_actor_name"]."'".",
                    "."'".$_FILES["voice_actor_picture"]["name"]."'".", 
                    "."'".$_POST["voice_actor_description"]."'".")";
                mysqli_query($conn, $sql);
                $images->Upload("voiceactor", "voice_actor_request", "voice_actor_picture", "voice_actor_id");
                echo '<script>alert("We recevied your request. We will check it soon")</script>';
        }
        else if (isset($_POST["VSendButton"]) && isset($_GET["VoiceActor"])) {
            $sql = "UPDATE gameandcharacters SET voice_actor_id=".$voiceActor[0]["voice_actor_id"]." WHERE game_id = ".$_GET["GameId"]." AND character_id=".$_GET["CharacterId"]."";
                mysqli_query($conn, $sql);
            echo "<script>window.location.href='/Game/".$_GET["GameId"]."';</script>";
        }

        $data.=
        '
        <div class="main-block">
            <form action="#" id="voiceActorDataSend" method="post" enctype="multipart/form-data">';
        if (isset($_GET["GameId"])) {
            $data .= '<select name="game_status" id="select"  onchange="location = this.value;">';
            $data .= '<option>Choose a Voice actor...</option>';

        $sql = "SELECT * FROM voice_actor ORDER BY voice_actor_name";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $data .= '<option value="?VoiceActor='.$row["voice_actor_id"].'">'.$row["voice_actor_name"].'</option>';
        }

        $data .='
            </select>
        ';
        if (isset($_GET["VoiceActor"])) {
            $data.=
            '
                    <div class="info">
                        <img class="pictures" src="/images/voiceactor/'.$voiceActor[0]["voice_actor_picture"].'">
                        <input value="'.$voiceActor[0]["voice_actor_name"].'" class="names" type="text" name="voice_actor_name" placeholder="Voice actor name" readonly>
                        <textarea rows="4" name="voice_actor_description" id="character_description" placeholder="Voice actor description" readonly>'.$voiceActor[0]["voice_actor_description"].'</textarea>
                    </div>
                    <div><input type="submit" value="Send" name="VSendButton"></div>
                </form>
            </div>';
        }
        else {
            $data.=
            '
                    <div class="info">
                        <input class="names" type="text" name="voice_actor_name" placeholder="Voice actor name">
                        <textarea rows="4" name="voice_actor_description" id="voice_actor_description" placeholder="Voice actor description"></textarea>
                        <a class="btn btn-primary" href="/DataSend/VoiceActor" role="button">Add new Voice actor</a>
                    </div>
                </form>
            </div>';
        }
        }
        else {
            $data.=
            '
                    <div class="info">
                        <input type="text" name="voice_actor_name" id="voice_actor_name" placeholder="Voice actor name">
                        <textarea rows="4" name="voice_actor_description" id="voice_actor_description" placeholder="Voice actor description"></textarea>
                        <input type="file" name="voice_actor_picture" id="voice_actor_picture" placeholder="Voice actor picture">
                    </div>
                    <div><input type="submit" value="Send" id="AcceptVoiceActor" name="VSendButton"></div>
                </form>
            </div>
            <script src="/javascript/DataSend.js"></script>
            ';
        }
        
    }
    elseif ($_GET["dataType"] == "Publisher") {
        if (isset($_POST["PSendButton"]) && !isset($_GET["Publisher"])) {
            $sql = "INSERT INTO publisher_request(publisher_name, publisher_logo, publisher_description) 
                    VALUES ("."'".$_POST["publisher_name"]."'".",
                    "."'".$_FILES["publisher_logo"]["name"]."'".", 
                    "."'".$_POST["publisher_description"]."'".")";
            mysqli_query($conn, $sql);
            $images->Upload("publisher", "publisher_request", "publisher_logo", "publisher_id");
            echo '<script>alert("We recevied your request. We will check it soon")</script>';
        }
        else if (isset($_POST["PSendButton"]) && isset($_GET["Publisher"])) {
            if (empty(CURL("http://rest-api.com/GameAndPublisher/".$_GET["GameId"]."/".$publisher[0]["publisher_id"].""))) {
                $sql = "INSERT INTO gameandpublisher(publisher_id, game_id) 
                        VALUES('".$publisher[0]["publisher_id"]."', '".$_GET["GameId"]."')";
                mysqli_query($conn, $sql);
                echo "<script>window.location.href='/Game/".$_GET["GameId"]."';</script>";
            }
            else {
                echo '<script>alert("This pair is already exists")</script>';
            }
        }


        $data.=
        '
        <div class="main-block">
            <form action="#" method="post" enctype="multipart/form-data">';
        if (isset($_GET["GameId"])) {
            $data .= '<select name="game_status" id="select"  onchange="location = this.value;">';
            $data .= '<option>Choose a Voice actor...</option>';

        $sql = "SELECT * FROM publisher ORDER BY publisher_name";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $data .= '<option value="?Publisher='.$row["publisher_id"].'">'.$row["publisher_name"].'</option>';
        }

        $data .='
            </select>
        ';
        if (isset($_GET["Publisher"])) {
            $data.=
            '
                    <div class="info">
                        <img class="pictures" src="/images/publisher/'.$publisher[0]["publisher_logo"].'">
                        <input value="'.$publisher[0]["publisher_name"].'" class="names" type="text" name="publisher_name" placeholder="Publisher name" readonly>
                        <textarea rows="4" name="publisher_description" placeholder="Publisher description" readonly>'.$publisher[0]["publisher_description"].'</textarea>
                    </div>
                    <div><input type="submit" value="Send" name="PSendButton"></div>
                </form>
            </div>';
        }
        else {
            $data.=
            '
                    <div class="info">
                        <input class="names" type="text" name="publisher_name" placeholder="Publisher name">
                        <textarea rows="4" name="publisher_description" id="publisher_description" placeholder="Publisher description"></textarea>
                        <a class="btn btn-primary" href="/DataSend/Publisher" role="button">Add new publisher</a>
                    </div>
                </form>
            </div>';
        }
        }

        else {
            $data.=
            '
                    <div class="info">
                        <input type="text" name="publisher_name" id="publisher_name" placeholder="Publisher name">
                        <textarea rows="4" name="publisher_description" id="publisher_description" placeholder="Publisher description"></textarea>
                        <input type="file" name="publisher_logo" id="publisher_logo" placeholder="Publisher logo">
                    </div>
                    <div><input type="submit" value="Send" id="AcceptPublisher" name="PSendButton"></div>
                </form>
            </div>
            <script src="/javascript/DataSend.js"></script>
            ';
        }
        
    }
    elseif ($_GET["dataType"] == "Developer") {
        if (isset($_POST["DSendButton"]) && !isset($_GET["Developer"])) {
            $sql = "INSERT INTO developer_request(developer_name, developer_logo, developer_description) 
                    VALUES ("."'".$_POST["developer_name"]."'".",
                    "."'".$_FILES["developer_logo"]["name"]."'".", 
                    "."'".$_POST["developer_description"]."'".")";
            mysqli_query($conn, $sql);
            $images->Upload("developer", "developer_request", "developer_logo", "developer_id");
            echo '<script>alert("We recevied your request. We will check it soon")</script>';
        }
        else if (isset($_POST["DSendButton"]) && isset($_GET["Developer"])) {
            if (empty(CURL("http://rest-api.com/GameAndDeveloper/".$_GET["GameId"]."/".$developer[0]["developer_id"].""))) {
                $sql = "INSERT INTO gameanddeveloper(developer_id, game_id) 
                        VALUES('".$developer[0]["developer_id"]."', '".$_GET["GameId"]."')";
                mysqli_query($conn, $sql);
                echo "<script>window.location.href='/Game/".$_GET["GameId"]."';</script>";
            }
            else {
                echo '<script>alert("This pair is already exists")</script>';
            }
        }


        $data.=
        '
        <div class="main-block">
            <form action="#" method="post" enctype="multipart/form-data">';
        if (isset($_GET["GameId"])) {
            $data .= '<select name="game_status" id="select"  onchange="location = this.value;">';
            $data .= '<option>Choose a Developer...</option>';

        $sql = "SELECT * FROM developer ORDER BY developer_name";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $data .= '<option value="?Developer='.$row["developer_id"].'">'.$row["developer_name"].'</option>';
        }

        $data .='
            </select>
        ';
        if (isset($_GET["Developer"])) {
            $data.=
            '
                    <div class="info">
                        <img class="pictures" src="/images/developer/'.$developer[0]["developer_logo"].'">
                        <input value="'.$developer[0]["developer_name"].'" class="names" type="text" name="developer_name" placeholder="Developer name" readonly>
                        <textarea rows="4" name="developer_description" placeholder="Developer description" readonly>'.$developer[0]["developer_description"].'</textarea>
                    </div>
                    <div><input type="submit" value="Send" name="DSendButton"></div>
                </form>
            </div>';
        }
        else {
            $data.=
            '
                    <div class="info">
                        <input class="names" type="text" name="developer_name" placeholder="Developer name">
                        <textarea rows="4" name="developer_description" id="developer_description" placeholder="Developer description"></textarea>
                        <a class="btn btn-primary" href="/DataSend/Developer" role="button">Add new Developer</a>
                    </div>
                </form>
            </div>';
        }
        }

        else {
            $data.=
            '
                    <div class="info">
                        <input type="text" name="developer_name" id="developer_name" placeholder="Developer name">
                        <textarea rows="4" name="developer_description" id="developer_description" placeholder="Developer description"></textarea>
                        <input type="file" name="developer_logo" id="developer_logo" placeholder="Developer logo">
                    </div>
                    <div><input type="submit" value="Send" id="AcceptDeveloper" name="DSendButton"></div>
                </form>
            </div>
            <script src="/javascript/DataSend.js"></script>
            ';
        }
        
    }
    elseif ($_GET["dataType"] == "Genre") {
        if (isset($_POST["GenreSendButton"]) && isset($_GET["Genre"])) {
            if (empty(CURL("http://rest-api.com/GameAndGenre/".$_GET["GameId"]."/".$genre[0]["genre_id"].""))) {
                $sql = "INSERT INTO gameandgenre(genre_id, game_id) 
                    VALUES('".$genre[0]["genre_id"]."', '".$_GET["GameId"]."')";
                mysqli_query($conn, $sql);
                echo "<script>window.location.href='/Game/".$_GET["GameId"]."';</script>";
            }
            else {
                echo '<script>alert("This pair is already exists")</script>';
            }
        }

        $data.=
        '
        <div class="main-block">
            <form action="#" method="post" enctype="multipart/form-data">';
        if (isset($_GET["GameId"])) {
            $data .= '<select name="game_status" id="select"  onchange="location = this.value;">';
            $data .= '<option>Choose a Genre...</option>';

            $sql = "SELECT * FROM genre ORDER BY genre_name";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                $data .= '<option value="?Genre='.$row["genre_id"].'">'.$row["genre_name"].'</option>';
            }

            $data .='
                </select>
            ';
            if (isset($_GET["Genre"])) {
                $data.=
                '
                        <div class="info">
                            <input value="'.$genre[0]["genre_name"].'" class="names" type="text" name="genre_name" placeholder="genre name" readonly>
                        </div>
                        <div><input type="submit" value="Send" name="GenreSendButton"></div>
                    </form>
                </div>';
            }
            else {
                $data.=
                '
                        <div class="info">
                            <input class="names" type="text" name="genre_name" placeholder="genre name">
                        </div>
                    </form>
                </div>';
            }
        }
        
    }
}
else {
    echo "<script>window.location.href='/Error';</script>";
}

function asd($buffer){
    if (isset($GLOBALS['data'])) {
        return str_replace("%%DATASEND%%", $GLOBALS['data'], $buffer);
    }
}
ob_start("asd");
include $_SERVER['DOCUMENT_ROOT']."/html/DataSend.html";
ob_end_flush();
?>
