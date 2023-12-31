<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
<header>
	         <nav class="container">
                <div class="logo-main-menu">
                    <a href="" id="logo">
                        <img src="images/logoTHLVN.jpg" alt="BOOKSTORE" width="200px">
                    </a> 
                </div>
                <footer>
                    <div id ="top-bot">
                        <div><h1>Thông Tin Liên Hệ </h1></div>
                        <div id ="ngang">
                            <div>
                                <ul>
                                    <li id = "ngang"><img src="images/vtri.png"><span><h3><b>      170 An Dương Vương , TP.Quy Nhơn , Tỉnh Bình Định</b></h3></span></li>
                                    <li id = "ngang" ><img src ="images/homthu.jpg"><span><h3><b>   bookstore@gmail.com</b></h3></span></li>
                                    
                                </ul>
                            </div>
                            <div>
                                <ul>
                                    <li id = "ngang"><img src ="images/web.png"><span><h3><b> WWW.bookstore.com.vn</b></h3></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
            </footer>
                <div class="main-menu-right">
                    <ul id="main-menu-right2">
                        <li>
                            <div id="top-bot">
                                <a><img src = "images/tk.jpg" width = "150" ></a>
                                <a href="#">    Tài Khoản </a>
                            </div>
                        </li>
                        <li>
                            <div id="top-bot">
                                <a><img src = "images/R.png" width = "100" ></a>
                            <a href="http://localhost/bansach/THLVN/giohang.php">Giỏ Hàng </a>
                            </div>
                        </li>
                    </ul>
                </div>
             </nav>
        </header>
        <div>
        <div>
    <ul id="main-menu">
        <li ><a href="TrangChu.php" class="active"> TRANG CHỦ</a></li>
        <li><a href=""> GIỚI THIỆU</a></li>
        <li><a href=""> THỂ LOẠI SÁCH</a>
        <ul class="sub-menu" style="text-indent: 0; margin-left: 0;">
                                <!-- Lặp qua các danh mục và hiển thị chúng trong menu -->
                                <?php
                                include 'connect_db.php';
                                $categoriesQuery = mysqli_query($kn, "SELECT * FROM `theloai`");

                                while ($loctheloai = mysqli_fetch_assoc($categoriesQuery)) {
                                    echo '<li><a href="loctheloai.php?id_theloai=' . $loctheloai['id_theloai'] . '">' . $loctheloai['ten'] . '</a></li>';
                                }
                                ?>
                            </ul>
        </li>
        <li><a href="giaodienmenu.php"> LIÊN HỆ</a></li>
		<li><div class="search-container">
			<form id="product-search" method="GET">
		  <input type="text" value="<?=isset($_GET['name']) ? $_GET['name'] : ""?>" name="name" placeholder="Tìm kiếm...">
		  <button type="submit"><i class="fa fa-search"></i></button>
		  </form>
		</div></li>
       
    </ul>
</div>
</div>
