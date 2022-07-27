<?php include "inc/header.php";
include "inc/sidebar.php";
include "../classes/product.php";
include "../classes/category.php";
include "../classes/brand.php";

$product = new product();
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh Sách Sản Phẩm</h2>
        <button id="btnAddProduct" class="btn btn-success">Thêm sản phẩm</button>
        <div class="block">
            <table data-role="table" class="data display" id="productTable">
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
                    $pdlist = $product->show_product();
                    if ($pdlist) {
                        while ($result = $pdlist->fetch_assoc()) {
                            $quantity = $result["quantity"];
                    ?>
                            <tr class="odd gradeX">
                                <td><?php echo $result["productId"] ?></td>
                                <td><?php echo $result["productName"] ?></td>
                                <td><?php echo $product->fm->format_currency($result["price"]) ?></td>
                                <td><img src="uploads/<?php echo $result["image"] ?>" width="50px" style="padding-top:10px;"></td>
                                <td>
                                    <?php echo $quantity; ?>
                                    <button id="<?php echo $quantity; ?>" class="btnSl btn btn-secondary p-0 m-2">
                                        <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-plus' viewBox='0 0 16 16'> "
                                            <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z' />
                                        </svg>
                                    </button>
                                </td>
                                <td><?php echo $result["catName"] ?></td>
                                <td><?php echo $result["brandName"] ?></td>
                                <td>
                                    <button class="btnDetail btn btn-primary m-1" id="<?php echo $result["productId"]; ?>">Xem chi tiết</button>
                                    <button class="btnDelete btn btn-danger" id="<?php echo $result["productId"]; ?>">Xóa</button>
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
                        <td>
                            <label>Tên</label>
                        </td>
                        <td>
                            <input type="text" id="name" placeholder="Nhập tên sản phẩm..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Danh mục</label>
                        </td>
                        <td>
                            <select id="category">
                                <option value="-1">-------Chọn danh mục--------</option>
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
                            <select id="brand">
                                <option value="-1">-------Chọn thương hiệu-------</option>
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
                        <td>
                            <textarea id="description" class="tinymce"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Giá</label>
                        </td>
                        <td>
                            <input id="price" placeholder="Nhập giá..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Số lượng</label>
                        </td>
                        <td>
                            <input id="quantity" placeholder="Nhập số lượng..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Ảnh</label>
                        </td>
                        <td>
                            <input type="file" id="image" />
                        </td>
                    </tr>

                </table>
            </div>
            <div id="dialogDeleteProduct">
                <span></span>
            </div>
            <div id="sl">
                <input id="slAdd" type="number" placeholder="Thêm số lượng">
                <button id="btnSlAdd">Thêm</button>
            </div>
        </div>
    </div>
</div>

<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="js/product.js" type="text/javascript"></script>
<?php include "inc/footer.php"; ?>