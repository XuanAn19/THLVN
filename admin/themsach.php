<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/them.css">
    <title>Thêm Sách</title>
</head>
<body>
    <?php
    include '../connect_db.php';
    ?>
    <a href="http://localhost/bansach/THLVN/admin/quanlysach.php" class="back-to-menu">quay lại menu quản lí</a>
        <form action="<?php echo ($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">
        <div class ="form-container">
                <div class="form-left">
                    <ul>
                        <li>Mã Sách <input type="text"name="id_sp" > </li>
                        <li>Tên Sách<input type="text" name ="ten_sp" required oninvalid="this.setCustomValidity('Vui lòng nhập Tên Sách')"> </li>
                        <li>Tên Tác Giả<input type="text" name ="tentacgia" required oninvalid="this.setCustomValidity('Vui lòng nhập Tên Tác Giả')"> </li>
                        <li>Giá Tiền<input type="text" name ="gia" required oninvalid="this.setCustomValidity('Vui lòng nhập Giá Tiền')"> </li>
                        <li> Số Lượng<input type="text" name ="soluong" required oninvalid="this.setCustomValidity('Vui lòng nhập Số Lượng')"></li> 
                    </ul>  
                </div>
                <div class="form-right">
                    
                        <ul>
                            
                        <label>Thể Loại</label>
                            <li> 
                                <select name="theloai"  >
                                    <?php
                                        include './connect_db.php';
                                        $query = "SELECT * FROM theloai";
                                        $theloai = mysqli_query($kn, $query);
                                        while ($row = mysqli_fetch_assoc($theloai)) {
                                        $categoryId = $row['id_theloai'];
                                        $categoryName = $row['ten'];
                                        echo "<option value='$categoryId'>$categoryName</option>";
                                        }

                                        // Đóng kết nối cơ sở dữ liệu
                                        mysqli_close($kn);
                                    ?>
                                </select>
                                
                            </li> 
                             <li>Giới thiệu sách<textarea name="chitiet" id="" cols="30" rows="10" required oninvalid="this.setCustomValidity('Vui lòng nhập Giới Thiệu Sách')"></textarea> </li>
                            <li>Chọn Ảnh <input type="file" name="hinh_sp" id="hinh_sp" required oninvalid="this.setCustomValidity('Vui lòng Chọn hình ảnh sách')"></li>
                            <li><input type="submit" value="Thêm "name ="them"></li>
                        </ul>
                </div>
            </div>
        </form>        
        <?php
        include '../connect_db.php'; 
            if (isset($_POST['them'])){
                $ten_sp=$_POST['ten_sp'];
                $soluong=$_POST['soluong'];
                $tentacgia=$_POST['tentacgia'];
                $gia=$_POST['gia'];
                $chitiet=$_POST['chitiet'];                
                $theloai=$_POST['theloai'];
                    $image = $_FILES["hinh_sp"];
             
                    $image_name = $image["name"];
                    // Kiểm tra và di chuyển tệp tin vào thư mục lưu trữ (hoặc thực hiện các xử lý khác tùy ý)
                    $upload_dir = "./images/";
                    $image_path = $upload_dir . basename($image_name);
                       // Lưu đường dẫn vào cơ sở dữ liệu
                       $sql_them = "INSERT INTO `sanpham` (`ten_sp`, `soluong`, `hinh_sp`, `tentacgia`, `gia`, `chitiet`, `theloai`)
              VALUES ('".$ten_sp."', '".$soluong."', '".$image_path."', '".$tentacgia."', '".$gia."', '".$chitiet."', '".$theloai."')";
                    $result = mysqli_query($kn, $sql_them);
          var_dump($sql_them);
   
          var_dump($result);
          
            }   
        ?>
</body>
</html>