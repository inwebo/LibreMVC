<?php

namespace LibreMVC\Http\Rest;

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
 * @package   Http
 * @subpackage Rest
 * @subpackage Server
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://github.com/inwebo/RESTfulClient
 * @since     File available since 06-04-2013
 */

/**
 * Simple Server RESTful.
 *
 * @category  LibreMVC
 * @package   Http
 * @subpackage Rest
 * @subpackage Server
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version    $Id:$
 * @link       https://github.com/inwebo/RESTfulClient
 * @since     File available since 06-04-2013
 * @todo Devrait retourner le type demandé
 * @todo rendre indépendant du framework, le server du framework devrait etre un Objet AjaxController
 * @todo Si
 */

class Server {

    /**
     * @var string Methode http de la requête courante.
     */
    public $method;

    /**
     * @var string Le contenu courante de la requête.
     */
    public $content;

    /**
     * @var string
     */
    public $contentType;

    /**
     * @param string $data file_get_contents
     */
    protected function __construct( $data ) {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->content = $data;
    }

    static public function handler( $data ) {
        return new Server($data);
    }

}
