<?php 
session_start();
ob_start();
if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php 
    require_once 'connection.php';

    //marka ekleme

    if(isset($_POST['add_brand'])){
        $marka_adi = isset($_POST['marka_adi']) ? $_POST['marka_adi'] : null;
        $marka_adi = ucfirst($marka_adi);
        $sorgu = $db->prepare('INSERT INTO brands SET
            marka_adi = ?
        ');
        $marka_ekle = $sorgu->execute([
            $marka_adi
        ]);
        if($marka_ekle){
            header('location:pagination.php?page=storage');
        }
    }

    //toplu veri silme

    if(isset($_POST['delete_all'])){
        
        $sorgu = $db->prepare('DELETE FROM storage WHERE urun_markasi = ?');
        $sil = $sorgu->execute([$_POST['urun_markasi']]);
        if($sil){
            header('location:pagination.php?page=storage');
        }
    }

    //marka silme

    if(isset($_POST['delete_brand'])){
        $sorgu = $db->prepare('DELETE FROM brands WHERE marka_adi = ?');
        $sil = $sorgu->execute([$_POST['marka_adi']]);
        if($sil){
            header('location:pagination.php?page=storage');
        }
    }

    // yüzdelik fiyat azaltma

    if(isset($_POST['azalt'])){
         $urun_markasi = isset($_POST['urun_markasi']) ? $_POST['urun_markasi'] : null;
         $deger = isset($_POST['deger']) ? $_POST['deger'] : null;
         $deger = 1 - (intval($deger)/100); 


         $sorgu = $db->prepare('UPDATE storage SET urun_pesin = ROUND((urun_pesin * ?)), urun_veresiye = ROUND((urun_veresiye * ?)) WHERE urun_markasi = ?');
         $vericek = $sorgu->execute([
            $deger,
            $deger,
            $urun_markasi
         ]);
         if($vericek){
            header('location:pagination.php?page=storage'); 
         }
    
    }

    if(isset($_POST['arttir'])){
        $urun_markasi = isset($_POST['urun_markasi']) ? $_POST['urun_markasi'] : null;
        $deger = isset($_POST['deger']) ? $_POST['deger'] : null;
        $deger = 1 + (intval($deger)/100); 


        $sorgu = $db->prepare('UPDATE storage SET urun_pesin = ROUND((urun_pesin * ?)), urun_veresiye = ROUND((urun_veresiye * ?)) WHERE urun_markasi = ?');
        $vericek = $sorgu->execute([
           $deger,
           $deger,
           $urun_markasi
        ]);
        if($vericek){
           header('location:pagination.php?page=storage'); 
        }
   
   }

?>