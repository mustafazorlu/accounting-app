<?php require_once 'html_first.php'; ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
                                    <!-- BURASI BATTERY AKÜ PHP -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
ob_start();

$aku_veri_sorgu = $db->query('SELECT * FROM battery ORDER BY aku_id DESC');
$akuVerileri = $aku_veri_sorgu->fetchAll(PDO::FETCH_ASSOC);

// $aku_id = $db->prepare('SELECT * FROM battery WHERE aku_id = ?');
// $aku_id->execute([
//     $_GET['aku_id']
// ]);
// $aku_id_cek = $aku_id->fetch(PDO::FETCH_ASSOC);

$currentTime = date('Y-m-d');
//$currentTime = strtotime($currentTime);

$hata = '';
if(isset($_POST['battery_add'])){
    $musteri_adi = isset($_POST['musteri_adi']) ? $_POST['musteri_adi'] : null;
    $musteri_soyadi = isset($_POST['musteri_soyadi']) ? $_POST['musteri_soyadi'] : null;
    $aku_baslangic = isset($_POST['aku_baslangic']) ? $_POST['aku_baslangic'] : null;
    $aku_bitis = isset($_POST['aku_bitis']) ? $_POST['aku_bitis'] : null;
    $plaka = isset($_POST['plaka']) ? $_POST['plaka'] : null;
    $marka = isset($_POST['marka']) ? $_POST['marka'] : null;
    $amper = isset($_POST['amper']) ? $_POST['amper'] : null;
    //harflerin bas harflerini büyük yapma
    $musteri_adi = mb_convert_case($musteri_adi, MB_CASE_TITLE, "UTF-8");
    $musteri_soyadi = mb_convert_case($musteri_soyadi, MB_CASE_TITLE, "UTF-8");

    

    
    $plaka = strtoupper($plaka);
    

    
    if(!$musteri_adi){
        $hata = 'Lütfen müşteri adını giriniz.';
    }elseif(!$musteri_soyadi){
        $hata = 'Lütfen müşteri soyadını giriniz.';
    }elseif(!$plaka){
        $hata = 'Lütfen plaka giriniz.';
    }elseif(!$marka){
        $hata = 'Lütfen marka giriniz.';
    }elseif(!$amper){
        $hata = 'Lütfen amper giriniz.';
    }else{
        $sorgu = $db->prepare('INSERT INTO battery SET
            musteri_adi = ?,
            musteri_soyadi = ?,
            aku_baslangic = ?,
            aku_bitis = ?,
            plaka = ?,
            marka = ?,
            amper = ?
        ');
        $aku_ekle = $sorgu->execute([
            $musteri_adi,
            $musteri_soyadi,
            $aku_baslangic,
            $aku_bitis,
            $plaka,
            $marka,
            $amper
        ]);

        if($aku_ekle){
            header('location:pagination.php?page=battery');
            exit;
        }
    }
}

?>

        <div class="main">
            <div class="info-boxes flex">
                <div class="box yellowBorder battery-box" id="battery-data-import">
                    Akü İşlemi Ekle
                </div>
            </div>

            <div class="data-box table-1 yellowBorder">
                <div class="data-box-title flex flex-ai-c">
                <i class="fa-solid fa-battery-three-quarters"></i>
                    <h4>Akü Verileri</h4>
                </div>
                <div class="utility-box flex flex-ai-c flex-jc-sb">
                    
                   <div class="data-search-box">
                       <span style="color:#495057; font-size:14px">Ara :</span>
                       <input type="text" id="myInput" onkeyup='tableSearch()' placeholder="Müşteri ismi">
                   </div>
                </div>
                <div class="table">
                    <table id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                        <thead>
                            <tr>
                                <td style="width: 100px;">Akü No</td>
                                <td>Ad Soyad</td>
                                <td></td>
                                <td style="width: 130px;">Başlangıç Tarihi</td>
                                <td style="width: 100px;">Bitiş Tarihi</td>
                                <td style="width: 120px;">Plaka</td>
                                <td>Marka</td>
                                <td style="width: 100px;">Amper</td>
                                <td class="txtac" style="width: 100px;">Düzenle</td>
                                <td class="txtac" style="width: 75px;">Sil</td>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                                <?php foreach($akuVerileri as $veri):?>
                                    <tr>
                                        <?php
                                            //$aku_baslangic_time = strtotime($veri['aku_baslangic']);
                                            //$aku_bitis_time = strtotime($veri['aku_bitis']);
                                            //echo $currentTime ." BİTİS ". $veri['aku_bitis'];
                                        ?>
                                        <td><?php echo $veri['aku_id']?></td>
                                        <td><?php echo $veri['musteri_adi'] . ' ' . $veri['musteri_soyadi']  ?></td>              
                                        <td style="width:20px; background-color:<?php echo $currentTime <= $veri['aku_bitis'] ? '#3AC47D' : '#D92550'; ?>"></td>
                                        <td><?php echo $veri['aku_baslangic']?></td>
                                        <td><?php echo $veri['aku_bitis']?></td>
                                        <td><?php echo $veri['plaka']?></td>
                                        <td><?php echo $veri['marka']?></td>
                                        <td><?php echo $veri['amper']?><b><?php echo 'A' ?></b></td>
                                        <td class="txtac"><a href="pagination.php?page=update_battery&aku_id=<?php echo $veri['aku_id'];?>" class="update">Düzenle</a></td>
                                        <td class="txtac"><a href="pagination.php?page=delete_battery&aku_id=<?php echo $veri['aku_id'];?>" class="delete">Sil</a></td>
                                        <!-- . ' ' .  $currentTime . ' ' . $contractDateBegin . ' ' . $contractDateEnd -->
                                    </tr>
                                <?php endforeach;?>
                            
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
                    <h3>Akü İşlemi Ekle</h3>
                    <div class="input">
                        <span>Adı :</span>
                        <input type="text" name="musteri_adi" required>
                    </div>
                    <div class="input" required>
                        <span>Soyadı :</span>
                        <input type="text" name="musteri_soyadi" required>
                    </div>
                    <div class="input" required>
                        <span>Başlangıç Tarihi :</span>
                        <input type="date" name="aku_baslangic" required>
                    </div>
                    <div class="input" required>
                        <span>Bitiş Tarihi :</span>
                        <input type="date" name="aku_bitis" required>
                    </div>
                    <div class="input" required>
                        <span>Plaka :</span>
                        <input type="text" name="plaka" required>
                    </div>
                    <div class="input" required>
                        <span>Marka :</span>
                        <input type="text" name="marka" required>
                    </div>
                    <div class="input" required>
                        <span>Amper :</span>
                        <input type="number" name="amper" required>
                    </div>
                    <input type="hidden" name="battery_add">
                    <button class="btn battery-btn" type="submit">Ekle</button>
                </form>
            </div>
        </div>

<?php require_once 'html_last.php' ?>


