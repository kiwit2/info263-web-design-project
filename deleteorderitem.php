<?php 

	$product_num  = $_POST['product_num'];
  
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
	
	$sql = "SELECT MAX(ORDER_NUM) FROM ORDER_ITEM";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		$order_num = $row['MAX(ORDER_NUM)'];
	}	
	//delete this product from the order
	$sql = "DELETE FROM ORDER_ITEM WHERE PRODUCT_NUM = '$product_num' AND ORDER_NUM = $order_num";
  
  
  	if (mysqli_query($conn, $sql)) {
		echo "Order record deleted successfully<br/>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
	//close connection

?>

<script type="text/javascript">
	function redirect(url)
	{
	 location.href = url;
	}
	
    redirect("./products.php");
</script>
