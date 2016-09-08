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
$devCategory = $deviceType = $entryType =  $brandName = $devQuantity = $deviceCondition = $deviceDesc = $timeStmp = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO inventory (devCategory, devName, entryType, brandName, devQuantity, devCondition, devDescription, timeStmp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssisss", $devCategory, $deviceType, $entryType, $brandName, $devQuantity, $deviceCondition, $deviceDesc, $timeStmp  );

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
    $entryType = isset($_POST['entryType']) ? input($_POST['entryType']) : "0";
    $brandName = isset($_POST['brandName']) ? input($_POST['brandName']) : "0";
    if($entryType == "Single"){
        $devQuantity = 1;
    } else {
        $devQuantity = isset($_POST['devQuantity']) ? input($_POST['devQuantity']) : "0";
    }

    $deviceCondition = isset($_POST['deviceCondition']) ? input($_POST['deviceCondition']) : "0";
    $deviceDesc = isset($_POST['deviceDesc']) ? input($_POST['deviceDesc']) : "0";
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