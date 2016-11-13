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
	else {
		$sql = "SELECT MAX(ORDER_NUM) FROM ORDER_ITEM";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$order_num = $row['MAX(ORDER_NUM)'] + 1;		
	}
?>

<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Products Aeolus</title>
	<meta name="keywords" content="drone, drones, aeolus, exploration, racing, contact, contact aeolus" />
	<meta name="description" content="Products page for aeolus drones, exploration and racing type drones" />
	<link href="./default.css" rel="stylesheet" type="text/css" media="all" />
	<style type="text/css">
		.auto-style1 {
		margin-bottom: 0px;
	}
	</style>
</head>

<body>
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="./index.html"><img src="./aeoluslogo.png" alt="Aeolus Group LTD" height="155" width="467"/></a></h1>
		</div>
		<div id="menu">
			<ul>
				<li><a href="./index.html" accesskey="1" title="">Home</a></li>
				<li><a href="./about.html" accesskey="2" title="">About</a></li>
				<li class="current_page_item">
				<a href="products.php" accesskey="3" title="">Products</a></li>
				<li><a href="./contact.html" accesskey="4" title="">Contact</a></li>
			</ul>
		</div>
	</div>
	
	<input type="button" class="checkout" value="Proceed To Check Out" onclick="window.location.href='./checkout.php'"  />

	<div id="wrapper">
		<div id="page" class="container">	
		
			<h1>Shopping Cart</h1>
			
			<table class="shoppingcart">			
			
			<tr class="titles">
				<td>Name</td>
				<td>Quantity</td>
				<td>Price</td>
				<td>Remove</td>
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
	            <td>
	            	<form method="post" action="deleteorderitem.php">
	            		<input name ="product_num" type ="hidden" value="<?php echo $row['PRODUCT_NUM'] ?>">
						<input type="submit" value="Remove">
	            	</form>
	            </td> 
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
			
			<div class="filler">
			
			</div>
			
			<div class="product-type">
				<h1>Exploration Drones</h1>
			</div>	
			<?php 
  
				$sql="SELECT * FROM PRODUCT WHERE CATEGORY = 'Exploration Drone' ORDER BY PRODUCT_NAME ASC"; 
				$result = $conn->query($sql);				   
				while($row = $result->fetch_assoc()) {	 
			      
			?>
			
			<div class="product">
					<div class="picture-exp">
						<img src="<?php echo $row['PICTURE_URL'] ?>" alt ="immersion 1" width="313" height="161"/>
					</div>
					<div class="pL_description" >
						<h1><?php echo $row['PRODUCT_NAME'] ?></h1>

						<div class="price"> $<?php echo $row['PRICE'] ?></div>

							<p>
								<?php echo $row['DESCRIPTION'] ?>
							</p>

						</div>		
					</div>

			<div class="addToCart">				
				<form method="post" action="updateorder.php">
					Quantity:
					<select name="qty">
					<option value="1" selected>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					</select>
					<input name ="product_num" type ="hidden" value="<?php echo $row['PRODUCT_NUM'] ?>">
					<input type="submit" value="Add To Cart">
				</form>

			</div>
			
			<?php } ?>

		
			<div class="product-type">
				<h1>Exploration Drone Parts</h1>
			</div>	
			<?php 
  
				$sql="SELECT * FROM PRODUCT WHERE CATEGORY = 'Exploration Drone Part' ORDER BY PRODUCT_NAME ASC"; 
				$result = $conn->query($sql);				   
				while($row = $result->fetch_assoc()) {	 
			      
			?>
			
			
			
			<div class="product">
					<div class="picture-exp">
						<img src="<?php echo $row['PICTURE_URL'] ?>" alt ="immersion 1" width="313" height="161"/>
					</div>
					<div class="pL_description" >
						<h1><?php echo $row['PRODUCT_NAME'] ?></h1>

						<div class="price"> $<?php echo $row['PRICE'] ?></div>

							<p>
								<?php echo $row['DESCRIPTION'] ?>
							</p>

						</div>		
					</div>

			<div class="addToCart">
				
				<form method="post" action="updateorder.php">
					Quantity:
					<select name="qty">
					<option value="1" selected>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					</select>
					<input name ="product_num" type ="hidden" value="<?php echo $row['PRODUCT_NUM'] ?>">
					<input type="submit" value="Add To Cart">
				</form>

			</div>
			
			<?php } ?>
			
			<div class="product-type">
				<h1>Racing Drones</h1>
			</div>
			<?php 
  
				$sql="SELECT * FROM PRODUCT WHERE CATEGORY = 'Racing Drone' ORDER BY PRODUCT_NAME ASC"; 
				$result = $conn->query($sql);				   
				while($row = $result->fetch_assoc()) {	 
			      
			?>
			
			<div class="product">
					<div class="picture-exp">
						<img src="<?php echo $row['PICTURE_URL'] ?>" alt ="immersion 1" width="313" height="161"/>
					</div>
					<div class="pL_description" >
						<h1><?php echo $row['PRODUCT_NAME'] ?></h1>

						<div class="price"> $<?php echo $row['PRICE'] ?></div>

							<p>
								<?php echo $row['DESCRIPTION'] ?>
							</p>

						</div>		
					</div>

			<div class="addToCart">
				
				<form method="post" action="updateorder.php">
					Quantity:
					<select name="qty">
					<option value="1" selected>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					</select>
					<input name ="product_num" type ="hidden" value="<?php echo $row['PRODUCT_NUM'] ?>">
					<input type="submit" value="Add To Cart">
				</form>

			</div>
			
			<?php } ?>
			
			<div class="product-type">
				<h1>Racing Drone Parts</h1>
			</div>			
			<?php 
  
				$sql="SELECT * FROM PRODUCT WHERE CATEGORY = 'Racing Drone Part' ORDER BY PRODUCT_NAME ASC"; 
				$result = $conn->query($sql);				   
				while($row = $result->fetch_assoc()) {	 
			      
			?>
			
			<div class="product">
					<div class="picture-exp">
						<img src="<?php echo $row['PICTURE_URL'] ?>" alt ="immersion 1" width="313" height="161"/>
					</div>
					<div class="pL_description" >
						<h1><?php echo $row['PRODUCT_NAME'] ?></h1>

						<div class="price"> $<?php echo $row['PRICE'] ?></div>

							<p>
								<?php echo $row['DESCRIPTION'] ?>
							</p>

						</div>		
					</div>

			<div class="addToCart">
				
				<form method="post" action="updateorder.php">
					Quantity:
					<select name="qty">
					<option value="1" selected>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					</select>
					<input name ="product_num" type ="hidden" value="<?php echo $row['PRODUCT_NUM'] ?>">
					<input type="submit" value="Add To Cart">
				</form>

			</div>
			
			<?php } ?>

		</div>
	</div>
	
	








	<div id="copyright" class="container">
		<p>&copy; All rights reserved. | Content by Aeolus | CCS Skeleton by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
	</div>
</body>
</html>
