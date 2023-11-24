<?php
include '../THLVN/connect_db.php'; 


$categoriesQuery = mysqli_query($kn, "SELECT * FROM `theloai`");

// Kiểm tra xem có danh mục nào không
if (mysqli_num_rows($categoriesQuery) > 0) {
    echo '<ul id="main-menu">';
    echo '<li><a href="TrangChu.php" class="active">TRANG CHỦ</a></li>';
    echo '<li><a href="">GIỚI THIỆU</a></li>';
    echo '<li><a href="">THỂ LOẠI SÁCH</a>';
    echo '<ul class="sub-menu" style="text-indent: 0; margin-left: 0;">';

    // Lặp qua các danh mục và hiển thị chúng trong menu
    while ($loctheloai = mysqli_fetch_assoc($categoriesQuery)) {
        echo '<li><a href="loctheloai.php?id_theloai=' . $loctheloai['id_theloai'] . '">' . $loctheloai['ten'] . '</a></li>';
    }

    echo '</ul>';
    echo '</li>';
    echo '<li><a href="">HỖ TRỢ</a></li>';
    echo '<li>
            <div class="search-container">
                <form id="product-search" method="GET">
                    <input type="text" value="' . (isset($_GET['name']) ? $_GET['name'] : '') . '" name="name" placeholder="Tìm kiếm...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </li>';
    echo '</ul>';
}

// Đóng kết nối cơ sở dữ liệu
mysqli_close($kn);
?>