<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/brand.php'; ?>
<?php include '../classes/category.php'; ?>
<?php include '../classes/product.php'; ?>
<?php include '../classes/comment.php'; ?>
<?php include_once '../helpers/dbhelper.php'; ?>
<?php
$cm = new comment();
$fm = new Format();

if (isset($_GET['binhluanid'])) {
	$id = $_GET['binhluanid'];
	$delcomment = $cm->del_comment($id);
}
?>
<div class="grid_10">
	<div class="box round first grid">
		<h2>Bình luận</h2>
		<div class="block">
			<?php
			if (isset($delcomment)) {
				echo $delcomment;
			}
			?>

			<table class="data display fixed" id="commentTable">
				<thead>
					<tr>
						<th>STT</th>
						<th>Người bình luận</th>
						<th>Sản phẩm</th>
						<th>Nội dung</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$cmlist = $cm->show_comment();
					if ($cmlist) {

						while ($result = $cmlist->fetch_assoc()) {
					?>
							<tr class="odd gradeX">
								<td><?php echo $result["binhluan_id"] ?></td>
								<td><?php echo $result['name'] ?></td>
								<td id="<?php echo $result["productId"] ?>" class="btnProduct hover">
									<p class="text-primary">
										<?php echo $result["productName"]; ?></p>
									<img src="<?php echo "uploads/" . $result['image'] ?>" width="50px">
								</td>
								<td><?php echo $result['binhluan'] ?></td>
								<td>
									<button id="<?php echo $result["binhluan_id"] ?>" class="btnDelete btn btn-danger">Xóa</button>
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
<script src="js/comment.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		setupLeftMenu();
		setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php'; ?>