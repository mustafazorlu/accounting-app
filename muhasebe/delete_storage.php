<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php

if(!isset($_GET['stok_id']) || empty($_GET['stok_id'])){
    header('location:pagination.php?page=storage');
}
$sorgu = $db->prepare('DELETE FROM storage WHERE stok_id = ?');
$sorgu->execute([$_GET['stok_id']]);

header('location:pagination.php?page=storage');

?>