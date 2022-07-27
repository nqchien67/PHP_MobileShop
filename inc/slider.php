<div class="header_bottom">
	<div class="header_bottom_left" style="margin-top:4px;">
		<div class="section group" style="height: 165px;">
			<?php
			$getLastXiaomi = $product->getLastestXiaomi();
			if ($getLastXiaomi) {
				while ($resultXiaomi = $getLastXiaomi->fetch_assoc()) {
			?>
					<div class="listview_1_of_2 images_1_of_2" style="height: 140px; padding-top: 10x;width: 275px;">
						<div class="listimg listimg_2_of_1">
							<a href="details.php"> <img src="admin/uploads/<?php echo $resultXiaomi['image'] ?>" alt="" style="height:100px;" /></a>
						</div>
						<div class="text list_2_of_1">
							<h2>Xiaomi</h2>
							<p><?php echo $resultXiaomi['productName'] ?></p>
							<div class="button"><span><a href="details.php?proId=<?php echo $resultXiaomi['productId'] ?>" style="font-size: 10px;">Thêm Giỏ Hàng</a></span></div>
						</div>
					</div>
			<?php
				}
			}
			?>
			<?php
			$getLastOppo = $product->getLastestOppo();
			if ($getLastOppo) {
				while ($resultOppo = $getLastOppo->fetch_assoc()) {
			?>
					<div class="listview_1_of_2 images_1_of_2" style="height: 140px;padding-top: 10px;width: 275px;">
						<div class="listimg listimg_2_of_1">
							<a href="details.php"> <img src="admin/uploads/<?php echo $resultOppo['image'] ?>" alt="" style="height:100px;" /></a>
						</div>
						<div class="text list_2_of_1">
							<h2>Oppo</h2>
							<p><?php echo $resultOppo['productName'] ?></p>
							<div class="button"><span><a href="details.php?proId=<?php echo $resultOppo['productId'] ?>" style="font-size: 10px;">Thêm Giỏ Hàng</a></span></div>
						</div>
					</div>
			<?php
				}
			}
			?>
		</div>
		<div class="section group" style="height: 165px;">
			<?php
			$getLastIphone = $product->getLastestIPhone();
			if ($getLastIphone) {
				while ($resultIP = $getLastIphone->fetch_assoc()) {
			?>
					<div class="listview_1_of_2 images_1_of_2" style="height: 140px; padding-top: 10px;width: 275px;">
						<div class="listimg listimg_2_of_1">
							<a href="details.php"><img src="admin/uploads/<?php echo $resultIP['image'] ?>" alt="" style="height:100px;" /></a>
						</div>
						<div class="text list_2_of_1">
							<h2>Iphone</h2>
							<p><?php echo $resultIP['productName'] ?></p>
							<div class="button"><span><a href="details.php?proId=<?php echo $resultIP['productId'] ?>" style="font-size: 10px;">Thêm Giỏ Hàng</a></span></div>
						</div>
					</div>
			<?php
				}
			}
			?>
			<?php
			$getLastSS = $product->getLastestSamSung();
			if ($getLastSS) {
				while ($resultSS = $getLastSS->fetch_assoc()) {
			?>
					<div class="listview_1_of_2 images_1_of_2" style="height: 140px; padding-top: 10px;width: 275px;">
						<div class="listimg listimg_2_of_1">
							<a href="details.php"><img src="admin/uploads/<?php echo $resultSS['image'] ?>" alt="" style="height:100px;" /></a>
						</div>
						<div class="text list_2_of_1">
							<h2>SamSung</h2>
							<p><?php echo $resultSS['productName'] ?></p>
							<div class="button"><span><a href="details.php?proId=<?php echo $resultSS['productId'] ?>" style="font-size: 10px;">Thêm Giỏ Hàng</a></span></div>
						</div>
					</div>
			<?php
				}
			}
			?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="header_bottom_right_images">
		<!-- FlexSlider -->

		<section class="slider">
			<div class="flexslider">
				<ul class="slides">
					<?php
					$get_slider = $product->show_slider();
					if ($get_slider) {
						while ($result_slider = $get_slider->fetch_assoc()) {
					?>
							<li>
								<?php
								$slPro = $result_slider["productId"];
								$slImg = $result_slider["slider_image"];
								if ($slPro != null) {
									echo "<a href='./details.php?proId=$slPro'>
									<img src='admin/uploads/$slImg' alt=''/></a>";
								} else {
									echo "<img src='admin/uploads/$slImg' alt=''/>";
								}
								?>
							</li>
					<?php
						}
					}
					?>
				</ul>
			</div>
		</section>
		<!-- FlexSlider -->
	</div>
	<div class="clear"></div>
</div>