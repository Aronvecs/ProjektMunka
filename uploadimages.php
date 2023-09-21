<?php
class Images{

    function Upload($dataType, $table, $image, $tableId){
        // Database configuration
        $dbHost     = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName     = "nagyprojekt";

        // Create database connection
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        $statusMsg = '';

        // File upload path
        $targetDir = "images/".$dataType."/";
        $fileName = basename($_FILES["$image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if(!empty($_FILES["$image"]["name"])){
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg','gif','pdf');
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["$image"]["tmp_name"], $targetFilePath)){
                    // Insert image file name into database
                    $update = $db->query("UPDATE $table SET $image = '".$fileName."' WHERE $tableId = MAX($tableId)");
                    if($update){
                        $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                    }else{
                        $statusMsg = "File upload failed, please try again.";
                    } 
                }else{
                    $statusMsg = "Sorry, there was an error uploading your file.";
                }
            }else{
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
            }
        }else{
            $statusMsg = 'Please select a file to upload.';
        }
        return $statusMsg;
    }
}

?>