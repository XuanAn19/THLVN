
<style>
    .book {
    border: 1px solid #ddd;
    padding: 10px;
    margin: 10px;
    text-align: center;
}

.book img {
    max-width: 100%;
    height: auto;
}

.book h3 {
    margin-top: 10px; /* Khoảng cách giữa hình ảnh và tiêu đề */
}

.book p {
    margin-top: 5px; /* Khoảng cách giữa tiêu đề và nội dung */
}

</style>


<?php
include '../THLVN/connect_db.php'; // Đường dẫn tới file kết nối cơ sở dữ liệu

// Kiểm tra nếu có tham số truyền vào (id_theloai)
if (isset($_GET['id_theloai'])) {
    $category_id = $_GET['id_theloai'];

    // Truy vấn để lấy thông tin về thể loại
    $categoryQuery = mysqli_query($kn, "SELECT * FROM `theloai` WHERE `id_theloai` = $category_id");

    // Kiểm tra xem thể loại có tồn tại không
    if (mysqli_num_rows($categoryQuery) > 0) {
        $category = mysqli_fetch_assoc($categoryQuery);
        $category_name = $category['ten'];

        // Truy vấn sách theo thể loại
        $booksQuery = mysqli_query($kn, "SELECT * FROM `sanpham` WHERE `theloai` = $category_id");

        // Kiểm tra xem có sách trong thể loại không
        if (mysqli_num_rows($booksQuery) > 0) {
            // Thêm tiêu đề "Thể loại> 'tên thể loại'"
            echo "<h1>Thể loại> " . $category_name . "</h1>";

            while ($book = mysqli_fetch_assoc($booksQuery)) {
                echo '<div class="book">';
                echo '<img src="' . $book['hinh_sp'] . '" alt="' . $book['ten_sp'] . '">';
                echo '<h3>' . $book['ten_sp'] . '</h3>';
                echo '<p>' . $book['chitiet'] . '</p>';
                echo '<p>Giá: ' . number_format($book['gia'], 0, ",", ".") . 'đ</p>';
                // Các thông tin khác về sách có thể thêm vào ở đây
                echo '</div>';
            }
        } else {
            echo "Danh mục sách chưa được cập nhật.";
        }
    } else {
        echo "Thể loại không tồn tại.";
    }
}

// Đóng kết nối cơ sở dữ liệu
mysqli_close($kn);
?>