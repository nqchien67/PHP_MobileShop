<?php
	require_once 'inc/header.php';
	// require_once 'inc/slider.php';	
?>
<?php
	if(isset($_GET['proid'])){
        $customer_id = Session::get('customer_Id');
		$proid = $_GET['proid'];
		$delwlist = $product->del_wishlist($proid,$customer_id);
	}
?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2 style="width:40%;">Danh Sách Yêu Thích</h2>
						<table class="tblone">
							<tr>
								<th width="10%">STT</th>
								<th width="20%">Tên Sản Phẩm</th>
								<th width="20%">Hình Ảnh</th>
								<th width="15%">Giá</th>
								<th width="15%">Hành Động</th>
							</tr>
							<?php
								$customer_id = Session::get('customer_Id');
								$get_wishlist = $product->get_wishlist($customer_id);
								if($get_wishlist){
									$i = 0;
									while($result = $get_wishlist->fetch_assoc()){
										$i++;
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $result['productName']?></td>
								<td><img src="admin/uploads/<?php echo $result['image']?>" alt="" style="width:40px; height: 40px;"/></td>
								<td><?php echo $result['price']." VND"?></td>
								<td>
                                    <a href="?proid=<?php echo $result['productId']?>">Xóa</a> ||
                                    <a href="details.php?proId=<?php echo $result['productId']?>">Mua Ngay</a>
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
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="payment.php"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php
	require_once 'inc/footer.php';
?>