<?php
Doo::loadCore('db/DooModel');

class Options extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $option_id;

    /**
     * @var varchar Max length is 64.
     */
    public $option_name;

    /**
     * @var longtext
     */
    public $option_value;

    /**
     * @var varchar Max length is 20.
     */
    public $autoload;

    public $_table = 'wp_options';
    public $_primarykey = 'option_id';
    public $_fields = array('option_id','option_name','option_value','autoload');

    public function getVRules() {
        return array(
                'option_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'optional' ),
                ),

                'option_name' => array(
                        array( 'maxlength', 64 ),
                        array( 'notnull' ),
                ),

                'option_value' => array(
                        array( 'notnull' ),
                ),

                'autoload' => array(
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                )
            );
    }

}