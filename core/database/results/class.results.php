<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 18:02
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database;


class Results {

    protected $pdoStatement;
    protected $rows;
    protected $totalRows;

    public function __construct(\PDOStatement $pdoStatement) {
        $this->pdoStatement = $pdoStatement;
        $this->rows = new \ArrayIterator($this->pdoStatement->fetchAll());
        $this->rows->rewind();
    }

    public function all() {
        return $this->rows;
    }

    public function first() {
        return ( isset($this->rows[0]) && !empty($this->rows) ) ? $this->rows[0] : null;
    }

    public function last() {
        return ( isset($this->rows[0]) && !empty($this->rows) ) ? $this->rows[0] : null;
    }

    public function count(){
        return $this->rows->count();
    }
}