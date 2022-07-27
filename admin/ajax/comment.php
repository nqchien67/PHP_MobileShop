<?php
include '../../classes/comment.php';
// include '../../classes/product.php';
include '../../lib/session.php';
Session::checkSession();

$comment = new comment();
// $product = new product();

if (isset($_POST["action"])) {
    // if ($_POST["action"] == "get") {
    //     $resutl = $product->getproductbyId($_POST["productId"]);
    //     $response = array(
    //         "id" => $result["productId"],
    //         "name" => $result["productName"],
    //         "price" =>  $result["price"],
    //         "catId" => $result["catId"],
    //         "brandId" => $result["brandId"],
    //         "desc" => $result["product_desc"],
    //     );
    //     echo json_encode($response);
    //     exit();
    // }

    if ($_POST["action"] == "delete") {
        $success = $comment->del_comment($_POST["id"]);
        echo json_encode($success);
        exit();
    }
}
