<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/product.php' ?>
<?php
$product = new product();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $insertSlider = $product->insert_slider($_POST, $_FILES);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm Slider</h2>
        <div class="block">
            <div class="container">
                <form action="slideradd.php" method="post" enctype="multipart/form-data" class="row">
                    <div class="col-4">
                        <a class="btn btn-primary mb-3" href="sliderlist.php" role="button">Quay lại</a>
                        <h4><?php
                            if (isset($insertSlider)) {
                                echo $insertSlider;
                            }
                            ?></h4>
                        <table class="form">
                            <tr>
                                <td>
                                    <label>Tiêu Đề</label>
                                </td>
                                <td>
                                    <input type="text" name="sliderName" placeholder="Tiêu đề ..." />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>Tải ảnh lên</label>
                                </td>
                                <td>
                                    <input type="file" name="image" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Hiển thị</label>
                                </td>
                                <td>
                                    <select name="type">
                                        <option value="1">Bật</option>
                                        <option value="0">Tắt</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" name="submit" value="Lưu" class="btn btn-success" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-8">
                        <table data-role="table" class="data display" id="productTable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Mã SP</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Ảnh Sản Phẩm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pdlist = $product->show_product();
                                if ($pdlist) {
                                    while ($result = $pdlist->fetch_assoc()) {
                                        $productId = $result["productId"];
                                ?>
                                        <tr class="odd gradeX">
                                            <td><input type="radio" name="pro" value="<?php echo $productId ?>"></td>
                                            <td><?php echo $productId ?></td>
                                            <td><?php echo $result["productName"] ?></td>
                                            <td><img src="uploads/<?php echo $result["image"] ?>" width="50px" style="padding-top:10px;"></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#productTable").DataTable({
        "pageLength": 5,
        columnDefs: [{
            width: "14%",
            targets: 1
        }],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json",
        },
    });
</script>
<?php include 'inc/footer.php'; ?>