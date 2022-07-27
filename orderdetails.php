<?php
	require_once 'inc/header.php';
	// require_once 'inc/slider.php';	
	include_once 'classes/orderDetail.php';
    include_once 'classes/order.php';
    $orderDetail = new orderDetail();	
    $order = new order();
?>
<?php 
// echo "<script>window.location = 'productlist.php'</script>";
	$login_check = Session::get('customer_login');
	if($login_check==false){
		header('Location:login.php');
	}
	$ct = new cart();
//  if(isset($_GET['confirmid'])){
//     $Id = $_GET['confirmid'];
//     $time = $_GET['time'];
//     $price = $_GET['price'];
//     $shifted_confirm = $ct->shifted_confirm($Id,$time,$price);//da nhan duoc hang
//  }
?>
<?php
	if(isset($_GET['cartId'])){
		$cartid = $_GET['cartId'];
		$delcart = $ct->del_product_cart($cartid);
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
		$cartid = $_POST['cartid'];
        $quantity = $_POST['quantity'];
		$update_quantity_cart = $ct->update_quantity_cart($quantity,$cartid);
		if($quantity<=0){
			$delcart = $ct->del_product_cart($cartid);
		}
    }
?>
<?php 
	// if(!isset($_GET['id'])){
	// 	echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
	// }
?>

<?php
	$orderid = 215;
	if(isset($_GET['orderId']))
	{
		$orderid = $_GET['orderId'];
	}
?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2 style="width: 500px;">Chi Tiết Đơn Hàng</h2>
					<?php		
						if(isset($delcart)){
							echo $delcart;
						}
					?>
						<table class="tblone">
							<tr>
								<th width="5%">STT</th>
								<th width="10%">Mã Sản Phẩm</th>	
								<th width="20%">Tên Sản Phẩm</th>
								<th width="10%">Ảnh</th>
								<th width="10%">Giá</th>
								<th width="10%">Số Lượng</th>
								<th width="15%">Tổng giá</th>
							</tr>
							<?php
								$get_order_detail = $orderDetail ->get_detail_by_orderId($orderid);
								if($get_order_detail){
									$i=0;
									while($result =$get_order_detail->fetch_assoc()){		
										$i++;		
							?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $result['productId']?></td>
								<td><?php echo $result['productName']?></td>
								<td><img src="admin/uploads/<?php echo $result['image']?>" alt="" style="width:40px; height: 40px;"/></td>
								<td><?php echo $fm->format_currency($result['price'])." VND"?></td>
								<td><?php echo $result['quantity']?></td>
								<td><?php echo $fm->format_currency($result['totalPrice'])." VND"?></td>
							</tr>
							<?php
							
								}
							}
							?>
						</table>
					</div>
					<div class="shopping">
					<div class="shopleft">
					<a href="ordersp.php"><button id="shopping" style="padding: 10px 25px;font-size: 20px;border: gray;background-color: yellow;"><i class="fas fa-hand-point-left" style="padding-right: 10px;"></i>Quay Lại</button></a>
				</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php
	require_once 'inc/footer.php';
?>