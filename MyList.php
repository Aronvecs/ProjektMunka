<?php
include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}
if (isset($_GET["delete"])) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/DataDelete/".$_GET["delete"]."");
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);

    curl_close ($ch);
    $_SESSION['counter']++;
    echo "<script>window.location.href='/MyList/".$_GET["username"]."/".$_GET["orderby"]."';</script>";
}


if(isset($_GET["edit"])){
    if ($_SESSION["counter"]%2!=0 || $_SESSION["counter"]==0) {
        $_SESSION['counter']++;
    }
    if ($_SESSION["counter"]%2==0 && $_SESSION["counter"]!=0) {
        $_SESSION['counter'] = 0;
        echo "<script>window.location.href='/MyList/".$_GET["username"]."/".$_GET["orderby"]."';</script>";
    }
    
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/users/email/".$_SESSION['email']."");
curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$output = curl_exec($ch);
$userdata = json_decode($output, true);
if (empty($userdata)) {
    $username = "InvalidUser";
}
else {
    $username = $userdata[0]["username"];
}
curl_close ($ch);

$data ='';
$headerData='
<tr class="OrderSelector">
    <td><a href="/MyList/'.$_GET["username"].'/all">All</a></td>
    <td><a href="/MyList/'.$_GET["username"].'/playing">Playing</a></td>
    <td><a href="/MyList/'.$_GET["username"].'/completed">Completed</a></td>
    <td><a href="/MyList/'.$_GET["username"].'/plan to play">Plan to play</a></td>
    <td><a href="/MyList/'.$_GET["username"].'/dropped">Dropped</a></td>
    <td><a href="/MyList/'.$_GET["username"].'/on hold">On hold</a></td>
</tr>
';
if (isset($_GET["orderby"])) {

    if ($_GET["orderby"]=="all") {

        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/MyList/".$_GET["username"]."");
        curl_setopt($ch, CURLOPT_POST, 1);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $output = curl_exec($ch);
        $mylist = json_decode($output, true);
        if (empty($mylist)) {
            $mylist = array();
        }
        curl_close ($ch);

        
        $data .= "<tr class='TableHeader'>
        <td>image</td>
        <td>Name</td>
        <td>Score</td>
        <td>Status</td>";
        if (isset($_GET["edit"]) && $_GET["username"] == $username) {
            $data .= '<td>Delete</td>';
        }        
        $data .=    "</tr>";
        if ($_GET["username"] == $username) {
            $data .= '<tr>
            <td></td>
            <td></td>
            <td></td>';
            if (isset($_GET["edit"]) && $_GET["username"] == $username) {
                $data .= '<td></td>';
            }    
            $data .= '<td> <a href="/MyList/'.$_GET["username"].'/'.$_GET["orderby"].'/edit" style="float:right;" type="button" class="btn btn-primary"><i style="height:10px;"  class="fa fa-pencil" aria-hidden="true"> edit</i></a> </td>
            </tr>';
        }

        for ($i=0; $i < count($mylist); $i++) {
            $data .=
            "<tr>
                <td class='gameimagetd'><img class='gameimage' src='/images/game/".$mylist[$i]["game_cover_image"]."' class='mylistimage'></td>
                <td><a href=/Game/".$mylist[$i]["game_id"].">".$mylist[$i]["game_name"]."</a></td>";

                if ($mylist[$i]["rating"] != 0) {
                    $data .= "<td>".$mylist[$i]["rating"]."</td>";
                }
                else {
                    $data .= "<td>Pending</td>";
                }
            $data.="<td>".$mylist[$i]["status"]."</td>";
            if (isset($_GET["edit"]) && $_GET["username"] == $username) {
                $data .= '<td><a href="?delete='.$mylist[$i]["gamelist_id"].'" class="btn btn-primary"><i style="height:10px;" class="fa fa-minus-square-o" aria-hidden="true"></i></a></td>';
            }
            $data.="</tr>";
        }
    }
    else {
        if ($_GET["orderby"] == "plan to play") {
            $_GET["orderby"] = "plan%20to%20play";
        }
        elseif ($_GET["orderby"] == "on hold") {
            $_GET["orderby"] = "on%20hold";
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/MyList/".$_GET["username"]."/".$_GET["orderby"]."");
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $mylist = json_decode($output, true);
        if (empty($mylist)) {
            $mylist = array();
        }

        curl_close ($ch);


        $data .= "<tr class='TableHeader'>
                <td>image</td>
                <td>Name</td>
                <td>Score</td>";
        if (isset($_GET["edit"]) && $_GET["username"] == $username) {
            $data .= '<td>Delete</td>';
        }        
        $data .=    "</tr>";
        if ($_GET["username"] == $username) {
            $data .= '<tr>
            <td></td>
            <td></td>';
            if (isset($_GET["edit"]) && $_GET["username"] == $username) {
                $data .= '<td></td>';
            }    
            $data .= '<td> <a href="/MyList/'.$_GET["username"].'/'.$_GET["orderby"].'/edit" style="float:right;" type="button" class="btn btn-primary"><i style="height:10px;"  class="fa fa-pencil" aria-hidden="true"> edit</i></a> </td>
            </tr>';
        }

        
        if ($mylist != null) {
            for ($i=0; $i < count($mylist); $i++) { 
                $data .= 
                "<tr>
                    <td class='gameimagetd'><img class='gameimage' src='/images/game/".$mylist[$i]["game_cover_image"]."' class='mylistimage'></td>
                    <td><a href=/Game/".$mylist[$i]["game_id"].">".$mylist[$i]["game_name"]."</a></td>";
                if ($mylist[$i]["rating"] != 0) {
                    $data.=    "<td>".$mylist[$i]["rating"]."</td>";
                }
                else {
                    $data .= "<td>Pending</td>";
                }
                if (isset($_GET["edit"]) && $_GET["username"] == $username) {
                    $data .= '<td><a style="background-color:red;" href="?delete='.$mylist[$i]["gamelist_id"].'" class="btn btn-primary"><i style="height:10px;" class="fa fa-minus-square-o" aria-hidden="true"></i></a></td>';
                }
                $data .= '</tr>';
            }
        }
    }
}

function asd1($buffer){
    if (isset($GLOBALS['headerData'])) {
        return str_replace("%%Header%%", $GLOBALS['headerData'], $buffer);
    }
}
ob_start("asd1");
include $_SERVER['DOCUMENT_ROOT']."/html/MyList.html";

function asd2($buffer){
    if (isset($GLOBALS['data'])) {
        return str_replace("%%DATASEND%%", $GLOBALS['data'], $buffer);
    }
}
ob_start("asd2");
include $_SERVER['DOCUMENT_ROOT']."/html/MyList.html";
ob_end_flush();


?>