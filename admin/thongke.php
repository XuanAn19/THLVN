<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/thongke.css">
    <style>
    .search-container {
  position: relative;
  display: inline-block;
}

.search-container input[type="text"] {
  padding: 10px;
  padding-right: 20px;
  margin-top: 10px;
  border-radius: 5px;
}

.search-container button[type="submit"] {
  position: absolute;
  top: 0;
  right: 0;
  padding: 22px;
  background-color: transparent;
  border: none;
  cursor: pointer;
}

.search-container button[type="submit"] i {
  color: #555;
}
.underline {
  text-decoration: underline;
}
</style>

    <title>Date Range Picker Example</title>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Thống Kê</title>
    
</head>
<body>
                
		<?php include "header.php" ;
        $search = isset($_GET['name']) ? $_GET['name'] : "";
        if ($search) {
            $where = "WHERE `name` LIKE '%" . $search . "%'";
        }
        
         ?>

        <div class="content" >
            
            <div align="center"><h2 style="font-size:40px;">Thống Kê</h2></div>
            
            <label for="picker1">Từ ngày:</label>
<input type="date" id="picker1" name="picker1">

<label for="picker2">Đến ngày:</label>
<input type="date" id="picker2" name="picker2">

<br>
        
            <div class="search-container"  >
            <form id="product-search" method="GET">
        
            <label >Mã sản phẩm</label>
            <button type="submit"><i class="fas fa-search"></i></button>
		  <input type="text" value="<?=isset($_GET['name']) ? $_GET['name'] : ""?>" name="name" placeholder="search">
		  
		  </form>
</br>
    <script>
        document.getElementById("searchButton").addEventListener("click", function() {
            // Lấy giá trị từ ô nhập liệu
            var searchTerm = document.getElementById("searchInput").value;

            // Kiểm tra xem ô nhập liệu có dữ liệu hay không
            if (searchTerm.trim() !== '') {
                // Hiển thị thông báo với kết quả tìm kiếm
                alert("Đang tìm sản phẩm với từ khóa: " + searchTerm);
                // Có thể thêm mã JavaScript để xử lý tìm kiếm thực tế ở đây
            } else {
                // Hiển thị thông báo nếu ô nhập liệu trống
                alert("Vui lòng nhập từ khóa tìm kiếm!");
            }
        });
    </script>

            </div>

            <table class="customer-table" style="border: 4px solid #dddddd;">
                <thead>
                    <tr>
                        <th>Mã sách</th>   
                        <th>Tên sách</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>  
                    </tr>	
                </thead>
                <tbody>
                    <?php
                    
                        // Keết nối đến cơ sở dữ liệu và truy vấn dữ liệu ở đây
                        include '../connect_db.php';
						$sql = "SELECT id_sanpham,sanpham.ten_sp,chitiet_giohang.gia, SUM(chitiet_giohang.soluong) AS tong_soluong, SUM(chitiet_giohang.gia * chitiet_giohang.soluong) AS tong_giatien 
								FROM chitiet_giohang inner join giohang on chitiet_giohang.id_giohang = giohang.id_gh 
                                					INNER JOIN sanpham on chitiet_giohang.id_sanpham = sanpham.id_sp								
								WHERE 1 
								GROUP BY id_sanpham,sanpham.ten_sp";

                        $sqlsearch = "SELECT 
                        sanpham.id_sp,
                        sanpham.ten_sp,
                        chitiet_giohang.gia,
                        SUM(chitiet_giohang.soluong) AS tong_soluong,
                        SUM(chitiet_giohang.gia * chitiet_giohang.soluong) AS tong_giatien 
                        FROM 
                        chitiet_giohang 
                        INNER JOIN 
                        giohang ON chitiet_giohang.id_giohang = giohang.id_gh 
                        INNER JOIN 
                        sanpham ON chitiet_giohang.id_sanpham = sanpham.id_sp								
                        WHERE 
                        sanpham.id_sp = '".$search."'
                        GROUP BY 
                        sanpham.id_sp, sanpham.ten_sp, chitiet_giohang.gia";

						$result = mysqli_query($kn, $sql);
                        $resultsearch = mysqli_query($kn, $sqlsearch);

                        if ($search) {
                            $tong = 0;
                            if (mysqli_num_rows($resultsearch) > 0) {
                                while ($row = $resultsearch->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $row['id_sp'] ?></td>
                                        <td><?= $row['ten_sp'] ?></td>
                                        <td><?= $row['tong_soluong'] ?></td>
                                        <td><?= $row['gia'] ?></td>
                                        <td><?= $row['tong_giatien'] ?></td>
                                        <?php $tong = $tong + $row['tong_giatien']; ?>
                                    </tr>
                                <?php }
                            } else {
                                echo "Không tìm thấy sản phẩm này!";
                            }
                        } else {
                            $tong = 0;
                            while ($rows = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $rows['id_sanpham'] ?></td>
                                    <td><?= $rows['ten_sp'] ?></td>
                                    <td><?= $rows['tong_soluong'] ?></td>
                                    <td><?= $rows['gia'] ?></td>
                                    <td><?= $rows['tong_giatien'] ?></td>
                                    <?php $tong = $tong + $rows['tong_giatien']; ?>
                                </tr>
                        <?php }
                        }
                        ?>
                    
                        
					
				<thead>
					<th>Tổng tiền</th>
					<th></th> 		  
                    <th></th>
                    <th></th>
                    <th><?= $tong; ?></th>
				</thead>
                </tbody>
				<tbody>
					
				</tbody>
            </table>
        </div>
        
        
    </div>

</body>
</html>