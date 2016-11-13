<?php 
	//Insert data into the database
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
	
	$sql = "SELECT MAX(ORDER_NUM) FROM ORDER_ITEM WHERE COMPLETED = FALSE";
	$result = $conn->query($sql);
	
	$row = $result->fetch_assoc();
	
	if ($row['MAX(ORDER_NUM)'] <> NULL) {
		$order_num = $row['MAX(ORDER_NUM)'];
	}
	else { ?>
	<script type="text/javascript">
		function redirect(url)
		{
		 location.href = url;
		}
		
	    redirect("./products.php");
	</script>
		
	<?php } ?>
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
				<li><a href="products.php" accesskey="3" title="">Products</a></li>
				<li><a href="./contact.html" accesskey="4" title="">Contact</a></li>
			</ul>
		</div>
	</div>
	<div id="wrapper">
		<div id="page" class="container">			
			<div class="form_container">
				<img id="top" src="./contact/top.png" alt="" />				
				<h1 class="form_heading">Order Summary</h1>
                
                <table class="shoppingcart">			
			
			<tr class="titles">
				<td>Name</td>
				<td>Quantity</td>
				<td>Price</td>
			</tr>
			
			<?php 
  				
				$sql="SELECT PRODUCT.PRODUCT_NUM, PRODUCT.PRODUCT_NAME, PRODUCT.PRICE, SUM(ORDER_ITEM.QTY) FROM PRODUCT, ORDER_ITEM WHERE ORDER_ITEM.ORDER_NUM = $order_num AND ORDER_ITEM.PRODUCT_NUM = PRODUCT.PRODUCT_NUM GROUP BY PRODUCT.PRODUCT_NAME"; 
				
				$result = $conn->query($sql);
				$total = 0;	
				$temp_total = 0;
				
				if ($result->num_rows > 0) {
											   
				while($row = $result->fetch_assoc()) {	
					$temp_total = ($row['PRICE'] * $row['SUM(ORDER_ITEM.QTY)']);
			    
			?>
			
			<tr class="content"> 
	            <td><?php echo $row['PRODUCT_NAME'] ?></td> 
	            <td><?php echo $row['SUM(ORDER_ITEM.QTY)'] ?></td> 
	            <td>$<?php echo $temp_total ?></td>
        	</tr> 
						
			<?php
				$total += $temp_total;
				 } 
			?>
			
			<tr class="titles">
				<td>Total incl GST:</td>
				<td></td>
				<td>$<?php echo $total ?></td>
			</tr>
			
			<?php
			 	} else {
			 	echo "<tr><td>Your cart appears to be empty.</td></tr>";
			 	}
			?>

			
			</table>
				
				<p>Doesn't look right? Edit your order <a href="./products.php" >here</a></p>
	

                <h1 class="form_heading">Shipping Details</h1>
				<div class="contact_form">

				<form method="post" action="processorder.php" class="contact_form_class"> <!-- Contact Form -->
				
					<div> <!-- Form Description -->
						<p>Please enter your shipping details.</p>
					</div>					
					
                    <div>
                        <div id="shipping_details_left">
                            <ul>
                                <li>
                                    <label>First Name*</label>
                                </li>
                                <li>
                                    <label>Last Name*</label>
                                </li>
                                <li>
                                    <label>Email Address*</label>
                                </li>
                                <li>
                                    <label>Street Address*</label>
                                </li>
                                <li>
                                    <label>City*</label>
                                </li>
                                <li>
                                    <label>Zip Code*</label>
                                </li>
                                <li>
                                    <label>Country*</label>
                                </li>
                            </ul>
                        </div>
                        <div id="shipping_details_right"> <!-- maxlength attributes are the same as customer table constraints-->
                            <ul>
                                <li>
                                    <input name= "first_name" class="textbox_text" type="text" maxlength="14" size="20" value="" required />
                                </li>
                                <li>
                                    <input name= "last_name" class="textbox_text" type="text" maxlength="15" size="20" value="" required />
                                </li>
                                <li>
                                    <input name= "email_address" class="textbox_text" type="email" maxlength="30" size="30" value="" required />
                                </li>
                                <li>
                                    <input name= "address" class="textbox_text" type="text" maxlength="30" size="30" value="" required />
                                </li>
                                <li>
                                    <input name= "city" class="textbox_text" type="text" maxlength="20" size="20" value="" required />
                                </li>
                                <li>
                                    <input name= "zip" class="textbox_text" type="text" maxlength="4" size="4" value="" required />
                                </li>
                                <li>
                                    <input name= "country" class="textbox_text" type="text" maxlength="20" size="20" value="" required />
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="complete_order_button">
                        <input class="submit_button" type="submit" name="submit" value="Complete Order"/>
                    </div>

				</form>
				</div>
				
				<img id="bottom" src="./contact/bottom.png" alt="" style ="padding-top: 2em;"/>
			</div>	
		</div>
	</div>
	
	
	<div id="copyright" class="container">
		<p>&copy; All rights reserved. | Content by Aeolus | CCS Skeleton by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
	</div>
</body>
</html>
