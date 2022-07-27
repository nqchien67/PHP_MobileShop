<?php
// Session_start();
	require_once 'inc/header.php';
	// require_once 'inc/slider.php';
?>
<?php
				$login_check = Session::get('customer_login');
				if($login_check){
					header('Location:order.php');
				}
?>
<?php
    // $pd = new product();
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $insertCustomers = $cs-> insert_customers($_POST);
    }
?>
<?php
    // $pd = new product();
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
        $loginCustomers = $cs-> login_customers($_POST);
    }
?>
 <div class="main">
    <div class="content">
    	<div class="login_panel">
		<?php
				if(isset($loginCustomers)){
					echo $loginCustomers;
				}
			?>
        	<h3>Thông Tin Khách Hàng</h3>
        	<p>Đăng nhập theo form bên dưới</p>
        	<form action="" method="POST">
                	<input type="text" name="email" class="field" placeholder="Nhập Email">
                    <input type="password" name="password" class="field" placeholder="Nhập Mật Khẩu...........">
                 <!-- <p class="note"><a href="#">here</a></p> -->
                    <div class="buttons"><div><input type="submit" name="login" class="grey" value="Đăng Nhập"  style="background-color:gray;color: #fff; padding: 10px;"></input></div></div>
			</form>
			</div>
			
    	<div class="register_account" style="height: 320px; width: 77%;">
    		<h3>Đăng Kí Tài Khoản Mới</h3>
			<?php
				if(isset($insertCustomers)){
					echo $insertCustomers;
				}
			?>
		
    		<form action="" method="post" style="height: 245px; ">
		   			 <table>
		   				<tbody>
						<tr>
							<td>
								<div>
								<input id ="username" type="text" name="name" placeholder="Nhập Tên ..." style="width: 400px;" >
								</div>
								<div>
									<input id = "email" type="text" name="email" placeholder="Nhập Email ..."style="width: 400px;">
								</div>
							</td>
							<td>
								<div>
									<input id = "address" type="text" name="address" placeholder="Nhập Địa Chỉ..."style="width: 400px;">
								</div>
								<div>
								<input id = "phone" type="text" name="phone" placeholder="Nhập số điện thoại..."style="width: 400px;">
								</div>
								<div>
									<input id = "password" type="text" name="password" placeholder="Nhập Mật Khẩu ..."style="width: 400px;">
								</div>
							</td>
		   			 	</tr> 
		    		</tbody>
				</table> 
				<div class="search"><div><input type="submit" name="submit" class="grey" value="Tạo Tài Khoản" style="background-color:gray;color: #fff; padding: 10px;"></input></div></div>
		    <div class="clear"></div>
		    </form>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php
	require_once 'inc/footer.php';
?>
