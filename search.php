<?php
$conn = mysqli_connect("localhost", "root", "", "nagyprojekt");
 
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_REQUEST["term"]))
{
    $sql = "SELECT * FROM game WHERE game_name LIKE '".$_REQUEST["term"]."%'";
    $result = $conn->query($sql);
    if(mysqli_num_rows($result) > 0)
    {
        echo "<p>Games:</p>";
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            echo "<a href='/Game/".$row["game_id"]."' class='srca'><p>". $row["game_name"]."<img src='/images/game/".$row["game_cover_image"]."' class='srcimage'></p></a>";
        }
    }
    else
    {
        echo "<p>No game matches found</p>";
    }
    $sql = "SELECT * FROM users WHERE username LIKE '".$_REQUEST["term"]."%'";
    $result = $conn->query($sql);
    if(mysqli_num_rows($result) > 0)
    {
        echo "<p>Users:</p>";
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

            echo "<a href='/profile/".$row["username"]."' class='srca'><p>". $row["username"]."<img src='/images/user/".$row["profile_picture"]."' class='srcimage'></p></a>";
        }
    }
    else
    {
        echo "<p>No user matches found</p>";
    }
}
?>