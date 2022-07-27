<?php
include "inc/header.php";
include "inc/sidebar.php";
include "../classes/brand.php";

$brand = new brand();

if (isset($_GET["delid"])) {
    //neu ton tai delid thi se gan vaof $id
    $id = $_GET["delid"];
    $delbrand = $brand->del_brand($id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách thương hiệu</h2>
        <button id="btnAddBrand" class="btn btn-success">Thêm thương hiệu</button>
        <div class="block">
            <table class="data display" id="brandTable">
                <thead>
                    <tr>
                        <th>Mã thương hiệu</th>
                        <th>Tên thương hiệu</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $show_brand = $brand->show_brand();
                    if ($show_brand) {
                        $i = 0;
                        while ($result = $show_brand->fetch_assoc()) {
                    ?>
                            <tr class="odd gradeX">
                                <td><?php echo $result["brandId"]; ?></td>
                                <td><?php echo $result["brandName"] ?></td>
                                <td>
                                    <button class="btn btn-primary btnEdit" ?>Sửa</button>
                                    <button class="btn btn-danger btnDelete" ?>Xóa</button>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div id="dialogAddBrand">
                <input type="text" placeholder="Tên thương hiệu" />
            </div>
            <div id="dialogDeleteBrand">
                <span></span>
            </div>
        </div>
    </div>
</div>
<script src="js/brand.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setupLeftMenu();
        setSidebarHeight();
    });
</script>
<?php include "inc/footer.php"; ?>