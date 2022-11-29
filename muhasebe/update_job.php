<?php require_once 'html_first.php' ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
<?php 
require_once 'connection.php';
$get_data = $db->prepare('SELECT * FROM job WHERE job_id = ?');
$get_data->execute([
    $_GET['job_id']
]);
$veri = $get_data->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['update_job'])){
    $musteri_adi = isset($_POST['musteri_adi']) ? $_POST['musteri_adi'] : $veri['musteri_adi'];
    $musteri_soyadi = isset($_POST['musteri_soyadi']) ? $_POST['musteri_soyadi'] : $veri['musteri_soyadi'];
    $job_baslangic = isset($_POST['job_baslangic']) ? $_POST['job_baslangic'] : $veri['job_baslangic'];
    $job_bitis = isset($_POST['job_bitis']) ? $_POST['job_bitis'] : $veri['job_bitis'];
    $plaka = isset($_POST['plaka']) ? $_POST['plaka'] : $veri['plaka'];
    $arac_model = isset($_POST['arac_model']) ? $_POST['arac_model'] : $veri['arac_model'];
    $aciklama = isset($_POST['aciklama']) ? $_POST['aciklama'] : $veri['aciklama'];
    $bakiye = isset($_POST['bakiye']) ? $_POST['bakiye'] : $veri['bakiye'];
    //harfleri büyük yapma
    $musteri_adi = ucwords($musteri_adi);
    $musteri_soyadi = ucwords($musteri_soyadi);

    $sorgu = $db->prepare('UPDATE job SET
        musteri_adi = ?,
        musteri_soyadi = ?,
        job_baslangic = ?,
        job_bitis = ?,
        plaka = ?,
        arac_model = ?,
        aciklama = ?,
        bakiye = ?
        WHERE job_id = ?
    ');
    $job_guncelle = $sorgu->execute([
        $musteri_adi,
        $musteri_soyadi,
        $job_baslangic,
        $job_bitis,
        $plaka,
        $arac_model,
        $aciklama,
        $bakiye,
        $veri['job_id']
    ]);
    if($job_guncelle){
        header('location:pagination.php?page=job');
        exit;
    }
}

// $get_data = $db->prepare('SELECT * FROM job WHERE job_id = ?');
// $get_data->execute([$_GET['job_id']]);
// $veri = $get_data->fetch(PDO::FETCH_ASSOC);

print_r($veri);


?>

<div class="main">
<div class="add-battery-box-overlay data-update-overlay" id="overlay">
            <div class="add-battery-box greenBorder flex data-update">
                
                <form class="flex flex-fdir-c" method="post">
                    <h3>İş Garantisi İşlemi Düzenle</h3>
                    <div class="input">
                        <span>Adı :</span>
                        <input type="text" name="musteri_adi" required value="<?php echo $veri['musteri_adi']; ?>">
                    </div>
                    <div class="input">
                        <span>Soyadı :</span>
                        <input type="text" name="musteri_soyadi" required value="<?php echo $veri['musteri_soyadi']; ?>">
                    </div>
                    <div class="input">
                        <span>Başlangıç Tarihi :</span>
                        <input type="date" name="job_baslangic" required value="<?php echo $veri['job_baslangic']; ?>">
                    </div>
                    <div class="input">
                        <span>Bitiş Tarihi :</span>
                        <input type="date" name="job_bitis" required value="<?php echo $veri['job_bitis']; ?>">
                    </div>
                    <div class="input">
                        <span>Plaka :</span>
                        <input type="text" name="plaka" required value="<?php echo $veri['plaka']; ?>">
                    </div>
                    <div class="input">
                        <span>Arac Model :</span>
                        <input type="text" name="arac_model" required value="<?php echo $veri['arac_model']; ?>">
                    </div>
                    <div class="input">
                        <span>Bakiye :</span>
                        <input type="number" name="bakiye" required value="<?php echo $veri['bakiye']; ?>">
                    </div>
                    <div class="input txtarea flex">
                        <span>Açıklama :</span>
                        <textarea name="aciklama" id="" cols="30" rows="10" required maxlength="150"><?php echo $veri['aciklama']; ?></textarea>
                    </div>
                    <input type="hidden" name="update_job">
                    <button class="btn battery-btn" type="submit">Güncelle</button>
                </form>
            </div>
        </div>
</div>

<?php require_once 'html_last.php' ?>