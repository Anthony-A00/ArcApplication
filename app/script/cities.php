<?php
require('db.php'); //Base mySQL Connection

function search($db, $city){
    if(str_contains($city, ",")){

        $newcity = explode(',', $city);
        $state = strtoupper($newcity[1]);
        $city = ucfirst($newcity[0]);

        if(str_contains($newcity[1], ' ')){
            $new_str = str_replace(' ', '', $newcity[1]);
            $state = $new_str;
        }

        $result = $db->query("SELECT * FROM `city_info` WHERE `city` LIKE '{$city}' AND `state_code` LIKE '{$state}' LIMIT 1");
    }else{

        $result = $db->query("SELECT * FROM `city_info` WHERE `city` LIKE '{$city}' ORDER BY city ASC LIMIT 3");

    }
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}

if ($_GET['term']){
    $AllCities = search($db, $_GET['term']);
    $CityArray = array();
    foreach($AllCities as $Cities){
        $CityArray[] = $Cities['city'].", ".$Cities['state_code'];

    }
    echo json_encode($CityArray);
}

?>