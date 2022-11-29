<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlham Oto Elektrik</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="image/favicon.ico">
</head>
<body style="width:100%; height:100vh" class="flex flex-jc-c flex-ai-c">
    

<div class="">
    <div class="add-battery-box-overlay data-update-overlay" id="overlay">
        <div class="add-battery-box flex data-update">
            <form class="flex flex-fdir-c" method="post" action="login_process.php">
                
                <h3>Giriş Yap</h3>
                <?php if(isset($_GET['error'])): ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php endif; ?>
                <div class="input">
                    <span>Kullanıcı Adı :</span>
                    <input type="text" name="k_adi">
                </div>
                <div class="input">
                    <span>Şifre :</span>
                    <input type="password" name="sifre">
                </div>

                <button class="btn battery-btn" type="submit">Giriş Yap</button>
            </form>
        </div>
    </div>
</div>



    <script src="js/script.js"></script>
</body>
</html>