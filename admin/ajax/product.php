<?php
include '../../classes/product.php';
include '../../lib/session.php';
Session::checkSession();

$product = new product();
// $product->$fm = new format();

function saveImage($file)
{
	$uploadsFolder = "../uploads/";

	$fileName = $file['name'];
	$fileTemp = $file['tmp_name'];
	$div = explode('.', $fileName);
	$file_ext = strtolower(end($div));
	$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
	$uploaded_image = $uploadsFolder . $unique_image;
	move_uploaded_file($fileTemp, $uploaded_image);
	return $unique_image;
}

function saveDescriptionImages()
{
	$accepted_origins = array("http://localhost");
	$imageFolder = "../uploads/description_images/";

	reset($_FILES);
	$temp = current($_FILES);
	if (is_uploaded_file($temp['tmp_name'])) {
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			// same-origin requests won't set an origin. If the origin is set, it must be valid.
			if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
				header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
			} else {
				header("HTTP/1.1 403 Origin Denied");
				return;
			}
		}

		/*
		If your script needs to receive cookies, set images_upload_credentials : true in
		the configuration and enable the following two headers.
	    */
		// header('Access-Control-Allow-Credentials: true');
		// header('P3P: CP="There is no P3P policy."');

		// Sanitize input
		if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
			header("HTTP/1.1 400 Tên file không hợp lệ.");
			return;
		}

		// Verify extension
		if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
			header("HTTP/1.1 400 Định dạng không hợp lệ.");
			return;
		}

		// Accept upload if there was no origin, or if it is an accepted origin
		$filetowrite = $imageFolder . $temp['name'];
		move_uploaded_file($temp['tmp_name'], $filetowrite);

		// Respond to the successful upload with JSON.
		// Use a location key to specify the path to the saved image resource.
		// { location : '/your/uploaded/image/file'}
		echo json_encode(array('location' => "uploads/description_images/" . $temp['name']));
	} else {
		// Notify editor that the upload failed
		header("HTTP/1.1 500 Server Error");
	}
}

function get($product)
{
	$result = $product->getproductbyId($_POST["productId"])->fetch_assoc();
	$response = array(
		"id" => $result["productId"],
		"name" => $result["productName"],
		"price" =>  $result["price"],
		"catId" => $result["catId"],
		"brandId" => $result["brandId"],
		"desc" => $result["product_desc"],
		"quantity" => $result["quantity"],
	);
	echo json_encode($response);
	exit();
}

function add($product)
{
	$unique_image = saveImage($_FILES["image"]);

	$newProduct = $_POST;
	unset($newProduct["action"]);
	$newProduct["image"] = $unique_image;

	return $product->insert_product($newProduct);
}

function delete($product)
{
	return $product->del_product($_POST["productId"]);
}

function edit($product)
{
	$uploadsFolder = "../uploads/";
	$result = $_POST;
	unset($result["action"]);
	unset($result["id"]);

	$unique_image = "";
	if (isset($_FILES['image'])) {
		$existImage = $product->get_image_name($_POST["productId"]);
		unlink($uploadsFolder . $existImage);
		$unique_image = saveImage($_FILES["image"]);
	}
	$result["image"] = $unique_image;
	return $product->update_product($result, $_POST["productId"]);
}

function addSl($product)
{
	return $product->updateQuantity($_POST["id"], $_POST["sl"]);
}

function lowQuantity($product)
{
	$productList = $product->showProductLowQuanity($_POST["number"]);
	if ($productList == null) {
		echo json_encode("");
		exit();
	}
	$response = array();
	while ($result = $productList->fetch_assoc()) {
		$row = array(
			$result["productId"],
			$result["productName"],
			$product->fm->format_currency($result["price"]),
			"<img src='uploads/" . $result["image"] . "' width='50px' style='padding-top:10px;'>",
			$result["quantity"],
			$result["catName"],
			$result["brandName"],
			"<button class='btnDetail btn btn-primary m-2'>Xem chi tiết</button>",
		);
		array_push($response, $row);
	}

	echo json_encode($response);
	exit();
}

if (isset($_POST["action"])) {
	$success = false;

	switch ($_POST["action"]) {
		case "get":
			get($product);
			break;
		case "add":
			$success = add($product);
			break;
		case "delete":
			$success = delete($product);
			break;
		case "edit":
			$success = edit($product);
			break;
		case "addSl":
			$success = addSl($product);
			break;
		case "lowQuantity":
			lowQuantity($product);
			break;
	}

	if (!$success) {
		echo json_encode(false);
		exit();
	}

	$productList = $product->show_product();
	if ($productList == null) {
		echo json_encode("");
		exit();
	}

	$response = array();
	while ($result = $productList->fetch_assoc()) {
		$row = array(
			$result["productId"],
			$result["productName"],
			$product->fm->format_currency($result["price"]),
			"<img src='uploads/" . $result["image"] . "' width='50px' style='padding-top:10px;'>",
			$result["quantity"] .
				"<button id=" . $result["quantity"] . " class='btnSl btn btn-secondary p-0 m-2'>
					<svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-plus' viewBox='0 0 16 16'>
					<path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z' /></svg>
				</button>",
			$result["catName"],
			$result["brandName"],
			"<button class='btnDetail btn btn-primary m-2'>Xem chi tiết</button>
			<button class='btn btn-danger btnDelete'>Xóa</button>",
		);
		array_push($response, $row);
	}

	echo json_encode($response);
	exit();
} else if (isset($_FILES)) {
	saveDescriptionImages();
	exit();
} else {
	header("HTTP/1.1 500 Server Error");
}
