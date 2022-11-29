<?php require_once 'html_first.php' ?>
<?php 

if(empty($_SESSION['k_adi']) && empty($_SESSION['id'])){
    header('location:login.php');
}

?>
                                    <!-- BURASI STORAGE STOK PHP -->

<?php

    $stok_verileri = $db->query('SELECT * FROM storage ORDER BY stok_id DESC');
    $veri_goster = $stok_verileri->fetchAll(PDO::FETCH_ASSOC);

    $marka_verileri = $db->query('SELECT * FROM brands');
    $marka_cek = $marka_verileri->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['add_storage'])){
        $stok_no = isset($_POST['stok_no']) ? $_POST['stok_no'] : null;
        $urun_adi = isset($_POST['urun_adi']) ? $_POST['urun_adi'] : null;
        $urun_markasi = isset($_POST['urun_markasi']) ? $_POST['urun_markasi'] : null;
        $urun_adedi = isset($_POST['urun_adedi']) ? $_POST['urun_adedi'] : null;
        $urun_pesin = isset($_POST['urun_pesin']) ? $_POST['urun_pesin'] : null;
        $urun_veresiye = isset($_POST['urun_veresiye']) ? $_POST['urun_veresiye'] : null;

        //harfleri büyük yapma
        $urun_adi = mb_convert_case($urun_adi, MB_CASE_TITLE, "UTF-8");

        $stok_veri = $db->prepare('INSERT INTO storage SET
            stok_no = ?,
            urun_adi = ?,
            urun_markasi = ?,
            urun_adedi = ?,
            urun_pesin = ?,
            urun_veresiye = ?
        ');
        $stok_ekle = $stok_veri->execute([
            $stok_no,
            $urun_adi,
            $urun_markasi,
            $urun_adedi,
            $urun_pesin,
            $urun_veresiye
        ]);

        if($stok_ekle){
            header('location:pagination.php?page=storage');
        }
    }

?>
        <div class="main">
            <div class="info-boxes flex">
                <div class="box redBorder battery-box storage-add" id="battery-data-import">
                    Stok Ekle
                </div>
                <div class="box redBorder battery-box storage-delete" id="storage_all_delete">
                    Stok Toplu Sil
                </div>
                <div class="box redBorder battery-box storage-delete" id="brand-overlay-btn">
                    Marka Ekle/Sil
                </div>
                <div class="box redBorder battery-box storage-delete" id="product_percent">
                    Ürün Fiyatı Azaltma Arttırma
                </div>
                <div class="box redBorder battery-box storage-delete" id="zekatbuton">
                    Ürünlerin Toplam Tutarı
                </div>
            </div>

            <div class="data-box table-1 redBorder">
                <div class="data-box-title flex flex-ai-c">
                <i class="fa-solid fa-box"></i>
                    <h4>Stok Verileri</h4>
                </div>
                <div class="utility-box flex flex-ai-c flex-jc-sb">
                    
                   <div class="data-search-box">
                       <span style="color:#495057; font-size:14px">Ara :</span>
                       <input type="text" class="search" placeholder="Müşteri ismi" id="myInput" onkeyup='tableSearch()'>
                   </div>
                </div>
                <div class="table">
                    <table id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                        <thead>
                            <tr>
                                <td>Stok No</td>
                                <td>Ürün Adı</td>
                                <td>Marka</td>
                                <td>Ürün Adedi</td>
                                <td>Peşin Fiyatı</td>
                                <td>Veresiye Fiyatı</td>
                                <td style="width:100px" class="txtac">Düzenle</td>
                                <td style="width:75px" class="txtac">Sil</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($veri_goster as $veri):?>
                            <tr>
                                <td style="width: 150px;"><?php echo $veri['stok_no'];?></td>
                                <td><?php echo $veri['urun_adi'];?></td>
                                <td><?php echo $veri['urun_markasi'];?></td>
                                <td style="width: 125px;"><?php echo $veri['urun_adedi'];?></td>
                                <td style="width: 125px;"><?php echo $veri['urun_pesin'] . '₺';?></td>
                                <td style="width: 150px;"><?php echo $veri['urun_veresiye'] . '₺';?></td>
                                <td class="txtac"><a href="pagination.php?page=update_storage&stok_id=<?php echo $veri['stok_id']?>" class="update">Düzenle</a></td>
                                <td class="txtac"><a href="pagination.php?page=delete_storage&stok_id=<?php echo $veri['stok_id']?>" class="delete">Sil</a></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <div class="add-battery-box-overlay" id="overlay">
            <div class="add-battery-box redBorder">
                
                <form class="flex flex-fdir-c" method="post">
                    <div class="times" id="times">
                    <i class="fa-solid fa-xmark"></i>
                    </div>
                    <h3>Stok Ekle</h3>
                    <div class="input">
                        <span>Stok No :</span>
                        <input type="text" name="stok_no" required >
                    </div>
                    <div class="input">
                        <span>Ürün Adı :</span>
                        <input type="text" name="urun_adi" required>
                    </div>
                    <div class="input">
                        <span>Marka :</span>
                        
                        <select name="urun_markasi" id="" required>
                            <?php foreach($marka_cek as $veri): ?>
                                <option value="<?php echo $veri['marka_adi']; ?>"><?php echo $veri['marka_adi']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input">
                        <span>Ürün Adedi :</span>
                        <input type="number" name="urun_adedi" required>
                    </div>
                    <div class="input">
                        <span>Peşin Fiyatı :</span>
                        <input type="number" name="urun_pesin" required>
                    </div>
                    <div class="input">
                        <span>Veresiye Fiyatı :</span>
                        <input type="number" name="urun_veresiye" required>
                    </div>
                    <input type="hidden" name="add_storage">
                    <button class="btn battery-btn" type="submit">Ekle</button>
                </form>
            </div>
        </div>

        <!-- marka ekleme -->

        <div class="add-battery-box-overlay" id="brand-overlay">
            <div class="add-battery-box redBorder">
                
                <form action="process.php" class="flex flex-fdir-c" method="post">
                    <div class="times" id="x">
                    <i class="fa-solid fa-xmark"></i>
                    </div>
                    <h3>Marka Ekle</h3>
                    <div class="input">
                        <span>Marka Adı :</span>
                        <input type="text" name="marka_adi" required>
                    </div>
                    <input type="hidden" name="add_brand">
                    <button class="btn battery-btn" type="submit">Ekle</button>
                </form>

                <form action="process.php" class="flex flex-fdir-c" method="post">
                    <h3>Marka Sil</h3>
                        <div class="input">
                            <select name="marka_adi" id="" required>
                                <?php foreach($marka_cek as $veri): ?>
                                    <option value="<?php echo $veri['marka_adi']; ?>"><?php echo $veri['marka_adi']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span style="margin-left:10px">markasını sil.</span>
                        </div>
                    <input type="hidden" name="delete_brand">
                    <button class="btn battery-btn" type="submit">Sil</button>
                </form>
            </div>
        </div>

        <!-- stok toplu silme -->

        <div class="add-battery-box-overlay" id="all_delete_overlay">
            <div class="add-battery-box redBorder">
                
                <form action="process.php" class="flex flex-fdir-c" method="post">
                    <div class="times" id="carpi">
                    <i class="fa-solid fa-xmark"></i>
                    </div>
                    <h3>Markaya Göre Toplu Sil</h3>

                    <div class="input">
                        <select name="urun_markasi" id="" required>
                            <?php foreach($marka_cek as $veri): ?>
                                <option value="<?php echo $veri['marka_adi']; ?>"><?php echo $veri['marka_adi']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span style="margin-left:10px">markalı ürünleri sil.</span>
                    </div>
                    
                    

                    <input type="hidden" name="delete_all">
                    <button class="btn battery-btn" type="submit">Sil</button>
                </form>
            </div>
        </div>

        <!-- urunleri yüzdelik arttırıp azaltma -->

        <div class="add-battery-box-overlay" id="product_price_box">
            <div class="add-battery-box redBorder">
                
                <form action="process.php" class="flex flex-fdir-c" method="post">
                    <div class="times" id="xisareti">
                    <i class="fa-solid fa-xmark"></i>
                    </div>
                    <h3>Fiyat Değiştir</h3>

                    <div class="input flex flex-ai-c">
                        <select name="urun_markasi" id="" required>
                            <?php foreach($marka_cek as $veri): ?>
                                <option value="<?php echo $veri['marka_adi']; ?>"><?php echo $veri['marka_adi']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span style="text-align:center; width:195px">ürünlerinin fiyatını yüzde</span>
                        <input type="number" style="width: 100px;" name="deger">
                    </div>
                    
                    

                    <div class="button_box flex flex-jc-c">
                        <button class="btn battery-btn" type="submit" name="azalt">Azalt</button>
                        <button class="btn battery-btn" type="submit" name="arttir">Arttır</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="add-battery-box-overlay" id="zekatBox">
            <div class="add-battery-box redBorder">
                
                <form action="process.php" class="flex flex-fdir-c" method="post">
                    <div class="times" id="xIsareti">
                    <i class="fa-solid fa-xmark"></i>
                    </div>
                    <h3>Ürünlerin Toplam Tutarı</h3>
                    <div class="txtac"><?php
                    
                            $toplamTutar = 0;
                            foreach($veri_goster as $veri){
                                if($veri['urun_adedi']>0){
                                    $toplamTutar += $veri['urun_adedi'] * $veri['urun_pesin'];
                                }
                            }
                            echo $toplamTutar . '₺';
                    
                    ?></div>

                    
                </form>
            </div>
        </div>

        

        
<?php require_once 'html_last.php' ?>