<?php

namespace LibreMVC\Files;

class FilesException extends \Exception{};

class IO {

    /**
     * @var bool True all inputs are in DECIMAL, False all inputs are in OCTAL.
     */
    public static $decimalMode = true;

    public static $cache = false;

    /**
     * @return bool
     */
    public static function isUnix() {
        return ( bool ) ( PHP_OS === 'Linux' );
    }

    protected static function isLink( $filename ) {
        return is_link( $filename );
    }

    protected static function isDir( $filename ) {
        return is_dir( $filename );
    }

    public static function isWritable( $node ) {
        return is_writable( $node );
    }

    public static function isReadable( $node ) {
        return is_readable( $node );
    }

    public static function copyDir() {

    }

    public static function mkDir( $where, $folderName, $chmod, $erase = true) {
        if( is_dir( $where ) ) {
            if( self::isWritable( $where ) ) {
                if( is_dir( $folderName ) && ( $erase === false ) ) {
                    throw new FilesException('Folder ' . $folderName . ' already exists');
                }
                else {
                    $old = umask(0);
                    if( is_bool( @mkdir( $folderName, $chmod ) ) ) {
                        umask($old);
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }
            else {
                trigger_error('Dir ' . $where . ' is not writable.');
            }
        }
        else {

            trigger_error('Dir ' . $where . ' is not a valid folder.');
        }

    }

    public static function rmDir( $dir ) {
        $files = array_diff( scandir( $dir ), array( '.', '..' ) );
        foreach ($files as $file) {
            $current = $dir . '/' . $file;
            ( is_dir( $current ) && !is_link( $dir ) ) ? self::rmdir( $current ) : unlink( $current );
        }
        return rmdir($dir);
    }

    public static function copyFile( $filename, $destinationFilename ) {
        $context = dirname($filename);
        //var_dump($context);

        // Le dossier de destination est il accessible en écriture ?
        //var_dump(is_writable($context));

        // Oui

        return copy( $filename, $destinationFilename );
    }

    public static function move( $from, $to ) {

    }

    public static function getDaemonUser() {
        $pwu_data = posix_getpwuid(posix_geteuid());
        return $pwu_data['name'];
    }

    public static function getDaemonGroup( $getId = true ) {
        $ids = posix_getgroups();
        if( $getId ) {
            return $ids;
        }
        else {
            $array = array();
            foreach($ids as $v) {
                $array[] = posix_getgrgid($v);
            }
            return $array;
        }
    }

    /**
     * Gets the name of the owner of the current PHP script
     *
     * @return string The name of the owner of the current PHP script.
     */
    public static function getFileOwnerName() {
        return get_current_user();
    }

    /**
     * @param $filename
     * @param $mode
     * @return bool
     * @throws FilesException
     */
    public static function chmod( $filename, $mode ) {
        if( self::isChModAllowed() ) {
            return chmod( $filename, octdec( $mode ) );
        }
        else {
            throw new FilesException('Current deamon user : ' . self::getCurrentDeamonUser() .' is not allowed to change mode.');
        }

    }

    public static function getChmod( $file ) {
        return substr(sprintf('%o', fileperms($file)), -4);
    }

    /**
     * utilisateur courant =/= utilisateur du deamon php
     *
     * @return bool True si le changement des droits est possible sinon false.
     * @see https://stackoverflow.com/questions/23070266/php-chmod-operation-not-permitted-safe-mode-deprecation-involved
     */
    public static function isChModAllowed() {
        return ( bool ) get_current_user() === self::getDaemonUser();
    }

    public static function recursiveChmod( $pathname, $mode ) {
        $iterator = new \RecursiveIteratorIterator (new \RecursiveDirectoryIterator( $pathname ) );
        foreach( $iterator as $item ) {
            chmod( $item, octdec( $mode ) );
        }
    }

} 