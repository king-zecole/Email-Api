<?php
   

    session_cache_limiter( 'nocache' );
    header( 'Expires: ' . gmdate( 'r', 0 ) );
    header( 'Content-type: application/json' );
    header( 'Accept: application/json' );

    //echo file_get_contents('php://input'); // prints post request
    
    if(strtoupper($_SERVER['REQUEST_METHOD']) != "POST"){
        
      $result = array( 'response' => 'error', 'message'=>'GET not Implemented');
      echo json_encode($result );
      die;
        
    }
    
    if($_SERVER['HTTP_ACCEPT'] != "application/json"){
        
        $result = array( 'response' => 'error', 'empty'=>'HTTP_ACCEPT', 'message'=>'<strong>Error!</strong> No http-accept header. Http-accept must be application/json' );
        echo json_encode($result );
        die;
    }
    
    $to             = strip_tags($_POST['to']); //put your email here

    $subject    = strip_tags($_POST['subject']);
    $email      = strip_tags($_POST['email']);
    $name       = strip_tags($_POST['name']);
    $message    = nl2br( htmlspecialchars($_POST['message'], ENT_QUOTES) );
    $result     = array();


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