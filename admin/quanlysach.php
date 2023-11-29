<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style-quanlyTK.css">
    <title>Quản Lý Thông Tin Sách</title>
</head>
<body>
		<?php include "header.php" ; 
           
		if (!empty($_SESSION['username'])) {?>
		
        <div class="content" >
            <div align="center">
                <h2>Quản lý sách</h2> 
                
                        <script>
                                function redirectToThemSach() {
                                     window.location.href = "http://localhost/bansach/THLVN/admin/themsach.php";
                                }
                        </script>
           <style>
        .content1 {
            text-align: center;
        }

        .add-button {
            margin-top: 30px; 
            margin-right: 10px;
            margin-bottom: 5px;
            float: right;
            width: 150px; 
            height: 40px; 
        }
    </style>
            </div>
            <div class= "content1">
            <button onclick="redirectToThemSach()" class="add-button">Thêm</button>
            </div>
            
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>Mã Sách</th>
                        <th>Tên Sách </th>
                        <th>Tên Tác Giả </th>
                        <th>Số Lượng </th>
                        <th>Giá</th>
                        <th>Thể Loại </th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Keết nối đến cơ sở dữ liệu và truy vấn dữ liệu ở đây
                        include '../connect_db.php';
                        $result = mysqli_query($kn, "SELECT * FROM `sanpham` WHERE 1");
                        
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                            <td> <?= $row['id_sp']?> </td>
                            <td> <?= $row['ten_sp'] ?></td>
                            <td> <?= $row['tentacgia']?> </td>
                            <td><?= $row['soluong'] ?></td>
                            <td> <?= $row['gia']?> </td>
                            <td> <?= $row['theloai']?> </td>
                            <form action="<?php echo ($_SERVER['PHP_SELF']);?>" method="post">
                                <td><button name="xoa" value="<?= $row['id_sp']?>">Xóa</button></td>
                                <td><a href="http://localhost/bansach/THLVN/admin/suasach.php?id=<?= $row['id_sp']?>" >Sửa</a></td>
                            </form>
                            </tr>
                    <?php }?>
                </tbody>
                <?php
                if (isset($_POST['xoa'])) {
                    $id_sp = $_POST['xoa'];
                
                    // Thực hiện câu lệnh DELETE
                    $sql_xoa = "DELETE FROM sanpham WHERE id_sp = $id_sp";
                    $result = mysqli_query($kn, $sql_xoa);
                    if ($result) {
                        echo "
                        <script>
                        
                        window.history.back();
                        </script>
                        ";
                    }
                }
        }else{
            echo "khong thanh cong";
        }
?>
            </table>
        </div>
        
    </div>

</body>
</html>