<!doctype html>
<?php session_start(); ?>
<?php
	include "connect_db.php";
	if (!isset($_SESSION['username'])) {
			header("location: http://localhost/bansach/THLVN/dangnhap.php");
			exit;
	}
 ?>
<html lang="vn">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="css/dangnhap.css">
</head>
<?php
					include './connect_db.php';
					$user =$_SESSION['username']; 
                    if(isset($_POST['dn']))
                    {

                    $tentk = $_POST['tk'];
                    $mkcu = $_POST['mkcu'];
                    $mkmoi = $_POST['mkmoi'];
                    $remkmoi = $_POST['remkmoi'];
                    //$kn = mysqli_connect("localhost","root","","dbkhachhang") or die("tài khoản hoặc mật khẩu của bạn sai");
                    $sql = "SELECT * FROM taikhoan WHERE tendangnhap = ? AND matkhau = ?";
                    $stmt = mysqli_prepare($kn, $sql);
                    mysqli_stmt_bind_param($stmt, "ss", $tentk, $mkcu);
                    mysqli_stmt_execute($stmt);
                    
                    $kq = mysqli_stmt_get_result($stmt);
                    
                    if (!$kq) {
                        die('Lỗi truy vấn: ' . mysqli_error($kn));
                    }else{
                        if($row = (mysqli_fetch_assoc($kq))){
                           
                            if( $tentk == $row['tendangnhap'])
                            {
                                if($mkcu == $row['matkhau'])
                                {
                                    if($mkmoi == $remkmoi)
                                    {
                                        $sql2 = "UPDATE taikhoan SET matkhau = ? WHERE tendangnhap = ?";
                                        $stmt2 = mysqli_prepare($kn, $sql2);
                                        mysqli_stmt_bind_param($stmt2, "ss", $remkmoi, $tentk);
                                        mysqli_stmt_execute($stmt2);
                                        $kq2 = mysqli_stmt_affected_rows($stmt2);
                                        
                                        echo "<script> alert('doi thanh cong')  </script>";
                                    }
                                    else{
                                         echo "<script> alert('mat khau khong khop')  </script>";
									}
                                }
                                else{
                                     echo "<script> alert('ban nhap sai mat khau')  </script>";
								}
                            }
                            

                    }
                    else{
                          echo "<script> alert('khong tim thay ten tai khoan')  </script>";
                   
                          mysqli_close($kn);
                    }
					}
					}
   ?>
<body>
    <div class="container">
        <h2>Đăng ký tài khoản</h2>
  <form action = "<?php echo ($_SERVER['PHP_SELF']);?>" method="POST">
		<input type="text" placeholder="Tên đăng nhập" value="<?= $user ?>" name="tk" >
        <input type="password" placeholder="Mật khẩu" name="mkcu" required oninvalid="this.setCustomValidity('Thông tin bắt buộc')">
		<input type="password" placeholder="Nhập mật khẩu mới" name="mkmoi" >
		<input type="password" placeholder="Nhập lại mật khẩu mới" name="remkmoi" >
    <button type="submit" name ="dn" class="btn btn-primary">Đổi mật khẩu</button>
  </form>
  <script src="script.js"></script>
       </div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>




