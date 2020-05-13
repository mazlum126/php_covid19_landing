<?php

    $dsn = 'mysql:host=localhost;dbname=statsday_db';
    $user = 'root';
    $pass = '';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );
    try {
        $con = new PDO($dsn, $user, $pass, $option);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        echo 'Failed To Connect' . $e->getMessage();
    }

    $date = $_POST["date"];
    
    $table_sql = "";
    $sql = "";
    if ($date) {
        $sql = "SELECT * FROM `countries_backup` where DATE(date_backup) like '".$date."'";
        $table_sql = $con->prepare($sql);
        
    } else {
        $table_sql = $con->prepare("SELECT * FROM `countries_backup` where DATE(date_backup) like (select MAX(DATE(date_backup)) from countries_backup)");
    }
    $table_sql->execute();
    $data_table = $table_sql->fetchall();

    // echo $data_table;

    if($data_table){

        echo json_encode($data_table);
    } else {
        echo "0";
    }

?>
