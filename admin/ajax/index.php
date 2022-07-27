<?php
include '../../classes/order.php';
include '../../lib/session.php';
Session::checkSession();

$order = new order();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dateArr = $_POST["dateArr"];
    $orderList = $order->get_order_by_date($dateArr[0], $dateArr[count($dateArr) - 1]);

    if ($orderList == null) {
        echo json_encode("");
        exit();
    }

    $response = array();
    foreach ($dateArr as $date) {
        array_push($response, [
            "price" => 0,
            "total" => 0,
            "date" => $date,
        ]);
    }

    function getDateFromStr($dateTime)
    {
        $result = explode(" ", $dateTime);
        return $result[0];
    }

    $i = 0;
    while ($data = $orderList->fetch_assoc()) {
        while ($dateArr[$i] < getDateFromStr($data["date_order"])) {
            $i++;
        }
        $response[$i]["price"] += (int)$data["total"];
        $response[$i]["total"]++;
    }

    echo json_encode($response);
    exit();
}
