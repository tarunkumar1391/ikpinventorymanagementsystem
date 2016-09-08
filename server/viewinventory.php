<?php
/**
 * Created by PhpStorm.
 * User: Haus-IT
 * Date: 9/8/2016
 * Time: 3:38 PM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "root", "", "ikp");

$result = $conn->query("SELECT * FROM inventory");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"Sno":"'  . $rs["sno"] . '",';
    $outp .= '"devCategory":"'  . $rs["devCategory"] . '",';
    $outp .= '"devName":"'  . $rs["devName"] . '",';
    $outp .= '"entryType":"'  . $rs["entryType"] . '",';
    $outp .= '"brandName":"'   . $rs["brandName"] . '",';
    $outp .= '"devQuantity":"'   . $rs["devQuantity"] . '",';
    $outp .= '"Condition":"'. $rs["devCondition"] . '",';
    $outp .= '"Description":"'. $rs["devDescription"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>