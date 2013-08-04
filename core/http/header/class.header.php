<?php
namespace LibreMVC\Http;

class Header {
    
    public static function forbidden( $content='' ) {
        header('HTTP/1.1 403 Forbidden');
        echo ($content === '') ? '403 Forbiden' : $content;
        die();
    }
    
    public static function notFound( $content='' ) {
        header('HTTP/1.1 404 Not Found');
        echo ($content === '') ? '404 Not Found' : $content;
        die();
    }
    
    public static function disableCache() {
        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
        header('Expires: Thu, 14 Apr 1982 05:00:00 GMT');
        header('Pragma: no-cache');
        header('ETag: ' . md5( time() ) );
    }

    // @todo abstraction affichage
    public static function redirect( $url, $delay = 0 ) {
        if( $delay > 0 ) {
            header('Refresh: '. $delay .'; url=' . $url);
            print 'You will be redirected in '. $delay .' seconds';
            exit;
        }
        else {
            header("Status: 200");
            header('Location: ' . $url);
            exit;
        }
    }
    
    public static function poweredBy( $name ) {
        header('X-Powered-By: '. $name);
    }
    
    public static function contentLanguage( $cl ) {
        header('Content-language: '. $cl);
    }
    
    public static function lastModified($birth) {
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', $birth).' GMT');
    }
    
    /**
     * Connexion persistente pour les imgages, SOAP sont inutiles...
     */
    public static function disableKeepAlive() {
        header('Connection: Close');
    }
    
    public static function notModified() {
        header('HTTP/1.1 304 Not Modified');
    }

    public static function json() {
        header('Content-type: application/json');
    }

    public static function contentLength($size) {
        header('Content-Length: '.$size);
    }
    
    public static function expires( $birth, $life ) {
        $life = $birth + $life;
        header('Expires: ' . gmdate('D, d M Y H:i:s', $life));
    }
    
    public static function neverExpires() {
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", time() + 365*86440);
        header('HTTP/1.1 304 Not Modified');
        header("Expires: $then");
    }
    
    public static function fromCache($birth,$life,$content) {
        self::lastModified($birth);
        self::expires($birth, $life);
        self::contentLength(strlen($content));
        self::notModified();
    }
    
    public static function ajax() {
        self::disableCache();
        self::disableKeepAlive();
    }

    static public function isAjax() {

    }

    public static function hideInfos() {
        header('Server: ');
        header('X-Powered-By: ');
    }
    
    
    // @todo http://www.php.net/manual/fr/function.header.php#88875
    /*header("Cache-Control: no-cache");
    header("Expires: -1"); */
}