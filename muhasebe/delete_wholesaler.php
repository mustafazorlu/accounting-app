<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php

if(!isset($_GET['toptanci_id']) || empty($_GET['toptanci_id'])){
    header('location:pagination.php?page=wholesaler');
}
$sorgu = $db->prepare('DELETE FROM wholesaler WHERE toptanci_id = ?');
$sorgu->execute([$_GET['toptanci_id']]);

header('location:pagination.php?page=wholesaler');

?>