<?php
    include 'connexionDB.php';

// Vérifie si un utilisateur existe dans la base de données
function userExist($login){
        $linkpdo = connexion_db();
        $requete = $linkpdo->prepare("SELECT count(*) FROM utilisateurs WHERE login = :login");
        $requete->execute(array('login'=>$login));
        $res = $requete->fetch();
        return $res[0] >= 1;
    }

// Récupère le mot de passe hashé d'un utilisateur
function getPassword($login){
        $linkpdo = connexion_db();
        $requete = $linkpdo->prepare("SELECT mdp FROM user WHERE login = :login");
        $requete->execute(array('login'=>$login));
        $res = $requete->fetch();
        if(!empty($res)){
            return $res['password'];
        }
    }

?>