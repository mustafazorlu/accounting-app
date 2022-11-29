<?php
    session_start();
    $conn = mysqli_connect('localhost','root','','u392945277_muhasebe');
    $k_adi = $_POST['k_adi'];
    $sifre = $_POST['sifre'];

    if(empty($k_adi)){
        header('location:login.php?error=Lütfen kullanıcı adı giriniz');
        exit;
    }elseif(empty($sifre)){
        header('location:login.php?error=Lütfen şifre giriniz');
        exit;
    }else{
        // $query = $db->query("SELECT * FROM login WHERE k_adi = '$k_adi' AND sifre = '$sifre'");
        $sql = "SELECT * FROM login WHERE k_adi = '$k_adi' AND sifre = '$sifre'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)){
            $row = mysqli_fetch_assoc($result);
            if($row['k_adi'] === $k_adi && $row['sifre'] === $sifre){
                $_SESSION['k_adi'] = $row['k_adi'];
                $_SESSION['isim'] = $row['isim'];
                $_SESSION['id'] = $row['id'];
                header('location:pagination.php');
                exit;
            }
        }else{
            header('location:login.php?error=Geçersiz kullanıcı adı veya şifre');
            exit;
        }
    }

?>