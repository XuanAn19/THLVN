<?php
	session_start();
	// Kết nối cơ sở dữ liệu (kn là biến kết nối đã được khởi tạo trước đó)
	include "connect_db.php";
	if (!isset($_SESSION['username'])) {
			header("location: http://localhost/bansach/THLVN/dangnhap.php");
			exit;
		}else{
		// Lấy tên người dùng từ session
		$user = $_SESSION['username'];
		// Truy vấn để lấy thông tin giỏ hàng từ giohangtemp
		$sql = "SELECT giohangtemp.*, sanpham.ten_sp AS ten_sp 
				FROM giohangtemp 
				INNER JOIN sanpham ON giohangtemp.id_sanpham = id_sp 
				WHERE giohangtemp.name = '$user'";
		$result = mysqli_query($kn, $sql);
		//var_dump($result);
		// Kiểm tra kết quả truy vấn
		if ($result && mysqli_num_rows($result) > 0) {
			// Tạo một mảng để lưu trữ thông tin giỏ hàng
			$cart = array();

			// Lặp qua các mục trong giỏ hàng
			while ($row = mysqli_fetch_assoc($result)) {
				$product_id = $row['id_sanpham'];
				$quantity = $row['soluong'];

				// Lưu thông tin sản phẩm vào giỏ hàng
				$cart[$product_id] = $quantity;
			}

			// Lưu giỏ hàng vào session
			$_SESSION['giohang'] = $cart;
		}
	}
	// Kiểm tra nếu giỏ hàng tồn tại trong session
	if (!empty($_SESSION['giohang'])) {
		// Lấy danh sách sản phẩm từ giỏ hàng
		$product_ids = array_keys($_SESSION['giohang']);
		$product_ids_string = implode(",", $product_ids);

		// Truy vấn để lấy thông tin sản phẩm từ CSDL (product là bảng chứa thông tin sản phẩm)
		$sql = "SELECT * FROM sanpham WHERE id_sp IN ($product_ids_string)";
		$result = mysqli_query($kn, $sql);
		$sql_delete = "DELETE FROM giohangtemp WHERE name = '".$user."'";
		$delete = mysqli_query($kn, $sql_delete);
		mysqli_close($kn);
		// Kiểm tra kết quả truy vấn
		if ($result && mysqli_num_rows($result) > 0) {
			// Lặp qua các sản phẩm trong giỏ hàng
			
			while ($row = mysqli_fetch_assoc($result)) {
				$product_id = $row['id_sp'];
				$product_name = $row['ten_sp'];
				$quantity = $_SESSION['giohang'][$product_id];
				$price = $row['gia'];

				//Hiển thị thông tin giỏ hàng
				// echo "Product ID: $product_id<br>";
				// echo "Product Name: $product_name<br>";
				// echo "Quantity: $quantity<br>";
				// echo "Price: $price<br>";
				// echo "<br>";
			}
			
		}
	} 

?>
<html>
    <head>
            <title>Giỏ hàng</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
			<link rel="stylesheet" href="css/giohang.css">
            
    </head>
<body>
<?php
	$error= false;
		$success =false;
		include 'connect_db.php';
		if(!isset($_SESSION["giohang"])){
			$_SESSION["giohang"]=array();
		}else{
		if(isset($_GET['action'])){
			function update_cart($add = false){
			// Key = id; value = quantity
				foreach ($_POST['quantity'] as $id => $quantity) {
					if ($quantity == 0) {
						unset($_SESSION["giohang"][$id]);
					} else {
						if ($add) {
							// Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
							if (isset($_SESSION["giohang"][$id])) {
								// Nếu đã tồn tại, tăng số lượng lên
								$_SESSION["giohang"][$id] += $quantity;
							} else {
								// Nếu chưa tồn tại, thêm sản phẩm vào giỏ hàng với số lượng mới
								$_SESSION["giohang"][$id] = $quantity;
							}
						} else {
							$_SESSION["giohang"][$id] = $quantity;
						}
					}
				}
			}
		
			switch($_GET['action']){
				case "add":
				update_cart(true);	
				header("Location: ./giohang.php");				
				break;
				
				case "delete":
					if(isset($_GET['id'])){
						unset($_SESSION["giohang"][$_GET['id']]);
					}
					header("Location: ./giohang.php");
				break;
				case "submit":
					if(isset($_POST['update_click'])){//Cập nhật số lượng
						update_cart();
						header("Location: ./giohang.php");
					}elseif($_POST['order_click']){//Đặt hàng
						if(empty($_POST['name'])){
							$error="Bạn chưa nhập tên người nhận";
						}elseif(empty($_POST['phone'])){
							$error="Bạn chưa nhập số điện thoại người nhận";
						}elseif(empty($_POST['address'])){
							$error="Bạn chưa nhập địa chỉ người nhận";
						}elseif(empty($_POST['address'])){
							$error="Giỏ hàng khong có gì";
						}
						if($error==false &&!empty($_POST['quantity'])){//Xử lý lưu vào giỏ hàng
							$product = mysqli_query($kn, "SELECT * FROM `sanpham` WHERE `id_sp` IN (" . implode(",", array_keys($_POST['quantity'])) . ")");
							//lấy ra
							$total =0; 
							//tạo mảng mới để lưu giỏ hàng
							$ordersProduct = array();
							while($row= mysqli_fetch_array($product)){
								$ordersProduct[] = $row;//lưu vào cho khỏi mất
								$total += $row['gia']*$_POST['quantity'][$row['id_sp']];								
							}
							$kq=true;
							foreach ($ordersProduct as $key => $product) {                              
								if(($_POST['quantity'][$product['id_sp']])>$product['soluong']){
									$error="Sản phẩm ".$product['ten_sp']." không đủ ";
									$kq=false;								
								}
							}						
							if($kq){
							$insertOrder = mysqli_query($kn, "INSERT INTO giohang (`id_gh`, `tennguoidat`, `sodienthoai`, `diachi`, `ghichu`, `tongtien`) VALUES  ('NULL','".$_POST['name']."','".$_POST['phone']."','".$_POST['address']."','".$_POST['note']."','".$total."')");
							$orderID = $kn->insert_id;
                            $insertString = "";
                            foreach ($ordersProduct as $key => $product) {                                								
									$insertString .= "(NULL, '" . $orderID . "', '" . $product['id_sp'] . "', '" . $_POST['quantity'][$product['id_sp']] . "', '" . $product['gia'] . "')";
									if ($key != count($ordersProduct) - 1) {
                                    $insertString .= ",";
									}
									$new_quantity = $product['soluong'] - $_POST['quantity'][$product['id_sp']];
									$updateProduct = mysqli_query($kn, "UPDATE `sanpham` SET `soluong`='$new_quantity' WHERE `id_sp`='".$product['id_sp']."'");
									if (!$updateProduct) {
										$error = "Cập nhật số lượng sản phẩm thất bại";
									}								
                            }
var_dump($insertOrder);						
							$insertOrder_detail = mysqli_query($kn, "INSERT INTO `chitiet_giohang`(`id`, `id_giohang`, `id_sanpham`, `soluong`, `gia`) VALUES  " . $insertString . ";");
							$success = "Đặt hàng thành công";
							
							$user = $_SESSION['username'];
							$sql_delete = "DELETE FROM giohangtemp WHERE name = '$user'";
							$kn->query($sql_delete);
							unset($_SESSION['giohang']);
							
							}
						}
					}
				break;
			}
		}
		}
		if(!empty($_SESSION["giohang"])){
			$product = mysqli_query($kn, "SELECT * FROM `sanpham` WHERE `id_sp` IN (".implode(",", array_keys($_SESSION["giohang"])).")");
		}
        ?>
	<div id="wrapper">
		<header>
	         <nav class="container">
                <div class="logo-main-menu">
                <a href="" id="logo">
                    <img src="images/logo.jpg" alt="BOOKSTORE" width="200px">
                </a>
                
                </div>
                <div class="main-menu-right">
                    <ul id="main-menu-right2">
					
                    <li><a href="http://localhost/bansach/THLVN/doimatkhau.php"><button type="button" class="btn btn-outline-warning">Đổi mật khẩu</button></a></li>
					<li><a href="http://localhost/bansach/THLVN/dangxuat.php"><button type="button" class="btn btn-outline-danger">Đăng Xuất</button></a></li>
                </ul>
                </div>
             </nav>
			 </header>
			<?php if(!empty($error)){ ?>
			<?php echo "<script>
					alert('$error');
					window.history.back();
					</script>";?>
			<?php }elseif(!empty($success)){?>
			<?php echo "<script>
					alert('$success');
					</script>";?>
					<a href ="http://localhost/bansach/THLVN/TrangChu.php">Tiếp tục mua hàng</a>
			<?php }else{ ?>
				<a href ="http://localhost/bansach/THLVN/TrangChu.php" class="product-tc">Quay Lại</a>
            <h1>Giỏ hàng</h1>
			<form id="cart-form" action="giohang.php?action=submit" method="POST">
            <table>
				<tr>
					<th class ="product-number">STT</th>
					<th class ="product-name">Tên Sản Phẩm</th>
					<th class ="product-img">Ảnh sản phẩm</th>
					<th class ="product-price">Đơn giá</th>
					<th class ="product-quantity">Số lượng</th>
					<th class ="total-money">Thành tiền</th>
					<th class ="product-delete">Xóa</th>
				</tr>
				<?php 
				if(!empty($product)){
					var_dump($product);
						$stt=1;
						$total=0;
					while($row =mysqli_fetch_array($product)){ ?>
					<tr>
						<td class ="product-number"><?= $stt; ?></td>
						<td class ="product-name"><?= $row['ten_sp'] ?></td>
						<td class ="product-img"><img src="admin1/<?= $row['hinh_sp'] ?>"/></td>
						<td class ="product-price"><?= number_format($row['gia'], 0, ",", ".") ?></td>
						<td class ="product-quantity"><input type="text" value="<?= number_format($_SESSION["giohang"][$row['id_sp']], 0, ",", ".") ?>" name="quantity[<?= $row['id_sp'] ?>]" /></td>
						<td class ="total-money"><?= number_format($row['gia']*$_SESSION["giohang"][$row['id_sp']], 0, ",", ".") ?></td>
						<td class ="product-delete"><a href="giohang.php?action=delete&id=<?=$row['id_sp'] ?>">Xóa</td>
					</tr>
						<?php 
						$total +=$row['gia']*$_SESSION["giohang"][$row['id_sp']];
						$stt++;
						}?>
						<tr id="row-total">
							<td class ="product-number">&nbsp;</td>
							<td class ="product-name">Tổng tiền</td>
							<td class ="product-img">&nbsp;</td>
							<td class ="product-price">&nbsp;</td>
							<td class ="product-quantity">&nbsp;</td>
							<td class ="total-money"><?= number_format($total, 0, ",", ".") ?></td>
							<td class ="product-delete"></td>
						</tr>
				<?php } ?>				
				</table>
			<div id="form-button">
					<input type="submit" name="update_click" value="Cập nhật">
				</div>
			<table>
			<div class="label_list">
			<!--<div><label class="name">Tài khoản đặt: </label><?php echo $_SESSION['username']; ?></div>-->
			<div class="input-group mb-3">
			  <span class="input-group-text" id="basic-addon1">Người nhận</span>
			  <input type="text" name="name" class="form-control" placeholder="Nhập tên người nhận hàng">
			</div>
			<div class="input-group mb-3">
			  <span class="input-group-text" id="basic-addon1">Điện thoại    </span>
			  <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại người nhận hàng">
			</div>
			<div class="input-group mb-3">
			  <span class="input-group-text" id="basic-addon1">Địachỉnhận</span>
			  <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ nhận hàng">
			</div>
			<div class="input-group">
			  <span class="input-group-text">Ghi chú a:</span>
			  <textarea class="form-control" name="note" aria-label="With textarea" placeholder="Nhập ghi chú đơn hàng..."></textarea>
			</div>
			<input type="submit" name="order_click" class="btn btn-outline-success" value ="Đặt hàng">
			</form>
			</div>
			<div class="label_list_item">
				<img src="images/logo.jpg" alt="">
				<h3>BOOKSTORE</h3>
			</div>
			</table>
			<?php } ?>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script></body>
</html>
