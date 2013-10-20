<?php
Doo::loadCore('db/DooModel');

class TermRelationships extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $object_id;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $term_taxonomy_id;

    /**
     * @var int Max length is 11.
     */
    public $term_order;

    public $_table = 'wp_term_relationships';
    public $_primarykey = 'term_taxonomy_id';
    public $_fields = array('object_id','term_taxonomy_id','term_order');

    public function getVRules() {
        return array(
                'object_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'term_taxonomy_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'term_order' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                )
            );
    }

}