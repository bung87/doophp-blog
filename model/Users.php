<?php
Doo::loadCore('db/DooModel');

class Users extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $ID;

    /**
     * @var varchar Max length is 60.
     */
    public $user_login;

    /**
     * @var varchar Max length is 64.
     */
    public $user_pass;

    /**
     * @var varchar Max length is 50.
     */
    public $user_nicename;

    /**
     * @var varchar Max length is 100.
     */
    public $user_email;

    /**
     * @var varchar Max length is 100.
     */
    public $user_url;

    /**
     * @var datetime
     */
    public $user_registered;

    /**
     * @var varchar Max length is 60.
     */
    public $user_activation_key;

    /**
     * @var int Max length is 11.
     */
    public $user_status;

    /**
     * @var varchar Max length is 250.
     */
    public $display_name;

    public $_table = 'wp_users';
    public $_primarykey = 'ID';
    public $_fields = array('ID','user_login','user_pass','user_nicename','user_email','user_url','user_registered','user_activation_key','user_status','display_name');

    public function getVRules() {
        return array(
                'ID' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'optional' ),
                ),

                'user_login' => array(
                        array( 'maxlength', 60 ),
                        array( 'notnull' ),
                ),

                'user_pass' => array(
                        array( 'maxlength', 64 ),
                        array( 'notnull' ),
                ),

                'user_nicename' => array(
                        array( 'maxlength', 50 ),
                        array( 'notnull' ),
                ),

                'user_email' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'user_url' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'user_registered' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'user_activation_key' => array(
                        array( 'maxlength', 60 ),
                        array( 'notnull' ),
                ),

                'user_status' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'display_name' => array(
                        array( 'maxlength', 250 ),
                        array( 'notnull' ),
                )
            );
    }

}