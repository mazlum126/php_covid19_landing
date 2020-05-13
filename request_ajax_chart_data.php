<?php

    $chart_date = $_POST["chart_date"];

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

    $daily_cases = array();
    $daily_serious = array();
    $daily_deaths = array();
    $daily_recovered = array();

    $cases_sql = $con->prepare("SELECT sum(total_cases) as all_cases FROM `countries_backup` where DATEDIFF('".$chart_date."', DATE(date_backup)) < 10 group by DATE(date_backup)");
    $cases_sql->execute();
    $daily_cases = $cases_sql->fetchall();

    $serious_sql = $con->prepare("SELECT sum(serious_critical) as all_serious FROM `countries_backup` where DATEDIFF('".$chart_date."', DATE(date_backup)) < 10 group by DATE(date_backup)");
    $serious_sql->execute();
    $daily_serious = $serious_sql->fetchall();

    $deaths_sql = $con->prepare("SELECT sum(total_deaths) as all_deaths FROM `countries_backup` where DATEDIFF('".$chart_date."', DATE(date_backup)) < 10 group by DATE(date_backup)");
    $deaths_sql->execute();
    $daily_deaths = $deaths_sql->fetchall();

    $recovered_sql = $con->prepare("SELECT sum(total_recovered) as all_recovered FROM `countries_backup` where DATEDIFF('".$chart_date."', DATE(date_backup)) < 10 group by DATE(date_backup)");
    $recovered_sql->execute();
    $daily_recovered = $recovered_sql->fetchall();

    $date_sql = $con->prepare("SELECT DATE(date_backup) as date FROM `countries_backup` where DATEDIFF('".$chart_date."', DATE(date_backup)) < 10 group by DATE(date_backup)");
    $date_sql->execute();
    $lb_date = $date_sql->fetchall();

    $result_array = array($daily_cases, $daily_serious, $daily_deaths, $daily_recovered, $lb_date);

    echo json_encode($result_array);
   

?>
