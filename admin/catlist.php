<?php
include "inc/header.php";
include "inc/sidebar.php";
include "../classes/category.php";

$cat = new category();
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh mục sản phẩm</h2>
        <button id="btnAddCat" class="btn btn-success">Thêm danh mục</button>
        <div class="block">
            <table class="data display" id="catTable">
                <thead>
                    <tr>
                        <th>Mã danh mục</th>
                        <th>Tên danh mục</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $show_cate = $cat->show_category();
                    if ($show_cate) {
                        $i = 0;
                        while ($result = $show_cate->fetch_assoc()) {
                    ?>
                            <tr class="odd gradeX">
                                <td><?php echo $result["catId"]; ?></td>
                                <td><?php echo $result["catName"]; ?></td>
                                <td>
                                    <button class="btn btn-primary btnEdit">Sửa</button>
                                    <button class="btn btn-danger btnDelete">Xóa</button>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div id="dialogAddCat">
            <input type="text" placeholder="Tên danh mục" />
        </div>
        <div id="dialogDeleteCat">
            <span></span>
        </div>
    </div>
</div>
<script src="js/category.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setupLeftMenu();
        setSidebarHeight();
    });
</script>
<?php include "inc/footer.php"; ?>