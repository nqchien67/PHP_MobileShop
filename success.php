<?php
	require_once 'inc/header.php';
	// require_once 'inc/slider.php';
?>
<?php
	if(isset($_GET['orderId'])&&$_GET['orderId']=='order'){
        $customer_Id = Session::get('customer_Id');
        $insertOrder = $ct->insertOrder($customer_Id);
        $delCart = $ct->del_all_data_cart();
        header('Location: success.php');
    }
?>
<style type="text/css">
  h2.success{
      text-align: center;
      color:red;
  }
  p.success_note{
      text-align:center;
      padding:8px;
      font-size:17px;
  }
</style>
<form action="" method="POST">
<div class="main">
    <div class="content">
    	<div class="section group">
        <h2 class="success_order">Đặt Hàng Thành Công</h2>
        <?php 
		 $customer_Id = Session::get('customer_Id');
            $get_amount = $ct->getAmountPrice($customer_Id);
            if($get_amount){
                $amount = 0;
                while($result = $get_amount->fetch_assoc()){
                    $price = $result['price'];
                    $amount +=$price;
                }
            }
        ?>
        <p class="success_note">Tổng giá tiền mà bạn đã mua tại trang web của chúng tôi là:
            <?php
                $vat = $amount * 0.15;
                $total = $vat + $amount;
                echo $fm->format_currency($total). 'VND';
            ?>
        </p>
        <p class="success_note">Chúng tôi sẽ liên lạc sớm nhất có thể. Làm ơn xem lại chi tiết đơn hàng <a href="ordersp.php" style="text-decoration: none;"><span style="border: 1px solid red;background-color: red; color: #fff;padding: 5px;">Click Here</span></a></p>
        </div>
       
 	</div>
</div>
</form>
<?php
	require_once 'inc/footer.php';
?>