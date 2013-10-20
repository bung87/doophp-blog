<?php
Doo::loadCore('db/DooModel');

class Comments extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $comment_ID;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $comment_post_ID;

    /**
     * @var tinytext
     */
    public $comment_author;

    /**
     * @var varchar Max length is 200.
     */
    public $comment_author_avatar;

    /**
     * @var varchar Max length is 100.
     */
    public $comment_author_email;

    /**
     * @var varchar Max length is 200.
     */
    public $comment_author_url;

    /**
     * @var varchar Max length is 100.
     */
    public $comment_author_IP;

    /**
     * @var datetime
     */
    public $comment_date;

    /**
     * @var datetime
     */
    public $comment_date_gmt;

    /**
     * @var text
     */
    public $comment_content;

    /**
     * @var int Max length is 11.
     */
    public $comment_karma;

    /**
     * @var varchar Max length is 20.
     */
    public $comment_approved;

    /**
     * @var varchar Max length is 255.
     */
    public $comment_agent;

    /**
     * @var varchar Max length is 20.
     */
    public $comment_type;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $comment_parent;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $user_id;

    public $_table = 'wp_comments';
    public $_primarykey = 'comment_ID';
    public $_fields = array('comment_ID','comment_post_ID','comment_author','comment_author_avatar','comment_author_email','comment_author_url','comment_author_IP','comment_date','comment_date_gmt','comment_content','comment_karma','comment_approved','comment_agent','comment_type','comment_parent','user_id');

    public function getVRules() {
        return array(
                'comment_ID' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'optional' ),
                ),

                'comment_post_ID' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'comment_author' => array(
                        array( 'notnull' ),
                ),

                'comment_author_avatar' => array(
                        array( 'maxlength', 200 ),
                        array( 'notnull' ),
                ),

                'comment_author_email' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'comment_author_url' => array(
                        array( 'maxlength', 200 ),
                        array( 'notnull' ),
                ),

                'comment_author_IP' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'comment_date' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'comment_date_gmt' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'comment_content' => array(
                        array( 'notnull' ),
                ),

                'comment_karma' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'comment_approved' => array(
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'comment_agent' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'comment_type' => array(
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'comment_parent' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'user_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                )
            );
    }

}