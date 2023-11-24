<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/giaodien.css">
    <link rel="stylesheet" href="css/theloai.css">
	<title>BOOKSTORE</title>
    <style>
	
.products {
    padding: 0 80px;
}

.products-content {
    margin-top: 10px;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    grid-gap: 3rem 2rem;
    padding: 1rem;
    min-height: 400px;
}

.product {
    text-align: center;
    border: 2px solid rgb(123, 63, 63);
    border-radius: 20px;
}
#product-search{
            padding-bottom: 20px;
            float: left;
        }

.product__avatar {
    cursor: pointer;
}

.product>div+div {
    margin-top: 2%;
}

.product__avatar>img {
    width: 100%;
    object-fit: cover;
    border-radius:20px;
    object-position: center;
}
.product:hover img{
    transform: translate(0,-20px);
}
.product__name:hover{
    color:#81d512;
}
.product__avatar--back {
    display: none;
}

.product__avatar:hover .product__avatar--back {
    display: inline-block;
}

.product__avatar:hover .product__avatar--front {
    display: none;
}
.product__avatar--front, .product__avatar--back {
    width: 240px;
    height: 300px;
	border-radius:15px;
}

.product__name {
    font-weight: bold;
    overflow: hidden;
    text-overflow: ellipsis;
    padding:10px 0;
}

.product__price {
	font-weight:bold;
    white-space: nowrap;
    overflow: hidden;
    padding-bottom:10px;
}
.price{
	font-weight:bold;
}
.product__price>span+span {
    margin-left: 2%;
	font-weight:bold;
}
.buy-button{
    text-align: right;
    margin-top: 10px;
}
.buy-button a{
    background: #444;
    padding: 5px;
    color: #fff;
}
	</style>
</head>
<body>
    
        <?php include 'header.php';?>
        <?php include 'menu.php';?>
       
        
        
        <?php
                
                include './connect_db.php';
				$param = "";
				$sortParam = "";
				$orderConditon = "";
				//Tìm kiếm
				$search = isset($_GET['name']) ? $_GET['name'] : "";
				if ($search) {
					$where = "WHERE `name` LIKE '%" . $search . "%'";
					$param .= "name=".$search."&";
				}

                $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:10;
                $current_page = !empty($_GET['page'])?$_GET['page']:1; //Trang hiện tại
                $offset = ($current_page - 1) * $item_per_page;// sản phẩm bắt đầu từ offset trong database
				if ($search) {
					$products = mysqli_query($kn, "SELECT * FROM `sanpham` WHERE `ten_sp` LIKE '%" . $search . "%' ".$orderConditon."  LIMIT " . $item_per_page . " OFFSET " . $offset);
					$totalRecords = mysqli_query($kn, "SELECT * FROM `sanpham` WHERE `ten_sp` LIKE '%" . $search . "%'");
					$totalRecordsCount = $totalRecords->num_rows;
					if($totalRecordsCount > 0){?>
					<br>
					<h1 class="underline">Kết quả tìm kiếm</h1>
					<br>
						<?php
					}else{?>
						<h1 class="underline">Không tìm thấy kết quả nào</h1>
					<?php
					}
				}else{
                $products = mysqli_query($kn, "SELECT * FROM `sanpham` ORDER BY `id_sp` ASC  LIMIT " . $item_per_page . " OFFSET " . $offset);
                $totalRecords = mysqli_query($kn, "SELECT * FROM `sanpham`");//tổng số sản phẩm
				}
				$totalRecords = $totalRecords->num_rows;
                //ceil làm tròn
                $totalPages = ceil($totalRecords / $item_per_page);//tổng số trang
                mysqli_close($kn);
        ?>

        <section class="products">
            <div class="products-content">
                <?php                                   
                    while($row = mysqli_fetch_array($products)) { 
                        if($row['soluong']>0){
                ?>
                        <ul>
                            <div class="product">
                                <div class="product__avatar">
                                    <a href="chitietsanpham.php?id=<?=$row['id_sp'] ?>"><img src="<?=$row['hinh_sp'] ?>" title="<?= $row['ten_sp']?>" class="product__avatar--front"/></a>
                                    <a href="chitietsanpham.php?id=<?=$row['id_sp'] ?>"><img src="<?=$row['hinh_sp'] ?>" title="<?= $row['ten_sp']?>" class="product__avatar--back"/></a>
                                </div>
                                <div class="product__name"><a href="chitietsanpham.php?id=<?=$row['id_sp'] ?>"><?= $row['ten_sp']?></div>    
                                <div class="product__price">
                                    <span><a href="chitietsanpham.php?id=<?=$row['id_sp'] ?>">Giá: <?= number_format($row['gia'], 0, ",", ".") ?></a><span>đ</span></span>
                                </div>
                                    <p><a href="chitietsanpham.php?id=<?=$row['id_sp'] ?>"><?= $row['chitiet'] ?></p>
                                    <br>
                                        <div class="buy-button">
                                            <form id="add-to-cart-form" action="giohang.php?action=add" method="POST" >
                                                <input type="text" value="1" name="quantity[<?= $row['id_sp']?>]">
                                                <input type="submit" value="Mua sản phẩm" />
                                            </form>
                                        </div>
                            </div>  
                        </ul>
                <?php } else {
                    ?>
                        <ul>
                            <div class="product">
                                <div class="product__avatar">
                                    <a href="chitietsanpham.php?id=<?=$row['id_sp'] ?>"><img src="<?=$row['hinh_sp'] ?>" title="<?= $row['ten_sp']?>" class="product__avatar--front"/></a>
                                    <a href="chitietsanpham.php?id=<?=$row['id_sp'] ?>"><img src="<?=$row['hinh_sp'] ?>" title="<?= $row['ten_sp']?>" class="product__avatar--back"/></a>
                                </div>
                                <div class="product__name"><a href="http://localhost/bansach/THLVN/chitietsanpham.php?id=<?=$row['id_sp'] ?>"><?= $row['ten_sp']?></div>    
                                <div class="product__price">
                                    <span><a href="http://localhost/bansach/THLVN/chitietsanpham.php?id=<?=$row['id_sp'] ?>">Giá: <?= number_format($row['gia'], 0, ",", ".") ?></a><span>đ</span></span>
                                </div>
                                    <p><?= $row['chitiet'] ?></p>
                                    <br>
                                        <h4>Hết Hàng</h4>
                            </div>  
                        </ul>
                    <?php } 
                    }
                    ?>
        </div>
        
    </section>
                   
          <?php include 'phantrang.php'?>          
</body>
</html>