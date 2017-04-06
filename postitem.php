<?php
define("MAX_FILE_SIZE", 2000000);
//echo "entered php<br>";

if (isset($_POST['post_item']) && isset($_FILES['fileToUpload1']) && isset($_FILES['fileToUpload2']) && isset($_FILES['fileToUpload3'])){

    //echo "entered submit<br>";

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
        //echo "File1 is an image - " . $check1["mime"] . ".<br>";
        $uploadOk1 = 1;
    } else {
        echo "File1 is not an image.<br>";
        $uploadOk1 = 0;
    }

    $check2 = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
    if($check2 == true) {
        //echo "File2 is an image - " . $check2["mime"] . ".<br>";
        $uploadOk2 = 1;
    } else {
        echo "File2 is not an image.<br>";
        $uploadOk2 = 0;
    }

    $check3 = getimagesize($_FILES["fileToUpload3"]["tmp_name"]);
    if($check3 == true) {
        //echo "File3 is an image - " . $check3["mime"] . ".<br>";
        $uploadOk3 = 1;
    } else {
        echo "File3 is not an image.<br>";
        $uploadOk3 = 0;
    }

    // Check if file already exists
    // if (file_exists($target_file)) {
    //     //echo "Sorry, file already exists.";
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
        echo "Sorry file1 is not supported, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk1 = 0;
    }
    if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg"
    && $imageFileType2 != "gif" ) {
        echo "Sorry file2 is not supported, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk2 = 0;
    }
    if($imageFileType3 != "jpg" && $imageFileType3 != "png" && $imageFileType3 != "jpeg"
    && $imageFileType3 != "gif" ) {
        echo "Sorry file3 is not supported, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk3 = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk1 == 0) {
        echo "Sorry, file1 was not uploaded.<br>";
    // if everything is ok, try to upload file
    } 
    if ($uploadOk2 == 0) {
        echo "Sorry, file2 was not uploaded.<br>";
    // if everything is ok, try to upload file
    } 
    if ($uploadOk3 == 0) {
        echo "Sorry, file3 was not uploaded.<br>";
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
        //echo "product_count: ".$row["count(*)"]."<br>";
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
            echo "Sorry, there was an error uploading file3.<br>";
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
            echo "Record updated successfully<br>";
        }
        else {
            echo "Error updating record: " . $conn->error."<br>";
        }

    }
    else{
        echo "Please upload all the files again.<br>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shopin A Ecommerce Category Flat Bootstrap Responsive Website Template | Home :: w3layouts</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<!--theme-style-->
<link href="css/style2.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Shopin Responsive web template, Bootstrap Web Templates, Flat Web Templates, AndroId Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--theme-style-->
<link href="css/style4.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<script src="js/jquery.min.js"></script>
<!--- start-rate---->
<script src="js/jstarbox.js"></script>
	<link rel="stylesheet" href="css/jstarbox.css" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript">
			jQuery(function() {
			jQuery('.starbox').each(function() {
				var starbox = jQuery(this);
					starbox.starbox({
					average: starbox.attr('data-start-value'),
					changeable: starbox.hasClass('unchangeable') ? false : starbox.hasClass('clickonce') ? 'once' : true,
					ghosting: starbox.hasClass('ghosting'),
					autoUpdateAverage: starbox.hasClass('autoupdate'),
					buttons: starbox.hasClass('smooth') ? false : starbox.attr('data-button-count') || 5,
					stars: starbox.attr('data-star-count') || 5
					}).bind('starbox-value-changed', function(event, value) {
					if(starbox.hasClass('random')) {
					var val = Math.random();
					starbox.next().text(' '+val);
					return val;
					} 
				})
			});
		});
		</script>
<!---//End-rate---->

</head>
<body>
<!--header-->
<div class="header">
<div class="container">
		<div class="head">
			<div class=" logo">
				<a href="seller_index.html"><img src="images/logo.png" alt=""></a>	
			</div>
		</div>
	</div>
	<div class="header-top">
		<div class="container">
		<div class="col-sm-5 col-md-offset-2  header-login">
					<ul >
						<li><a href="login.html">Login</a></li>
						<li><a href="register.html">Register</a></li>
						<li><a href="checkout.html">Checkout</a></li>
					</ul>
				</div>
				
			<div class="col-sm-5 header-social">		
					<ul >
						<li><a href="#"><i></i></a></li>
						<li><a href="#"><i class="ic1"></i></a></li>
						<li><a href="#"><i class="ic2"></i></a></li>
						<li><a href="#"><i class="ic3"></i></a></li>
						<li><a href="#"><i class="ic4"></i></a></li>
					</ul>
					
			</div>
				<div class="clearfix"> </div>
		</div>
		</div>
		
		<div class="container">
		
			<div class="head-top">
			
		 <div class="col-sm-8 col-md-offset-2 h_menu4">
				<nav class="navbar nav_bottom" role="navigation">
 
 <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header nav_2">
      <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     
   </div> 
   <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
        <ul class="nav navbar-nav nav_1">
            <li><a class="color" href="seller_index.html">Home</a></li>
            
    		<li>
			    <a class="color1" href="postitem.php">Post New Item</a>				
			</li>
			<li>
			    <a class="color2" href="updateitem.html">Update My Items</a>							
			</li>
			<li><a class="color4" href="404_seller.html">About</a></li>
            <li ><a class="color6" href="contact_seller.html">Contact</a></li>
        </ul>
     </div><!-- /.navbar-collapse -->

</nav>
			</div>
			<div class="col-sm-2 search-right">
				
					
					<div class="clearfix"> </div>
					
						<!----->

						<!---pop-up-box---->					  
			<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all"/>
			<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
			<!---//pop-up-box---->
			<div id="small-dialog" class="mfp-hide">
				<div class="search-top">
					<div class="login-search">
						<input type="submit" value="">
						<input type="text" value="Search.." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search..';}">		
					</div>
					<p>Shopin</p>
				</div>				
			</div>		
						<!----->
			</div>
			<div class="clearfix"></div>
		</div>	
	</div>	
</div>
<!--banner-->
<div class="banner_3">
<div class="container">
<section class="rw-wrapper">
				<h1 class="rw-sentence">
					<span>B u y M e C h i p s</span>
					<div class="rw-words rw-words-1">
						<span> Global</span>
						<span>Most Beautiful</span>
						<span>Lowest Price</span>
						<span>heheXD</span>
					</div>
					<div class="rw-words rw-words-2">
						<span>Always in style</span>
						<span>More stores More value</span>
						<span>World of happiness</span>
						<span>MikeWorld</span>
					</div>
				</h1>
			</section>
			</div>
</div>
	<!--content-->
		<div class="content">
			<div class="container">
			<br><br>
			<div class="col-2">
							<h2>Bring a New Item to BMC</a></h2>
							<h4>PLease enter the information of your product.</h4><br>
							
						</div>
			
				<form action="postitem.php" method="post" enctype="multipart/form-data">
				
				<label for="Product Name">Product name: &nbsp &nbsp &nbsp &nbsp &nbsp</label>
				<input id="product_name" type="text" name="product_name" >
				<br><br>
				
				<label for="Price">Price: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</label>
				<input id="price" type="text" name="price" >
				<br><br>
				
				<label for="Description">Description: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</label>
				<input id="description" type="text" name="description" >
				<br><br>
				
				<label for="Origin Country">Production Country: &nbsp</label>
				<input id="country" type="text" name="country" >
				<br><br>
				<label for="Category">Category: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </label>
				<input id="category" type="text" name="category" >
				<br><br>
				<label for="Production Country">Upload three photos: </label>

				<input type="file" name="fileToUpload1" id="fileToUpload1"><br>
				<input type="file" name="fileToUpload2" id="fileToUpload2"><br>
				<input type="file" name="fileToUpload3" id="fileToUpload3"><br>
				<br>
    			<input type="submit" value="Post Item now!" name="post_item">
				</form>
				<br>
				<br>
				
		</div>

				<!--//footer-->
	<div class="footer">
	<div class="footer-middle">
				<div class="container">
					<div class="col-md-3 footer-middle-in">
						<a href="seller.html"><img src="images/log.png" alt=""></a>
						<p>Suspendisse sed accumsan risus. Curabitur rhoncus, elit vel tincidunt elementum, nunc urna tristique nisi, in interdum libero magna tristique ante. adipiscing varius. Vestibulum dolor lorem.</p>
					</div>
					
					<div class="col-md-3 footer-middle-in">
						<h6>Information</h6>
						<ul class=" in">
							<li><a href="404_seller.html">About</a></li>
							<li><a href="contact_seller.html">Contact Us</a></li>
							<li><a href="#">Returns</a></li>
							<li><a href="contact_seller.html">Site Map</a></li>
						</ul>
						<ul class="in in1">
							<li><a href="#">Order History</a></li>
							<li><a href="wishlist.html">Wish List</a></li>
							<li><a href="login.html">Login</a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="col-md-3 footer-middle-in">
						<h6>Tags</h6>
						<ul class="tag-in">
							<li><a href="#">Lorem</a></li>
							<li><a href="#">Sed</a></li>
							<li><a href="#">Ipsum</a></li>
							<li><a href="#">Contrary</a></li>
							<li><a href="#">Chunk</a></li>
							<li><a href="#">Amet</a></li>
							<li><a href="#">Omnis</a></li>
						</ul>
					</div>
					<div class="col-md-3 footer-middle-in">
						<h6>Newsletter</h6>
						<span>Sign up for News Letter</span>
							<form>
								<input type="text" value="Enter your E-mail" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='Enter your E-mail';}">
								<input type="submit" value="Subscribe">	
							</form>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
			<div class="footer-bottom">
				<div class="container">
					<ul class="footer-bottom-top">
						<li><a href="#"><img src="images/f1.png" class="img-responsive" alt=""></a></li>
						<li><a href="#"><img src="images/f2.png" class="img-responsive" alt=""></a></li>
						<li><a href="#"><img src="images/f3.png" class="img-responsive" alt=""></a></li>
					</ul>
					<p class="footer-class">&copy; 2016 Shopin. All Rights Reserved | Design by  <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
		<!--//footer-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/simpleCart.min.js"> </script>
<!-- slide -->
<script src="js/bootstrap.min.js"></script>
<!--light-box-files -->
		<script src="js/jquery.chocolat.js"></script>
		<link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen" charset="utf-8">
		<!--light-box-files -->
		<script type="text/javascript" charset="utf-8">
		$(function() {
			$('a.picture').Chocolat();
		});
		</script>

</body>
</html>