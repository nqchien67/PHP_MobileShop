<?php
	require_once 'inc/header.php';
?>
 <?php
	 	$login_check = Session::get('customer_login');
		 if($login_check==false){
             //nếu đăng nhập sai sẽ quay về trang login
			header('Location:login.php');
		 } 
		 else{
			 echo '<a href="profile.php"></a>';
		 }
	  ?>
<?php
?>
 <div class="main">
    <div class="content">
    	<div class="section group">
            <div class="content_top">
                <div class="heading">
                    <h3>Thông Tin Khách Hàng</h3>
                </div>
    		<div class="clear"></div>
    	</div>
            <table class="tblone">
                <?php
                $id = Session::get('customer_Id');
                    $get_customers = $cs->show_customers($id);
                    if($get_customers){
                        while($result = $get_customers->fetch_assoc()){
                ?>
                <tr>
                    <td>Tên Khách Hàng</td>
                    <td>:</td>
                    <td><?php echo $result['name'] ?></td>
                </tr>
                <tr>
                    <td>Điện Thoại</td>
                    <td>:</td>
                    <td><?php echo $result['phone'] ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><?php echo $result['email'] ?></td>
                </tr>

                <tr>
                    <td>Địa Chỉ</td>
                    <td>:</td>
                    <td><?php echo $result['address'] ?></td>
                </tr>
                <tr>
                    <td colspan="3"><a href="editprofile.php">Cập Nhật Thông Tin</a></td>
                </tr>
                <?php                       
                        }
                  }
                ?>
            </table>
 		</div>
 	</div>

<?php
	require_once 'inc/footer.php';
?>