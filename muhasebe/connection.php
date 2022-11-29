<?php

    try{
        $db = new PDO('mysql:host=localhost;dbname=u392945277_muhasebe;','root','');
    }catch(Exception $e){
        $e->getMessage();
	    echo $e;
    }

?>