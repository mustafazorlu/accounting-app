<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php

    if(!isset($_GET['job_id']) || empty($_GET['job_id'])){
        header('location:pagination.php?page=job');
    }
    $sorgu = $db->prepare('DELETE FROM job WHERE job_id = ?');
    $sorgu->execute([$_GET['job_id']]);

    header('location:pagination.php?page=job');

?>