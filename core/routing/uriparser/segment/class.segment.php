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
    public $isNamed;

    /**
     * @var mixed|null Si isNamed alors contient le nom du parametre
     */
    public $name;

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
     * @var bool Le segment valide t il la contrainte de type.
     */
    public $validateType;

    /**
     * @var bool Est il un segment valide.
     */
    public $valid = false;

    /**
     * @param $segment string Un segment de l'URI.
     */
    public function __construct( $segment ) {
        $this->rawSegment       = $segment;
        $this->mandatory        = $this->isMandatory();
        $this->segment          = trim( $segment, '[]' );
        $this->isNamed          = $this->isNamed();
        $this->name             = ( $this->isNamed() ) ? $this->getName()      : null;
        $this->isTyped          = $this->isTyped();
        $this->type             = ( $this->isTyped )   ? $this->getType()      : null ;
        $this->valid            = $this->isValid();
        $this->isRegex          = $this->isRegex();
    }

    /**
     * Le segment
     *
     * @return bool TRUE si est un parametre nomé.
     */
    protected function isNamed() {
        return ( strpos(  $this->segment, ':id|' ) !== false ) ? true :false;
    }

    protected function getName() {
        $name = explode( '|', $this->segment );

        if($this->isTyped()) {
            $name[1] = preg_replace('#\(.*\)#','',$name[1]);
        }
        if($this->isRegex()) {
            $name[1] = preg_replace('#\#(.*)\##','',$name[1]);
        }
        return $name[1];
    }

    protected function isTyped() {
        return (preg_match('#\({1}(.*)\){1}#', $this->segment) === 0) ? false : true;
    }

    protected function isMandatory() {
        return !($this->rawSegment[0] === "[");
    }

    protected function getType() {
        return $this->betweenChar(array('(',')'), $this->segment);
    }

    protected function validateType( $data ) {
        switch( $this->type ) {
            case 'int':
                return !preg_match('#[a-zA-Z]#', $data );
                break;

            case 'regex':
                preg_match_all("#\#(.*)\##", $this->segment, $match);
                $result = preg_match($match[0][0], $data );
                $this->regex = $match[0][0];
                return ($result === 0) ? false : true;
                break;
        }
    }

    protected function betweenChar( $char, $segment ) {
        $pos   = array();
        $pos[] = strpos($this->segment, $char[0]);
        $pos[] = strpos($this->segment, $char[1]);
        return substr( $this->segment, $pos[0] + 1, ( $pos[1] - $pos[0] ) -1 );
    }

    protected function isRegex() {
        return (bool)preg_match("#\#(.*)\##", $this->segment);
    }

    protected function isValid() {
        return $this->validateType ;
    }

}