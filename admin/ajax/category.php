<?php
include '../../classes/category.php';
include '../../lib/session.php';
Session::checkSession();

$cat = new category();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["action"] == "add") {
        $categoryName = $_POST["categoryName"];
        $success = $cat->insert_category($categoryName);
    }

    if ($_POST["action"] == "delete") {
        $success = $cat->del_category($_POST["categoryId"]);
    }

    if ($_POST["action"] == "edit") {
        $success = $cat->update_category($_POST["categoryName"], $_POST["categoryId"]);
    }

    if (!$success) {
        echo json_encode(false);
        exit();
    }

    $catArr = array();
    $catList = $cat->show_category();
    if ($catList == null) {
        echo json_encode("");
        exit();
    }

    while ($data = $catList->fetch_assoc()) {
        $row = array(
            $data["catId"],
            $data["catName"],
            "<button class='btnEdit btn btn-primary'>Sửa</button>" .
                " <button class='btnDelete btn btn-danger'>Xóa</button>",
        );
        array_push($catArr, $row);
    }

    echo json_encode($catArr);
    exit();
}
