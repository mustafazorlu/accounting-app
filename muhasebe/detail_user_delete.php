<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php



if(!isset($_GET['sell_id']) || empty($_GET['sell_id'])){
    header('Refresh:0');
}
$sorgu = $db->prepare('DELETE FROM sell WHERE sell_id = ?');
$sorgu->execute([$_GET['sell_id']]);


$sorgu = $db->prepare('UPDATE user SET
     bakiye = bakiye + ?
     WHERE musteri_id = ?
');
$sorgu->execute([
        $_GET['toplam_ucret'],
        $_GET['musteri_id']
]);

$sorgu = $db->prepare('UPDATE storage SET
     urun_adedi = urun_adedi + ?
     WHERE stok_id = ?
');
$sorgu->execute([
        $_GET['urun_adedi'],
        $_GET['urun_id']
]);



header('location:pagination.php?page=detail_user&musteri_id=' . $_GET['musteri_id']);
?>

