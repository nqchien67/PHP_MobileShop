<?php
	require_once 'inc/header.php';
	// require_once 'inc/slider.php';
?>
<?php
	if(!isset($_GET['brandId'])||$_GET['brandId']==NULL){
		echo "<script>window.lobrandion = '404.php'</script>";
	}
	else{
		$id = $_GET['brandId'];
	}
?>

 <div class="main">
    <div class="content">
			<?php
				$name_brand = $brand->get_name_by_brand($id);
				if($name_brand){
					while($result_name = $name_brand->fetch_assoc()){
			?>
    	<div class="content_top">
    		<div class="heading">
    		<h3>Thương Hiệu: <?php echo $result_name['brandName']?></h3>
    		</div>
    		<div class="clear"></div>	
    	</div>
		<?php
					}
				}
			?>
	      <div class="section group">
			  <?php
			 	$productbybrand = $brand->get_product_by_brand($id);
				 if($productbybrand){
					 while($result = $productbybrand->fetch_assoc()){
			  ?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details-3.php"><img src="admin/uploads/<?php echo $result['image']?>" style="width: 220px;height:auto;"alt="" style="" /></a>
					 <h2><?php echo $result['productName']?></h2>
					 <p><?php echo $fm->textShorten($result['product_desc'],50)?></p>
					 <p><span class="price"><?php echo $result['price'].' VND'?></span></p>
				     <div class="button"><span><a href="details.php?proId=<?php echo $result['productId']?>" class="details">Details</a></span></div>
				</div>
				<?php
					 	}
					}
						 else
						 {
								echo 'Brandegory Not Avaiable!!!';
						 }
					 
				?>
			</div>

    </div>
 </div>
 <?php
	require_once 'inc/footer.php';
?>