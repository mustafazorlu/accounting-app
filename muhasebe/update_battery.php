<?php require_once 'html_first.php' ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php



$get_data = $db->prepare('SELECT * FROM battery WHERE aku_id = ?');
$get_data->execute([$_GET['aku_id']]);
$veri = $get_data->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['battery_update'])){
    $musteri_adi = isset($_POST['musteri_adi']) ? $_POST['musteri_adi'] : $veri['musteri_adi'];
    $musteri_soyadi = isset($_POST['musteri_soyadi']) ? $_POST['musteri_soyadi'] : $veri['musteri_soyadi'];
    $aku_baslangic = isset($_POST['aku_baslangic']) ? $_POST['aku_baslangic'] : $veri['aku_baslangic'];
    $aku_bitis = isset($_POST['aku_bitis']) ? $_POST['aku_bitis'] : $veri['aku_bitis'];
    $plaka = isset($_POST['plaka']) ? $_POST['plaka'] : $veri['plaka'];
    $marka = isset($_POST['marka']) ? $_POST['marka'] : $veri['marka'];
    $amper = isset($_POST['amper']) ? $_POST['amper'] : $veri['amper'];
    //harflerin bas harflerini büyük yapma
    $musteri_adi = ucwords($musteri_adi);
    $musteri_soyadi = ucwords($musteri_soyadi);

    $sorgu = $db->prepare('UPDATE battery SET
        musteri_adi = ?,
        musteri_soyadi = ?,
        aku_baslangic = ?,
        aku_bitis = ?,
        plaka = ?,
        marka = ?,
        amper = ?
        WHERE aku_id = ?
    ');
    $veri_güncelle = $sorgu->execute([
        $musteri_adi,
        $musteri_soyadi,
        $aku_baslangic,
        $aku_bitis,
        $plaka,
        $marka,
        $amper,
        $veri['aku_id']
    ]);

    if($veri_güncelle){
        header('location:pagination.php?page=battery');
        exit;
    }
}
?>

<div class="main">
<div class="add-battery-box-overlay data-update-overlay" id="overlay">
            <div class="add-battery-box yellowBorder flex data-update">
                
                <form class="flex flex-fdir-c" method="post">
                    <h3>Akü İşlemi Düzenle</h3>
                    <div class="input">
                        <span>Adı :</span>
                        <input type="text" name="musteri_adi" required value="<?php echo $veri['musteri_adi']?>">
                    </div>
                    <div class="input">
                        <span>Soyadı :</span>
                        <input type="text" name="musteri_soyadi" required  value="<?php echo $veri['musteri_soyadi']?>">
                    </div>
                    <div class="input">
                        <span>Başlangıç Tarihi :</span>
                        <input type="date" name="aku_baslangic" required  value="<?php echo $veri['aku_baslangic']?>">
                    </div>
                    <div class="input">
                        <span>Bitiş Tarihi :</span>
                        <input type="date" name="aku_bitis" required  value="<?php echo $veri['aku_bitis']?>">
                    </div>
                    <div class="input">
                        <span>Plaka :</span>
                        <input type="text" name="plaka" required  value="<?php echo $veri['plaka']?>">
                    </div>
                    <div class="input">
                        <span>Marka :</span>
                        <input type="text" name="marka" required  value="<?php echo $veri['marka']?>">
                    </div>
                    <div class="input">
                        <span>Amper :</span>
                        <input type="number" name="amper" required  value="<?php echo $veri['amper']?>">
                    </div>
                    <input type="hidden" name="battery_update">
                    <button class="btn battery-btn" type="submit">Güncelle</button>
                </form>
            </div>
        </div>
</div>





<?php require_once 'html_last.php' ?>