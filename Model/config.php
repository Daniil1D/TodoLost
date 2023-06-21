<?php

$config = [
    'dbHost' => 'localhost',      
    'dbUsername' => 'root',       
    'dbPassword' => '',            
    'dbName' => 'Todo List',        
];

$link = mysqli_connect($config['dbHost'], $config['dbUsername'], $config['dbPassword'], $config['dbName']);
?>