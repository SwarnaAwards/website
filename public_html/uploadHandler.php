<?php
require('db.php');

// https://stackoverflow.com/a/2040279/3764306
function gen_uuid()
{
	return sprintf(
		'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		// 32 bits for "time_low"
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),

		// 16 bits for "time_mid"
		mt_rand(0, 0xffff),

		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 4
		mt_rand(0, 0x0fff) | 0x4000,

		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		mt_rand(0, 0x3fff) | 0x8000,

		// 48 bits for "node"
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff)
	);
}

require('productionmode.php');

header('Content-Type: application/json');
http_response_code(400);

$response = array(
	'success' => false,
	'message' => ''
);

$allowedExts = array("video/mp4", "mp4", "wma");
$extension = pathinfo($_FILES['UserVideos']['name'], PATHINFO_EXTENSION);

if ((($_FILES["UserVideos"]["type"] == "video/mp4") || ($_FILES["UserVideos"]["type"] == "audio/wma")) && ($_FILES["UserVideos"]["size"] < 800000000)
	&& in_array($extension, $allowedExts)
) {
	if ($_FILES["UserVideos"]["error"] > 0) {
		$response['message'] = "Return Code: " . $_FILES["UserVideos"]["error"] . "<br />";
		return print json_encode($response);
	} else {
		$fileId = gen_uuid();
		$filefullpath = $uploadsPath . $fileId . "." . $extension;
		$uploadresponse  = move_uploaded_file($_FILES["UserVideos"]["tmp_name"], $filefullpath);

		$inUse = 0;
		$stmt = $conn->prepare('INSERT INTO files(fileId, originalName, filePath, inUse, createdAt, updatedAt) VALUES(?, ?, ?, ?, NOW(), NOW())');
		$stmt->bind_param('sssi', $fileId, $_FILES['UserVideos']['name'], $filefullpath, $inUse);
		if (!$stmt->execute()) {
			$response['message'] = $stmt->error;
			http_response_code(500);
			return print json_encode($response);
		}

		http_response_code(200);
		$response['success'] = true;
		$response['fid'] = $fileId;
		$response['message'] = 'Uploaded successfully !!';
		return print json_encode($response);
	}
} else {
	$response['message'] = "Check your file type and size. Allowed file type is .mp4 format only";
	return print json_encode($response);
}
