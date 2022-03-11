<?php
class Stock{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "invoice_system";   
	private $invoiceUserTable = 'invoice_user';	

    private $stockOrderTable = 'stock_order';
	private $stockOrderItemTable = 'stock_order_item';
 
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function loginUsers($email, $password){
		$sqlQuery = "
			SELECT id, email, first_name, last_name, address, mobile 
			FROM ".$this->invoiceUserTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}	
	public function checkLoggedIn(){
		if(!$_SESSION['userid']) {
			header("Location:index.php");
		}
	}		
	public function savestock($POST) {		
		
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->stockOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
			VALUES ('".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}       	
	}
	// stock change 16feb

	public function updatestock($POST) {
		if($POST['stockId']) {	
			$sqlInsert = "
				UPDATE ".$this->stockOrderTable." 
				SET order_receiver_name = '".$POST['companyName']."', order_receiver_address= '".$POST['address']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."' 
				WHERE user_id = '".$POST['userId']."' AND order_id = '".$POST['stockId']."'";		
			mysqli_query($this->dbConnect, $sqlInsert);	
		}		
		$this->deletestockItems($POST['stockId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->stockOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
				VALUES ('".$POST['stockId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);			
		}       	
	}	
	public function getstockList(){
		$sqlQuery = "
			SELECT * FROM ".$this->stockOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."'";
		return  $this->getData($sqlQuery);
	}	
	public function getstock($stockId){
		$sqlQuery = "
			SELECT * FROM ".$this->stockOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND order_id = '$stockId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	
	public function getstockItems($stockId){
		$sqlQuery = "
			SELECT * FROM ".$this->stockOrderItemTable." 
			WHERE order_id = '$stockId'";
		return  $this->getData($sqlQuery);	
	}
	public function deletestockItems($stockId){
		$sqlQuery = "
			DELETE FROM ".$this->stockOrderItemTable." 
			WHERE order_id = '".$stockId."'";
		mysqli_query($this->dbConnect, $sqlQuery);				
	}
	public function deletestock($stockId){
		$sqlQuery = "
			DELETE FROM ".$this->stockOrderTable." 
			WHERE order_id = '".$stockId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deletestockItems($stockId);	
		return 1;
	}
}
?>