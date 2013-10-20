<?php
Doo::loadCore('db/DooModel');

class TermTaxonomy extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $term_taxonomy_id;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $term_id;

    /**
     * @var varchar Max length is 32.
     */
    public $taxonomy;

    /**
     * @var longtext
     */
    public $description;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $parent;

    /**
     * @var bigint Max length is 20.
     */
    public $count;

    public $_table = 'wp_term_taxonomy';
    public $_primarykey = 'term_taxonomy_id';
    public $_fields = array('term_taxonomy_id','term_id','taxonomy','description','parent','count');

    public function getVRules() {
        return array(
                'term_taxonomy_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'optional' ),
                ),

                'term_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'taxonomy' => array(
                        array( 'maxlength', 32 ),
                        array( 'notnull' ),
                ),

                'description' => array(
                        array( 'notnull' ),
                ),

                'parent' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'count' => array(
                        array( 'integer' ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                )
            );
    }

}