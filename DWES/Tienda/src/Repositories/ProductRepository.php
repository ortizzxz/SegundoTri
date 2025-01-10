<?php
    namespace Repositories;
    use Lib\Database;
    use DTOException;

    class ProductRepository{
        private Database $database;

        public function __construct() {
            $this->database = new Database();
        }

        
    }

