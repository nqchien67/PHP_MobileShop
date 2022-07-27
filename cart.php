<?php
	require_once 'inc/header.php';
	// require_once 'inc/slider.php';	
?>
<?php
	if(isset($_GET['cartid'])){
		$cartid = $_GET['cartid'];
		$delcart = $ct->del_product_cart($cartid);
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
		// request_method :Phương thức  yêu cầu được truy cập trang
		$cartId = $_POST['cartId'];
        $quantity = $_POST['quantity'];
		$update_quantity_cart = $ct->update_quantity_cart($quantity,$cartId);
		if($quantity<=0){
			$delcart = $ct->del_product_cart($cartId);
		}
    }

?>
<?php 
	if(!isset($_GET['id'])){
		echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
	}
?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Giỏ Hàng</h2>
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
								<th width="20%">Tên Sản Phẩm</th>
								<th width="15%">Hình Ảnh</th>
								<th width="10%">Giá</th>
								<th width="20%">Số Lượng</th>
								<th width="20%">Tổng Tiền</th>
								<th width="15%">Trạng Thái</th>
							</tr>
							<?php
							$pd = new product();
								$get_product_cart = $ct ->get_product_cart();
								if($get_product_cart){
									$subtotal = 0;
									$qty = 0;
									while($result = $get_product_cart->fetch_assoc()){
										$productId = $result['productId'];
										$pdlist = $pd->checkQuantity($productId);

									?>
							<tr>
								<td><?php echo $result['productName']?></td>
								<td><img src="admin/uploads/<?php echo $result['image']?>" alt="" style="width:40px; height: 40px;"/></td>
								<td><?php echo $fm->format_currency($result['price'])." VND"?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartId" value="<?php echo $result['cartId']?>"/>
										<input type="number" name="quantity" min = "0" value="<?php echo $result['quantity']?>" max="<?php echo $pdlist ?>"/>
										<input type="submit" name="submit" value="Cập nhật"/>
									</form>
								</td>
								<td>
									<?php 
									$total = $result['price'] * $result['quantity'];
									echo $fm->format_currency($total)." VND";
									?>
									</td>
									<td><a onclick="return confirm('Bạn có muốn xóa không?');" href="?cartid=<?php echo $result['cartId'] ?>">Xóa</a></td>
								
							</tr>
							<?php
								$subtotal +=$total;//tổng sản phẩm chưa tính thuế
								$qty = $qty + $result['quantity'];
								}
							}
							?>
						</table>
						<?php
									$check_cart = $ct->check_cart();
									if($check_cart){
										
						?>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Tổng Giá : </th>
							<td>
								<?php
									echo $fm->format_currency($subtotal)." VND";
									Session::set('sum',$subtotal);
									Session::set('qty',$qty);
								?>
							</td>
							</tr>
							<tr>
								<th>Thuế VAT : </th>
								<td>15%</td>
							</tr>
							<tr>
								<th>Tổng Giá(sau thuế) :</th>
								<td>
									<?php $vat = $subtotal*0.15;
										$glotal = $subtotal+$vat;
										echo $fm->format_currency($glotal)." VND";
									?>
								</td>
							</tr>
					   </table>
					   <?php
								}
								else{
									echo "<span class='error'>Giỏ Hàng Của Bạn Hiện Tại Đang Trống</span>";
								}  
						?>
			</div>
			<div class="shopping">
				<div class="shopleft">
					<a href="index.php"><button id="shopping" style="padding: 10px 25px;font-size: 20px; border: gray;background-color: yellow;"><i class="fas fa-hand-point-left" style="padding-right: 10px;"></i>Quay Lại</button></a>
				</div>
				<div class="shopright">
					<a href="payment.php"><button id="shopping" style="padding: 10px 25px;font-size:20px;border: gray;gray;background-color: yellow;"><i class="fas fa-money-bill-wave" style="padding-right: 10px;"></i>Thanh Toán</button></a>
				</div>
			</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php
	require_once 'inc/footer.php';
?>