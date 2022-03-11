<?php 
session_start();
include('inc/header.php');
include 'stock.php';
$stock = new Stock();
$stock->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName']) {	
	$stock->savestock($_POST);
	header("Location:stock_list.php");	
}
?>
<title>ApnaPlywood</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('inc/container.php');?>
<div class="container content-invoice">
	<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate=""> 
		<div class="load-animate animated fadeInUp">
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<h2 class="title">Generate Stock Window</h2>
					<?php include('menu.php');?>	
				</div>		    		
			</div>
			<input id="currency" type="hidden" value="$">
		
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-hover" id="invoiceItem">	
						<tr>
							<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
							<th width="15%">Item Code</th>
							<th width="38%">Item Name</th>
							<th width="15%">Quantity</th>
							<th width="15%">Length</th>								
							<th width="15%">Width</th>
						</tr>							
						<tr>
							<td><input class="itemRow" type="checkbox"></td>
							<td><input type="text" name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td>
							<td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off"></td>			
							<td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
							<td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
							<td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
						</tr>						
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
					<button class="btn btn-success" id="addRows" type="button">+ Add More</button>
				</div>
			</div>
			<div class="row">	
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<h3>Description: </h3>
					<div class="form-group">
						<textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Your Notes"></textarea>
					</div>
					<br>
					<div class="form-group">
						<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
						<input data-loading-text="Saving stock..." type="submit" name="invoice_btn" value="Save" class="btn btn-success submit_btn invoice-save-btm">						
					</div>
					
				</div>
				</div>
			</div>
			<div class="clearfix"></div>		      	
		</div>
	</form>			
</div>
</div>	
<?php include('inc/footer.php');?>