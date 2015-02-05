<?php
ini_set('display_errors', 'on');
include('../core/files/autoload.php');

$demoFolder = getcwd()."/demo/io/";
$writable = $demoFolder . "writable/";
$locked = $demoFolder . "locked/";
trait Modifiable {

    public function isWritable( $filename ) {
        if( is_file( $filename ) && is_writable( dirname( $filename ) ) ) {
            $f = fopen( $filename , "r+" );
            $result = ( is_writable( $filename ) && $f );
            fclose($f);
            return $result;
        }
        if( is_dir( $filename ) ) {
            return is_writable($filename);
        }
        if( is_dir( dirname( $filename ) ) ) {
            return is_writable( dirname( $filename ) );
        }
    }

    public function write( $filename, $content ) {
        if( $this->isWritable( $filename ) ) {
            $handle = fopen( $filename, 'w+' );
            if ( flock($handle, \LOCK_EX ) ) {
                fwrite( $handle, $content );
                flock( $handle, \LOCK_UN );
                fclose( $handle );
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function append( $filename, $content ) {
        if( $this->isWritable( $filename ) ) {
            $handle = fopen( $filename, 'a' );
            if ( flock($handle, \LOCK_EX ) ) {
                fwrite( $handle, $content );
                flock( $handle, \LOCK_UN );
                fclose( $handle );
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function unlink( $filename ) {
        if( $this->isWritable( $filename ) ) {
            return unlink($filename);
        }
    }

}

trait isDistantFile {

    public function isDistantFile( $filename ) {

        if( filter_var( $filename, FILTER_VALIDATE_URL ) ) {

            $opts = array(
                'http' => array(
                    'method' => 'HEAD'
                )
            );

            $context = stream_context_create( $opts );

            $file = file_get_contents( $filename, false, $context, null, 0 );

            return ( $file !== false ) ? true : false;
        }
        return false;
    }

}

class _Directory {

    protected $_baseDir;

    protected $_inodes;

    public function __construct( $path, $isRecursive = true ) {
        $this->_baseDir = $path;
        try {
            $recursiveDirectoryIterator = new \RecursiveDirectoryIterator(
                $this->_baseDir,
                \FilesystemIterator::SKIP_DOTS
            );
            $recursiveIteratorIterator = new \RecursiveIteratorIterator(
                $recursiveDirectoryIterator,
                \RecursiveIteratorIterator::CHILD_FIRST
            );
            $this->_inodes = $recursiveIteratorIterator;
        }
        catch(\Exception $e) {
            var_dump($e);
        }
    }

    public function getNodes() {
        return $this->_inodes;
    }

    public function count() {
        $this->getNodes()->rewind();
        return iterator_count($this->getNodes());
    }

    protected function recursiveDirs() {
        try {
            $recursiveDirectoryIterator = new \RecursiveDirectoryIterator(
                $this->_baseDir,
                \FilesystemIterator::SKIP_DOTS
            );
            $recursiveIteratorIterator = new \RecursiveIteratorIterator(
                $recursiveDirectoryIterator,
                \RecursiveIteratorIterator::CHILD_FIRST
            );
        }
        catch(\Exception $e) {
            var_dump($e);
        }
        $recursiveIteratorIterator->rewind();
        return $recursiveIteratorIterator;
    }

    protected function flatDir() {
        try {
            $inodes = new \DirectoryIterator($this->_baseDir);
        }
        catch(\Exception $e) {
            var_dump($e);
        }
        $inodes->rewind();
        return $inodes;
    }

    public function getFiles() {

    }

    public function getDirs() {

    }



}

class File {

    use Modifiable;
    use isDistantFile;

}

class InodesFilter extends \FilterIterator {

    public function accept() {

    }

}


$dir = new _Directory( './demo/io/' );
$dir->getNodes()->rewind();
while($dir->getNodes()->valid()) {
    $node = $dir->getNodes()->current();
    echo($node->getBaseName() . "<br>");
    $dir->getNodes()->next();
}
echo $dir->count();
//\LibreMVC\Files\IO::mkDir($writable,"test",0755);

// Objet->cp('blab/bla/bla');

// IO::cp($who, $where);

$v = parse_ini_file('./demo/config2.ini',true);
var_dump($v);