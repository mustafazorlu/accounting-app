<?php require_once 'html_first.php'; ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>

<?php

    $is_veri = $db->query('SELECT * FROM job ORDER BY job_id DESC');
    $is_veri_cek = $is_veri->fetchAll(PDO::FETCH_ASSOC);

    $currentTime = date('Y-m-d');
    // $currentTime = date("d/m/Y");
    // $currentTime = strtotime($currentTime);

    
    

    if(isset($_POST['job_data_add'])){
        $musteri_adi = isset($_POST['musteri_adi']) ? $_POST['musteri_adi'] : null;
        $musteri_soyadi = isset($_POST['musteri_soyadi']) ? $_POST['musteri_soyadi'] : null;
        $job_baslangic = isset($_POST['job_baslangic']) ? $_POST['job_baslangic'] : null;
        $job_bitis = isset($_POST['job_bitis']) ? $_POST['job_bitis'] : null;
        $plaka = isset($_POST['plaka']) ? $_POST['plaka'] : null;
        $arac_model = isset($_POST['arac_model']) ? $_POST['arac_model'] : null;
        $aciklama = isset($_POST['aciklama']) ? $_POST['aciklama'] : null;
        $bakiye = isset($_POST['bakiye']) ? $_POST['bakiye'] : null;

        $job_basla_mili = strtotime($job_baslangic);
        $job_bitis_mili = strtotime($job_bitis);
        
        //harfleri büyük yapma
        $musteri_adi = mb_convert_case($musteri_adi, MB_CASE_TITLE, "UTF-8");
        $musteri_soyadi = mb_convert_case($musteri_soyadi, MB_CASE_TITLE, "UTF-8");
        $aciklama = mb_convert_case($aciklama, MB_CASE_TITLE, "UTF-8");

        // $musteri_adi = ucwords($musteri_adi);
        // $musteri_soyadi = ucwords($musteri_soyadi);

        // $aciklama = ucfirst($aciklama);
        $plaka = strtoupper($plaka);
        

        

        $sorgu = $db->prepare('INSERT INTO job SET
            musteri_adi = ?,
            musteri_soyadi = ?,
            job_baslangic = ?,
            job_bitis = ?,
            plaka = ?,
            arac_model = ?,
            aciklama = ?,
            bakiye = ?
        ');
        $job_ekle = $sorgu->execute([
            $musteri_adi,
            $musteri_soyadi,
            $job_baslangic,
            $job_bitis,
            $plaka,
            $arac_model,
            $aciklama,
            $bakiye
        ]);

        if($job_ekle){
            header('location:pagination.php?page=job');
            exit;
        }
    }


?>
        <div class="main">
            <div class="info-boxes flex">
                <div class="box box1 battery-box" id="battery-data-import">
                    İş Garantisi İşlemi Ekle  
                </div>
            </div>

            <div class="data-box table-1 greenBorder">
                <div class="data-box-title flex flex-ai-c">
                <i class="fa-solid fa-calculator"></i>
                    <h4>İş Garantisi Verileri</h4> 
                </div>
                <div class="utility-box flex flex-ai-c flex-jc-sb">
                    
                   <div class="data-search-box">
                       <span style="color:#495057; font-size:14px">Ara :</span>
                       <input type="text" id="myInput" onkeyup='tableSearch()' placeholder="Müşteri ismi">
                   </div>
                </div>
                <div class="table" id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <table>
                        <thead>
                            <tr>
                               
                                <td style="width: 75px;">İş No</td>
                                <td>Ad Soyad</td>
                                <td></td>
                                <td>Başlangıç Tarihi</td>
                                <td>Bitiş Tarihi</td>
                                <td>Plaka</td>
                                <td>Araç Modeli</td>
                                <td>Bakiye</td>
                                <td style="width: 200px;">Açıklama</td>
                                <td class="txtac" style="width:100px">Düzenle</td>
                                <td class="txtac" style="width:75px">Sil</td>
                                <td style="width:20px"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($is_veri_cek as $veri): ?>
                            <tr>
                                
                                <td><?php echo $veri['job_id'] ?></td>
                                <td><?php echo $veri['musteri_adi'] . ' ' . $veri['musteri_soyadi']?></td>
                                <td style="width:20px; background-color:<?php echo $currentTime <= $veri['job_bitis'] ? '#3AC47D' : '#D92550'; ?>"></td>
                                <td><?php echo $veri['job_baslangic'] ?></td>
                                <td><?php echo $veri['job_bitis'] ?></td>
                                <td><?php echo $veri['plaka'] ?></td>
                                <td><?php echo $veri['arac_model'] ?></td>
                                <td><?php echo $veri['bakiye'] ?></td>
                                <td><?php echo $veri['aciklama'] ?></td>
                                <td class="txtac"><a href="pagination.php?page=update_job&job_id=<?php echo $veri['job_id'];?>" class="update">Düzenle</a></td>
                                <td class="txtac"><a href="pagination.php?page=delete_job&job_id=<?php echo $veri['job_id'];?>" class="delete">Sil</a></td>
                                <td style="background-color:<?php $currentTime >= $job_basla_mili && $currentTime < $job_bitis_mili ? 'green' : 'red'; ?>"></td>
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
                    <h3>İş Garantisi İşlemi Ekle</h3>
                    <div class="input">
                        <span>Adı :</span>
                        <input type="text" required name="musteri_adi">
                    </div>
                    <div class="input">
                        <span>Soyadı :</span>
                        <input type="text" required name="musteri_soyadi">
                    </div>
                    <div class="input">
                        <span>Başlangıç Tarihi :</span>
                        <input type="date" required name="job_baslangic">
                    </div>
                    <div class="input">
                        <span>Bitiş Tarihi :</span>
                        <input type="date" required name="job_bitis">
                    </div>
                    <div class="input">
                        <span>Plaka :</span>
                        <input type="text" required name="plaka">
                    </div>
                    <div class="input">
                        <span>Araç Modeli :</span>
                        <input type="text" required name="arac_model">
                    </div>
                    <div class="input">
                        <span>Bakiye :</span>
                        <input type="number" required name="bakiye">
                    </div>
                    <div class="input txtarea flex">
                        <span>Açıklama :</span>
                        <textarea name="aciklama" id="" cols="30" rows="10" required maxlength="150"></textarea>
                    </div>
                    <input type="hidden" name="job_data_add">
                    <button href="" class="btn battery-btn" type="submit">Ekle</button>
                </form>
            </div>
        </div>
        <?php require_once 'html_last.php'; ?>