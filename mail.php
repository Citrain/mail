<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
try{
$bdd = new PDO('mysql:host=localhost;dbname=mail;charset=utf8', 'root', '');
}catch(Exception $e){
    die('Erreur : '.$e->getMessage());
}
require 'PHPMailer/PHPMailerAutoload.php';


 function Mailing($id=0){
	 global $bdd;
	$req = $bdd->prepare('SELECT * from user where id>:id');
	$req->bindParam(":id",$id);
	$req->execute();
	//$req->execute(array($id));

	  var_dump($req);
		var_dump($id);
	if($req->fetch()){
			while ($row = $req->fetch()) {
				$id=$row['id'];

			date_default_timezone_set('Etc/UTC');

			//Create a new PHPMailer instance
			$mail = new PHPMailer;
			//Tell PHPMailer to use SMTP
			$mail->isSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 0;
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail->Host = 'smtp.gmail.com';
			// use
			// $mail->Host = gethostbyname('smtp.gmail.com');
			// if your network does not support SMTP over IPv6
			//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
			$mail->Port = 587;
			//Set the encryption system to use - ssl (deprecated) or tls
			$mail->SMTPSecure = 'tls';
			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;
			//Username to use for SMTP authentication - use full email address for gmail
			$mail->Username = "sylv13129@gmail.com";
			//Password to use for SMTP authentication
			$mail->Password = "pass";
			//Set who the message is to be sent from
			$mail->setFrom('sylv13129@gmail.com', 'First Last');
			//Set an alternative reply-to address
			//$mail->addReplyTo('citrainsylvain@gmail.com', 'First Last');
			//Set who the message is to be sent to
			$mail->addAddress($row['Email'], 'John Doe');
			//Set the subject line
			$mail->Subject = 'PHPMailer GMail SMTP test';
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
			//Replace the plain text body with one created manually
			$mail->AsltBody = 'This is a plain-text message body';
			$mail->msgHTML('<p>
			test
			</p>');
			//Attach an image file
			//$mail->addAttachment('images/phpmailer_mini.png');
			//send the message, check for errors
			if (!$mail->send()) {
			    echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
			    echo "Message sent!";
			}

			$req->closeCursor();
			echo"<br /><br />";
			echo date('s') . "\n";
			echo"<br /><br />";
			usleep(2000000);
			echo date('s') . "\n";
				Mailing($id);
		}
	}else{break;}

}

Mailing();
