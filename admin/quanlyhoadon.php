
<?php
	include 'header.php';
	$config_name = "order";
	$config_title = "hóa đơn";
	if (!empty($_SESSION['username'])) {
	//Lọc sản phẩm
    /*if(!empty($_GET['action']) && $_GET['action'] == 'search' && !empty($_POST)){
        $_SESSION[$config_name.'_filter'] = $_POST;
        header('Location: '.$config_name.'_listing.php');exit;
    }
    if(!empty($_SESSION[$config_name.'filter'])){
        $where = "";
        foreach ($_SESSION[$config_name.'filter'] as $field => $value) {
            if(!empty($value)){
                switch ($field) {
                    case 'name':
                    $where .= (!empty($where))? " AND "."`".$field."` LIKE '%".$value."%'" : "`".$field."` LIKE '%".$value."%'";
                    break;
                    default:
                    $where .= (!empty($where))? " AND "."`".$field."` = ".$value."": "`".$field."` = ".$value."";
                    break;
                }
            }
        }
        extract($_SESSION[$config_name.'filter']);
    }*/
    $item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 10;
    $current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $item_per_page;
    if(!empty($where)){
        $totalRecords = mysqli_query($kn, "SELECT * FROM `giohang` where (".$where.")");
    }else{
        $totalRecords = mysqli_query($kn, "SELECT * FROM `giohang`");
    }
    $totalRecords = $totalRecords->num_rows;
    $totalPages = ceil($totalRecords / $item_per_page);
    if(!empty($where)){
        $giohang = mysqli_query($kn, "SELECT * FROM `giohang` where (".$where.") ORDER BY `id_gh` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
    }else{
        $giohang = mysqli_query($kn, "SELECT * FROM `giohang` ORDER BY `id_gh` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
    }
    mysqli_close($kn);
    ?>
	
    <!--<div class="main-content">
        <h1>Danh sách <?=$config_title?></h1>
        <div class="listing-items">
            <div class="buttons">
               <a href="./<?=$config_name?>_editing.php">Thêm <?=$config_title?></a>
            </div>
            <div class="listing-search">
                <form id="<?=$config_name?>-search-form" action="<?=$config_name?>_listing.php?action=search" method="POST">
                    <fieldset>
                        <legend>Tìm kiếm <?=$config_title?>:</legend>
                        ID: <input type="text" name="id" value="<?=!empty($id)?$id:""?>" />
                        Tên <?=$config_title?>: <input type="text" name="name" value="<?=!empty($name)?$name:""?>" />
                        <input type="submit" value="Tìm" />
                    </fieldset>
                </form>
            </div>-->
            
            
         <div class="content" >
            <div align="center"><h2>Quản lý thông tin hóa đơn</h2></div>
            <table class="customer-table">
                <thead>
                <tr>
                    <th>ID</th>
					<th>Tên người nhận</th>
					<th>Địa chỉ</th>
					<th>Điện thoại</th>
					<th>Tổng tiền</th>
					<th>Hành động</th>
                </tr>
				</thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_array($giohang)) {
                    ?>
					<tr>
						<td><?=$row['id_gh'] ?></td>
						<td><?=$row['tennguoidat'] ?></td>
						<td><?=$row['diachi'] ?></td>
						<td><?=$row['sodienthoai'] ?></td>
						<td><?=$row['tongtien'] ?></td>
						<td><a href="inGoiHang.php?id=<?=$row['id_gh']?>" target="_blank">In</a></td>
					</tr>
                <?php } ?>
            </ul>
			</tbody>
			</table>
		
	
	
     </div>
<?php	 
}
?>