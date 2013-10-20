<?php
Doo::loadCore('db/DooModel');

class Postmeta extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $meta_id;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $post_id;

    /**
     * @var varchar Max length is 255.
     */
    public $meta_key;

    /**
     * @var longtext
     */
    public $meta_value;

    public $_table = 'wp_postmeta';
    public $_primarykey = 'meta_id';
    public $_fields = array('meta_id','post_id','meta_key','meta_value');

    public function getVRules() {
        return array(
                'meta_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'optional' ),
                ),

                'post_id' => array(
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