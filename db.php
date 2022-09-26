<?php

   require_once("db.php");
   
   $hostname = 'HOSTNAME';
   $database = 'DATABASE';
   $username = 'USERNAME';
   $password = 'PASSWORD';
   $charset = 'utf8mb4';   

   $dsn = "mysql:host={$hostname};dbname={$database};charset={$charset}";

   $cfg = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES => FALSE,
   ];

   try {
    $pdo = new PDO($dsn,$username,$password,$cfg);
   } catch(Exception $ex) {
    throw new \PDOException($ex->getMessage,intval($ex->getCode()));
   }