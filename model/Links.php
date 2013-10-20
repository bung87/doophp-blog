<?php
Doo::loadCore('db/DooModel');

class Links extends DooModel{

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $link_id;

    /**
     * @var varchar Max length is 255.
     */
    public $link_url;

    /**
     * @var varchar Max length is 255.
     */
    public $link_name;

    /**
     * @var varchar Max length is 255.
     */
    public $link_image;

    /**
     * @var varchar Max length is 25.
     */
    public $link_target;

    /**
     * @var varchar Max length is 255.
     */
    public $link_description;

    /**
     * @var varchar Max length is 20.
     */
    public $link_visible;

    /**
     * @var bigint Max length is 20.  unsigned.
     */
    public $link_owner;

    /**
     * @var int Max length is 11.
     */
    public $link_rating;

    /**
     * @var datetime
     */
    public $link_updated;

    /**
     * @var varchar Max length is 255.
     */
    public $link_rel;

    /**
     * @var mediumtext
     */
    public $link_notes;

    /**
     * @var varchar Max length is 255.
     */
    public $link_rss;

    public $_table = 'wp_links';
    public $_primarykey = 'link_id';
    public $_fields = array('link_id','link_url','link_name','link_image','link_target','link_description','link_visible','link_owner','link_rating','link_updated','link_rel','link_notes','link_rss');

    public function getVRules() {
        return array(
                'link_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'optional' ),
                ),

                'link_url' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'link_name' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'link_image' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'link_target' => array(
                        array( 'maxlength', 25 ),
                        array( 'notnull' ),
                ),

                'link_description' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'link_visible' => array(
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'link_owner' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),

                'link_rating' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'link_updated' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'link_rel' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'link_notes' => array(
                        array( 'notnull' ),
                ),

                'link_rss' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                )
            );
    }

}