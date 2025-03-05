<?php
    include 'jwt_utils.php';
    include 'functions.php';

    $http_method = $_SERVER['REQUEST_METHOD'];
    switch ($http_method){
        case "POST" :
            $postedData = file_get_contents('php://input');
            $data = json_decode($postedData,true);
            
            $login = $data['login'];
            $mdp = $data['password'];

            if(userExist($login)){

                if(password_verify($mdp,getPassword($login))){
                    $headers = array('alg'=>'HS256', 'typ'=>'JWT');
                    $payload = array('username'=>$login,'role'=>getRole($login),'exp'=>(time()+120));
                    $jwt = generate_jwt($headers,$payload,'supersecretdelamortquitue');
                    deliver_response("200","Connexion établie",$jwt);
                        
                } else {
                    deliver_response("401","Invalid password");
                }
            } else {
                deliver_response("400","Invalid user");
            }
            break;
        case "GET":
            $jeton = get_bearer_token();
            if(is_jwt_valid($jeton,'supersecretdelamortquitue')){
                deliver_response("200","Jeton valide");
            } else {
                deliver_response("400","Jeton expiré ou invalide");
            }
            break;
    }

    function deliver_response($status_code, $status_message, $data=null){
        
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        /// Paramétrage de l'entête HTTP
        http_response_code($status_code);
        
        header('Content-Type:application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $response['status_code'] = $status_code;
        $response['status_message'] = $status_message;
        $response['data'] = $data;
        /// Mapping de la réponse au format JSON
        $json_response = json_encode($response);
        if($json_response===false)
        die('json encode ERROR : '.json_last_error_msg());
        /// Affichage de la réponse (Retourné au client)
        echo $json_response;
        }
?>