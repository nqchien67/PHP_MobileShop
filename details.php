<?php
require_once "inc/header.php";
// require_once "classes/comment.php";
require_once "classes/customer.php";
// require_once "inc/slider.php";

?>
<?php
$comment = new comment();
$customer = new customer();
$id;
if (!isset($_GET["proId"]) || $_GET["proId"] == NULL) {
	echo "<script>window.location = '404.php'<script>";
} else {
	$id = $_GET["proId"];
}
$customer_id = Session::get("customer_Id");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
	$quantity = $_POST["quantity"];
	$insertCart = $ct->add_to_cart($quantity, $id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["wishlist"])) {
	$productId = $_POST["productId"];
	$insertWishlist = $product->insertWishlist($productId, $customer_id);
}
if (isset($_POST["binhluan_submit"])) {
	$binhluan_insert = $comment->insert_binhluan();
	header("Location: details.php?proId=" . $id);
}

?>
<div class="main">
	<div class="content">
		<div class="section group">
			<?php
			$get_product_details = $product->get_details($id);
			if ($get_product_details) {
				while ($result_details = $get_product_details->fetch_assoc()) {
			?>
					<div class="cont-desc span_1_of_2">
						<div class="grid images_3_of_2">
							<img src="admin/uploads/<?php echo $result_details["image"] ?>" style="width:90%;" alt="" />
						</div>
						<div class="desc span_3_of_2">
							<h2><?php echo $result_details["productName"] ?></h2>
							<p><?php echo $fm->textShorten($result_details["product_desc"], 150) ?></p>
							<div class="price">
								<p>Giá: <span><?php echo $fm->format_currency($result_details["price"]) . " VND" ?></span></p>
								<p>Danh Mục Sản Phẩm: <span><?php echo $result_details["catName"] ?></span></p>
								<p>Thương Hiệu:<span><?php echo $result_details["brandName"] ?></span></p>
							</div>
							<?php
								$pd = new product();
								$pdlist = $pd->checkQuantity($id);
							?>
							<div class="add-cart">
								<form action="" method="post">
									<input type="number" class="buyfield" name="quantity" value="1" min="1" max="<?php echo $pdlist ?>"/>
									<label style="color: gray; padding: 0 5px;"><?php echo "Còn ".$pdlist." sản phẩm"?></label>
									<input type="submit" class="buysubmit" name="submit" value="Mua Hàng" />
								</form>
								<?php
								if (isset($insertCart)) {
									echo $insertCart;
								}
							?>
							</div>
							<div class="add-cart">
								<div class="button-details">
									<form action="" method="POST">
										<input type="hidden" name="productId" value="<?php echo $result_details["productId"] ?>" />
										<?php
										$login_check = Session::get("customer_login");
										?>
									</form>
									<form action="" method="POST">
										<input type="hidden" name="productId" value="<?php echo $result_details["productId"] ?> " />
										<?php
										$login_check = Session::get("customer_login");
										if ($login_check) {
											echo "<input type='submit' class='buysubmit' name='wishlist' value='Sản Phẩm Yêu Thích'>";
										} else {
											echo "";
										}
										?>
									</form>
								</div>
								<div class="clear"></div>
								<p>
									<?php
									if (isset($insertWishlist)) {
										echo $insertWishlist;
									}
									?>
								</p>
							</div>
						</div>
						<div class="product-desc">
							<h2>Chi Tiết Sản Phẩm</h2>
							<p><?php echo $fm->textShorten($result_details["product_desc"], 150) ?></p>
						</div>
						<div class="binhluan product-desc">
							<h2>Nhận xét từ khách hàng</h2>
							<?php
							if (isset($binhluan_insert)) {
								echo $binhluan_insert;
							}
							?>
							<form action="" method="POST">
								<p>
									<input type="hidden" value="<?php echo $id ?>" name="product_id_binhluan">
									<input type="hidden" value="<?php echo $customer_id ?>" name="customer_id">
								</p>
								<p>
									<input type="text" value="<?php echo $customer->get_customerName($customer_id); ?>" class="form-control" name="tennguoibinhluan" disabled>
								</p>
								<p>
									<textarea rows="5" style="resize:none;" placeholder="Nội dung..." class="form-control" name="binhluan"></textarea>
								</p>
								<p>
									<input type="submit" name="binhluan_submit" class="btn btn-success" value="Gửi bình luận">
								</p>
							</form>

							<div class="comment container-fluid">
								<?php
								$commentList = $comment->get_comments_by_productId($id);
								if ($commentList) {
									while ($result = $commentList->fetch_assoc()) {
										echo "
									<div class='row'>
										<div class='col-sm-6'><b>" . $result["name"] . "</b></div>
										<p class='col-sm-6'>" . $result["binhluan"] . "</p>
									</div>";
									}
								}
								?>
							</div>
						</div>
					</div>
			<?php
				}
			}
			?>
			<div class="rightsidebar span_3_of_1">
				<h2>Danh Mục Sản Phẩm</h2>
				<ul>
					<?php
					$getall_category = $cat->show_category_fontend();
					if ($getall_category) {
						while ($result_allcat = $getall_category->fetch_assoc()) {
					?>
							<li><a href="productbycat.php?catId=<?php echo $result_allcat["catId"] ?>"><?php echo $result_allcat["catName"] ?></a></li>
					<?php
						}
					}
					?>
				</ul>
			</div>
		</div>

	</div>
	<?php
	require_once "inc/footer.php";
	?>