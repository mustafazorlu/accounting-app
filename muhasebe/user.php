<?php require_once 'html_first.php' ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
                                        <!-- BURASI USER KULLANICI PHP -->
<?php

    $user_veri_sorgu = $db->query('SELECT * FROM user ORDER BY musteri_id DESC');
    $user_verileri = $user_veri_sorgu->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['user_add'])){
        $musteri_adi = isset($_POST['musteri_adi']) ? $_POST['musteri_adi'] : null;
        $musteri_soyadi = isset($_POST['musteri_soyadi']) ? $_POST['musteri_soyadi'] : null;
        $musteri_tel = isset($_POST['musteri_tel']) ? $_POST['musteri_tel'] : null;
        $musteri_adres = isset($_POST['musteri_adres']) ? $_POST['musteri_adres'] : null;
        $musteri_aciklama = isset($_POST['musteri_aciklama']) ? $_POST['musteri_aciklama'] : null;
        
        //harfleri büyük yapma
        $musteri_adi = ucwords($musteri_adi);
        $musteri_soyadi = ucwords($musteri_soyadi);
        $musteri_adres = ucwords($musteri_adres);
        $musteri_aciklama = ucwords($musteri_aciklama);

        $sorgu = $db->prepare('INSERT INTO user SET
            musteri_adi = ?,
            musteri_soyadi = ?,
            musteri_tel = ?,
            musteri_adres = ?,
            musteri_aciklama = ?
        ');
        $user_ekle = $sorgu->execute([
            $musteri_adi,
            $musteri_soyadi,
            $musteri_tel,
            $musteri_adres,
            $musteri_aciklama
        ]);
        if($user_ekle){
            header('location:pagination.php?page=user');
            exit;
        }

    }


?>
    <div class="main">
        <div class="info-boxes flex">
            <div class="box blueBorder battery-box" id="battery-data-import">
                Müşteri Ekle
            </div>
        </div>
        <div class="data-box table-1 blueBorder">
            <div class="data-box-title flex flex-ai-c">
            <i class="fa-solid fa-user-group"></i>
                <h4>Müşteri Verileri</h4>
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
                            <td style="width:100px">Müşteri No</td>
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
                            <td><?php echo $veri['musteri_id']?></td>
                            <td><?php echo $veri['musteri_adi'] . ' ' . $veri['musteri_soyadi']?></td>
                            <td><?php echo $veri['musteri_tel']?></td>
                            <td><?php echo $veri['musteri_adres']?></td>
                            <td><?php echo $veri['musteri_kayit']?></td>
                            <td class="txtac"><a href="pagination.php?page=detail_user&musteri_id=<?php echo $veri['musteri_id']?>" class="detail">Ayrıntılar</a></td>
                            <td class="txtac"><a href="pagination.php?page=update_user&musteri_id=<?php echo $veri['musteri_id']?>" class="update">Düzenle</a></td>
                            <td class="txtac"><a href="pagination.php?page=delete_user&musteri_id=<?php echo $veri['musteri_id']?>" class="delete">Sil</a></td>
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
                <h3>Müşteri Ekle</h3>
                <div class="input">
                    <span>Adı :</span>
                    <input type="text" name="musteri_adi" required>
                </div>
                <div class="input">
                    <span>Soyadı :</span>
                    <input type="text" name="musteri_soyadi" required>
                </div>
                <div class="input">
                    <span>Tel :</span>
                    <input type="number" name="musteri_tel" required>
                </div>
                <div class="input txtarea flex">
                    <span>Adres :</span>
                    <textarea cols="30" rows="10" name="musteri_adres" maxlength="150"></textarea>
                </div>

                <div class="input txtarea flex">
                    <span>Açıklama :</span>
                    <textarea cols="30" rows="10" name="musteri_aciklama" maxlength="150"></textarea>
                </div>
                <input type="hidden" name="user_add">
                <button class="btn battery-btn" type="submit">Ekle</button>
            </form>
        </div>
    </div>
<?php require_once 'html_last.php' ?>