<?php
namespace LibreMVC\Mvc\Controller;
use LibreMVC\Http\Header;
use LibreMVC\Models\AjaxResponse;
use LibreMVC\View;

class AjaxController extends BaseController{

    /**
     * @var bool Le resultat de la requête doit il être mis en cache ?
     */
    protected $_cachable = false;
    /**
     * @var AjaxResponse L'objet de réponse
     */
    protected $_reply;

    public $_inputs;

    public function init() {
        $this->_reply = new AjaxResponse();
        // Réponse est elle cachable ?
        if( !$this->_cachable ) {
            Header::noCache();
        }
        $this->_view->setEmptyLayout();
        $this->negotiateHttpContentType();
        // Peuple.
        $this->initInputs();
    }

    protected function initInputs() {
        if( isset($_GET) && !empty($_GET) ) {
            $this->_inputs = $_GET;
        }
        else {
            parse_str(file_get_contents('php://input'), $this->_inputs);
        }


    }

    protected function negotiateHttpContentType() {
        switch($this->getRequest()->getHeader('Accept')) {
            case 'application/json':
                Header::json();
                break;

            case 'text/xml':
                Header::xml();
                break;
            default:
            case 'text/html':
                Header::html();
                break;

            case 'text/plain':
                Header::textPlain();
                break;
        }
    }

    public function __destruct() {
        switch($this->getRequest()->getHeader('Accept')) {

            case 'application/json':
                echo $this->_reply->toJson();
                break;

            case 'text/xml':
                echo $this->_reply->toXml();
                break;

            case 'text/html':
                echo $this->_reply->toHtml();
                break;

            default:
            case 'text/plain':
                echo $this->_reply->toString();
                break;
        }
    }
}