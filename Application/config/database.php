<?php
    try
    {
        $PDO =  new PDO('mysql:host=localhost;dbname=kilimo', 'root', '');        //access for XAMP
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }	catch (PDOException $e){
        echo $e->getMessage();
        exit();
    }
?>