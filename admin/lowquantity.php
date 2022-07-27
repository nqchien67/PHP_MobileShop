<?php include "inc/header.php";
include "inc/sidebar.php";
include "../classes/product.php";
include "../classes/category.php";
include "../classes/brand.php";

$product = new product();
$fm = new format();
if (isset($_GET["productId"])) {
    $id = $_GET["productId"];
    $delpro = $pd->del_product($id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Sản phẩm sắp hết</h2>
        <div class="block">
            <div class="mb-3">
                <label>Hiển thị sản phẩm số lượng dưới:</label>
                <input type="number" name="number" id="inputNumber" min="0" value="5">
            </div>
            <table class="data display" id="productTable">
                <thead>
                    <tr>
                        <th>Mã SP</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Ảnh Sản Phẩm</th>
                        <th>Số lượng</th>
                        <th>Danh Mục</th>
                        <th>Thương Hiệu</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pdlist = $product->showProductLowQuanity(5);
                    if ($pdlist) {
                        while ($result = $pdlist->fetch_assoc()) {
                    ?>
                            <tr class="odd gradeX">
                                <td><?php echo $result["productId"] ?></td>
                                <td><?php echo $result["productName"] ?></td>
                                <td><?php echo $product->fm->format_currency($result["price"]) ?></td>
                                <td><img src="uploads/<?php echo $result["image"] ?>" width="50px" style="padding-top:10px;"></td>
                                <td><?php echo $result["quantity"]; ?></td>
                                <td><?php echo $result["catName"] ?></td>
                                <td><?php echo $result["brandName"] ?></td>
                                <td>
                                    <button class="btnDetail btn btn-primary" id="<?php echo $result["productId"]; ?>">Xem chi tiết</button>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div id="dialogAddProduct">
                <table class="form">
                    <tr>
                        <td><label>Tên</label></td>
                        <td><input disabled type="text" id="name" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Danh mục</label></td>
                        <td>
                            <select disabled id="category">
                                <?php
                                $cat = new category();
                                $catlist = $cat->show_category();
                                if ($catlist) {
                                    while ($result = $catlist->fetch_assoc()) {
                                ?>
                                        <option value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Thương hiệu</label>
                        </td>
                        <td>
                            <select disabled id="brand">
                                <?php
                                $brand = new brand();
                                $brandlist = $brand->show_brand();
                                if ($brandlist) {
                                    while ($result = $brandlist->fetch_assoc()) {
                                ?>
                                        <option value="<?php echo $result['brandId'] ?>"><?php echo $result['brandName'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Miêu tả</label>
                        </td>
                        <td><textarea id="description" class="tinymce"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Giá</label></td>
                        <td><input disabled id="price" placeholder="Nhập giá..." class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Số lượng</label></td>
                        <td><input disabled id="quantity" placeholder="Nhập số lượng..." class="medium" /></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="js/lowquantity.js" type="text/javascript"></script>
<?php include "inc/footer.php"; ?>