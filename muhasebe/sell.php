<?php require_once 'html_first.php' ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
    $veriler_user = $db->query('SELECT * FROM user');
    $verileri_cek = $veriler_user->fetchAll(PDO::FETCH_ASSOC);

    $veriler_urun = $db->query('SELECT * FROM storage');
    $verileri_cek_urun = $veriler_urun->fetchAll(PDO::FETCH_ASSOC);

    $satis_urunleri = $db->query('SELECT * FROM sell ORDER BY sell_id DESC');
    $verileri_cek_satis = $satis_urunleri->fetchAll(PDO::FETCH_ASSOC);
    
    if(isset($_POST['sell_process'])){
        $currentTime = date('Y-m-d');
        $musteri = isset($_POST['musteri']) ? $_POST['musteri'] : null;
        $urun = isset($_POST['urun']) ? $_POST['urun'] : null;
        $urun_sayisi = isset($_POST['urun_sayisi']) ? $_POST['urun_sayisi'] : null;
        $date = isset($_POST['date']) ? $_POST['date'] : null;
        $aciklama = isset($_POST['aciklama']) ? $_POST['aciklama'] : null;
        $process = ($date != null) ? "veresiye" : "pesin";
        $date = ($date == "" || $date == "0000-00-00") ? $currentTime : $date;
        $urun_adi = explode('-ID:',$urun)[0];
        $urun_id = explode('-ID:',$urun)[1];
        $musteri_id = explode('-ID:',$musteri)[1];
        $musteri = explode('-ID:',$musteri)[0]; //Yusuf Bolat-ID:25 = $musteri; $musteri[0] $musteri[1]
        $aciklama = ucwords($aciklama);

        // urun bilgileri
        $queryString = 'SELECT * FROM storage WHERE stok_id = ' . $urun_id;
        $queryUrun = $db->query($queryString);
        $verilerUrun = $queryUrun->fetch(PDO::FETCH_ASSOC);

        $sorgu = $db->prepare('INSERT INTO sell SET
            musteri = ?,
            musteri_id = ?,
            urun = ?,
            urun_id = ?,
            urun_sayisi = ?,
            toplam_ucret = ?,
            odenen = ?,
            process = ?,
            due_date = ?,
            aciklama = ?
        ');
    
        $satis_ekle = $sorgu->execute([
            $musteri,
            $musteri_id,
            $urun_adi,
            $urun_id,
            $urun_sayisi,
            $process == "pesin" ? $verilerUrun['urun_pesin'] * $urun_sayisi : $verilerUrun['urun_veresiye'] * $urun_sayisi,
            $process == "pesin" ? $verilerUrun['urun_pesin'] * $urun_sayisi : 0,
            $process,
            $date,
            $aciklama
        ]);
        // urun adet guncelle
        $queryString = 'SELECT * FROM storage WHERE stok_id = ' . $urun_id;
        $queryUrunBilgi = $db->query($queryString);
        $veriUrunBilgi = $queryUrunBilgi->fetch(PDO::FETCH_ASSOC);
        $urunAdetGuncelle = $db->prepare('UPDATE storage SET
            urun_adedi = ?
            WHERE stok_id = ?
        ');
        $urunAdetGuncelle->execute([
            $veriUrunBilgi['urun_adedi'] - $urun_sayisi,
            $urun_id    
        ]);

        // musteri bakiye
        // $queryMusteri = $db->query("SELECT * FROM user WHERE musteri_id");
        // $queryMusteri = $db->query("SELECT * FROM user WHERE musteri_id=" . $musteri_id);

        // $queryMusteri = $db->query("SELECT * FROM user WHERE musteri_id");
        // $verilerMusteri = $queryMusteri->fetch(PDO::FETCH_ASSOC);
        // $musteriBakiye = $verilerMusteri['bakiye'];

        // $sorgu = $db->prepare('UPDATE user SET
        //     bakiye = ?
        //     WHERE musteri_id = ?
        // ');
        // $sorgu->execute([
        //     $musteriBakiye - ($process == "pesin" ? $musteriBakiye : $verilerUrun['urun_veresiye'] * $urun_sayisi),
        //     $musteri_id
        // ]);

        if($process == 'veresiye'){
            $sorgu = $db->prepare('UPDATE user SET
             bakiye = bakiye - ?
             WHERE musteri_id = ?
        ');
        $sorgu->execute([
                $verilerUrun['urun_veresiye'] * $urun_sayisi,
                $musteri_id
        ]);
        }


        // $query = $db->query('SELECT * FROM sell OUTHER JOIN storage ON sell_id = stok_id ');

        if($satis_ekle){
            header('location:pagination.php?page=sell');
            exit;
        }
    }

    if(isset($_POST['hizmet_process'])){
        $currentTime = date('Y-m-d');
        $hizmet_musteri = isset($_POST['hizmet_musteri']) ? $_POST['hizmet_musteri'] : null;
        $hizmet_adi = isset($_POST['hizmet_adi']) ? $_POST['hizmet_adi'] : null;
        $hizmet_fiyat = isset($_POST['hizmet_fiyat']) ? $_POST['hizmet_fiyat'] : null;
        $hizmet_son_odeme = isset($_POST['hizmet_son_odeme']) ? $_POST['hizmet_son_odeme'] : null;
        $hizmet_aciklama = isset($_POST['hizmet_aciklama']) ? $_POST['hizmet_aciklama'] : null;
        $hizmet_aciklama = ucwords($hizmet_aciklama);
        $hizmet_adi = ucwords($hizmet_adi);
        $urun_sayisi = 1;
        $hizmet_musteri_id = explode('-ID:',$hizmet_musteri)[1];
        $hizmet_musteri = explode('-ID:',$hizmet_musteri)[0];
        $process = ($hizmet_son_odeme != null) ? "veresiye" : "pesin";
        $hizmet_son_odeme = ($hizmet_son_odeme == "" || $hizmet_son_odeme == "0000-00-00") ? $currentTime : $hizmet_son_odeme;

        $sorgu = $db->prepare('INSERT INTO sell SET
            musteri = ?,
            musteri_id = ?,
            urun = ?,
            urun_sayisi = ?,
            toplam_ucret = ?,
            odenen = ?,
            process = ?,
            due_date = ?,
            aciklama = ?
        ');
        $satis_ekle = $sorgu->execute([
            $hizmet_musteri,
            $hizmet_musteri_id,
            $hizmet_adi,
            $urun_sayisi,
            $hizmet_fiyat,
            $process == "pesin" ? $verilerUrun['urun_pesin'] * $urun_sayisi : 0,
            $process,
            $hizmet_son_odeme,
            $hizmet_aciklama

        ]);
        // $process == "pesin" ? $verilerUrun['urun_pesin'] * $urun_sayisi : $verilerUrun['urun_veresiye'] * $urun_sayisi,
        // $process == "pesin" ? $verilerUrun['urun_pesin'] * $urun_sayisi : 0,

        // $queryMusteri = $db->query("SELECT * FROM user WHERE musteri_id");
        // $verilerMusteri = $queryMusteri->fetch(PDO::FETCH_ASSOC);
        // $musteriBakiye = $verilerMusteri['bakiye'];

        if($process == 'veresiye'){
            $sorgu = $db->prepare('UPDATE user SET
             bakiye = bakiye - ?
             WHERE musteri_id = ?
        ');
        $sorgu->execute([
            $hizmet_fiyat,
            $hizmet_musteri_id
        ]);
        }

        if($satis_ekle){
            header('location:pagination.php?page=sell');
            exit;
        }

    }


?>

<div class="main">

            <div class="info-boxes flex">
                <div class="box redBorder battery-box storage-add" id="battery-data-import">
                    Satış Ekle 
                </div>
            </div>

            <div class="data-box table-1 redBorder">
                <div class="data-box-title flex flex-ai-c">
                <i class="fa-solid fa-money-bill"></i>
                    <h4>Satış Verileri</h4>
                </div>
                <div class="utility-box flex flex-ai-c flex-jc-sb">
                    
                   <div class="data-search-box">
                       <span style="color:#495057; font-size:14px">Ara :</span>
                       <input type="text" class="search" placeholder="Müşteri ismi" id="myInput" onkeyup="tableSearch()">
                   </div>
                </div>
                <div class="table">
                    <table id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                        <thead>
                            <tr>
                                <td>Satış No</td>
                                <td>Müşteri</td>
                                <td>Ürün/Hizmet Adı</td>
                                <td>Ürün Adedi</td>
                                <td>Toplam Ücret</td>
                                <td>Açıklama</td>
                                <td style="width: 160px;">İşlem Tarihi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($verileri_cek_satis as $veri): ?>
                                <tr>
                                    <td><?php echo $veri['sell_id'] ?></td>
                                    <td><?php echo $veri['musteri'] ?></td>
                                    <td><?php echo $veri['urun'] ?></td>
                                    <td><?php echo $veri['urun_sayisi'] ?></td>
                                    <td><?php echo $veri['toplam_ucret']?></td>
                                    <td><?php echo $veri['aciklama']?></td>
                                    <td><?php echo $veri['sell_kayit'];?> </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <div class="add-battery-box-overlay" id="overlay">
            <div class="add-battery-box greenBorder">
                
                <form class="flex flex-fdir-c" method="post">
                    <div class="times" id="times">
                    <i class="fa-solid fa-xmark"></i>
                    </div>
                    <h3>Satış İşlemi Ekle</h3>
                    <div class="get-info flex flex-fdir-r" style="column-gap:30px">
                        <div class="main-info flex-fdir-c" >
                            <div class="input">
                                <span>Müşteri Seçin :</span>
                                <input list="yusuf" name="musteri">
                                <datalist id="yusuf">
                                    <option value=""></option>
                                    <?php foreach($verileri_cek as $veri): ?>
                                        <option value="<?php echo $veri['musteri_adi'] . ' ' . $veri['musteri_soyadi'] . '-ID:' . $veri['musteri_id']  ?>"><?php echo $veri['musteri_adi'] . ' ' . $veri['musteri_soyadi']?></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            
                            
                            <div class="input">
                                <span>Son Ödeme Tarihi</span>
                                <input type="date" name="date">
                            </div>
                            <div class="input txtarea flex">
                                <span>Açıklama</span>
                                <textarea name="aciklama"></textarea>
                            </div>
                        </div>
                        <div class="side-info flex flex-fdir-c" >
                            <div class="div1" style="display:none" id="div1">
                                <div class="input">
                                    <span>Ürün Seçin</span>
                                    <input list="musteriler" name="urun" required>
                                    <datalist id="musteriler" required>
                                        <?php foreach($verileri_cek_urun as $veri): ?>
                                            <option value="<?php echo $veri['urun_adi'] . '-ID:' . $veri['stok_id'] ?>"><?php echo $veri['urun_adedi'] ?> adet</option>
                                            
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>
                                <div class="input">
                                        <span>Ürün Adedi</span>
                                        <input type="number" name="urun_sayisi" required>
                                </div>
                            </div>
                            <div class="div2" id="div2">
                                <div class="input">
                                <span>Hizmet :</span>
                                <input type="text" name="hizmet_adi" required>
                                </div>
                                <div class="input">
                                    <span>Fiyat :</span>
                                    <input type="text" name="hizmet_fiyat" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                            <span style="font-size:14px; color:red;"><b>NOT:</b> Son ödeme tarihi seçildiği takdirde müşteri <br> veresiye  fiyatıyla borçlandırılacaktır.</span>
                    </div>
                    <input type="hidden" name="sell_process">
                    <div class="buttons flex flex-fdir-r" style="width:100%;">
                        <a class="btn battery-btn" type="" id="buton1">Buton1</a>
                        <a class="btn battery-btn" type="" id="buton2">Buton2</a>
                        <button href="" class="btn battery-btn" type="submit" style="margin-left:auto">Sat</button>
                    </div>
                </form>
            </div>
        </div>
        
<?php require_once 'html_last.php' ?>