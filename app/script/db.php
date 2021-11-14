<?php
    $user = array(
    'user'=>'root',
    'pass'=>'',
    'db'=>'sorc',
    'ip'=>'localhost'
    );
    $db = new mySQLi($user['ip'], $user['user'], $user['pass'], $user['db']) or die($db);

?>