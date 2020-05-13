<?php

    // function get_map_data() {
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

        $map_date = $_POST["map_date"];
    
        $sql = "select country_flags, country_name_en, total_cases, serious_critical, total_deaths, total_recovered from countries_backup 
                where DATE(date_backup) like '".$map_date."'";
        $map_data_sql = $con->prepare( $sql);
        $map_data_sql->execute();
        $map_tooltip_data = $map_data_sql->fetchall();
        if($map_tooltip_data) {
            echo json_encode($map_tooltip_data);
        } else {
            echo "0";
        }
    // }
    
?>
