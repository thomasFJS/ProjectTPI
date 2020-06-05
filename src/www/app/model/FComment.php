<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FComment.
*     Brief               :  Comment's model.
*     Date                :  28.05.2020.
*     Version             :  1.0.
*/

/**
 * Represents an comment.
 */
class FComment{
    
    /**
     * @brief Class constructor, create an comment with specified details
     * 
     * @param string $CommentParam comment's text
     * @param string $PostedAtParam comment's date 
     * @param FUser $UserParam comment's user
     */
    public function __construct(string $CommentParam = "", string $PostedAtParam = "", FUser $UserParam)
    {
        $this->Comment = $CommentParam;
        $this->PostedAt = $PostedAtParam;
        $this->User = $UserParam;
    } 
    /**
     * @var string comment's text
     */
    public $Comment;

    /**
     * @var string date and hour where the comment was posted
     */
    public $PostedAt;

    /**
     * @var FUser comment's owner
     */
    public $User;

}
?>