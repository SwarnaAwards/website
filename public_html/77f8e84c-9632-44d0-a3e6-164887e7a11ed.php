<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="assets/img/swarna-logo.png" sizes="16x16" type="image/png">
    <link rel="stylesheet" href="assets/css/animate.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/venom-button.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/icofont.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/boostrap.css" type="text/css">
    <link rel="stylesheet" href="assets/css/homepage.css" type="text/css">
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

.ScrollStyle
{
    max-height: 500px;
    overflow-y: scroll;
	max-width : max-content;
}
</style>
</head>
<body>
<?php
require('db.php');
require('productionmode.php');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
<h2>Admin Dashboard</h2>
<div class="ScrollStyle">
<table>
  <tr>
  <th>
    <th>#</th>
    <input type="checkbox"></th>
    <th>Name</th>
    <th>Email</th>
    <th>Mobile</th>
	<th>Location</th>
	<th>Award Category</th>
	<th>Register on</th>
	<th>Video Link</th>
  </tr>
  
  <?php
  
  if($productionmode == 1){
     $projectdirectory = "";
}else{
	$projectdirectory = "sline";
}
  //http://localhost/sline/dashboard.php
  $imagePath =  'http://'.$_SERVER['HTTP_HOST'].'/'.$projectdirectory.'/upload/videos/';
  $sql = "SELECT * FROM sline.userregistration ORDER BY UId DESC;";
  $result = $conn->query($sql);
  $i=1;
  if($result->num_rows > 0){
      
	  while($row = $result->fetch_assoc()){
	  
	  //echo "username".$row['UserName'];
	  //echo $imagePath;
	  $pathComponents = explode('/',$row['UserVideos']);
      $fileName = $pathComponents[count($pathComponents) -1]
	  
	  ?>
	   
		<tr>
			<td><input type="checkbox"></td>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['UserName']; ?></td>
			<td><?php echo $row['UserEmail']; ?></td>
			<td><?php echo $row['UserMobile']; ?></td>
			<td><?php echo $row['UserLocation']; ?></td>
			<td><?php echo $row['AwardCategory']; ?></td>
			<td><?php echo $row['CreateDate']; ?></td>
			<td>
			<a href="<?php echo $imagePath.$fileName?>"  target="_blank">
			<div style="height:100%;width:100%">
			View Video here
			</div>
			</td>
		</tr>
	  <?php
	  }
 
  }else{
	  echo "No records found in the database";
  }
  ?>
  
</table>
</div>
</br>

<div>
   <table>
  <tr>
  <td colspan="2">
    <a href="http://example.com"  target="_blank">
    <div style="height:100%;width:100%">
      SMS
    </div>
  </td>
    <td colspan="2">
    <a href="http://example.com"  target="_blank">
    <div style="height:100%;width:100%">
      Whatsapp
    </div>
  </td>
  <td colspan="2">
    <a href="http://example.com"  target="_blank">
    <div style="height:100%;width:100%">
      Email
    </div>
  </td>
  </tr>
</div>
</body>
</html>
<?php   mysqli_close($conn); ?>