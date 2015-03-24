<?php

namespace LibreMVC\Database\Driver {

    use LibreMVC\Database\Driver;

    class MySql extends Driver {

        const COLS_NAME          = "Field";
        const COLS_TYPE          = "Type";
        const COLS_NULLABLE      = "Null";
        const COLS_DEFAULT       = "Default";
        const COLS_PRIMARY_KEY   = "Key";
        const COLS_PRIMARY_VALUE = "PRI";

        /**
         * @var string
         */
        protected $host;
        /**
         * @var string
         */
        protected $database;
        /**
         * @var string
         */
        protected $username;
        /**
         * @var string
         */
        protected $password;
        /**
         * @var array
         */
        protected $options;

        /**
         * @param string $host Database server
         * @param string $database Database name
         * @param string $username Database user
         * @param string $password Database password
         * @param array $options see : http://php.net/manual/fr/ref.pdo-mysql.php
         * @throws
         */
        public function __construct($host, $database, $username, $password, $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) {
            parent::__construct();
            try {
                $dsn = 'mysql:host=' . $host . ';dbname=' . $database;
                $this->driver = new \PDO($dsn, $username, $password, $options);
                $this->driver->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
                $this->host = $host;
                $this->database = $database;
                $this->username = $username;
                $this->passwd = $password;
                $this->options = $options;

                return $this->driver;

            } catch (\Exception $e) {
                throw $e;
            }
        }

        /**
         * @param $table Database table's name.
         * @return array All table's columns.
         */
        public function getTableInfos( $table ) {
            $info = $this->driver->query( 'SHOW COLUMNS FROM ' . $table );
            $info->setFetchMode(\PDO::FETCH_OBJ);
            return $info->fetchAll();
        }

    }
}