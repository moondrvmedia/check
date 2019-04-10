<?php
#include DB connection
include "/home/tatevik/webapps/app-collier/check/db_connect/db_connnection.php";
$status = $_POST['status'];
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$start = mysqli_real_escape_string($conn, $_POST['start']);
$end = mysqli_real_escape_string($conn, $_POST['end']);
$startUnix = strtotime($start);
$endUnix = strtotime($end);
if($_POST['phone'] && preg_match("/^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\.\/0-9]*$/", $phone)) {
	$stmt = $conn->prepare('SELECT phone FROM lead WHERE phone = ?');
	$stmt->bind_param('s', $phone);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		echo "$phone phone number already exists in DB<br>";
	} else {
		echo "$phone phone number does NOT exist in DB<br>";
	}
}
if($_POST['start'] && $_POST['end'] && $_POST['status']){
	$sql = "SELECT * FROM lead WHERE status = ? AND created_at BETWEEN ? AND ?";
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("iii", $status,$startUnix,$endUnix);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$count = $result->num_rows;
			echo "$count rows found for the period from $start to $end with status = $status in DB<br><br>";
		} else {
			echo "No rows for the period from $start to $end with status = $status in DB<br><br>";
		}	
	} else {
		echo "Could not run the query";
	}
}
?>