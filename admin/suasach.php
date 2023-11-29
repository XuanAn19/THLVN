<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/them.css">
    <title>Sửa Sách</title>
</head>

<body>
<?php
        include '../connect_db.php'; 
        if (!empty($_GET['id'])) {
            $result = mysqli_query($kn, "SELECT * FROM `sanpham` WHERE `id_sp` = " . $_GET['id']);
            $sanpham = $result->fetch_assoc();
        
        }
       
        if(isset($_GET['id'])){
            $id_sp= $_GET['id'];          
        ?>
            <a href="http://localhost/bansach/THLVN/admin/quanlysach.php" class="back-to-menu">quay lại menu quản lí</a>
        <form action="suasach.php?id=<?= $sanpham['id_sp']?>" method="post" enctype="multipart/form-data">
        <div class ="form-container">
                <div class="form-left">
                    <ul>
                        <li>Tên Sách<input type="text" name ="ten_sp" value="<?= !empty($sanpham) ? $sanpham['ten_sp'] : "" ?>" required oninvalid="this.setCustomValidity('Vui lòng nhập Tên Sách')"> </li>
                        <li>Tên Tác Giả<input type="text" name ="tentacgia" value="<?= !empty($sanpham) ? $sanpham['tentacgia'] : "" ?>" required oninvalid="this.setCustomValidity('Vui lòng nhập Tên Tác Giả')"> </li>
                        <li>Giá Tiền<input type="text" name ="gia" value="<?= !empty($sanpham) ? $sanpham['gia'] : "" ?>" required oninvalid="this.setCustomValidity('Vui lòng nhập Giá Tiền')"> </li>
                        <li> Số Lượng<input type="text" name ="soluong"value="<?= !empty($sanpham) ? $sanpham['soluong'] : "" ?>" required oninvalid="this.setCustomValidity('Vui lòng nhập Số Lượng')"></li> 
                    </ul>  
                </div>
                <div class="form-right">
                    
                        <ul>
                        <label>Thể Loại</label>
                            <li> 
                                <select name="theloai" >
                                    <?php
                                        
                                        $query = "SELECT * FROM theloai";
                                        $theloai = mysqli_query($kn, $query);
                                        while ($row = mysqli_fetch_assoc($theloai)) {
                                        $categoryId = $row['id_theloai'];
                                        $categoryName = $row['ten'];
                                        echo "<option value='$categoryId'>$categoryName</option>";
                                        }

                                        
                                    ?>
                                </select>
                                
                            </li>
                            <li>Giới thiệu sách<textarea name="chitiet" id="" <?= !empty($sanpham) ? $sanpham['chitiet'] : "" ?> cols="30" rows="10" required oninvalid="this.setCustomValidity('Vui lòng nhập Giới Thiệu Sách')"></textarea> </li>
                            <img  src=".<?= $sanpham['hinh_sp']?>" alt="" >
                            <li>Chọn Ảnh <input type="file" name="hinh_sp" id="hinh_sp"  ></li>
                            <li><input type="submit" value="Sửa "name ="sua"></li>
                        </ul>
                </div>
            </div>
        </form>  
         <?php 
          
            if (isset($_POST['sua'])){
                
                $ten_sp=$_POST['ten_sp'];
                $soluong=$_POST['soluong'];
                $tentacgia=$_POST['tentacgia'];
                $gia=$_POST['gia'];
                $chitiet=$_POST['chitiet'];
                $theloai=$_POST['theloai'];
                $image = $_FILES["hinh_sp"];
                if($image["name"]!=NULL){
                    $image_name = $image["name"];
                    // Kiểm tra và di chuyển tệp tin vào thư mục lưu trữ (hoặc thực hiện các xử lý khác tùy ý)
                    $upload_dir = "./images/";
                    $image_path = $upload_dir . basename($image_name);
                }else{
                    $image_path = $sanpham['hinh_sp'];
                }
                       // Lưu đường dẫn vào cơ sở dữ liệu
                       
                       $sql_capnhat = "UPDATE `sanpham`
                       SET `ten_sp` = '".$ten_sp."',
                           `soluong` = '".$soluong."',
                           `hinh_sp` = '".$image_path."',
                           `tentacgia` = '".$tentacgia."',
                           `gia` = '".$gia."',
                           `chitiet` = '".$chitiet."',
                           `theloai` = '".$theloai."'
                       WHERE `id_sp` = '".$id_sp."'";
                     
                $result = mysqli_query($kn, $sql_capnhat);
                mysqli_close($kn);
            } 
            } else{
                echo "khong co thong tin sach";
            } 
            
        ?>
          
        
</body>
</html>