<?php
    // Inclusion des fichiers nécessaires pour le JWT et les fonctions utilitaires
    include 'jwt_utils.php';
    include 'functions.php';

    // Récupération de la méthode HTTP utilisée pour la requête
    $http_method = $_SERVER['REQUEST_METHOD'];

    // Switch pour gérer les différentes méthodes HTTP
    switch ($http_method){
        case "POST" :
            // Récupération des données envoyées en POST
            $postedData = file_get_contents('php://input');
            $data = json_decode($postedData,true);
            
            // Extraction du login et du mot de passe
            $login = $data['login'];
            $mdp = $data['password'];

            //Vérification de si le login a été rentré sinon, envoi d'erreur personnalisé
            if (!isset($login)){
                deliver_response(400,"Un login doit être spécifié");
            } else {
                //Vérification de si le mot de passe a été rentré sinon, envoi d'erreur personnalisé
                if (!isset($mdp)){
                    deliver_response(400,"Un mot de passe doit être spécifié");
                } else {
                    // Vérification si l'utilisateur existe
                    if(userExist($login)){
                        // Vérification du mot de passe
                        if(password_verify($mdp,getPassword($login))){
                            // Création du JWT avec les informations nécessaires
                            $headers = array('alg'=>'HS256', 'typ'=>'JWT');
                            $payload = array('username'=>$login,'exp'=>(time()+1800));
                            $jwt = generate_jwt($headers,$payload,'supersecretdelamortquitue');
                            // Envoi de la réponse avec le JWT
                            deliver_response(200,"Connexion établie",$jwt);
                                
                        } else {
                            // Erreur si le mot de passe est incorrect
                            deliver_response(401,"Invalid password");
                        }
                    } else {
                        // Erreur si l'utilisateur n'existe pas
                        deliver_response(400,"Invalid user");
                    }
                }
            }
            break;
        case "GET":
            // Récupération du token JWT depuis l'en-tête Authorization
            $jeton = get_bearer_token();
            // Vérification de la validité du JWT
            if(is_jwt_valid($jeton,'supersecretdelamortquitue')){
                deliver_response(200,"Jeton valide");
            } else {
                deliver_response(418,"Jeton expiré ou invalide");
            }
            break;
        default:
            deliver_response(405,"Méthode non reconnue (L'authentification ne gère que GET et POST)");
            break;
    }

    /**
     * Fonction pour envoyer la réponse au format JSON
     * @param string $status_code Code de statut HTTP
     * @param string $status_message Message de statut
     * @param mixed $data Données à envoyer (optionnel)
     */
    function deliver_response($status_code, $status_message, $data=null){
        
        // Configuration des en-têtes CORS pour permettre l'accès depuis n'importe quelle origine
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        // Définition du code de statut HTTP
        http_response_code($status_code);
        
        // Configuration des en-têtes de la réponse
        header('Content-Type:application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        // Construction de la réponse
        $response['status_code'] = $status_code;
        $response['status_message'] = $status_message;
        $response['data'] = $data;

        // Conversion de la réponse en JSON
        $json_response = json_encode($response);
        if($json_response===false)
        die('json encode ERROR : '.json_last_error_msg());
        
        // Envoi de la réponse
        echo $json_response;
    }
?>