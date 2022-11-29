<?php require_once 'html_first.php' ?>
                                        <!-- BURASI USER KULLANICI PHP --><?php 
if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}
?>
<?php

$logAll = $db->prepare('SELECT * FROM musteri_log WHERE musteri_id = ? ORDER BY id DESC');
$logAll->execute([$_GET['musteri_id']]);
$getLog = $logAll->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['odeme'])){
    $odeme_miktari = isset($_POST['odenecek_tutar']) ? $_POST['odenecek_tutar'] : 0;
    $odeme_miktari = abs($odeme_miktari);
    $urun = isset($_POST['satis_islemi']) ? $_POST['satis_islemi'] : null;
    $aciklama = isset($_POST['aciklama']) ? $_POST['aciklama'] : null;
    $aciklama = ucwords($aciklama);

    $sell_id = explode('ID:',$urun)[1];

    

    $log = $db->prepare('INSERT INTO musteri_log SET
        musteri_id = ?,
        para_miktari = ?,
        aciklama = ?

    ');
    $log_ekle = $log->execute([
        $_GET['musteri_id'],
        $odeme_miktari,
        $aciklama
    ]);


    $odemeGuncelle = $db->prepare('UPDATE sell SET
    odenen = odenen + ?
    WHERE sell_id = ?');
    $odemeGuncelle->execute([
        $odeme_miktari,
        $sell_id
    ]);
    

    $bakiyeGuncelle = $db->prepare('UPDATE user SET
    bakiye = bakiye + ?
    WHERE musteri_id = ?');
    $bakiyeGuncelle->execute([
        $odeme_miktari,
        $_GET['musteri_id']
    ]);

    if($bakiyeGuncelle && $log_ekle && $odemeGuncelle){
        header('Refresh:0');
        exit;
    }
}

if(isset($_POST['borc'])){
    $odeme_miktari = isset($_POST['odenecek_tutar']) ? $_POST['odenecek_tutar'] : 0;
    $odeme_miktari = abs($odeme_miktari);
    $urun = isset($_POST['satis_islemi']) ? $_POST['satis_islemi'] : null;
    $aciklama = isset($_POST['aciklama']) ? $_POST['aciklama'] : null;
    $aciklama = ucwords($aciklama);

    $sell_id = explode('ID:',$urun)[1];

    

    $log = $db->prepare('INSERT INTO musteri_log SET
        musteri_id = ?,
        para_miktari = ?,
        aciklama = ?

    ');
    $log_ekle = $log->execute([
        $_GET['musteri_id'],
        $odeme_miktari,
        $aciklama
    ]);


    $odemeGuncelle = $db->prepare('UPDATE sell SET
    odenen = odenen - ?
    WHERE sell_id = ?');
    $odemeGuncelle->execute([
        $odeme_miktari,
        $sell_id
    ]);
    

    $bakiyeGuncelle = $db->prepare('UPDATE user SET
    bakiye = bakiye - ?
    WHERE musteri_id = ?');
    $bakiyeGuncelle->execute([
        $odeme_miktari,
        $_GET['musteri_id']
    ]);

    if($bakiyeGuncelle && $log_ekle && $odemeGuncelle){
        header('Refresh:0');
        exit;
    }
}

$currentTime = date('Y-m-d');
$musteri_veri = $db->prepare('SELECT * FROM user WHERE musteri_id = ?');
$musteri_veri->execute([$_GET['musteri_id']]);
$veri = $musteri_veri->fetch(PDO::FETCH_ASSOC);

$veriBakiye = abs($veri['bakiye']);

$satis_veri = $db->prepare('SELECT * FROM sell WHERE musteri_id = ? ORDER BY sell_id DESC');
$satis_veri->execute([$_GET['musteri_id']]);
$satislar = $satis_veri->fetchAll(PDO::FETCH_ASSOC);

$odenmemisler = array();
foreach($satislar as $satis){
    if($satis['toplam_ucret'] > $satis['odenen']){
        $odenmemisler[]=$satis;
    }
}

?>




    <div class="main">
        <div class="info-boxes flex detail-user ">
            <div class="box battery-box blueBorder" style="width: 50% !important;">
                
                <h4 style="margin-bottom:1rem;">Müşteri Verileri</h4>
                
                <div class="table" id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 100px;">Müşteri No</td>
                                <td><?php echo $veri['musteri_id'] ?></td>
                            </tr> 
                            <tr>
                                <td>Adı Soyadı</td>
                                <td><?php echo $veri['musteri_adi'] . ' ' . $veri['musteri_soyadi']  ?></td>
                            </tr> 
                            <tr>
                                <td>Tel No</td>
                                <td><?php echo $veri['musteri_tel'] ?></td>
                            </tr> 
                            <tr>
                                <td>Adres</td>
                                <td><?php echo $veri['musteri_adres'] ?></td>
                            </tr> 
                            <tr>
                                <td>Kayıt Tarihi</td>
                                <td><?php echo $veri['musteri_kayit'] ?></td>
                            </tr>
                            <tr>
                                <td>Açıklama</td>
                                <td><?php echo $veri['musteri_aciklama'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box blueBorder battery-box" style="width: 50% !important;">
                
                <div class="table" id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <h4 style="margin-bottom:0.5rem;">Müşteri Bakiye Durumu</h4>
                    <!-- <div style="padding-left:1rem; margin-bottom:0.5rem"><?php #echo $veri['bakiye'] < 0 ? 'Borçlu Müşteri' : '';   ?></div> -->
                    <div class="bakiye" style="padding-left:0.7rem;  position:relative; border-radius:10px; background-color:#F7F7F7">
                        <div class="durum_kutusu" style="opacity:<?php echo $veri['bakiye'] < 0 ? '1' : '0'; ?>"><?php echo $veri['bakiye'] < 0 ? 'Borçlu Müşteri' : '';   ?></div>
                        <div style="font-size:3rem; color:#343a40;"><?php echo $veriBakiye ;?> ₺</div>
                    </div>
                    <h4 style="margin:1rem 0;">Bakiye İşlemi Yap</h4>
                    <form action="" method="post">
                        <div class="input">
                                <input style="width: 120px;" list="yusuf" name="satis_islemi" placeholder="Satış işlem">
                                <datalist id="yusuf">
                                    <?php foreach($odenmemisler as $odenmemis): ?>
                                        <option value="<?php echo ' ID:' . $odenmemis['sell_id']  ?>"><?php echo $odenmemis['urun'] . ' ' . $odenmemis['toplam_ucret'] . '/' . $odenmemis['odenen']?></option>
                                    <?php endforeach; ?>
                                </datalist>
                                <input style="width: 120px;" type="number" name="odenecek_tutar" placeholder="Ödeme Tutarı">
                                <input type="text" placeholder="Açıklama" style="width: 160px;" name="aciklama">
                                
                                <button class="btn battery-btn" style="margin-left:3px;" type="submit" name="odeme">Ödeme Yap</button>
                                <button class="btn battery-btn" style="margin-left:3px; background-color:#D92550;" type="submit" name="borc">Borç Ekle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="data-box table-1 blueBorder">
            <div class="data-box-title flex flex-ai-c">
            <i class="fa-solid fa-money-bill"></i>
                <h4>Müşteri Satış Verileri</h4>
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
                            <td>Satış No</td>
                            <td>Ürün Adı</td>
                            <td>Ürün Adedi</td>
                            <td>Son Ödeme Tarihi</td>
                            <td style="width: 20px;"></td>
                            <td>Toplam Ücret</td>
                            <td>Kalan</td>
                            <td>Açıklama</td>

                            
                            <td style="width:75px" class="txtac">Sil</td>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php foreach($satislar as $satis): ?>
                            <tr>
                                <td><?php echo $satis["sell_id"] ?></td>
                                <td><?php echo $satis["urun"] ?></td>
                                <td><?php echo $satis["urun_sayisi"] ?></td>
                                <td><?php echo ($satis["process"] == "pesin") ? "PEŞİN" : $satis["due_date"]  ?></td>
                                <td style="width:20px; background-color:<?php echo ($currentTime <= $satis['due_date'] || $satis["process"] == "pesin" || $satis["odenen"] >= $satis["toplam_ucret"]) ? '#3AC47D' : '#D92550'; ?>"></td>
                                <td><?php echo $satis["toplam_ucret"] ?> ₺</td>
                                <td><?php echo ($satis["toplam_ucret"] > $satis["odenen"] ? $satis["toplam_ucret"] - $satis["odenen"] . " ₺": "ÖDENDİ") ?></td>
                                <td><?php echo $satis["aciklama"];?></td>
                                <td class="txtac"><a href="pagination.php?page=detail_user_delete&sell_id=<?php echo $satis['sell_id'] ?>&musteri_id=<?php echo $satis['musteri_id'] ?>&toplam_ucret=<?php echo $satis['toplam_ucret'] ?>&urun_adedi=<?php echo $satis['urun_sayisi'] ?>&urun_id=<?php echo $satis['urun_id']; ?>" class="delete">Sil</a></td>
                                <!-- <td class="txtac"><a href="" class="delete" name="delete">Sil</a></td> -->
                            </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="data-box table-2 blueBorder">
            <div class="data-box-title flex flex-ai-c">
            <i class="fa-solid fa-money-bill"></i>
                <h4>Müşteri Ödeme Verileri</h4>
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
                            <td>Müşteri No</td>
                            <td>Miktar</td>
                            <td>Açıklama</td>
                            <td>İşlem Tarihi</td>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php foreach($getLog as $logItem): ?>
                            <tr>
                               <td><?php echo $logItem['musteri_id'] ?></td>
                               <td><?php echo $logItem['para_miktari'] ?></td>
                               <td><?php echo $logItem['aciklama'] ?></td>
                               <td><?php echo $logItem['kayit_tarihi'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>
            </div>
            
        </div>
        
    </div>
<?php require_once 'html_last.php' ?>