<?php
/**
 * Created by PhpStorm.
 * User: tarun
 * Date: 11/25/16
 * Time: 6:13 PM
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikp";
//define variables
$userName = $userEmail =  $userRoom = $devCategory = $devType = $brandName = $devQuantity = $devCondition = $kostenstelle = $invNumber = $devDesc = $timestamp = $subject= "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO userdevregistration (userName, userEmail, userRoom, devCategory, devType, brandName, devQuantity,devCondition, kostenstelle, invNumber, devDesc, timestamp ) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssisiiss", $userName, $userEmail, $userRoom, $devCategory, $devType, $brandName, $devQuantity, $devCondition, $kostenstelle, $invNumber, $devDesc, $timestamp  );

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// set parameters and execute
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $userName = isset($_POST['userName']) ? input($_POST['userName']) : "0";
    $userEmail = isset($_POST['userEmail']) ? input($_POST['userEmail']) : "0";
    $userRoom = isset($_POST['userRoom']) ? input($_POST['userRoom']) : "0";
    $devCategory = isset($_POST['devCategory']) ? input($_POST['devCategory']) : "0";
    $devType = isset($_POST['deviceType']) ? input($_POST['deviceType']) : "0";
    $brandName = isset($_POST['brandName']) ? input($_POST['brandName']) : "0";
    $devQuantity = isset($_POST['devQuantity']) ? input($_POST['devQuantity']) : "0";
    $devCondition = isset($_POST['deviceCondition']) ? input($_POST['deviceCondition']) : "0";
    $kostenstelle = isset($_POST['kostenstelle']) ? input($_POST['kostenstelle']) : "0";
    $invNumber = isset($_POST['invNumber']) ? input($_POST['invNumber']) : "0";
    $devDesc = isset($_POST['deviceDesc']) ? input($_POST['deviceDesc']) : "0";
    $timestamp = date("Y-m-d H:i:s");;
    $subject = "DO NOT REPLY - Your Hardware registration at IKP";
}


if ($stmt->execute()) {
    echo "A new entry has been created successfully!! An email will be sent to you shortly confirming your submission ".'\n' ;
    echo '<a href="../www/index.html">click here to return!!</a>';
//    header("Location: ../www/index.html");
//script for mail

    require('./phpmailer/PHPMailerAutoload.php');
    $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'linix.ikp.physik.tu-darmstadt.de';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'tramdas@ikp.tu-darmstadt.de';                 // SMTP username
    $mail->Password = 'FACu0jWukG';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('tramdas@ikp.tu-darmstadt.de', 'Tarun Kumar R');
    $mail->addAddress($userEmail,$subject);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'IT - Hardware registration at IKP';
    $mail->msgHTML(file_get_contents('../www/confirmation.html'), dirname(__FILE__));
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
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