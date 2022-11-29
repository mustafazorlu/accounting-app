<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlham Oto Elektrik</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="image/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <div class="container">
        <div class="topbar flex flex-ai-c flex-jc-sb">
            <div class="left-side flex flex-ai-c">
                <div class="logo-box"><a href="pagination.php?page=bos" style="color:#343a40">İlham Oto Elektrik</a></div>
                <!-- <div class="hamburger-menu"><ion-icon name="menu-outline"></ion-icon></div>
                <div class="search-box">
                    <input type="text" name="search" id="search" placeholder="Bir şeyler arayın">
                    <a class="search-btn"><ion-icon name="search-outline"></ion-icon></a>
                </div> -->
                
            </div>
            <div class="time flex flex-ai-c" style="font-size:16px; color:#343a40;"><i name="time-outline" class="fa-solid fa-calendar-days" style="font-size:20px; margin-right:6px; margin-top:2px"></i><?php echo date('d/m/Y'); ?></div>
            <div class="right-side">
                <div class="user-box flex flex-ai-c">
                    <div class="user-image">
                        <img src="image/user-solid.png" alt="">
                    </div>
                    <div class="user-information flex flex-fdir-c">
                        <span class="user-name"><?php echo $_SESSION['isim'] ?></span>
                        <a href="logout.php" class="logout">Çıkış</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="navigation">
            <h5>Ana Sayfa</h5>
            <ul>
                <li>
                    <a href="pagination.php" class="flex flex-ai-c"><i class="fa-solid fa-house"></i><span>Ana Sayfa</span></a>
                </li>
            </ul>

            <h5>İşlemler</h5>
            <ul>
                <li>
                    <a href="pagination.php?page=sell" class="flex flex-ai-c"><i class="fa-solid fa-money-bill"></i><span>Satış</span></a>
                </li>
                <li>
                    <a href="pagination.php?page=storage" class="flex flex-ai-c"><i class="fa-solid fa-box"></i><span>Stok</span></a>
                </li>
                <li>
                    <a href="pagination.php?page=user" class="flex flex-ai-c"><i class="fa-solid fa-user-group"></i><span>Müşteri</span></a>
                </li>
                <li>
                    <a href="pagination.php?page=wholesaler" class="flex flex-ai-c"><i class="fa-solid fa-user-large"></i><span>Toptancılar</span></a>
                </li>
            </ul>

            <h5>Garanti</h5>
            <ul>
                <li>
                    <a href="pagination.php?page=job" class="flex flex-ai-c"><i class="fa-solid fa-calculator"></i><span>İş Garantisi</span></a>
                </li>
                <li>
                    <a href="pagination.php?page=battery" class="flex flex-ai-c"><i class="fa-solid fa-battery-three-quarters"></i><span>Akü Garantisi</span></a>
                </li>
            </ul>
        </div>