<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 05/01/14
 * Time: 12:56
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing\UriParser;

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
        return ($this->segmentRoute->mandatory && $this->segmentUri->mandatory && ($this->segmentUri->segment === $this->segmentRoute->segment) );
    }

    public function isValidSegment(){
        return $this->valid;
    }

    public function isController() {
        return ($this->segmentRoute->segment === ":controller");
    }

    public function isAction() {
        return ($this->segmentRoute->segment === ":action");
    }

    public function isParam() {
        return ( ( strstr($this->segmentRoute->segment,':id') !== false ) ? true : false );
    }

    public function isInstance() {
        return ($this->segmentRoute->segment === ":instance");
    }

    public function getController() {
        return ($this->isController()) ? $this->segmentUri->segment : null;
    }

    public function getAction() {
        return ($this->isAction()) ? $this->segmentUri->segment : null;
    }

    public function getParam() {
        return ($this->isParam()) ? $this->segmentUri->segment : null;
    }

}