<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 11/08/13
 * Time: 22:31
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing\UriParser;

//@todo todo !
class Segment {

    /**
     * @var string Segment de l'uri.
     */
    public $rawSegment;

    /**
     * @var string Segment de l'uri sans les []
     */
    public $segment;

    /**
     * @var bool Est il un segment obligatoire dans l'uri.
     */
    public $mandatory;

    /**
     * @var bool Si est un paramétre ( pour être un parametre il doit commencer par [:id
     */
    public $isParam;

    /**
     * @var mixed|null Si isNamed alors contient le nom du parametre
     */
    public $paramName;

    /**
     * @var bool Il y a t il une contrainte de type sur le segment courant.
     */
    public $isTyped;

    /**
     * @var null|string So isTyped alors le type doit être int|regex
     */
    public $type;

    /**
     * @var bool La contrainte du segment est validé par une regex.
     */
    public $isRegex;

    /**
     * @var string Une regex de validation du segment.
     */
    public $regex;

    /**
     * @param $segment string Un segment de l'URI.
     */
    public function __construct( $segment ) {
        $this->rawSegment       = $segment;
        $this->segment          = trim( $segment, '[]' );
        $this->mandatory        = $this->isMandatory();
        $this->isParam          = $this->isParam();
        $this->paramName        = ( $this->isParam ) ? $this->getParamName() : null;
        $this->isTyped          = $this->isTypedParam();
        $this->type             = ( $this->isTyped ) ? $this->getTypeParam() : null ;
        $this->isRegex          = $this->isRegex();
        $this->regex            = ( $this->isRegex ) ? $this->getRegex() : null ;
    }

    protected function isMandatory() {
        return !($this->rawSegment[0] === "[");
    }

    protected function isParam() {
        return ( strpos(  $this->segment, ':id|' ) !== false ) ? true :false;
    }

    protected function getParamName() {
        $segmentAsArray = explode( '|', $this->segment );
        $segment = $segmentAsArray[1];

        if( $this->isTypedParam() ) {
            $segment = preg_replace('#\({1}(regex|int)\){1}#','',$segment);
        }

        if( $this->isRegex() ) {
            $segment = preg_replace('#\#(.*)\##','',$segment);
        }

        return $segment;

    }

    protected function isTypedParam() {
        return (preg_match('#\({1}(.*)\){1}#', $this->segment) === 0) ? false : true;
    }

    protected function getTypeParam() {
        $_segment = preg_replace('#\#(.*)\##','',$this->segment);
        preg_match('#\((.*)\)#', $_segment,$match);
        if( isset($match[1]) ) {
            return $match[1];
        }
    }

    protected function isRegex() {
        return (bool)preg_match('#\#{1}(.*)\#{1}#', $this->segment);
    }

    protected function getRegex() {
        if( $this->isRegex() ) {
            preg_match('#\#{1}(.*)\#{1}#', $this->segment, $match);
            return $match[0];
        }
    }

    public function validateData( $data ) {
        switch( $this->type ) {
            default:
            case 'int':
                return !preg_match('#[a-zA-Z]#', $data );
                break;

            case 'regex':
                preg_match_all('#\#(.*)\##', $this->segment, $match);
                if(isset($match[0][0])) {
                    $result = preg_match($match[0][0], $data );
                    $this->regex = $match[0][0];
                    return ($result === 0) ? false : true;
                }
                else {
                    false;
                }
                break;
        }
    }



}