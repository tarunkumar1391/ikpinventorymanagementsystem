<?php
/**
 * Created by PhpStorm.
 * User: Haus-IT
 * Date: 10/11/2016
 * Time: 2:54 PM
 */

$sno = "";

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

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $sno = isset($_POST['recordNum']) ? $_POST['recordNum'] : "0";

}

if ($stmt->execute()) {

    echo "The entry". $sno ." has been deleted successfully!! ".'\n' ;
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