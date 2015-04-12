<?php
namespace LibreMVC\Mvc\Controller;
use LibreMVC\Http\Header;
use LibreMVC\Models\AjaxResponse;
use LibreMVC\Mvc\Controller;
use LibreMVC\View;
use LibreMVC\Http\Request;

class AjaxController extends ActionController{

    use Traits\Ajax;

    /**
     * @var bool
     */
    protected $_public = true;

    /**
     * @return boolean
     */
    public function isPublic()
    {
        return $this->_public;
    }

    private function setPublic(){}

    protected function init() {
        $this->setResponse(new AjaxResponse());
        /**
         * @todo : Empty layout ?
         */
        //$this->getView()->setEmptyLayout();
        $this->getResponse()->setData($this->getVo());
    }

}