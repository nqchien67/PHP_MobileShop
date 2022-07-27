

<?php
	require_once 'inc/header.php';
	require_once 'inc/slider.php';
?>
<?php
				$login_check = Session::get('customer_login');
				if($login_check==false){
					header('Location:login.php');
				}
?>
<div class="main">
    <div class="content">
    	<div class="cartoption">
            <div class="order_page" style="background-color:#dbd0d0;">
                <h2 style="color:red;font-weight: bold;font-size:40px;">Chào Mừng bạn đến với website</h2>
            </div>
                    
       <div class="clear"></div>
    </div>
 </div>

 <?php
	require_once 'inc/footer.php';
?>