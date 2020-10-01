<?php
require ('db.php');
require('productionmode.php');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

	if($productionmode == 1){
		 $projectdirectory = "";
	}else{
		$projectdirectory = "sline";
	}
if(isset($_POST['submit']))	
{
	$name= $_POST["UserName"];
	$mobnum= $_POST["UserMobile"];
	$emailid=  $_POST["UserEmail"];	
	$comments= $_POST["UserComments"];
	
$sql = "INSERT INTO  contactus (UserName, UserMobile, UserEmail, Usercomments, CreateDate)
		VALUES ('".$name."', '".$mobnum."', '".$emailid."', '".$comments."', now())";
		

		if ($conn->query($sql) === TRUE) {
		echo '<script language="javascript">';
        echo 'alert("Your message has been submitted succesfully, We will reach out to you & answer all your questions personally.Recurring questions questions will be added to FAQ page.");location.href="contact.html"';
        echo '</script>';
		  $lastinsertid = mysqli_insert_id($conn);
		  mysqli_close($conn); 
		}
		else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		  die;
		}
}
		
?>