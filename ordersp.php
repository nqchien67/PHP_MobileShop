<?php
	require_once 'inc/header.php';
	// require_once 'inc/slider.php';
    include_once 'classes/orderDetail.php';
    include_once 'classes/order.php';
    $orderDetail = new orderDetail();	
    $order = new order();
?>
<?php 
	$login_check = Session::get('customer_login');
	if($login_check==false){
		header('Location:login.php');
	}
	$ct = new cart();
?>
<?php
	if(isset($_GET['delorder']))
	{
		$delorderId = $_GET['delorder'];
		$delorder = $order->del_order($delorderId);
	}
	if (isset($_GET["shifted"])) {
		$order->shifted($_GET["shifted"]);
	}
?>

 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2 style="width: 500px;">Đơn Hàng</h2>
						<table class="tblone">
							<tr>
                                <th width="5%">STT</th>
								<th width="10%">Mã Đơn</th>	
								<th width="15%">Tổng Tiền</th>
								<th width="25%">Ngày Đặt</th>
								<th width="15%">Trạng Thái</th>
                                <th width="20%"></th>
							</tr>
							<?php
							 $customer_Id = Session::get('customer_Id');
								$get_cart_ordered = $order ->get_order_by_customer($customer_Id);
								if($get_cart_ordered){
									$i=0;
									while($result = $get_cart_ordered->fetch_assoc()){		
										$i++;	
							?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $result['orderId']?></td>
								<td><?php echo $fm->format_currency($result['total'])." VND"?></td>
								<td><?php echo $fm->formatDate($result['date_order'])?></td>
								<!-- <td> -->
									<?php 
										// if($result['status']==1)
										// {
										// 	echo "<a href=".$order->status_toString($result['status'])."'></a>"	;
										// }
										// if($result['status']==2){
										// 	echo "<a href=".$order->status_toString($result['status'])."'></a>"	;
										// }

											// echo $order->status_toString($result['status'])?>
									<!-- </td> -->
									<td>
										<?php
										if ($result["status"] == 1) {
											echo "<a href='?shifted=" . $result["orderId"] . "'>" . $order->status_toString($result["status"]) . "</a>";
										} else {
											echo $order->status_toString($result['status']);
										}
										?>
									</td>
								<td><a href="orderdetails.php?orderId=<?php echo $result['orderId']?>">Xem </a><?php if($result['status'] == 3 && $result['status'] == 0)
								{
									echo "||<a href='?delorder=".$result['orderId']."'> Hủy</a>";
								} 
								?>							
								</td>
							</tr>
							<?php
                                    }
								}

							?>
						</table>
					</div>
					<div class="shopping">
					<div class="shopleft">
					<a href="index.php"><button id="shopping" style="padding: 10px 25px;font-size: 20px;border: gray;background-color: yellow;"><i class="fas fa-hand-point-left" style="padding-right: 10px;"></i>Quay Lại</button></a>
				</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php
	require_once 'inc/footer.php';
?>