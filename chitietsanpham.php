<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 

	session_start();
	require_once "./connect_db.php";
	include "header.php"
	// if(empty($_SESSION['username'])){
		// header("location: http://localhost/bansach/THLVN/dangnhap.php");
		// exit;
	// }
?>
<html>
    <head>
        <title>BOOKSTORE</title>
        <meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/style_detail.css">
		<link rel="stylesheet" href="css/giaodien.css">
		<link rel="stylesheet" href="css/theloai.css">
        <link rel="stylesheet" href="css/TL.css">

       


    </head>
    <body>
        <?php
		
        $result = mysqli_query($kn, "SELECT * FROM `sanpham` WHERE `id_sp` = ".$_GET['id']);//.$_GET['id']
        $product = mysqli_fetch_assoc($result);
        if($product['soluong']>0){
        ?>
        <div class="container">
            <h2>Chi tiết sản phẩm</h2>
            <div id="product-detail">
                <div id="product-img">
                    <img src=".<?=$product['hinh_sp']?>" />
                </div>
                <div id="product-info">
                    <h1><?=$product['ten_sp']?></h1>
                    <label>Tên tác giả: </label><span class="product-price"><?=$product['tentacgia']?></span><br/>
					<label>Giá: </label><span class="product-price"><?= number_format($product['gia'], 0, ",", ".") ?> VND</span><br/>
					<label>Thể loại: </label><span class="product-price"><?=$product['theloai']?></span><br/>
                    <form id="add-to-cart-form" action="giohang.php?action=add" method="POST">
    <div class="quantity-container">
        <!-- Nút giảm số lượng -->
        <button type="button" class="quantity-button" onclick="decreaseQuantity()">-</button>

        <!-- Ô nhập số lượng -->
        <input type="number" value="1" name="quantity[<?= $product['id_sp'] ?>]" min="1" class="quantity-input" />

        <!-- Nút tăng số lượng -->
        <button type="button" class="quantity-button" onclick="increaseQuantity()">+</button>
    </div>

    <!-- Nút "Thêm vào giỏ hàng" -->
    <button type="submit" name="add-to-cart">Mua Ngay</button>

    <!-- Nút "Mua ngay" -->
    <button type="button" onclick="buyNow()">Thêm vào giỏ h</button>
</form>

<script>
    function increaseQuantity() {
        var quantityInput = document.querySelector('input[name="quantity[<?= $product['id_sp'] ?>]"]');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    }

    function decreaseQuantity() {
        var quantityInput = document.querySelector('input[name="quantity[<?= $product['id_sp'] ?>]"]');
        var newValue = parseInt(quantityInput.value) - 1;
        quantityInput.value = newValue < 1 ? 1 : newValue;
    }

    function buyNow() {
        
        alert('Sản phẩm đã được thêm vào giỏ hàng!');
    }
</script>
                    <?php if(!empty($product['hinh_sp'])){ ?>
                    <?php } ?>
                </div>
                <div class="clear-both"></div>
                <?=$product['chitiet']?>
            </div>
        </div>
		<?php }else{ ?>
		<div class="container">
            <h2>Chi tiết sản phẩm</h2>
            <div id="product-detail">
                <div id="product-img" >
                    <img src="<?=$product['hinh_sp']?>" />
                </div>
                <div id="product-info">
                    <h1><?=$product['ten_sp']?></h1>
                    <label>Giá: </label><span class="product-price"><?= number_format($product['gia'], 0, ",", ".") ?> VND</span><br/>
                    <p><h2>Hết hàng</h2></p>
                   
                </div>
                <div class="clear-both"></div>
                <?=$product['chitiet']?>
            </div>
			
            </div>
<?php } ?>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include theloai.js after jQuery -->
<script src="path/to/theloai.js"></script>

</body>
</html>