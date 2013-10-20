<?php
Doo::loadCore('db/DooModel');

class Usermeta extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $umeta_id;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $user_id;

    /**
     * @var varchar Max length is 255.
     */
    public $meta_key;

    /**
     * @var longtext
     */
    public $meta_value;

    public $_table = 'wp_usermeta';
    public $_primarykey = 'umeta_id';
    public $_fields = array('umeta_id','user_id','meta_key','meta_value');

    public function getVRules() {
        return array(
                'umeta_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'optional' ),
                ),

                'user_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'meta_key' => array(
                        array( 'maxlength', 255 ),
                        array( 'optional' ),
                ),

                'meta_value' => array(
                        array( 'optional' ),
                )
            );
    }

}