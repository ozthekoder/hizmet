<?php
require_once './mandrill/Mandrill.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailManager
 *
 * @author osman ozdemir
 */
class EmailManager 
{
    public $mandrill;
    
    public function __construct() 
    {
        $this->mandrill = new Mandrill(MANDRILL_API_KEY);
    }
    
    public function sendMail($to_email, $to_name, $subject, $html)
    {
        $message = array(
            'subject'       => $subject,
            'from_email'    => 'no-reply@uchore.com',
            'to'            => array(array('email' => $to_email, 'name' => $to_name)),
            'html'          => $html
        );
        
        return $this->mandrill->messages->send($message);
    }
    
    public function sendConfirmationMail($user)
    {
        $email = $user->email;
        $name = $user->firstName . ' ' . $user->firstName;
        $subject = "Welcome to Uchore!";
        $html = "<p>Hi there $user->firstName!</p>";
        $html .= "<p>Welcome to Uchore. Please click the the comfirmation link below to activate your account.</p>";
        $html .= "<a>". EventManager::$base . "confirm-user/$user->hash</a>";
        return $this->sendMail($email, $name, $subject, $html);
    }
}

?>
