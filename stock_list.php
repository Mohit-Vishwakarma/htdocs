<?php 
session_start();
include('inc/header.php');
include 'stock.php';// sql k liye
$stock = new Stock();
$stock->checkLoggedIn();
?>
<title>ApnaPlywood</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('inc/container.php');?>
	<div class="container">		
	<h2 style="text-align:center;padding:20px;">ApnaPlywood.Inc</h2>   
  <h2 class="title">Stock Portfolio</h2>
	  <?php include('menu.php');?>			 
    
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>Stock No.</th>
            <th>Create Date</th>
            <th>Item Name</th>
            <th>quantity</th>
            <!-- <th>Print</th> -->
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <?php		
		$stockList = $stock->getstockList();
        foreach($stockList as $stockDetails){
			$stockDate = date("d/M/Y, H:i:s", strtotime($stockDetails["order_date"]));
            echo '
              <tr>
                <td>'.$stockDetails["order_id"].'</td>
                <td>'.$stockDate.'</td>
                <td>'.$stockDetails["order_receiver_name"].'</td>
                <td>'.$stockDetails["order_total_after_tax"].'</td>
                
                
                <td><a href="edit_stock.php?update_id='.$stockDetails["order_id"].'"  title="Edit stock"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="stock_list.php" id="'.$stockDetails["order_id"].'" class="deletestock"  title="Delete stock"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            ';
        }       
        ?>
      </table>	
</div>	
<?php include('inc/footer.php');?>