<?php
Doo::loadCore('db/DooModel');

class Terms extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $term_id;

    /**
     * @var varchar Max length is 200.
     */
    public $name;

    /**
     * @var varchar Max length is 200.
     */
    public $slug;

    /**
     * @var bigint Max length is 10.
     */
    public $term_group;

    public $_table = 'wp_terms';
    public $_primarykey = 'term_id';
    public $_fields = array('term_id','name','slug','term_group');

    public function getVRules() {
        return array(
                'term_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'optional' ),
                ),

                'name' => array(
                        array( 'maxlength', 200 ),
                        array( 'notnull' ),
                ),

                'slug' => array(
                        array( 'maxlength', 200 ),
                        array( 'notnull' ),
                ),

                'term_group' => array(
                        array( 'integer' ),
                        array( 'maxlength', 10 ),
                        array( 'notnull' ),
                )
            );
    }

}