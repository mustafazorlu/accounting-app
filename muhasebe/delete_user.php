<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php

if(!isset($_GET['musteri_id']) || empty($_GET['musteri_id'])){
    header('location:pagination.php?page=user');
}
$sorgu = $db->prepare('DELETE FROM user WHERE musteri_id = ?');
$sorgu->execute([$_GET['musteri_id']]);

header('location:pagination.php?page=user');

?>