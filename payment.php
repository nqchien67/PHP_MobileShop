<?php
	require_once 'inc/header.php';
    require_once 'inc/slider.php';
?>
 <?php
	 	$login_check = Session::get('customer_login');
		 if($login_check==false){
			header('Location:login.php');
		 } 
		 else{
			 echo '<a href="profile.php"></a>';
		 }
	  ?>
<?php
?>
<style>
    h3.payment {
        text-align: center;
        font-size: 20px;
        font-weight:bold;
        text-decoration: underline;
    }
    .wrapper_method{
        text-align: center;
        width: 550px;
        height:120px;
        margin:0 auto;
        border:1px solid #666;
        padding: 20px;
        background:cornsilk;
    }
    .wrapper_method a{
        padding: 10px;
        background: red;
        color: #fff;
        margin-right:5px;
    }
    .wrapper_method a:hover{
        background: #df5353;
    }
    .wrapper_method h3{
        margin-bottom: 20px;
    }
    .pre{
        margin-top:30px;
    }

</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
            <div class="content_top">
                <div class="heading">
                    <h3>Phương Thức Thanh Toán</h3>
                </div>
    		<div class="clear"></div>
            <div class="wrapper_method" style="padding-top: 0px;">
                <h3 class="payment">Chọn Phương Thức Thanh Toán</h3>
                <a href="cart.php" style="background:grey;"><< Quay Lại</a>
                 <a href="offinepayment.php">Thanh Toán Offline</a>
                 <!-- <a href="onlinepayment.php">Thanh Toán Online</a>     -->
                <!-- <div class="pre">
                </div> -->
            </div>
           
    	</div>
        <div class="clear"></div>
 		</div>
 	</div>
     <?php
	require_once 'inc/footer.php';
?>