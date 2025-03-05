<?php
    include 'connexionDB.php';
    
function userExist($login){
        $linkpdo = connexion_db();
        $requete = $linkpdo->prepare("SELECT count(*) FROM user WHERE login = :login");
        $requete->execute(array('login'=>$login));
        $res = $requete->fetch();
        return $res[0] >= 1;
    }

    function getPassword($login){
        $linkpdo = connexion_db();
        $requete = $linkpdo->prepare("SELECT password FROM user WHERE login = :login");
        $requete->execute(array('login'=>$login));
        $res = $requete->fetch();
        if(!empty($res)){
            return $res['password'];
        }
    }

    function getRole($login){
        $linkpdo = connexion_db();
        $requete = $linkpdo->prepare("SELECT role FROM user WHERE login = :login");
        $requete->execute(array('login'=>$login));
        $res = $requete->fetch();
        return $res['role'];
    }
?>