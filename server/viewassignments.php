<?php
/**
 * Created by PhpStorm.
 * User: Haus-IT
 * Date: 10/10/2016
 * Time: 2:55 PM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "root", "", "ikp");

$result = $conn->query("SELECT * FROM hardwareassignments");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"Sno":"'  . $rs["sno"] . '",';
    $outp .= '"Name":"'  . $rs["assignedTo"] . '",';
    $outp .= '"Email":"'  . $rs["emailId"] . '",';
    $outp .= '"Room":"'  . $rs["roomNo"] . '",';
    $outp .= '"Category":"'   . $rs["devCategory"] . '",';
    $outp .= '"Device":"'   . $rs["device"] . '",';
    $outp .= '"Brand":"'   . $rs["devBrand"] . '",';
    $outp .= '"availableStock":"'   . $rs["availStock"] . '",';
    $outp .= '"Quantity":"'   . $rs["quantityReq"] . '",';
    $outp .= '"Condition":"'. $rs["devCondition"] . '",';
    $outp .= '"qrData":"'. $rs["qrData"] . '",';
    $outp .= '"DoA":"'. $rs["timeStmp"] . '",';
    $outp .= '"Comments":"'. $rs["comments"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>