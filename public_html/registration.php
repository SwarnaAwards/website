<?php
header('Content-Type: application/json');

$response = array(
	'success' => false,
	'message' => ''
);

require('db.php');
require_once('./razor-php/config.php');

$awardcategory = array(
	"1" => "Swarna Super Star - Male",
	"2" => "Swarna Super Star - Female",
	"3" => "Swarna Star Couple",
	"4" => "Swarna Comedy Star - Male",
	"5" => "Swarna Comedy Star - Female",
	"6" => "Swarna Stars Team - Comedy",
	"7" => "Swarna Star Social Cause - Team",
	"8" => "Swarna Star kid",
	"9" => "Swarna Star Singer",
);


if (isset($_POST["UserName"])) {
	$name = $_POST["UserName"];
	$mobnum = $_POST["UserMobile"];
	$emailid =  $_POST["UserEmail"];
	$place = $_POST["UserLocation"];
	$fid = $_POST['fid'];
	//$award= $_POST["AwardCategory"];
	//$videos=$_FILES["UserVideos"];
	//$CreateDate=datetime(d);

	if (isset($awardcategory[$_POST["AwardCategory"]])) {
		$award  = $awardcategory[$_POST["AwardCategory"]];
	} else {
		$award  = $_POST["AwardCategory"];
	}


	$conn->begin_transaction();

	$stmt = $conn->prepare('SELECT filePath FROM files WHERE fileId = ?');
	$stmt->bind_param('s', $fid);

	if (!$stmt->execute()) {
		$response['message'] = $stmt->error;
		http_response_code(500);
		return print json_encode($response);
	}

	$stmt->bind_result($filePath);
	$stmt->fetch();
	$stmt->close();

	if ($filePath) {
		$userInsertsql = $conn->prepare("INSERT INTO userregistration (CreateDate, UserName, UserMobile, UserEmail, UserLocation, AwardCategory, UserVideos, UserVideoFileId) VALUES (now(), ?, ?, ?, ?, ?, ?, ?)");
		if ($userInsertsql) {
			$userInsertsql->bind_param('sssssss', $name, $mobnum, $emailid, $place, $award, $filePath, $fid);

			$updateQuery = $conn->prepare('UPDATE files SET updatedAt = now(), inUse = 1 where fileId = ?');
			$updateQuery->bind_param('s', $fid);

			if ($userInsertsql->execute() === TRUE && $updateQuery->execute() === TRUE) {
				// echo "New record created successfully";
				$lastinsertid = mysqli_insert_id($conn);
				$conn->commit();
				$conn->close();

				$response['success'] = true;
				$response['razorPrefillEmail'] = $emailid;
				$response['razorPrefillMobile'] = $mobnum;
				$response['razorApiKey'] = $api_key_id;
				$response['location'] = 'razor-php/index.php?mobile=' . $mobnum . '&email=' . $emailid;
				return print json_encode($response);
			} else {
				$conn->rollback();
				$conn->close();
				http_response_code(500);
				$response['message'] = "Error: " . $conn->error;
				return print json_encode($response);
			}
		} else {
			http_response_code(500);
			$response['message'] = $conn->error;
			return print json_encode($response);
		}
	} else {
		http_response_code(400);
		$response['message'] = "Your video file doesn't exist, please retry";
		return print json_encode($response);
	}
} else {
	http_response_code(500);
	$response['message'] = "Something went wrong, please try again later";
	return print json_encode($response);
}
