<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  mailerController.
*     Brief               :  Controller for mailer.
*     Date                :  20.05.2020.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/swiftmailer5/lib/swift_required.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/config/config.php';
//Class mailer
class TMailerController{

    private static $instance; 
    private function __construct(){}
    private function __clone(){}
    public static function init(){
        if(!self::$instance){
            
        }
        return self::$instance;          
    }
    /**
     * @brief Send mail function 
     * 
     * @param string $subject mail subject
     * @param string $userEmail user email
     * @param string $body html body for the mail
     * 
     * @return bool true if the mail's send, else false
     */
    public static function sendMail(string $subject, string $userEmail, string $body) : bool{       

            try {
                $instance = Swift_SmtpTransport::newInstance(EMAIL_SERVER, EMAIL_PORT, EMAIL_TRANS)
                ->setUsername(EMAIL_USERNAME)
                ->setPassword(EMAIL_PASSWORD);
                $mailer = Swift_Mailer::newInstance($instance);
                $message = Swift_Message::newInstance();
                $message->setSubject($subject);
                $message->setFrom(array('thomasfujise13@gmail.com' => 'Thomas Fujise'));
                $message->setTo($userEmail);
            
                $message->setBody($body,'text/html');
                $result = $mailer->send($message);
                return true;
            } catch (Swift_TransportException $e) {
                echo "Problème d'envoi de message: ".$e->getMessage();
                return false;
            }
        
    }
    /**
     * @brief Get the activation mail body 
     * 
     * @param string $token the token activation
     * 
     * @return string activation mail body
     */
    public static function getActivationMail(string $token) : string{
        $body = <<<EOT
        <html> 
            <head></head>
            <body>
                <p>Veuillez cliquer sur le lien suivant : <a href="localhost/ProjectTPI/src/www/verified.php?token={$token}">Valider</a></p>
            </body>
        </html>
        EOT;   
        return $body;  
    } 

}

?>