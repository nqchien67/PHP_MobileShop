<?php
 $filepath = realpath(dirname(__FILE__));
 include_once ($filepath.'/../lib/database.php');
 include_once ($filepath.'/../helpers/dbhelper.php');
?>
<?php
    class category{  
        private $fm;
        private $db;
        public function __construct(){
            $this->db = new Database();
            $this->fm = new format();
        }
        //thêm danh muc san pham
        public function insert_category($catName){
            $catName = $this->fm->validation($catName);
            $catName = mysqli_real_escape_string($this->db->link,$catName); 
            if(empty($catName)){
                $alert = "<span class= 'error'>Danh Mục Sản Phẩm Không Được Để Trống</span>";
                return $alert;
            }
            else{
                //câu lệnh chèn danh mục sản phẩm
                $query = "INSERT INTO tbl_category(catName) VALUES('$catName')";
                $result = $this->db->insert($query);    
                if($result){
                    $alert = "<span class= 'success'>Thêm Danh Mục Sản Phẩm Thành Công</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class= 'error'>Thêm Danh Mục Sản Phẩm thất bại</span>";
                    return $alert;
                }
            }
        }
        public function show_category(){
            $query = "SELECT * from  tbl_category order by catId desc"; 
            //desc sắp xếp theo thứ tự giảm dần 
            $result = $this->db->select($query);
            return $result;
        }
        public function getcatbyid($id){
            //chọn tât cả các danh mục có catId = id;
            $query = "SELECT * FROM tbl_category where catId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }
        public function update_category($catName,$id){
            $catName = $this->fm->validation($catName);
            $catName = mysqli_real_escape_string($this->db->link,$catName);
            $id = mysqli_real_escape_string($this->db->link,$id);
            if(empty($catName)){
                $alert = "<span class='error'>Danh Mục Sản Phẩm Không Đươc Để Trống</span>";
                return $alert;
            }
            else{
                $query = "UPDATE tbl_category SET catName ='$catName' WHERE catId = '$id'";
                $result = $this->db->update($query);
                if($result){
                    $alert = "<span class='success'>Cập Nhật Danh Mục Sản Phẩm Thành Công</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Cập Nhật Danh Mục Sản Phẩm Thành Công</span>";
                    return $alert;
                }
            }
        } 
        public function del_category($id){
            $query = "DELETE FROM tbl_category WHERE catId = '$id'";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Xóa Danh Mục Sản Phẩm Thành Công</span>";
                return $alert;
            }
            else{
                $alert = "<span class = 'error'>Xóa Danh Mục Sản Phẩm Không Thành Công</span>";
                return $alert;
            }
        }
        public function show_category_fontend(){
            $query = "SELECT * from  tbl_category order by catId desc";
            $result = $this->db->select($query);
            return $result;
        }
        public function get_product_by_cat($id){
            $query = "SELECT * FROM tbl_product where catId = '$id' order by catId desc LIMIT 8";
            $result = $this->db->select($query);
            return $result;
        }
        public function get_name_by_cat($id){

            $query = "SELECT tbl_product.*,tbl_category.catName,tbl_category.catId FROM  tbl_product,tbl_category WHERE tbl_product.catId = tbl_category.catId AND tbl_product.catId = '$id' LIMIT 1";
            //chọn tất cả thành phần trong bảng product và chọn catName từ bảng category và chọn catID từ bảng category
            //điều kiện cartId của bảng product phải bằng cartId của bảng category và cartid của bảng product phải bằng id mình truyền vào, limit 1 (chỉ được chọn 1)
            $result = $this->db->select($query);
            return $result;
        }
    }

?>    