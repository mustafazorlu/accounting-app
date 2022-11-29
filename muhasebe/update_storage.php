<?php require_once 'html_first.php' ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>

<?php

$get_data = $db->prepare('SELECT * FROM storage WHERE stok_id = ?');
$get_data->execute([$_GET['stok_id']]);
$veri = $get_data->fetch(PDO::FETCH_ASSOC);

$marka_verileri = $db->query('SELECT * FROM brands');
$marka_cek = $marka_verileri->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['update_storage'])){
    $stok_no = isset($_POST['stok_no']) ? $_POST['stok_no'] : $veri['stok_no'];
    $urun_adi = isset($_POST['urun_adi']) ? $_POST['urun_adi'] : $veri['urun_adi'];
    $urun_markasi = isset($_POST['urun_markasi']) ? $_POST['urun_markasi'] : $veri['urun_markasi'];
    $urun_adedi = isset($_POST['urun_adedi']) ? $_POST['urun_adedi'] : $veri['urun_adedi'];
    $urun_pesin = isset($_POST['urun_pesin']) ? $_POST['urun_pesin'] : $veri['urun_pesin'];
    $urun_veresiye = isset($_POST['urun_veresiye']) ? $_POST['urun_veresiye'] : $veri['urun_veresiye'];
    //harfleri büyük yapma
    $urun_adi = ucwords($urun_adi);

    $sorgu = $db->prepare('UPDATE storage SET
        stok_no = ?,
        urun_adi = ?,
        urun_markasi = ?,
        urun_adedi = ?,
        urun_pesin = ?,
        urun_veresiye = ?
        WHERE stok_id = ?
    ');
    $veri_güncelle = $sorgu->execute([
        $stok_no,
        $urun_adi,
        $urun_markasi,
        $urun_adedi,
        $urun_pesin,
        $urun_veresiye,
        $veri['stok_id']
    ]);

    if($veri_güncelle){
        header('location:pagination.php?page=storage');
        exit;
    }
}

?>

<div class="main">
<div class="add-battery-box-overlay data-update-overlay" id="overlay">
            <div class="add-battery-box yellowBorder flex data-update">
                
                <form class="flex flex-fdir-c" method="post">
                <h3>Stok Düzenle</h3>
                    <div class="input">
                        <span>Stok No :</span>
                        <input type="text" name="stok_no" required value="<?php echo $veri['stok_no']?>">
                    </div>
                    <div class="input">
                        <span>Ürün Adı :</span>
                        <input type="text" name="urun_adi" required value="<?php echo $veri['urun_adi']?>">
                    </div>
                    <div class="input">
                        <span>Marka :</span>
                        <select name="urun_markasi" required>
                            <?php foreach($marka_cek as $marka): ?>
                                <option value="<?php echo $marka['marka_adi'] ?>"><?php echo $marka['marka_adi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input">
                        <span>Ürün Adedi :</span>
                        <input type="number" id="urun_adet_input" name="urun_adedi" required value="<?php echo $veri['urun_adedi']?>">
                    </div>
                    <div class="input">
                        <span>Peşin Fiyatı :</span>
                        <input type="number" name="urun_pesin" required value="<?php echo $veri['urun_pesin']?>">
                    </div>
                    <div class="input">
                        <span>Veresiye Fiyatı :</span>
                        <input type="number" name="urun_veresiye" required value="<?php echo $veri['urun_veresiye']?>">
                    </div>
                    <div class="input">
                        <span id="reset" class="reset">Ürün Adedini Sıfırla</span>
                    </div>
                    <input type="hidden" name="update_storage">
                    <button class="btn battery-btn" type="submit">Güncelle</button>
                </form>
            </div>
        </div>
</div>

<?php require_once 'html_last.php' ?>