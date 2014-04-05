<?php
namespace LibreMVC\View;
use LibreMVC\View\Interfaces\IDataProvider;

/**
 * Conteneur global des variables nécessaire aux templates.
 *
 * Singleton, permet d'éviter de polluer le namespace global avec les variables
 * des templates. C'est l'interface entre une vue & modéle. Toutes données qui
 * doivent être affichées devraient être définies dans le viewbag.
 *
 * @category   LibreMVC
 * @package    Views
 * @subpackage ViewBag
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @static
 */
class ViewBag implements IDataProvider{

    /**
     * Instance unique du ViewBag
     *
     * @param object $instance contient l'instance courante.
     * @static
     */
    protected static $instance;

    /**
     * Constructeur privé.
     * Pattern singleton
     */
    private function __construct() {}

    /**
     * Retourne l'instance courante d'un objet singleton ViewBag
     *
     * @return ViewBag ViewBag courant
     * @static
     */
    public static function get() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

    /**
     * Setter
     */
    public function __set($key, $value) {
        $this->$key = $value;
    }

    /**
     * Getter
     */
    public function __get($key) {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }

}