<?php
    include 'inc/header.php';
?>
<?php
    include 'inc/sidebar.php';
?>

<?php
 $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/customer.php');

    include_once ($filepath.'/../helpers/dbhelper.php');
    ?>
<?php
    if(!isset($_GET['customerId']) || $_GET['customerId']==NULL){
        echo "<script>window.location ='inbox.php'</script>";
    }
    else{
        $id = $_GET['customerId'];
    }
    $cs = new customer();
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        echo "<script>window.location ='inbox.php'</script>";
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thông Tin Khách Hàng</h2>
        <div class="block copyblock">
        <?php
          $cs = new customer();
            $get_customer = $cs->show_customers($id);
            if($get_customer){
                while($result = $get_customer->fetch_assoc()){
        ?>
            <form action="" method="post">
                <table class="form">
                    <tr>
                        <td>Tên</td>
                        <td>:</td>
                        <td>
                            <input type="text" readonly = "readonly" value="<?php echo $result['name']?>" name="catName" class="medium"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Địa Chỉ</td>
                        <td>:</td>
                        <td>
                            <input type="text" readonly = "readonly" value="<?php echo $result['address']?>" name="catName" class="medium"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>
                            <input type="text" readonly = "readonly" value="<?php echo $result['email']?>" name="catName" class="medium"/>
                        </td>
                    </tr>
                 
                </table>
            </form>
    <?php
                }
            }
    ?>
        </div>
    </div>
</div>
<?php
    include 'inc/footer.php';
?>