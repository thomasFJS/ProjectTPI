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
    public static function sendMail($userEmail,$token){       

            try {
                $instance = Swift_SmtpTransport::newInstance(EMAIL_SERVER, EMAIL_PORT, EMAIL_TRANS)
                ->setUsername(EMAIL_USERNAME)
                ->setPassword(EMAIL_PASSWORD);
                $mailer = Swift_Mailer::newInstance($instance);
                $message = Swift_Message::newInstance();
                $message->setSubject('Account Validation');
                $message->setFrom(array('thomasfujise13@gmail.com' => 'Thomas Fujise'));
                $message->setTo($userEmail);
            
                $body = <<<EOT
                <html> 
                    <head></head>
                    <body>
                        <p>Veuillez cliquer sur le lien suivant : <a href="localhost/ProjectTPI/src/www/verified.php?token={$token}">Valider</a></p>
                    </body>
                </html>
                EOT;
                $message->setBody($body,'text/html');
                $result = $mailer->send($message);
            
            } catch (Swift_TransportException $e) {
                echo "Problème d'envoi de message: ".$e->getMessage();
                exit();
            }
        
    }
}

?>