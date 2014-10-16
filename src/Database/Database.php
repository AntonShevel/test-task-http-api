<?php
/**
 * Date: 10/15/14
 * Time: 10:42 AM
 */

namespace Database;

use PDO;

class Database extends PDO{
    function __construct($path) {
        $path = realpath($path);
        parent::__construct('sqlite:'.$path);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}