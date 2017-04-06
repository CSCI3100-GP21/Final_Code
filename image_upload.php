<?php
define("MAX_FILE_SIZE", 2000000);
echo "entered php<br>";

if (isset($_POST['post_item']) && isset($_FILES['fileToUpload1']) && isset($_FILES['fileToUpload2']) && isset($_FILES['fileToUpload3'])){

    echo "entered submit<br>";

	$target_dir = '/Library/WebServer/Documents/images/user_upload/';
    $target_file1 = $target_dir . basename($_FILES["fileToUpload1"]["name"]);
    $target_file2 = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
    $target_file3 = $target_dir . basename($_FILES["fileToUpload3"]["name"]);
	$uploadOk1 = 1;
    
    $imageFileType1 = pathinfo($target_file1,PATHINFO_EXTENSION);
    $imageFileType2 = pathinfo($target_file2,PATHINFO_EXTENSION);
    $imageFileType3 = pathinfo($target_file3,PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    $check1 = getimagesize($_FILES["fileToUpload1"]["tmp_name"]);
    if($check1 == true) {
        echo "File1 is an image - " . $check1["mime"] . ".<br>";
        $uploadOk1 = 1;
    } else {
        echo "File1 is not an image.<br>";
        $uploadOk1 = 0;
    }

    $check2 = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
    if($check2 == true) {
        echo "File2 is an image - " . $check2["mime"] . ".<br>";
        $uploadOk2 = 1;
    } else {
        echo "File2 is not an image.<br>";
        $uploadOk2 = 0;
    }

    $check3 = getimagesize($_FILES["fileToUpload3"]["tmp_name"]);
    if($check3 == true) {
        echo "File3 is an image - " . $check3["mime"] . ".<br>";
        $uploadOk3 = 1;
    } else {
        echo "File3 is not an image.<br>";
        $uploadOk3 = 0;
    }

    // Check if file already exists
    // if (file_exists($target_file)) {
    //     echo "Sorry, file already exists.";
    //     $uploadOk = 0;
    // }

    // Check file size
    if ($_FILES["fileToUpload1"]["size"] > MAX_FILE_SIZE) {
        echo "Sorry, file1 is too large<br>.";
        $uploadOk1 = 0;
    }
    if ($_FILES["fileToUpload2"]["size"] > MAX_FILE_SIZE) {
        echo "Sorry, file2 is too large.<br>";
        $uploadOk2 = 0;
    }
    if ($_FILES["fileToUpload3"]["size"] > MAX_FILE_SIZE) {
        echo "Sorry, your file3 is too large.<br>";
        $uploadOk3 = 0;
    }

    // Allow certain file formats
    if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg"
    && $imageFileType1 != "gif" ) {
        echo "Sorry file1 is not supported, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk1 = 0;
    }
    if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg"
    && $imageFileType2 != "gif" ) {
        echo "Sorry file2 is not supported, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk2 = 0;
    }
    if($imageFileType3 != "jpg" && $imageFileType3 != "png" && $imageFileType3 != "jpeg"
    && $imageFileType3 != "gif" ) {
        echo "Sorry file3 is not supported, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk3 = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk1 == 0) {
        echo "Sorry, file1 was not uploaded.";
    // if everything is ok, try to upload file
    } 
    if ($uploadOk2 == 0) {
        echo "Sorry, file2 was not uploaded.";
    // if everything is ok, try to upload file
    } 
    if ($uploadOk3 == 0) {
        echo "Sorry, file3 was not uploaded.";
    // if everything is ok, try to upload file
    } 

    if ($uploadOk1 == 1 && $uploadOk2 == 1 && $uploadOk3 == 1){

        //connect to database
        $host = 'localhost';
        $user  = 'root';
        $pass = 'password';
        $db = 'bmc_db';

        $con = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT count(*) FROM products";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        echo "product_count: ".$row["count(*)"]."<br>";
        $pathNum1 = (intval($row["count(*)"])) * 3;
        $pathNum2 = (intval($row["count(*)"])) * 3 + 1;
        $pathNum3 = (intval($row["count(*)"])) * 3 + 2;
        $target_file1 = $target_dir . $pathNum1 . "." . pathinfo($target_file1,PATHINFO_EXTENSION);
        $target_file2 = $target_dir . $pathNum2 . "." . pathinfo($target_file2,PATHINFO_EXTENSION);
        $target_file3 = $target_dir . $pathNum3 . ".". pathinfo($target_file3,PATHINFO_EXTENSION);
        $pictureName1 = "NA";
        $pictureName2 = "NA";
        $pictureName3 = "NA";

        if (move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1)) {
            echo "The file ". basename( $_FILES["fileToUpload1"]["name"]). " has been uploaded.<br>";
            $pictureName1 = "/images/user_upload/". (string)$pathNum1;
		}
        else {
            echo "Sorry, there was an error uploading file1.";
        }
        if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file2)) {
            echo "The file ". basename( $_FILES["fileToUpload2"]["name"]). " has been uploaded.<br>";
            $pictureName2 = "/images/user_upload/". (string)$pathNum2;
        }
        else {
            echo "Sorry, there was an error uploading file2.";
        }
        if (move_uploaded_file($_FILES["fileToUpload3"]["tmp_name"], $target_file3)) {
            echo "The file ". basename( $_FILES["fileToUpload3"]["name"]). " has been uploaded.<br>";
            $pictureName3 = "/images/user_upload/". (string)$pathNum3;
        }
        else {
            echo "Sorry, there was an error uploading file3.";
        }

        $user_id = 15;
        $product_name = mysqli_real_escape_string($con, $_POST['product_name']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $price = intval($price);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $category = mysqli_real_escape_string($con, $_POST['category']);
        $country = mysqli_real_escape_string($con, $_POST['country']);

        $sql = "INSERT INTO products (user_id, img_path1, img_path2, img_path3, product_name, price, description, category, country) VALUES ('$user_id', '$pictureName1', '$pictureName2', '$pictureName3', '$product_name', '$price', '$description', '$category', '$country')";

        if ($con->query($sql) === TRUE) {
            echo "Record updated successfully";
        } 
        else {
            echo "Error updating record: " . $conn->error;
        }

    }
    else{
        echo "Please upload all the files again.<br>";
    }
}
?>