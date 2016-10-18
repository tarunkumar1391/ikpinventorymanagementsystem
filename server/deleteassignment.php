<?php
/**
 * Created by PhpStorm.
 * User: Haus-IT
 * Date: 10/11/2016
 * Time: 2:54 PM
 */

$sno = $availStk = $qrd = "";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikp";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
$stmt = $conn->prepare("DELETE  FROM hardwareassignments WHERE sno=?");
$stmt->bind_param("i", $sno);

$stmt2 = $conn->prepare("UPDATE inventory SET devQuantity=? WHERE qrData=?");
$stmt2->bind_param("is", $availStk,$qrd);

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $sno = isset($_POST['recordNum']) ? $_POST['recordNum'] : "0";
    $availStk = isset($_POST['availStock']) ? $_POST['availStock'] : "0";
    $qrd = isset($_POST['qrd']) ? $_POST['qrd'] : "0";
}

if ($stmt2->execute()) {

    if($stmt->execute()){
        echo "The record has been deleted and the inventory has been updated ".'\n' ;
        echo '<a href="../www/index.html">click here to return!!</a>';
//    header("Location: ../www/index.html");
    }else {
        die('execute() failed: ' . htmlspecialchars($stmt->error));
    }

} else {
    die('execute() failed: ' . htmlspecialchars($stmt2->error));
}

//if( true === $stmt){
//    die('execute() failed: ' . htmlspecialchars($stmt->error));
//}
//

//printf ("New records created successfully", $stmt->error);


$stmt2->close();
$stmt->close();
$conn->close();
?>