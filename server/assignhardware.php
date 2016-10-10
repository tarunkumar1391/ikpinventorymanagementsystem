<?php
/**
 * Created by PhpStorm.
 * User: tkumar
 * Date: 9/15/16
 * Time: 4:42 PM
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikp";
//define variables
$assignTo = $roomNo =  $emailId = $devCategory = $device = $devBrand = $deviceCondition = $availStock = $devQuantity = $comments = $qrData = $newStock="";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO hardwareassignments (assignedTo, roomNo, emailId, devCategory, device, devBrand, devCondition,quantity, comments, qrData, timeStmp) VALUES (?,?, ?, ?, ?, ?, ?, ?,?,?,?)");
$stmt->bind_param("sssssssisss", $assignTo,$roomNo,$emailId, $devCategory, $device, $devBrand, $deviceCondition,$devQuantity, $comments,$qrData, $timeStmp  );

$stmt2 = $conn->prepare("UPDATE inventory SET devQuantity=? WHERE qrData=?");
$stmt2->bind_param("is", $newStock,$qrData);
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// set parameters and execute
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $assignTo = isset($_POST['assigneeName']) ? input($_POST['assigneeName']) : "0";
    $roomNo = isset($_POST['assigneeRoom']) ? input($_POST['assigneeRoom']) : "0";
    $emailId = isset($_POST['assigneeEmail']) ? input($_POST['assigneeEmail']) : "0";
    $devCategory = isset($_POST['devCategory']) ? input($_POST['devCategory']) : "0";
    $device = isset($_POST['deviceType']) ? input($_POST['deviceType']) : "0";
    $devBrand = isset($_POST['deviceBrand']) ? input($_POST['deviceBrand']) : "0";
    $deviceCondition = isset($_POST['deviceCond']) ? input($_POST['deviceCond']) : "0";
    $devQuantity = isset($_POST['hardwareQty']) ? input($_POST['hardwareQty']) : "0";
    $comments = isset($_POST['hardComm']) ? input($_POST['hardComm']) : "0";
    $qrData = isset($_POST['qrData']) ? input($_POST['qrData']) : "0";
    $availStock = isset($_POST['availStock']) ? input($_POST['availStock']) : "0";
    $timeStmp = date("Y-m-d H:i:s");
    
    if($devQuantity <= $availStock && $devQuantity > 0){
        $newStock = $availStock - $devQuantity;
    } else {
        echo "The Chosen quantity is more than what is present in the inventory. Please enter a valid quantity!!";
    }
}


if ($stmt2->execute()) {

    if($stmt->execute()){
        echo "A new entry has been created successfully and the license database has been updated accordingly!! ".'\n' ;
        echo '<a href="../www/index.html">click here to return!!</a>';
//    header("Location: ../www/index.html");
    }else {
        die('execute() failed: ' . htmlspecialchars($stmt->error));
    }

} else {
    die('execute() failed: ' . htmlspecialchars($stmt->error));
}



$stmt2->close();
$stmt->close();
$conn->close();
?>