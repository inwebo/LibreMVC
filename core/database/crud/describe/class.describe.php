<?php

namespace LibreMVC\Database\Crud;

class Describe {
    
    protected $driver;
    public $database;
    public $tables;


    public function __construct( $driver, $databases = array() ) {
        $this->driver = $driver;
        $tables = $this->isValidDb($databases);
        if( $tables !== false ) {
            $this->tables = $this->extractTablesNames($tables);
            $this->database = $databases;
        }        
    }
    
    protected function isValidDb( $databases ) {
       $tables = $this->driver->query('SHOW tables FROM ' . $databases );
       return ( !empty( $tables ) ) ? $tables : false;
    }
    
    protected function extractTablesNames( $arrayQueryResult ) {
        $tables = array();
        $j = -1;
        while ( isset( $arrayQueryResult[++$j] )  ) {
            $tables[] = array_values( $arrayQueryResult[$j] )[0];
        }
        return $tables;
    }
    
    public function table( $table ) {
        $coloumns = $this->driver->query('describe ' . $this->database .'.' . $table );        
        return ( !empty( $coloumns ) ) ? $coloumns : false;
    }
    
    
    
}