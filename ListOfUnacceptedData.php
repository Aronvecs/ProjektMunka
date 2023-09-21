<?php
include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";

$data="";
    if (isset($_GET["unaceptedDataType"]) && $_SESSION["email"] !="" && isset($_SESSION["email"])) {
        if ($_GET["unaceptedDataType"] == "Character") {
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/characters_request");
            curl_setopt($ch, CURLOPT_POST, 1);
        
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $output = curl_exec($ch);
            $tableData = json_decode($output, true);
            if (empty($tableData)) {
                $tableData = array();
            }
            curl_close ($ch);
            for ($i=0; $i < count($tableData); $i++) { 
                $data .= 
                "<tr>
                    <td class='gameimagetd'><img class='gameimage'  src='/images/character/".$tableData[$i]["character_picture"]."' class='mylistimage'></td>
                    <td><a href=/UnacceptedData/CharacterId/".$i.">".$tableData[$i]["character_name"]."</a></td>
                </tr>";
            }
        }
        elseif ($_GET["unaceptedDataType"] == "Game") {
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/game_request");
            curl_setopt($ch, CURLOPT_POST, 1);
        
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $output = curl_exec($ch);
            $tableData = json_decode($output, true);
            if (empty($tableData)) {
                $tableData = array();
            }
            

            curl_close ($ch);
            
            for ($i=0; $i < count($tableData); $i++) { 
                if (!empty($tableData)) {
                    $data .= 
                    "<tr>
                        <td class='gameimagetd'><img class='gameimage' src='/images/game/".$tableData[$i]["game_cover_image"]."' class='mylistimage'></td>
                        <td><a href=/UnacceptedData/GameId/".$i.">".$tableData[$i]["game_name"]."</a></td>
                    </tr>";
                }
            }
        }
        elseif ($_GET["unaceptedDataType"] == "VoiceActor") {
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/voice_actor_request");
            curl_setopt($ch, CURLOPT_POST, 1);
        
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $output = curl_exec($ch);
            $tableData = json_decode($output, true);
            if (empty($tableData)) {
                $tableData = array();
            }
            curl_close ($ch);

            for ($i=0; $i < count($tableData); $i++) { 
                $data .= 
                "<tr>
                    <td class='gameimagetd'><img class='gameimage' src='/images/voiceactor/".$tableData[$i]["voice_actor_picture"]."' class='mylistimage'></td>
                    <td><a href=/UnacceptedData/VoiceActorId/".$i.">".$tableData[$i]["voice_actor_name"]."</a></td>
                </tr>";
            }
        }
        elseif ($_GET["unaceptedDataType"] == "Publisher") {
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/publisher_request");
            curl_setopt($ch, CURLOPT_POST, 1);
        
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $output = curl_exec($ch);
            $tableData = json_decode($output, true);
            if (empty($tableData)) {
                $tableData = array();
            }
            curl_close ($ch);

            for ($i=0; $i < count($tableData); $i++) { 
                $data .= 
                "<tr>
                    <td class='gameimagetd'><img class='gameimage' src='/images/publisher/".$tableData[$i]["publisher_logo"]."' class='mylistimage'></td>
                    <td><a href=/UnacceptedData/PublisherId/".$i.">".$tableData[$i]["publisher_name"]."</a></td>
                </tr>";
            }
        }
        elseif ($_GET["unaceptedDataType"] == "Developer") {
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/TableRequest/developer_request");
            curl_setopt($ch, CURLOPT_POST, 1);
        
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $output = curl_exec($ch);
            $tableData = json_decode($output, true);
            if (empty($tableData)) {
                $tableData = array();
            }
            curl_close ($ch);

            for ($i=0; $i < count($tableData); $i++) { 
                $data .= 
                "<tr>
                    <td class='gameimagetd'><img class='gameimage' src='/images/developer/".$tableData[$i]["developer_logo"]."' class='mylistimage'></td>
                    <td><a href=/UnacceptedData/DeveloperId/".$i.">".$tableData[$i]["developer_name"]."</a></td>
                </tr>";
            }
        }
    }
    else {
        echo "<script>window.location.href='/Error';</script>";
    }
    function asd($buffer){
        if (isset($GLOBALS['data'])) {
            return str_replace("%%ListOfUnnaccepted%%", $GLOBALS['data'], $buffer);
        }
    }
    ob_start("asd");
    include $_SERVER['DOCUMENT_ROOT']."/html/ListOfUnacceptedData.html";
    ob_end_flush();
?>