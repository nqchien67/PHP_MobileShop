<!-- <?php
	require_once 'inc/header.php';
	// require_once 'inc/slider.php';
?>
<?php
	if(isset($_GET['orderId'])&&$_GET['orderId']=='order'){
        $customer_Id = Session::get('customer_Id');
        $insertOrder = $ct->insertOrder($customer_Id);
        $delCart = $ct->del_all_data_cart();
        header('Location: success.php');
    }
   
	// if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
    //     $quantity = $_POST['quantity'];
	// 	$Addtocart = $ct-> add_to_cart($quantity,$id);
    // }
?>
<style type="text/css">
    .box-left{
        width: 100%;
        border:1px solid #666;ssss
        float: left;
        padding: 4px;
    }
  

</style>
<form action="" method="POST">
<div class="main">
    <div class="content">
    	<div class="section group">
            <div class="heading">
                    <h3>Thanh Toán Online</h3>
            </div>
            <div class="clear"></div>
            <div class="box-left">
            <div class="cartpage">
					<?php
						if(isset($update_quantity_cart)){
							echo $update_quantity_cart;
						}
					?>
					<?php		
						if(isset($delcart)){
							echo $delcart;
						}
					?>
						<table class="tblone">
							<tr>
                                <th width="5%">STT</th>
								<th width="15%">Tên Sản Phẩm</th>
								<th width="10%">Giá</th>
								<th width="15%">Số Lượng</th>
								<th width="15%">Tổng Giá</th>
                                <th width="20%">Trạng Thái Đơn Hàng</th>
								<th width="20%">Hủy Đơn Hàng</th>
							</tr>
							<?php
								$get_product_cart = $ct ->get_product_cart();
								if($get_product_cart){
									$subtotal = 0;
									$qty = 0;
                                    $i =0;
									while($result = $get_product_cart->fetch_assoc()){
                                        $i++;
							?>
							<tr>
                                <td><?php echo $i;?></td>
								<td><?php echo $result['productName']?></td>
								<td><?php echo $result['price']." VND"?></td>
								<td>
                                        <?php echo $result['quantity']?>
								</td>
								<td><?php $total = $result['price'] * $result['quantity']; echo $total.' VND';?></td>	
                            </tr>
							<?php
								$subtotal +=$total;
								$qty = $qty + $result['quantity'];
								}
							}
							?>
						</table>
						<?php
									$check_cart = $ct->check_cart();
									if($check_cart){
										
						?>
						<table style="float:right;text-align:left;" width="50%">
							<tr>
								<th>Tổng Giá : </th>
								<td>
                                <?php
									echo $subtotal.' VND';
									Session::set('sum',$subtotal);
									Session::set('qty',$qty);
								?>
							</td>
							</tr>
							<tr>
								<th>Thuế VAT : </th>
								<td>15%(<?php echo $vat = $subtotal*0.15;?>)</td>
							</tr>
							<tr>
								<th>Tổng Giá(sau thuế) :</th>
								<td>
									<?php $vat = $subtotal*0.15;
										$glotal = $subtotal+$vat;
										echo $glotal.' VND';
									?>
								</td>
							</tr>
					   </table>
					   <?php
								}
								else{
									echo 'Your cart is empty! please  shopping now';
								}  
						?>
					</div>	
            </div>
          
        </div>
       
 	</div>

     <center><a href="?orderId=order" class="a_order">Order Now</a></center><br />
</div>
</form>
<?php
	require_once 'inc/footer.php';
?> -->