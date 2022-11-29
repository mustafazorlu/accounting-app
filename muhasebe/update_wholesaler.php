<?php require_once 'html_first.php' ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>

<?php
    $toptanci_veri = $db->prepare('SELECT * FROM wholesaler WHERE toptanci_id = ?');
    $toptanci_veri->execute([$_GET['toptanci_id']]);
    $veri = $toptanci_veri->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['update_wholesaler'])){
        $toptanci_adi = isset($_POST['toptanci_adi']) ? $_POST['toptanci_adi'] : $_POST['toptanci_adi'];
        $toptanci_soyadi = isset($_POST['toptanci_soyadi']) ? $_POST['toptanci_soyadi'] : $_POST['toptanci_soyadi'];
        $toptanci_tel = isset($_POST['toptanci_tel']) ? $_POST['toptanci_tel'] : $_POST['toptanci_tel'];
        $aciklama = isset($_POST['aciklama']) ? $_POST['aciklama'] : $_POST['aciklama'];

        $toptanci_adi = ucwords($toptanci_adi);
        $toptanci_soyadi = ucwords($toptanci_soyadi);
        $aciklama = ucwords($aciklama);

        $user_data = $db->prepare('UPDATE wholesaler SET
            toptanci_adi = ?,
            toptanci_soyadi = ?,
            toptanci_tel = ?,
            aciklama = ?
            WHERE toptanci_id = ?
        ');
        $get_user_data = $user_data->execute([
            $toptanci_adi,
            $toptanci_soyadi,
            $toptanci_tel,
            $aciklama,
            $veri['toptanci_id']
        ]);

        if($get_user_data){
            header('location:pagination.php?page=wholesaler');
            exit;
        }

    }

?>
<div class="main">
<div class="add-battery-box-overlay data-update-overlay" id="overlay">
            <div class="add-battery-box blueBorder flex data-update">
                
                <form class="flex flex-fdir-c" method="post">
                    <h3>Toptanci Düzenle</h3>
                    <div class="input">
                        <span>Adı :</span>
                        <input type="text" name="toptanci_adi" required value="<?php echo $veri['toptanci_adi'] ?>">
                    </div>
                    <div class="input">
                        <span>Soyadı :</span>
                        <input type="text" name="toptanci_soyadi" required value="<?php echo $veri['toptanci_soyadi'] ?>">
                    </div>
                    <div class="input">
                        <span>Tel :</span>
                        <input type="number" name="toptanci_tel" required  value="<?php echo $veri['toptanci_tel'] ?>">
                    </div>
                    <div class="input txtarea flex">
                        <span>Açıklama :</span>
                        <textarea cols="30" rows="10" name="aciklama" required maxlength="150"><?php echo $veri['aciklama'] ?>"</textarea>
                    </div>
                    <input type="hidden" name="update_wholesaler">
                    <button class="btn battery-btn" type="submit">Güncelle</button>
                </form>
            </div>
        </div>
</div>

<?php require_once 'html_last.php' ?>