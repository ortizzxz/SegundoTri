<?php
namespace Repositories;
use Lib\Database;
use PDO;

class OrderRepository
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }
    
}

