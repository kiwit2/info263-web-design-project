<?php

	//echo "Processing your message..";
	$message = "";
	$message .= "To: aeolusdrones@gmail.com" . "<br/>"; // Use your own email address
	$subject = $_POST['email_subject'];
	$message .= $subject . "<br/><br/>";

	$message .= 'From: ' . $_POST['first_name'] . " " . $_POST['last_name'] . "<br/>";
	$message .= "Email: " . $_POST['email_address'] . "<br/><br/>";
	$message .= $_POST['email_body'] . "<br/>";

	//$headers = "From: " . $_POST['email_address'] . "\r\n";
	//$headers .= 'Content-Type: text/plain; charset=utf-8';

	//$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	//if ($email) {
	//   $headers .= "\r\nReply-To: $email";
	//}

	//$success = mail($to, $subject, $message, $headers);
	
	
?>


<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Contact Aeolus</title>
	<meta name="keywords" content="drone, drones, aeolus, exploration, racing, contact, contact aeolus" />
	<meta name="description" content="Page which holds contact information and a method (form) to communicate with Aeolus directly." />
	<link href="default.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript" src="./contact/contact.js"></script>
</head>

<body>
	<div id="header" class="container">
		<div id="logo">
			<h1>
				<a href="./index.html">
					<img src="./aeoluslogo.png" alt="Aeolus Group LTD" height="155" width="467" />
				</a>
			</h1>
		</div>
		<div id="menu">
			<ul>
				<li><a href="./index.html" accesskey="1" title="">Home</a></li>
				<li><a href="./about.html" accesskey="2" title="">About</a></li>
				<li><a href="./products.php" accesskey="3" title="">Products</a></li>
				<li><a href="./contact.html" accesskey="4" title="">Contact</a></li>
			</ul>
		</div>
	</div>
	<div id="wrapper">
		<div id="page" class="container">			
			<div class="form_container">
				<img id="top" src="./contact/top.png" alt="" />	
				     <br />
				     <br />
						<h1>Thank You, Your Details Have Been Noted</h1>
						<h2>An Aeolus Representative Will Contact You Soon</h2>
						<div style="text-align:left">
							<?php echo $message; ?>
						</div>
					<br />
					<br />	
				<img id="bottom" src="./contact/bottom.png" alt="" />
			</div>		
		</div>
	</div>
	
	
	<div id="copyright" class="container">
		<p>&copy; All rights reserved. | Content by Aeolus | CCS Skeleton by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
	</div>
</body>
</html>
