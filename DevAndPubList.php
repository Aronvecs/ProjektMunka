<?php
include $_SERVER['DOCUMENT_ROOT']."/sablon/sablon.php";
if (isset($_GET["DevOrPublisher"])) 
{
    // Developer Data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/List/Developer");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $DeveloperData = json_decode($output, true);
    curl_close ($ch);

    // Publisher Data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/List/Publisher");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $PublisherData = json_decode($output, true);
    curl_close ($ch);
}

// class Lists
// {
//     function GetPublisher()
//     {
//         global $conn;
//         $sql = "SELECT publisher.* , count(gameandpublisher.publisher_name) FROM publisher INNER JOIN gameandpublisher ON gameandpublisher.publisher_name = publisher.publisher_name GROUP BY publisher.publisher_name ORDER BY count(gameandpublisher.publisher_name) DESC";
//         $result = $conn->query($sql);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
//     function GetDeveloper()
//     {
//         global $conn;
//         $sql = "SELECT developer.* , count(gameanddeveloper.developer_name) FROM developer INNER JOIN gameanddeveloper ON gameanddeveloper.developer_name = developer.developer_name GROUP BY developer.developer_name ORDER BY count(gameanddeveloper.developer_name) DESC";
//         $result = $conn->query($sql);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
//     function GetPublisherWork($publisher)
//     {
//         global $conn;
//         $sql = "SELECT count(publisher_name) AS work FROM gameandpublisher WHERE publisher_name = '$publisher'";
//         $result = $conn->query($sql);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
//     function GetDeveloperWork($developer)
//     {
//         global $conn;
//         $sql = "SELECT count(developer_name) AS work FROM gameanddeveloper WHERE developer_name = '$developer'";
//         $result = $conn->query($sql);
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }
// }
// $get = new Lists();
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
                            if (isset($_GET["DevOrPublisher"]))
                            {
                                if($_GET["DevOrPublisher"] == "Publisher")
                                {
                                    echo('<td class="selectedtd"><a class="selected" href="/DeveloperAndPublisherList/Publisher">Publishers</a></td>');
                                    echo('<td><a href="/DeveloperAndPublisherList/Developer">Developers</a></td>');
                                }
                                else if($_GET["DevOrPublisher"] == "Developer")
                                {
                                    echo('<td><a href="/DeveloperAndPublisherList/Publisher">Publishers</a></td>');
                                    echo('<td class="selectedtd"><a class="selected" href="/DeveloperAndPublisherList/Developer">Developers</a></td>');
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
                        <td>Logo</td>
                        <td>Company name</td>
                        <td>Works</td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if (isset($_GET["DevOrPublisher"])) 
                            {
                                if($_GET["DevOrPublisher"] == "Publisher")
                                {
                                    for ($i=0; $i < count($PublisherData); $i++) 
                                    { 
                                    $rank = $i+1;
                                    echo(
                                        "<tr>                                                
                                        <td><big>$rank</big></td>
                                        <td class='gameimagetd' ><a href=/Publisher/".$PublisherData[$i]["publisher_id"]."><img class='gameimage'  src='/images/publisher/".$PublisherData[$i]["publisher_logo"]."' class='mylistimage'></a></td>
                                        <td><a href='/Publisher/".$PublisherData[$i]["publisher_id"]."'>".$PublisherData[$i]["publisher_name"]."</a></td>
                                        <td>".$PublisherData[$i]["work"]."</td>
                                        </tr>");              
                                    }
                                }            
                                else if($_GET["DevOrPublisher"] == "Developer")
                                {
                                    for ($i=0; $i < count($DeveloperData); $i++) 
                                    { 
                                        $rank = $i+1;
                                        echo(
                                            "<tr>                                                
                                            <td><big>$rank</big></td>
                                            <td class='gameimagetd' ><a href=/Developer/".$DeveloperData[$i]["developer_id"]."><img class='gameimage'  src='/images/developer/".$DeveloperData[$i]["developer_logo"]."' class='mylistimage'></a></td>
                                            <td><a href='/Developer/".$DeveloperData[$i]["developer_id"]."'>".$DeveloperData[$i]["developer_name"]."</a></td>
                                            <td>".$DeveloperData[$i]["work"]."</td>
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
</body>
</html>