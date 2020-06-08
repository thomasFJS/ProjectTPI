<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  FMailerManager.
*     Brief               :  mailer's manager.
*     Date                :  20.05.2020.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/swiftmailer5/lib/swift_required.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/config/config.php';
//Class mailer, contains all function for the mailer 
class FMailerManager{

    /**
     * @var static $instance the instance for the manager 
     * */
    private static $instance; 

    private function __construct(){}
    private function __clone(){}
    /**
     * @brief Create the initial instance for the manager or get it
     * @return $instance
     */
    public static function getInstance(){
        if(!self::$instance){
            self::$instance = Swift_SmtpTransport::newInstance(EMAIL_SERVER, EMAIL_PORT, EMAIL_TRANS)
            ->setUsername(EMAIL_USERNAME)
            ->setPassword(EMAIL_PASSWORD);
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
    public static function sendMail(string $subject, array $userEmail, string $body) : bool{       

            try {
                $instance = self::getInstance();
                $mailer = Swift_Mailer::newInstance($instance);
                $message = Swift_Message::newInstance();
                $message->setSubject($subject);
                $message->setFrom(array('travler.infos@gmail.com' => 'Travler Infos'));
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
    public static function getActivationMail(string $token, string $userEmail) : string{
        $body = <<<EOT
        <html> 
            <head></head>
            <body>
                <p>Hello,</p>
                </br>
                <p>Thank's for the interest you had for our website, please click on the following link to finalize your account activation : <a href="localhost/ProjectTPI/src/www/verified.php?token={$token}&email={$userEmail}">Activate</a></p>
                </br>
                <p>Sincerely,</p>
                <p>Team Travler</p>
            </body>
        </html>
        EOT;   
        return $body;  
    } 
    /**
     * @brief Get the mail body for owner when a user comment his itinerary
     * 
     * @param string $comment the comment the user posted 
     * @param string $nicknameUser user's nickname of the user who posted the comment
     * @param string $itineraryTitle itinerary's title
     * 
     * @return string  mail body
     */
    public static function getCommentAddMail(string $comment, string $nicknameUser, string $itineraryTitle) : string{
        $body = <<<EOT
        <html> 
            <head></head>
            <body>
                <p>Hello,</p>
                </br>
                <p>The user <b>{$nicknameUser}</b> comment your itinerary <b>{$itineraryTitle}</b> with the following comment : <i>{$comment}</i>.</p>
                <p>Feel free to check it by yourself on your itinerary page</p>
                </br>
                <p>Sincerely,</p>
                <p>Team Travler</p>
            </body>
        </html>
        EOT;   
        return $body;  
    } 
    
    /**
     * @brief Get the mail body for user when his account is blocked by an admin
     * 
     * 
     * @return string  mail body
     */
    public static function getDisableAccountMail() : string{
        $body = <<<EOT
        <html> 
            <head></head>
            <body>
                <p>Hello,</p>
                </br>
                <p>Your account has been suspend by an administrator for an indefinite period.</p>
                <p>From now on you can't login with your account on our website</p>
                </br>
                <p>Sincerely,</p>
                <p>Team Travler</p>
            </body>
        </html>
        EOT;   
        return $body;  
    } 
    
    /**
     * @brief Get the mail body for user when his itinerary is blocked by an admin
     * 
     * @param string $title the title of the itinerary
     * 
     * @return string  mail body
     */
    public static function getDisableItineraryMail($title) : string{
        $body = <<<EOT
        <html> 
            <head></head>
            <body>
                <p>Hello,</p>
                </br>
                <p>Your itinerary : {$title} has been suspend by an administrator for an indefinite period.</p>
                <p>From now on your itinerary cant be seen on our website</p>
                </br>
                <p>Sincerely,</p>
                <p>Team Travler</p>
            </body>
        </html>
        EOT;   
        return $body;  
    } 


}

?>