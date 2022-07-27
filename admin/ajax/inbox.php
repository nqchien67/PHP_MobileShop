<?php
// include '../../classes/order.php';
include '../../classes/orderDetail.php';
include '../../classes/order.php';
include '../../classes/customer.php';
include '../../lib/session.php';
Session::checkSession();

$orderDetail = new orderDetail();
$order = new order();
$customer = new customer();

function get($orderId, $orderDetail)
{
    $odList = $orderDetail->get_detail_by_orderId($orderId);

    if ($odList == null) {
        echo json_encode("");
        exit();
    }

    $response = array();
    while ($result = $odList->fetch_assoc()) {
        $row = array(
            $result["productId"],
            $result["productName"],
            "<img src='uploads/" . $result["image"] . "' width='100px' style='padding-top:10px;'>",
            $result["price"],
            $result["quantity"],
            $result["totalPrice"],
        );
        array_push($response, $row);
    }
    echo json_encode($response);
    exit();
}

function getCustomer($customerId, $customer)
{
    $result = $customer->show_customers($customerId)->fetch_assoc();
    $response = array(
        "id" => $result["id"],
        "name" => $result["name"],
        "address" => $result["address"],
        "city" => $result["city"],
        "phone" => $result["phone"],
        "email" => $result["email"],
    );
    echo json_encode($response);
    exit();
}

function checked($orderId, $order)
{
    $result = $order->shift($orderId);
    if (!$result) {
        echo json_encode("db");
        exit();
    }
}

function cancel($orderId, $order)
{
    $result = $order->cancel($orderId);
    if (!$result) {
        echo json_encode("db");
        exit();
    }
}

function shifted($orderId, $order)
{
    $result = $order->shifted($orderId);
    if (!$result) {
        echo json_encode("db");
        exit();
    }
}

if (isset($_POST["action"])) {
    switch ($_POST["action"]) {
        case "get":
            get($_POST["orderId"], $orderDetail);
            break;
        case "getCustomer":
            getCustomer($_POST["customerId"], $customer);
            break;
        case "checked":
            checked($_POST["orderId"], $order);
            break;
        case "cancel":
            cancel($_POST["orderId"], $order);
            break;
        case "shifted":
            shifted($_POST["orderId"], $order);
            break;
        default:
            echo json_encode("action = ''");
            exit();
    }

    echo json_encode(true);
    exit();
}
