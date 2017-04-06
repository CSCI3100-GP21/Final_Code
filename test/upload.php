<?php
if ($_FILES["file"]["error"] > 0){
	echo "Error: " . $_FILES["file"]["error"];
}
else{
echo "file name: " . $_FILES["file"]["name"]."<br/>";
echo "file type: " . $_FILES["file"]["type"]."<br/>";
echo "file size: " . ($_FILES["file"]["size"] / 1024)." Kb<br />";
echo "tmp name: " . $_FILES["file"]["tmp_name"];
}
?>