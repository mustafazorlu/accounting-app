<?php require_once 'html_first.php' ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php

    $musteri_veri = $db->prepare('SELECT * FROM user WHERE musteri_id = ?');
    $musteri_veri->execute([$_GET['musteri_id']]);
    $veri = $musteri_veri->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['update_user'])){
        $musteri_adi = isset($_POST['musteri_adi']) ? $_POST['musteri_adi'] : $_POST['musteri_adi'];
        $musteri_soyadi = isset($_POST['musteri_soyadi']) ? $_POST['musteri_soyadi'] : $_POST['musteri_soyadi'];
        $musteri_tel = isset($_POST['musteri_tel']) ? $_POST['musteri_tel'] : $_POST['musteri_tel'];
        $musteri_adres = isset($_POST['musteri_adres']) ? $_POST['musteri_adres'] : $_POST['musteri_adres'];
        $musteri_aciklama = isset($_POST['musteri_aciklama']) ? $_POST['musteri_aciklama'] : $_POST['musteri_aciklama'];
        //harfleri büyük yapma
        $musteri_adi = ucwords($musteri_adi);
        $musteri_soyadi = ucwords($musteri_soyadi);
        $musteri_adres = ucwords($musteri_adres);
        $musteri_aciklama = ucwords($musteri_aciklama);

        $user_data = $db->prepare('UPDATE user SET
            musteri_adi = ?,
            musteri_soyadi = ?,
            musteri_tel = ?,
            musteri_adres = ?,
            musteri_aciklama = ?
            WHERE musteri_id = ?
        ');
        $get_user_data = $user_data->execute([
            $musteri_adi,
            $musteri_soyadi,
            $musteri_tel,
            $musteri_adres,
            $musteri_aciklama,
            $veri['musteri_id']
        ]);

        if($get_user_data){
            header('location:pagination.php?page=user');
            exit;
        }

    }

?>
<div class="main">
<div class="add-battery-box-overlay data-update-overlay" id="overlay">
            <div class="add-battery-box blueBorder flex data-update">
                
                <form class="flex flex-fdir-c" method="post">
                    <h3>Müşteri Düzenle</h3>
                    <div class="input">
                        <span>Adı :</span>
                        <input type="text" name="musteri_adi" required value="<?php echo $veri['musteri_adi'] ?>">
                    </div>
                    <div class="input">
                        <span>Soyadı :</span>
                        <input type="text" name="musteri_soyadi" required value="<?php echo $veri['musteri_soyadi'] ?>">
                    </div>
                    <div class="input">
                        <span>Tel :</span>
                        <input type="number" name="musteri_tel" required value="<?php echo $veri['musteri_tel'] ?>">
                    </div>
                    <div class="input txtarea flex">
                        <span>Adres :</span>
                        <textarea cols="30" rows="10" name="musteri_adres" required maxlength="150"><?php echo $veri['musteri_adres'] ?></textarea>
                    </div>

                    <div class="input txtarea flex">
                        <span>Açıklama :</span>
                        <textarea cols="30" rows="10" name="musteri_aciklama" required maxlength="150"><?php echo $veri['musteri_aciklama'] ?></textarea>
                    </div>
                    <input type="hidden" name="update_user">
                    <button class="btn battery-btn" type="submit">Güncelle</button>
                </form>
            </div>
        </div>
</div>


<?php require_once 'html_last.php' ?>