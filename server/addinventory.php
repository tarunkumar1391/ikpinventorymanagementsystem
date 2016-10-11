<?php
/**
 * Created by PhpStorm.
 * User: Haus-IT
 * Date: 9/8/2016
 * Time: 11:50 AM
 */



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikp";
//define variables
$devCategory = $deviceType =  $brandName = $originalStock = $devQuantity = $deviceCondition = $deviceDesc = $qrdata = $timeStmp = $qrimg ="";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO inventory (devCategory, devName, brandName, originalStock, devQuantity, devCondition, devDescription,qrData, timeStmp) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiissss", $devCategory, $deviceType, $brandName,$originalStock, $devQuantity, $deviceCondition, $deviceDesc, $qrdata, $timeStmp  );

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// set parameters and execute
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $devCategory = isset($_POST['devCategory']) ? input($_POST['devCategory']) : "0";
    $deviceType = isset($_POST['deviceType']) ? input($_POST['deviceType']) : "0";
    $brandName = isset($_POST['brandName']) ? input($_POST['brandName']) : "0";
    $originalStock = isset($_POST['devQuantity']) ? input($_POST['devQuantity']) : "0";
    $devQuantity = isset($_POST['devQuantity']) ? input($_POST['devQuantity']) : "0";
    $deviceCondition = isset($_POST['deviceCondition']) ? input($_POST['deviceCondition']) : "0";
    $deviceDesc = isset($_POST['deviceDesc']) ? input($_POST['deviceDesc']) : "0";
    $tempDir = "/qrimg/";
    $qrdata = "IKP-INV-". strtoupper(substr($devCategory,0,3)) . "-" . strtoupper(substr($deviceType,0,3)) . "-" . uniqid(); ;
    $timeStmp = date("Y-m-d H:i:s");;
}


if ($stmt->execute()) {
    echo "A new entry has been created successfully!! ".'\n' ;
    echo '<a href="../www/index.html">click here to return!!</a>';
//    header("Location: ../www/index.html");

} else {
    die('execute() failed: ' . htmlspecialchars($stmt->error));
}

//if( true === $stmt){
//    die('execute() failed: ' . htmlspecialchars($stmt->error));
//}
//

//printf ("New records created successfully", $stmt->error);


$stmt->close();
$conn->close();
?>