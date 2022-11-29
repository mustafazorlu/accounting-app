<?php require_once 'html_first.php' ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>

<?php 

    $user_veri_sorgu = $db->query('SELECT * FROM wholesaler ORDER BY toptanci_id DESC');
    $user_verileri = $user_veri_sorgu->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['wholesaler_add'])){
        $toptanci_adi = isset($_POST['toptanci_adi']) ? $_POST['toptanci_adi'] : null;
        $toptanci_soyadi = isset($_POST['toptanci_soyadi']) ? $_POST['toptanci_soyadi'] : null;
        $toptanci_tel = isset($_POST['toptanci_tel']) ? $_POST['toptanci_tel'] : null;
        $aciklama = isset($_POST['aciklama']) ? $_POST['aciklama'] : null;
        //harfleri büyük yapma
        $toptanci_adi = ucwords($toptanci_adi);
        $toptanci_soyadi = ucwords($toptanci_soyadi);
        $aciklama = ucwords($aciklama);

        $sorgu = $db->prepare('INSERT INTO wholesaler SET
            toptanci_adi = ?,
            toptanci_soyadi = ?,
            toptanci_tel = ?,
            aciklama = ?
        ');
        $veri_cek = $sorgu->execute([
            $toptanci_adi,
            $toptanci_soyadi,
            $toptanci_tel,
            $aciklama
        ]);

        if($veri_cek){
            header('location:pagination.php?page=wholesaler');
        }

    }

?>

<div class="main">
        <div class="info-boxes flex">
            <div class="box blueBorder battery-box" id="battery-data-import">
                Toptancı Ekle
            </div>
        </div>
        <div class="data-box table-1 blueBorder">
            <div class="data-box-title flex flex-ai-c">
            <i class="fa-solid fa-user-large"></i>
                <h4>Toptancı Verileri</h4>
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
                            <td style="width:100px">Toptancı No</td>
                            <td>Ad Soyad</td>
                            <td style="width:150px">Tel</td>
                            <td style="width:300px">Adres</td>
                            <td style="width:170px">Kayıt Tarihi</td>
                            <td class="txtac">Ayrıntılar</td>
                            <td style="width:100px" class="txtac">Düzenle</td>
                            <td style="width:75px" class="txtac">Sil</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($user_verileri as $veri): ?>
                        <tr>
                            <td><?php echo $veri['toptanci_id']?></td>
                            <td><?php echo $veri['toptanci_adi'] . ' ' . $veri['toptanci_soyadi']?></td>
                            <td><?php echo $veri['toptanci_tel']?></td>
                            <td><?php echo $veri['aciklama']?></td>
                            <td><?php echo $veri['toptanci_kayit']?></td>
                            <td class="txtac"><a href="pagination.php?page=detail_wholesaler&toptanci_id=<?php echo $veri['toptanci_id']?>" class="detail">Ayrıntılar</a></td>
                            <td class="txtac"><a href="pagination.php?page=update_wholesaler&toptanci_id=<?php echo $veri['toptanci_id']?>" class="update">Düzenle</a></td>
                            <td class="txtac"><a href="pagination.php?page=delete_wholesaler&toptanci_id=<?php echo $veri['toptanci_id']?>" class="delete">Sil</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    <div class="add-battery-box-overlay" id="overlay">
        <div class="add-battery-box  blueBorder">
            
            <form class="flex flex-fdir-c" method="post">
                <div class="times" id="times">
                <i class="fa-solid fa-xmark"></i>
                </div>
                <h3>Toptanci Ekle</h3>
                <div class="input">
                    <span>Adı :</span>
                    <input type="text" name="toptanci_adi" required>
                </div>
                <div class="input">
                    <span>Soyadı :</span>
                    <input type="text" name="toptanci_soyadi" required>
                </div>
                <div class="input">
                    <span>Tel :</span>
                    <input type="number" name="toptanci_tel" required>
                </div>
                <div class="input txtarea flex">
                    <span>Adres :</span>
                    <textarea cols="30" rows="10" name="aciklama" required maxlength="150"></textarea>
                </div>
                <input type="hidden" name="wholesaler_add">
                <button class="btn battery-btn" type="submit">Ekle</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'html_last.php' ?>