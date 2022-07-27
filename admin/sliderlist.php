<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/product.php'; ?>
<?php
$product = new product();
if (isset($_GET['type_slider']) && isset($_GET['type'])) {
	$id = $_GET['type_slider'];
	$type = $_GET['type'];
	$update_type_slider = $product->update_type_slider($id, $type);
}
if (isset($_GET['slider_del'])) { //neu ton tai
	$id = $_GET['slider_del'];
	$del_slider = $product->del_slider($id);
}
?>
<div class="grid_10">
	<div class="box round first grid">
		<h2>Slider List</h2>
		<div class="block">
			<a href="./slideradd.php" class="btn btn-primary mb-3" type="submit">Thêm slider</a>
			<h4><?php
				if (isset($del_slider)) {
					echo $del_slider;
				}
				?></h4>
			<table class="data display" id="slidertable">
				<thead>
					<tr>
						<th>STT</th>
						<th>Tiêu Đề Slider</th>
						<th>Ảnh Slider</th>
						<th>Sản phẩm</th>
						<th>Trạng Thái</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$product = new product();
					$get_slider = $product->show_slider_list();
					if ($get_slider) {
						$i = 0;
						while ($result_slider = $get_slider->fetch_assoc()) {
							$i++;
					?>
							<tr class="odd gradeX">
								<td><?php echo $i; ?></td>
								<td><?php echo $result_slider['sliderName'] ?></td>
								<td><img src="uploads/<?php echo $result_slider['slider_image'] ?>" height="120px" width="500px" /></td>
								<td><?php
									if ($result_slider['productName'] != null)
										echo $result_slider['productName'];
									else echo "";
									?></td>
								<td>
									<?php
									$sliderId = $result_slider['sliderId'];
									if ($result_slider['type'] == 1) {
									?>
										<a class="btn btn-success" href="?type_slider=<?php echo $sliderId ?>&type=0">Bật</a>
									<?php
									} else {
									?>
										<a class="btn btn-secondary" href="?type_slider=<?php echo $sliderId ?>&type=1">Tắt</a>
									<?php
									}
									?>
								</td>
								<td>
									<a class="btn btn-danger" href="?slider_del=<?php echo $sliderId ?>" onclick="return confirm('Bạn có chắc chắn xóa không? ');">Xóa</a>
								</td>
							</tr>
					<?php
						}
					}

					?>
				</tbody>
			</table>

		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#slidertable').DataTable({
			order: [
				[0, "desc"]
			],
			language: {
				url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json",
			},
		});
	});
</script>
<?php include 'inc/footer.php'; ?>