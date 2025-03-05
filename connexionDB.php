<?php
    function connexion_db(){
        try {
            $linkpdo = new PDO("mysql:host=mysql-authapi.alwaysdata.net;dbname=authapi_login", "authapi", "AuthApi!158");
            return $linkpdo;
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
?>