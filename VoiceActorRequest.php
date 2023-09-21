<?php
    if (isset($_POST["name"])) {
        $data = array();
        $conn = mysqli_connect("localhost","root","",'nagyprojekt');
        $sql = "SELECT * FROM voice_actor WHERE voice_actor_name = '".$_POST["name"]."'";
            $result = $conn->query($sql);

        $data = $result->fetch_all(MYSQLI_ASSOC);  
        echo json_encode($data,true); 
    }
?>
