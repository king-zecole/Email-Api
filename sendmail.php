<?php
   

    session_cache_limiter( 'nocache' );
    header( 'Expires: ' . gmdate( 'r', 0 ) );
    header( 'Content-Type: application/json; charset=UTF-8' );
    header( 'Accept: application/json' );
    header( 'Access-Control-Allow-Methods: POST' );

    //echo file_get_contents('php://input'); // prints post request
    
    if(strtoupper($_SERVER['REQUEST_METHOD']) != "POST"){
        
      $result = array( 'response' => 'error', 'message'=> $_SERVER['REQUEST_METHOD'].' not Implemented');
      echo json_encode($result );
      die;
        
    }
    
    if($_SERVER['HTTP_ACCEPT'] != "application/json"){
        
        $result = array( 'response' => 'error', 'empty'=>'HTTP_ACCEPT', 'message'=>'<strong>Error!</strong> No http-accept header. Http-accept must be application/json' );
        echo json_encode($result );
        die;
    }
    
    $data = json_decode(file_get_contents("php://input"));
    
    if(
        !empty($data->to) &&
        !empty($data->subject) &&
        !empty($data->email) &&
        !empty($data->name) &&
        !empty($data->message)
    ){
    
    $to         = strip_tags($data->to); //put your email here

    $subject    = strip_tags($data->subject);
    $email      = strip_tags($data->email);
    $name       = strip_tags($data->name);
    $message    = nl2br( htmlspecialchars($data->message, ENT_QUOTES) );
    $result     = array();
    
    }else if(
        empty($data->to) &&
        empty($data->subject) &&
        empty($data->email) &&
        empty($data->name) &&
        empty($data->message)
    ){
        
        $result = array( 'response' => 'error', 'empty'=>'All Field', 'message'=>'<strong>Error!</strong> JSON post data is empty.' );
        echo json_encode($result );
        die;
    }


    if(empty($name)){

        $result = array( 'response' => 'error', 'empty'=>'name', 'message'=>'<strong>Error!</strong> Name is empty.' );
        echo json_encode($result );
        die;
    } 


    if(empty($subject)){

        $result = array( 'response' => 'error', 'empty'=>'name', 'message'=>'<strong>Error!</strong> Name is empty.' );
        echo json_encode($result );
        die;
    } 

    if(empty($email)){

        $result = array( 'response' => 'error', 'empty'=>'email', 'message'=>'<strong>Error!</strong> Email is empty.' );
        echo json_encode($result );
        die;
    } 

    if(empty($message)){

         $result = array( 'response' => 'error', 'empty'=>'message', 'message'=>'<strong>Error!</strong> Message body is empty.' );
         echo json_encode($result );
         die;
    }
    


    $headers  = "From: " . $name . ' <' . $email . '>' . "\r\n";
    $headers .= "Reply-To: ". $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";


    if ( mail( $to, $subject, $message, $headers ) ) {
        $result = array( 'response' => 'success', 'message'=>'<strong>Success!</strong> Mail Sent.' );
    } else {
        $result = array( 'response' => 'error', 'message'=>'<strong>Error!</strong> Cann\'t Send Mail.'  );
    }

    echo json_encode( $result );

    die;

?>
