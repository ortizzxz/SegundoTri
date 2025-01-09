<?php
    use DTOException;

    class UserRepository{
        private Database $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function save($user){
            
        }
    }