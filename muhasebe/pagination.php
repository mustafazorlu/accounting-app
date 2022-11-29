<?php 
session_start();
ob_start();
if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php

require_once 'connection.php';

if(!isset($_GET['page'])){
    $_GET['page'] = 'pagination'; //page = pagination
}

switch($_GET['page']){
    case 'pagination': require_once 'index.php'; break;
    case 'job' : require_once 'job.php'; break;
    case 'user' : require_once 'user.php'; break;
    case 'storage' : require_once 'storage.php'; break;
    case 'battery' : require_once 'battery.php'; break;
    case 'update_battery' : require_once 'update_battery.php'; break;
    case 'delete_battery' : require_once 'delete_battery.php'; break;
    case 'update_job' : require_once 'update_job.php'; break;
    case 'delete_job' : require_once 'delete_job.php'; break;
    case 'update_user' : require_once 'update_user.php'; break;
    case 'delete_user' : require_once 'delete_user.php'; break;
    case 'update_storage' : require_once 'update_storage.php'; break;
    case 'delete_storage' : require_once 'delete_storage.php'; break;
    case 'wholesaler' : require_once 'wholesaler.php'; break;
    case 'update_wholesaler' : require_once 'update_wholesaler.php'; break;
    case 'delete_wholesaler' : require_once 'delete_wholesaler.php'; break;
    case 'sell' : require_once 'sell.php'; break;
    case 'detail_user' : require_once 'detail_user.php'; break;
    case 'detail_wholesaler' : require_once 'detail_wholesaler.php'; break;
    case 'detail_user_delete' : require_once 'detail_user_delete.php'; break;
    case 'bos' : require_once 'bos.php'; break;
}

?>