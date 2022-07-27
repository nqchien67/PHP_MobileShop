<?php
ob_start();
require_once 'inc/header.php';
// require_once 'inc/slider.php';	
include_once 'classes/orderDetail.php';
include_once 'classes/order.php';
include_once 'classes/product.php';
$orderDetail = new orderDetail();	
$order = new order();
$pd = new product();
?>
<?php
	if(isset($_GET['orderId'])&&$_GET['orderId']=='order'){
        $customer_Id = Session::get('customer_Id');
        $insertOrder = $order->insert_Order($customer_Id);
        $delCart = $ct->del_all_data_cart();
		//----------------------------------------------------------------
		
		header('Location:offinepayment.php');
	}
?>
<style type="text/css">
    .box-left{
        width: 50%;
        border:1px solid #666;
        float: left;
        padding: 4px;
    }
    .box-right{
        width: 45%;
        border: 1px solid #666;
        float:right;
        padding: 4px;
    }
   a.a_order{
       background:red;
       padding:7px 20px;
       color:#fff;
       font-size: 21px;
   }
</style>
<form action="" method="POST">
<div class="main">
    <div class="content">
    	<div class="section group">
            <div class="heading">
                    <h3>Thanh Toán Offline</h3>
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
								<th width="15%">Giá</th>
								<th width="25%">Số Lượng</th>
								<th width="20%">Tổng Giá</th>
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
								<td><?php $total = $result['price'] * $result['quantity']; echo $fm->format_currency($total).' VND';?></td>	
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
									echo $fm->format_currency($subtotal).' VND';
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
										echo $fm->format_currency($glotal).' VND';
									?>
								</td>
							</tr>
					   </table>
					   <?php
								}
								else{
									echo "<span class='success'>Đã Đặt Hàng Thành Công!</span>";
								}  
						?>
					</div>	
            </div>
            <div class="box-right">
            <table class="tblone">
                <?php
                $id = Session::get('customer_Id');
                    $get_customers = $cs->show_customers($id);
                    if($get_customers){
                        while($result = $get_customers->fetch_assoc()){
                ?>
                <tr>
                    <td>Tên Khách Hàng</td>
                    <td>:</td>
                    <td><?php echo $result['name'] ?></td>
                </tr>  
                <tr>
                    <td>Số Điện Thoại</td>
                    <td>:</td>
                    <td><?php echo $result['phone'] ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><?php echo $result['email'] ?></td>
                </tr>

                <tr>
                    <td>Địa Chỉ</td>
                    <td>:</td>
                    <td><?php echo $result['address'] ?></td>
                </tr>
                <tr>
                    <td colspan="3"><a href="editprofile.php">Cập nhật thông tin</a></td>
                </tr>
                <?php                       
                        }
                  }
                ?>
            </table>
            </div>
 
        </div>
       
 	</div>

     <center><a href="?orderId=order" class="a_order">Đặt Hàng Ngay</a></center><br />
</div>
</form>
<?php
	require_once 'inc/footer.php';
?>