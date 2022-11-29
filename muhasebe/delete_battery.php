<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php 

    if(!isset($_GET['aku_id']) || empty($_GET['aku_id'])){
        header('location:pagination.php?page=battery');
    }
    $sorgu = $db->prepare('DELETE FROM battery WHERE aku_id = ?');
    $sorgu->execute([$_GET['aku_id']]);
    
    header('location:pagination.php?page=battery');


    

?>