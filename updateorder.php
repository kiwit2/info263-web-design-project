<?php 

	$qty = $_POST['qty'];
	$product_num = $_POST['product_num'];
  
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
	
	

	//insert customer data into customer table
	$sql = "INSERT INTO ORDER_ITEM(ORDER_NUM, PRODUCT_NUM, QTY)
	VALUES ($order_num,'$product_num', '$qty')";
  
  
  	if (mysqli_query($conn, $sql)) {
		echo "New order record created successfully<br/>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

?>

<script type="text/javascript">
	function redirect(url)
	{
	 location.href = url;
	}
	
    redirect("./products.php");
</script>
