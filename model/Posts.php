<?php
Doo::loadCore('db/DooModel');

class Posts extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $ID;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $post_author;

    /**
     * @var datetime
     */
    public $post_date;

    /**
     * @var datetime
     */
    public $post_date_gmt;

    /**
     * @var longtext
     */
    public $post_content;

    /**
     * @var text
     */
    public $post_title;

    /**
     * @var text
     */
    public $post_excerpt;

    /**
     * @var varchar Max length is 20.
     */
    public $post_status;

    /**
     * @var varchar Max length is 20.
     */
    public $comment_status;

    /**
     * @var varchar Max length is 20.
     */
    public $ping_status;

    /**
     * @var varchar Max length is 20.
     */
    public $post_password;

    /**
     * @var varchar Max length is 200.
     */
    public $post_name;

    /**
     * @var text
     */
    public $to_ping;

    /**
     * @var text
     */
    public $pinged;

    /**
     * @var datetime
     */
    public $post_modified;

    /**
     * @var datetime
     */
    public $post_modified_gmt;

    /**
     * @var longtext
     */
    public $post_content_filtered;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $post_parent;

    /**
     * @var varchar Max length is 255.
     */
    public $guid;

    /**
     * @var int Max length is 11.
     */
    public $menu_order;

    /**
     * @var varchar Max length is 20.
     */
    public $post_type;

    /**
     * @var varchar Max length is 100.
     */
    public $post_mime_type;

    /**
     * @var bigint Max length is 20.
     */
    public $comment_count;

    public $_table = 'wp_posts';
    public $_primarykey = 'ID';
    public $_fields = array('ID','post_author','post_date','post_date_gmt','post_content','post_title','post_excerpt','post_status','comment_status','ping_status','post_password','post_name','to_ping','pinged','post_modified','post_modified_gmt','post_content_filtered','post_parent','guid','menu_order','post_type','post_mime_type','comment_count');

    public function getVRules() {
        return array(
                'ID' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'optional' ),
                ),

                'post_author' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'post_date' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'post_date_gmt' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'post_content' => array(
                        array( 'notnull' ),
                ),

                'post_title' => array(
                        array( 'notnull' ),
                ),

                'post_excerpt' => array(
                        array( 'notnull' ),
                ),

                'post_status' => array(
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'comment_status' => array(
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'ping_status' => array(
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'post_password' => array(
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'post_name' => array(
                        array( 'maxlength', 200 ),
                        array( 'notnull' ),
                ),

                'to_ping' => array(
                        array( 'notnull' ),
                ),

                'pinged' => array(
                        array( 'notnull' ),
                ),

                'post_modified' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'post_modified_gmt' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'post_content_filtered' => array(
                        array( 'notnull' ),
                ),

                'post_parent' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'guid' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'menu_order' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'post_type' => array(
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'post_mime_type' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'comment_count' => array(
                        array( 'integer' ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                )
            );
    }

}