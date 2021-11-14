<?php
require('db.php');

if(isset($_POST['search']))
{
    $name = explode(', ', $_POST['search']);
    $city = ucfirst($name[0]);
    $state = strtoupper($name[1]);
    $result = $db->query("SELECT * FROM `city_info` WHERE `city`='{$city}' AND `state_code`='{$state}'");
    $return = $result->fetch_array(MYSQLI_ASSOC);
    $data = array(
        'success' => 1,
        'message' => json_encode($return)
    );
    echo json_encode($data);
}


?>