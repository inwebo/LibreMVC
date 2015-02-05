<?php
namespace LibreMVC\Mvc\Controller\AjaxController {

    use LibreMVC\Models\User;
    use LibreMVC\Mvc\Controller\AjaxController;
    use LibreMVC\Models\AjaxUser;

    class PrivateAjaxControllerException extends \Exception {}

    /**
     * Class PrivateAjaxController
     *
     * User, Key, Timestamp obligatoire dans la requête si est privée
     *
     * @package LibreMVC\Mvc\Controller\AjaxController
     */
    class PrivateAjaxController extends AjaxController{

        /**
         * @var bool
         */
        protected $_public = false;
        /**
         * @var AjaxUser
         */
        protected $_ajaxUser;
        /**
         * @var User
         */
        protected $_trustedUser;

        public function init(){
            parent::init();
            // Est privée.
            if(! $this->_public ) {
                // Fingerprinted
                if( $this->isFingerPrintedRequest() ) {
                    // Prépare une AjaxUser
                    $this->_ajaxUser = self::ajaxUserFactory($this->_inputs['User'], $this->_inputs['Key'],$this->_inputs['Timestamp']);
                    // Charge un utilisateur par sa clef
                    $this->_trustedUser = User::load($this->_inputs['User'],'login');
                    // Si trusted client exists
                    if( !is_null($this->_trustedUser) ) {
                        // Comparaison timestamp
                        if(
                            AjaxUser::hashTimestamp($this->_ajaxUser->publicKey,$this->_ajaxUser->timeStamp) ===
                            AjaxUser::hashTimestamp($this->_trustedUser->publicKey,$this->_ajaxUser->timeStamp)
                        ) {
                            // Clefs privées invalide
                            if( $this->comparePrivateKeys() === false) {
                                throw new PrivateAjaxControllerException('Wrong key !');
                            }
                        }
                        else {
                            throw new PrivateAjaxControllerException('Corrupted !');
                        }
                    }
                    else {
                        throw new PrivateAjaxControllerException('Unknown user');
                    }
                }
                else {
                    throw new PrivateAjaxControllerException('Private');
                }
            }
        }

        protected function comparePrivateKeys() {
            $_clientTempPrivate = User::hashPrivateKey(
                $this->_ajaxUser->user, $this->_ajaxUser->publicKey,
                $this->_trustedUser->passPhrase
            );

            return $_clientTempPrivate === $this->_trustedUser->privateKey;
        }

        static protected function ajaxUserFactory($user, $key, $timestamp){
            return new AjaxUser($user,$key,$timestamp);
        }

        public function indexAction(){
            var_dump(__METHOD__);
        }

        protected function isPublic() {
            return $this->_public;
        }

        protected function isFingerPrintedRequest() {
            return ( isset( $this->_inputs['User'] ) && isset( $this->_inputs['Key'] ) && isset( $this->_inputs['Timestamp'] ) );
        }

        protected function unauthorized() {
            header('HTTP/1.1 401 Unauthorized');
            $this->_ajaxResponse->msg ="Unauthorized acces";
            exit;
        }

    }
}