<?php
	
	//variables associated with shipping details form
	
	$first_name = test_input($_POST['first_name']);
	$last_name = test_input($_POST['last_name']);
	$name = $first_name . " " . $last_name;
	$email_address = test_input($_POST['email_address']);
	$address = test_input($_POST['address']);
	$city = test_input($_POST['city']);
	$zip = test_input($_POST['zip']);
	$country = test_input($_POST['country']);
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	// Insert data into the database
	$servername = "localhost";
	$username = "DBAdmin";
	$password = "afis233";
	$dbname = "Aeolus";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	//insert customer data into customer table
	$sql = "INSERT INTO CUSTOMER (CUSTOMER_NAME, EMAIL, ADDRESS, CITY, ZIP, COUNTRY)
	VALUES ('$name', '$email_address', '$address', '$city', '$zip', '$country')";

	if (mysqli_query($conn, $sql)) {
		//echo "New customer record created successfully<br/>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
	//get current customer ID and prepare customer part of email	
	$sql = "SELECT * FROM CUSTOMER WHERE CUSTOMER_NAME = '$name' AND EMAIL = '$email_address' AND ADDRESS = '$address'";
	$result = $conn->query($sql);
	$customer_info = "";
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {	    	
	    	$customer_ID = $row["CUSTOMER_NUM"];
	        $customer_info .= "<br/>" . "Name: " . $row["CUSTOMER_NAME"];
	        $customer_info .= "<br/>" . "Email: " . $row["EMAIL"];
	        $customer_info .= "<br/>" . "Address: " . $row["ADDRESS"];
	        $customer_info .= "<br/>" . "City: " . $row["CITY"];
	        $customer_info .= "<br/>" . "Zip Code: " . $row["ZIP"];
	        $customer_info .= "<br/>" . "Country: " . $row["COUNTRY"];
	    }
	} else {
	    echo "0 results";
	}
	
	date_default_timezone_set('Pacific/Auckland');
	$todays_date = date('Y-m-d');
	
	//pull current order number
	$sql = "SELECT MAX(ORDER_NUM) FROM ORDER_ITEM;";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		$order_num = $row['MAX(ORDER_NUM)'];
	}
	
	//update order_items to completed status
	$sql = "UPDATE ORDER_ITEM SET COMPLETED=TRUE WHERE ORDER_NUM = $order_num;";

	if (mysqli_query($conn, $sql)) {
		//echo "New order record created successfully<br/>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}	
	
	//insert stuff into order table
	$sql = "INSERT INTO ORDERS (ORDER_NUM, CUSTOMER_NUM, DATE) VALUES ($order_num, $customer_ID, '$todays_date')";
	if (mysqli_query($conn, $sql)) {
		//echo "New order record created successfully<br/>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}	

	
	$order_info = "";
	//pull product information from order_item table
	$sql="SELECT PRODUCT.PRODUCT_NUM, PRODUCT.PRODUCT_NAME, PRODUCT.PRICE, SUM(ORDER_ITEM.QTY) FROM PRODUCT, ORDER_ITEM WHERE ORDER_ITEM.ORDER_NUM = $order_num AND ORDER_ITEM.PRODUCT_NUM = PRODUCT.PRODUCT_NUM GROUP BY PRODUCT.PRODUCT_NAME"; 
	$result = $conn->query($sql);
	$total = 0;	
	$temp_total = 0;
				
	while($row = $result->fetch_assoc()) {
		$temp_total = ($row['PRICE'] * $row['SUM(ORDER_ITEM.QTY)']);
		$order_info .=  $row['PRODUCT_NAME'] . " x " . $row['SUM(ORDER_ITEM.QTY)'] . " [$" . $temp_total ."]<br/>";
		$total += $temp_total;
	}
	$order_info .= "Total: $" . $total . "<br/>";
	
	$date_info = "Order received on " . $todays_date;
	
	$message = "To: aeolusdrones@gmail.com" . "<br/>";
	$message .= "Subject: Order for " . $name . "<br/>";

	//$to = 'daniel.m.lorimer@gmail.com'; // email address to send information to
	//$subject = "Order for " . $name;
	
	//email headers
	//$headers = "From: " . $email_address . "\r\n";
	//$headers .= 'Content-Type: text/plain; charset=utf-8';

	$message .=  "<br/>" . $date_info . "<br/>";
	$message .= "<br/>" . "Customer Information:";
	
	$message .= $customer_info . "<br/>"; 
	$message .= "<br/>" . "Order Information:" . "<br/>";
	$message .= $order_info;
	
	//send email
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
						<h1>Thank You For Your Order</h1>
						<h2>Once payment has been processed a confirmation email will be sent</h2>
						<div style="text-align: left">
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





