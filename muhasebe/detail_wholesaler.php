<?php require_once 'html_first.php' ?>
                                        <!-- BURASI USER KULLANICI PHP --><?php 
if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}
?>

<?php

$currentTime = date('Y-m-d');
// $rs = $db->prepare('SELECT * FROM wholesaler WHERE toptanci_id = ?');
// $rs->execute([$_GET['toptanci_id']]);
// $veri = $rs->fetch(PDO::FETCH_ASSOC);


$query = $db->prepare('SELECT * FROM wholesaler WHERE toptanci_id = ?');
$query->execute([$_GET['toptanci_id']]);
$getData = $query->fetch(PDO::FETCH_ASSOC);

$logAll = $db->prepare('SELECT * FROM toptanci_log WHERE toptanci_id = ? ORDER BY id DESC');
$logAll->execute([$_GET['toptanci_id']]);
$getLog = $logAll->fetchAll(PDO::FETCH_ASSOC);



// $musteri_veri = $db->prepare('SELECT * FROM user WHERE musteri_id = ?');
// $musteri_veri->execute([$_GET['musteri_id']]);
// $veri = $musteri_veri->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['odeme'])){
    $odeme_miktari = isset($_POST['odenecek_tutar']) ? $_POST['odenecek_tutar'] : 0;
    $toptanci_aciklama = isset($_POST['toptanci_aciklama']) ? $_POST['toptanci_aciklama'] : null;
    $yapilan_islem = isset($_POST['yapilan_islem']) ? $_POST['yapilan_islem'] : null;
    $toptanci_aciklama = ucwords($toptanci_aciklama);
    $yapilan_islem = ucwords($yapilan_islem);

    $log = $db->prepare('INSERT INTO toptanci_log SET
        toptanci_id = ?,
        yapilan_islem = ?,
        para_miktari = ?,
        toptanci_aciklama = ?

    ');
    $log_ekle = $log->execute([
        $getData['toptanci_id'],
        $yapilan_islem,
        $odeme_miktari,
        $toptanci_aciklama
    ]);

    $bakiyeGuncelle = $db->prepare('UPDATE wholesaler SET
    bakiye = bakiye + ?
    WHERE toptanci_id = ?');
    $guncellenmisBakiye = $bakiyeGuncelle->execute([
        $odeme_miktari,
        $_GET['toptanci_id']
    ]);

    if($guncellenmisBakiye && $log_ekle){
        header('Refresh:0');
        exit;
    }
    

}

if(isset($_POST['borc'])){
    $odeme_miktari = isset($_POST['odenecek_tutar']) ? $_POST['odenecek_tutar'] : 0;
    $toptanci_aciklama = isset($_POST['toptanci_aciklama']) ? $_POST['toptanci_aciklama'] : null;
    $yapilan_islem = isset($_POST['yapilan_islem']) ? $_POST['yapilan_islem'] : null;
    $toptanci_aciklama = ucwords($toptanci_aciklama);
    $yapilan_islem = ucwords($yapilan_islem);

    $log = $db->prepare('INSERT INTO toptanci_log SET
        toptanci_id = ?,
        yapilan_islem = ?,
        para_miktari = ?,
        toptanci_aciklama = ?

    ');
    $log_ekle = $log->execute([
        $getData['toptanci_id'],
        $yapilan_islem,
        $odeme_miktari,
        $toptanci_aciklama
    ]);

    $bakiyeGuncelle = $db->prepare('UPDATE wholesaler SET
    bakiye = bakiye - ?
    WHERE toptanci_id = ?');
    $guncellenmisBakiye = $bakiyeGuncelle->execute([
        $odeme_miktari,
        $_GET['toptanci_id']
    ]);

    if($guncellenmisBakiye && $log_ekle){
        header('Refresh:0');
        exit;
    }
    

}
    

$veriBakiye = abs($getData['bakiye']);



// $satis_veri = $db->prepare('SELECT * FROM sell WHERE musteri_id = ?');
// $satis_veri->execute([$_GET['musteri_id']]);
// $satislar = $satis_veri->fetchAll(PDO::FETCH_ASSOC);

// $odenmemisler = array();
// foreach($satislar as $satis){
//     if($satis['toplam_ucret'] > $satis['odenen']){
//         $odenmemisler[]=$satis;
//     }
// }

?>
    <div class="main">
        <div class="info-boxes flex detail-user">
            <div class="box blueBorder battery-box" style="width: 50% !important;">
                
                <h4 style="margin-bottom:1rem;">Toptancı Verileri</h4>
                
                <div class="table" id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 100px;">Toptancı No</td>
                                <td><?php echo $getData['toptanci_id'] ?></td>
                            </tr> 
                            <tr>
                                <td>Adı Soyadı</td>
                                <td><?php echo $getData['toptanci_adi'] . ' ' . $getData['toptanci_soyadi']  ?></td>
                            </tr> 
                            <tr>
                                <td>Tel No</td>
                                <td><?php echo $getData['toptanci_tel'] ?></td>
                            </tr> 
                            <tr>
                                <td>Açıklama</td>
                                <td><?php echo $getData['aciklama'] ?></td>
                            </tr> 
                            <tr>
                                <td>Kayıt Tarihi</td>
                                <td><?php echo $getData['toptanci_kayit'] ?></td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box blueBorder battery-box" style="width: 50% !important;">
                
                <div class="table" id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <h4 style="margin-bottom:1rem;">Toptancı Bakiye Durumu</h4>
                    <div class="bakiye" style="padding-left:0.7rem; border-radius:10px; position:relative; background-color:#F7F7F7">
                        <div class="durum_kutusu" style="opacity:<?php echo $getData['bakiye'] < 0 ? '1' : '0'; ?>"><?php echo $getData['bakiye'] < 0 ? 'Toptancıya Olan Borç' : '';   ?></div>
                        <div style="font-size:3rem; color:#343a40;"><?php echo $veriBakiye;?> ₺</div>
                    </div>
                    <h4 style="margin:1rem 0;">Bakiye İşlemi Yap</h4>
                    <form action="" method="post">
                        <div class="input">
                                <input type="text" placeholder="Yapılan İşlem" style="width:130px;" name="yapilan_islem">
                                <input style="width: 120px;" type="number" name="odenecek_tutar" placeholder="Ödeme Tutarı">
                                <input type="text" placeholder="Açıklama" style="width: 140px;" name="toptanci_aciklama">
                                
                                <div>
                                <button class="btn battery-btn" style="margin-left:3px;" name="odeme" type="submit">Ödeme Yap</button>
                                <button class="btn battery-btn" name="borc" type="submit" style="background-color:#D92550">Borç Ekle</button>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <div class="data-box table-1 blueBorder">
            <div class="data-box-title flex flex-ai-c">
            <i class="fa-solid fa-money-bill"></i>
                <h4>Toptancı Ödeme Verileri</h4>
            </div>
            <!-- <div class="utility-box flex flex-ai-c flex-jc-sb">
                
               <div class="data-search-box">
                   <span style="color:#495057; font-size:14px">Ara :</span>
                   <input type="text" id="myInput" onkeyup='tableSearch()' placeholder="Müşteri ismi">
               </div>
            </div> -->
            <div class="table">
                <table id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <thead>
                        <tr>
                            <td>Toptancı No</td>
                            <td>Yapılan İşlem</td>
                            <td>Para Miktarı</td>
                            <td>Açıklama</td>
                            <td>İşlem Tarihi</td>
                            
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($getLog as $logItem): ?>
                            <tr>
                                <td><?php echo $logItem['toptanci_id'] ?></td>
                                <td><?php echo $logItem['yapilan_islem'] ?></td>
                                <td><?php echo $logItem['para_miktari'] ?></td>
                                <td><?php echo $logItem['toptanci_aciklama'] ?></td>
                                <td><?php echo $logItem['kayit_tarihi'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
        </div>

        
    </div>
<?php require_once 'html_last.php' ?>