<?php
    namespace Repositories;
    use Lib\Database;
    use DTOException;

    class UserRepository{
        private Database $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function save($user){
            $sql = "INSERT INTO usuarios (id, nombre, apellidos, email, password, rol) 
                    VALUES (null, :name, :lastname, :email, :password, :rol)";
            $data = [
                'name' => $user->getName(),
                'lastname' => $user->getLastname(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'rol' => $user->getRol()
            ];

            try {
                if (!$this->database->execute($sql, $data)) {
                    return false; 
                }
                return true;
            } catch (\PDOException $e) {
                return false;
            }
        }

        public function findByEmail($email) {
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            return $this->database->queryOne($sql, [':email' => $email]);
        }
        
        
        
    }

