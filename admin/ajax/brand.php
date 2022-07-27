<?php
include '../../classes/brand.php';
include '../../lib/session.php';
Session::checkSession();

$brand = new brand();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["action"] == "add") {
        $brandName = $_POST["brandName"];
        $success = $brand->insert_brand($brandName);
    }

    if ($_POST["action"] == "delete") {
        $success = $brand->del_brand($_POST["brandId"]);
    }

    if ($_POST["action"] == "edit") {
        $success = $brand->update_brand($_POST["brandName"], $_POST["brandId"]);
    }

    if (!$success) {
        echo json_encode(false);
        exit();
    }

    $response = array();
    $brandList = $brand->show_brand();
    if ($brandList == null) {
        echo json_encode("");
        exit();
    }

    while ($data = $brandList->fetch_assoc()) {
        $row = array(
            $data["brandId"],
            $data["brandName"],
            "<button class='btn btn-primary btnEdit'>Sửa</button>" .
                " <button class='btn btn-danger btnDelete'>Xóa</button>",
        );
        array_push($response, $row);
    }

    echo json_encode($response);
    exit();
}
