<?php

$filepath = realpath(dirname(__FILE__));
//realpath - Trả về tên đường dẫn tuyệt đối được chuẩn hóa
    include_once ($filepath.'/../lib/session.php');
    Session::checkLogin();
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/dbhelper.php');
    
?>
<?php
    class adminlogin{  
        private $fm;
        private $db;
        public function __construct(){
            $this->db = new Database();//gọi class rồi truyền vào nút db
            $this->fm = new format();
        }
        public function login_admin($adminUser,$adminPass){
            $adminUser = $this->fm->validation($adminUser);//kiểm tra xem các biến có hợp lệ hay không
            $adminPass = $this->fm->validation($adminPass);//kiểm tra xem các biến có hợp lệ hay không
            $adminUser = mysqli_real_escape_string($this->db->link,$adminUser);
            $adminPass = mysqli_real_escape_string($this->db->link,$adminPass);
            // mysqli_real_escape_string(kết nối với cơ sở dữ liệu, Tên biến)
            if(empty($adminUser)||empty($adminPass)){
                $alert = "Tên Người Dùng hoặc Mật Khẩu không được để trống";
                return $alert;
            }
            else{
                $query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass' LIMIT 1";
                $result = $this->db->select($query);    
                if($result != false){//nếu kết quả đúng
                    $value = $result ->fetch_assoc();//lấy kết quả ra
                    Session::set('adminlogin', true);//đã tồn tại admin này
                    Session::set('adminId',$value['adminId']);
                    Session::set('adminUser',$value['adminUser']);
                    Session::set('adminName',$value['adminName']);
                    header('Location:index.php');//nếu nhập user và pass  đúng thì hướng về file admin/index.php
                }
                else{
                    $alert = "Tên Người Dùng hoặc Mật Khẩu không đúng";
                    return $alert;
                }
            }
        }
    }
?>