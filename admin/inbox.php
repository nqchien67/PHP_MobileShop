<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/cart.php');
include_once($filepath . '/../helpers/dbhelper.php');
include_once($filepath . '/../classes/order.php');
include_once($filepath . '/../classes/customer.php');
?>
<?php
$customer = new customer();
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Đơn hàng</h2>
        <div class="block">
            <?php
            if (isset($shifted)) {
                echo $shifted;
            }
            ?>
            <?php
            if (isset($del_shifted)) {
                echo $del_shifted;
            }
            ?>
            <table class="data display" id="orderTable">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng tiền</th>
                        <th>Khách hàng</th>
                        <th>Trạng Thái</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $order = new order();
                    $fm = new format();
                    $getOrder = $order->get_order();
                    if ($getOrder) {
                        while ($result = $getOrder->fetch_assoc()) {
                    ?>
                            <tr class="odd gradeX">
                                <td><?php echo $result["orderId"] ?></td>
                                <td><?php echo $fm->formatDate($result['date_order']) ?></td>
                                <td><?php echo $fm->format_currency($result["total"]) . ' ' . ' đ' ?></td>
                                <td>
                                    <b>
                                        <p style="cursor: pointer;" id="
                                        <?php echo $result["customer_Id"] ?>" class="btnCustomer text-primary">
                                            <?php echo $customer->get_customerName($result["customer_Id"]); ?></p>
                                    </b>
                                </td>
                                <td class="status"><?php echo $order->status_toString($result["status"]); ?></td>
                                <td><button class="btnDetail btn btn-primary">Chi tiết</button></td>
                                <td><?php
                                    switch ($result["status"]) {
                                        case 0:
                                            echo "<button class='btnChecked btn btn-primary'>Xác nhận đơn</button>
                                            <button class='btnCancel btn btn-danger'>Hủy đơn</button>";
                                            break;
                                        case 1:
                                            echo "<button class='btnShifted btn btn-success'>Giao thành công</button>
                                            <button class='btnCancel btn btn-danger'>Hủy giao hàng</button>";
                                            break;
                                        default:
                                            echo "";
                                    }
                                    ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div id="dialogDetail">
                <table id="detailTable">
                    <thead>
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng giá</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="dialogCustomer">
                <table class="form">
                    <tr>
                        <td><label>Tên khách hàng: </label></td>
                        <td><span id="cName"></span></td>
                    </tr>
                    <tr>
                        <td><label>Số điện thoại: </label></td>
                        <td><span id="cPhone"></span></td>
                    </tr>
                    <tr>
                        <td><label>Địa chỉ: </label></td>
                        <td><span id="cAddress"></span></td>
                    </tr>
                    <tr>
                        <td><label>Email: </label></td>
                        <td><span id="cEmail"></span></td>
                    </tr>
                </table>
            </div>
            <div id="dialogCancel">
                <span></span>
            </div>
        </div>
    </div>
</div>

<script src="js/inbox.js" type="text/javascript"></script>
<?php include 'inc/footer.php' ?>