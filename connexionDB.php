<?php
    function connexion_db(){
        try {
            $linkpdo = new PDO("mysql:host=localhost;dbname=r401_api", "root", "");
            return $linkpdo;
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
?>