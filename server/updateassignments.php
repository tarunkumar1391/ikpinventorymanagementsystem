<?php
/**
 * Created by PhpStorm.
 * User: Haus-IT
 * Date: 10/10/2016
 * Time: 4:18 PM
 * To be updated further
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikp";
//define variables
$sno = $devCategory = $deviceType = $entryType = $brandName = $actualStock = $devQuantity = $deviceCondition = $deviceDesc = $timestmp = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("UPDATE inventory SET devCategory=?, devName=?,  entryType=?, brandName=?, devQuantity=?, devCondition=?, devDescription=?, timeStmp=?  WHERE sno=?");
$stmt->bind_param("ssssisssi", $devCategory, $deviceType, $entryType, $brandName, $devQuantity, $deviceCondition, $deviceDesc, $timestmp,$sno);

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// set parameters and execute
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $sno = isset($_POST['entryid']) ? input($_POST['entryid']) : "0";
    $devCategory = isset($_POST['devCategory']) ? input($_POST['devCategory']) : "0";
    $deviceType = isset($_POST['deviceType']) ? input($_POST['deviceType']) : "0";
    $entryType = isset($_POST['entryTyp']) ? input($_POST['entryTyp']) : "0";
    $brandName = isset($_POST['brandName']) ? input($_POST['brandName']) : "0";
    $actualStock = isset($_POST['brandName']) ? input($_POST['brandName']) : "0";
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

    echo "The entry". $sno ." has been updated successfully!! ".'\n' ;
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