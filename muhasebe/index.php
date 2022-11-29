<?php require_once 'html_first.php'; ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
                                    <!-- BURASI INDEX ANASAYFA PHP -->
        
<?php
require_once 'connection.php';
$currentTime = date('Y-m-d');

$aku_veri_sorgu = $db->query('SELECT * FROM battery ORDER BY aku_id DESC');
$akuVerileri = $aku_veri_sorgu->fetchAll(PDO::FETCH_ASSOC);

$is_veri = $db->query('SELECT * FROM job ORDER BY job_id DESC');
$is_veri_cek = $is_veri->fetchAll(PDO::FETCH_ASSOC);

$user_veri_sorgu = $db->query('SELECT * FROM user ORDER BY musteri_id DESC');
$user_verileri = $user_veri_sorgu->fetchAll(PDO::FETCH_ASSOC);

$toptanci_veri_sorgu = $db->query('SELECT * FROM wholesaler ORDER BY toptanci_id DESC');
$toptanci_verileri = $toptanci_veri_sorgu->fetchAll(PDO::FETCH_ASSOC);

$satis_urunleri = $db->query('SELECT * FROM sell');
$verileri_cek_satis = $satis_urunleri->fetchAll(PDO::FETCH_ASSOC);

$aku_toplam_kayit = $aku_veri_sorgu->rowCount();
$job_toplam_kayit = $is_veri->rowCount();
$user_toplam_kayit = $user_veri_sorgu->rowCount();
$sell_toplam_kayit = $satis_urunleri->rowCount();

$aku_gunluk_kayit = $aku_veri_sorgu->rowCount();
$job_gunluk_kayit = $is_veri->rowCount();
$user_gunluk_kayit = $user_veri_sorgu->rowCount();
//aku gunluk kayit
$arrAku = array();
for($i = 0; $i < $aku_toplam_kayit; $i++){
    $veri = $akuVerileri[$i]['aku_kayit'];
    $kayit = explode(" ",$veri);
    if($currentTime == $kayit[0]){
        $arrAku[] = $i;
    }
}
//job gunluk kayit
$arrJob = array();
for($i = 0; $i < $job_toplam_kayit; $i++){
    $veri = $is_veri_cek[$i]['job_kayit'];
    $kayit = explode(" ",$veri);
    if($currentTime == $kayit[0]){
        $arrJob[] = $i;
    }
}
//musteri borc
$borcMusteri = 0;
foreach($user_verileri as $tempUser){
    if ($tempUser["bakiye"] < 0){
        $borcMusteri += $tempUser["bakiye"]*-1;
    }
}
//satis
$satislar = 0;
foreach($verileri_cek_satis as $tempSatis){
    if (explode(" ", $tempSatis["sell_kayit"])[0] == $currentTime){
        $satislar += 1;
    }
}
//toptanci borc
$borcToptanci = 0;
foreach($toptanci_verileri as $tempToptanci){
    if ($tempToptanci["bakiye"] > 0){
        $borcToptanci += $tempToptanci["bakiye"] * -1;
    }
}


?>     
<div class="main">
            <div class="info-boxes flex">
                    <!-- box1 -->
                <div class="box yellowBorder">
                    <span class="title-box">Akü Garantisi</span>
                    <div class="money flex">
                        <span class="amount txtac value" style="display:block; width: 50%;"><?php echo count($arrAku); ?></span>
                        <span class="amount txtac" style="display:block; width: 50%;"><?php echo $aku_toplam_kayit; ?></span>
                    </div>
                    <div class="money-info flex">
                        <span class="amount txtac" style="display:block; width: 50%;">Bugün</span>
                        <span class="amount txtac" style="display:block; width: 50%;">Toplam</span>
                    </div>
                </div>
                <!-- box2 -->
                <div class="box greenBorder">
                    <span class="title-box">İş Garantisi</span>
                    <div class="money flex">
                        <span class="amount txtac" style="display:block; width: 50%;"><?php echo count($arrJob); ?></span>
                        <span class="amount txtac" style="display:block; width: 50%;"><?php echo $job_toplam_kayit; ?></span>
                    </div>
                    <div class="money-info flex">
                        <span class="amount txtac" style="display:block; width: 50%;">Bugün</span>
                        <span class="amount txtac" style="display:block; width: 50%;">Toplam</span>
                    </div>
                </div>
                <!-- box3 -->
                <div class="box blueBorder flex flex-jc-c flex-fdir-c">
                    <span class="title-box">Toplam Müşteri Borcu</span>
                    <div class="">
                        <div class="money">
                            <span class="amount txtac" style="display:block; "><?php echo $borcMusteri; ?> TL</span>
                        </div>
                        <div class="money-info">
                            <span class="amount txtac" style="display:block; ">Toplam</span>
                        </div>
                    </div>
                </div>
                <!-- box4 -->
                <div class="box box4 flex flex-jc-c flex-fdir-c">
                    <span class="title-box">Toplam Toptancı Borcu</span>
                    <div>
                        <div class="money">
                            <span class="amount txtac" style="display:block;"><?php echo $borcToptanci; ?> TL</span>
                        </div>
                        <div class="money-info">
                            <span class="amount txtac" style="display:block;">Toplam</span>
                        </div>
                    </div>
                </div>
                <!--box 5-->
                <div class="box pinkBorder">
                    <span class="title-box">Satış</span>
                    <div class="money flex">
                        <span class="amount txtac" style="display:block; width: 50%;"><?php echo $satislar; ?></span>
                        <span class="amount txtac" style="display:block; width: 50%;"><?php echo $sell_toplam_kayit; ?></span>
                    </div>
                    <div class="money-info flex">
                        <span class="amount txtac" style="display:block; width: 50%;">Bugün</span>
                        <span class="amount txtac" style="display:block; width: 50%;">Toplam</span>
                    </div>
                </div>
            </div>

            <div class="data-box table-1 yellowBorder">
                <div class="data-box-title flex flex-ai-c">
                <i class="fa-solid fa-battery-three-quarters"></i>
                    <h4>Akü Verileri</h4>
                </div>
                
                <div class="table" id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <table>
                        <thead>
                            <tr>
                                <td style="width: 100px;">Akü No</td>
                                <td>Ad Soyad</td>
                                <td style="width: 130px;">Başlangıç Tarihi</td>
                                <td style="width: 100px;">Bitiş Tarihi</td>
                                <td style="width: 120px;">Plaka</td>
                                <td>Marka</td>
                                <td style="width: 100px;">Amper</td>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <?php foreach($akuVerileri as $veri): ?>
                                    <?php $kayit = explode(" ",$veri['aku_kayit']) ?>
                                        <?php if($currentTime == $kayit[0]): ?>
                                            <tr>
                                                <td><?php echo $veri['aku_id']?></td>
                                                <td><?php echo $veri['musteri_adi'] . ' ' . $veri['musteri_soyadi']?></td>
                                                <td><?php echo $veri['aku_baslangic']?></td>
                                                <td><?php echo $veri['aku_bitis']?></td>
                                                <td><?php echo $veri['plaka']?></td>
                                                <td><?php echo $veri['marka']?></td>
                                                <td><?php echo $veri['amper']?><b><?php echo 'A' ?></b></td>
                                            </tr>
                                        <?php endif; ?>
                                <?php endforeach; ?>
                           
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="data-box table-2 greenBorder">
                <div class="data-box-title flex flex-ai-c">
                <i class="fa-solid fa-calculator"></i>
                    <h4>İş Garantisi Verileri</h4>
                </div>
                <div class="table myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <table>
                        <thead>
                            <tr>
                                <td style="width: 75px;">İş No</td>
                                <td>Ad Soyad</td>
                                <td>Başlangıç Tarihi</td>
                                <td>Bitiş Tarihi</td>
                                <td>Plaka</td>
                                <td>Araç Modeli</td>
                                <td>Bakiye</td>
                                <td>Açıklama</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $currentTime = date('Y-m-d');
                            ?>
                                <?php foreach($is_veri_cek as $veri): ?>
                                    <?php $kayit = explode(" ",$veri['job_kayit']) ?>
                                        <?php if($currentTime == $kayit[0]): ?>
                                            <tr>    
                                                <td style="width: 75px;"><?php echo $veri['job_id'] ?></td>
                                                <td><?php echo $veri['musteri_adi'] . ' ' . $veri['musteri_soyadi'] ?></td>
                                                <td><?php echo $veri['job_baslangic'] ?></td>
                                                <td><?php echo $veri['job_bitis'] ?></td>
                                                <td><?php echo $veri['plaka'] ?></td>
                                                <td><?php echo $veri['arac_model'] ?></td>
                                                <td><?php echo $veri['bakiye'] ?></td>
                                                <td><?php echo $veri['aciklama'] ?></td>
                                            </tr>
                                        <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="data-box table-3 blueBorder">
                <div class="data-box-title flex flex-ai-c">
                <i class="fa-solid fa-user-large"></i>
                    <h4>Müşteri Verileri</h4>
                </div>
                <div class="table" >
                    <table>
                        <thead>
                            <tr>
                                <td style="width:100px">Müşteri No</td>
                                <td>Ad Soyad</td>
                                <td style="width:150px">Tel</td>
                                <td style="width:300px">Adres</td>
                                <td style="width:170px">Kayıt Tarihi</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $currentTime = date('Y-m-d');
                            ?>
                                <?php foreach($user_verileri as $veri): ?>
                                    <?php $kayit = explode(" ",$veri['musteri_kayit']) ?>
                                        <?php if($currentTime == $kayit[0]): ?>
                                            <tr>    
                                                <td><?php echo $veri['musteri_id']?></td>
                                                <td><?php echo $veri['musteri_adi'] . ' ' . $veri['musteri_soyadi']?></td>
                                                <td><?php echo $veri['musteri_tel']?></td>
                                                <td><?php echo $veri['musteri_adres']?></td>
                                                <td><?php echo $veri['musteri_kayit']?></td>
                                            </tr>
                                        <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="data-box table-4 redBorder">
                <div class="data-box-title flex flex-ai-c">
                <i class="fa-solid fa-money-bill"></i>
                    <h4>Satış Verileri</h4>
                </div>
                <div class="table" >
                    <table>
                        <thead>
                            <tr>
                                <td>Satış No</td>
                                <td>Müşteri</td>
                                <td>Ürün Adı</td>
                                <td>Ürün Adedi</td>
                                <td>Toplam Ücret</td>
                            </tr>
                        </thead>
                        <tbody>
                                <?php foreach($verileri_cek_satis as $veri): ?>
                                    <?php $kayit = explode(" ",$veri['sell_kayit']) ?>
                                        <?php if($currentTime == $kayit[0]): ?>
                                            <tr>    
                                                <td><?php echo $veri['sell_id'] ?></td>
                                                <td><?php echo $veri['musteri'] ?></td>
                                                <td><?php echo $veri['urun'] ?></td>
                                                <td><?php echo $veri['urun_sayisi'] ?></td>
                                                <td><?php echo $veri['toplam_ucret']?></td>
                                            </tr>
                                        <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<script>

    function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelectorAll(".value").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "connection.php", true);
  xhttp.send();
}
setInterval(function(){
    loadXMLDoc();
},5000)
</script>
<?php require_once 'html_last.php' ?>
