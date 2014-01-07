<?php
namespace LibreMVC\Routing\UriParser;

//<editor-fold desc="Licence">
    /**
     * LibreMVC
     *
     * LICENCE
     *
     * You are free:
     * to Share ,to copy, distribute and transmit the work to Remix —
     * to adapt the work to make commercial use of the work
     *
     * Under the following conditions:
     * Attribution, You must attribute the work in the manner specified by
     * the author or licensor (but not in any way that suggests that they
     * endorse you or your use of the work).
     *
     * Share Alike, If you alter, transform, or build upon
     * this work, you may distribute the resulting work only under the
     * same or similar license to this one.
     *
     *
     * @category  LibreMVC
     * @package   LibreMVC\Routing
     * @copyright Copyright (c) 2005-2014 Inwebo (http://www.inwebo.net)
     * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
     * @version   $Id:$
     * @link      https://github.com/inwebo/LibreMVC/tree/master/core/routing
     * @since     File available since Beta 01-01-2012
     */
//</editor-fold>

use LibreMVC\Routing\UriParser\Segment;
use LibreMVC\Routing\UriParser\SegmentConstraint\SegmentComparable;

class SegmentConstraint implements SegmentComparable {

    protected $valid;
    protected $segmentUri;
    protected $segmentRoute;

    public function __construct( Segment $segmentUri, Segment $segmentRoute ) {
        $this->valid        = false;
        $this->segmentUri   = $segmentUri;
        $this->segmentRoute = $segmentRoute;
    }

    public function isValidMandatory() {
        return ($this->segmentRoute->isMandatory() && ($this->segmentUri->getSegment() === $this->segmentRoute->getSegment()) );
    }

    public function isValidSegment(){
        return $this->valid;
    }

    public function isController() {
        return ($this->segmentRoute->getSegment() === ":controller");
    }

    public function isAction() {
        return ($this->segmentRoute->getSegment() === ":action");
    }

    public function isParam() {
        return ( ( strstr($this->segmentRoute->getSegment(),':id') !== false ) ? true : false );
    }

    public function isInstance() {
        return ($this->segmentRoute->getSegment() === ":instance");
    }

    public function getController() {
        return ($this->isController()) ? $this->segmentUri->getSegment() : null;
    }

    public function getAction() {
        return ($this->isAction()) ? $this->segmentUri->getSegment() : null;
    }

    public function getParam() {
        return ($this->isParam()) ? $this->segmentUri->getSegment() : null;
    }

}