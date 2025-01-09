<?php
    namespace Models;
    
    class User{
        protected static array $errors = [];
        public function __construct(
                private int $id, 
                private String $name, 
                private String $lastname, 
                private String $email, 
                private String $rol,
                private String $password) {
        }

        public function getId(): int {
            return $this->id;
        }

        public function getName(): String {
            return $this->name;
        }

        public function getLastname(): String {
            return $this->lastname;
        }

        public function getEmail(): String {
            return $this->email;
        }

        public function getRol(): String {
            return $this->rol;
        }

        public function getPassword(): String {
            return $this->password;
        }

        public function setId(int $id): void {
            $this->id = $id;
        }

        public function setName(String $name): void {
            $this->name = $name;
        }

        public function setLastname(String $lastname): void {
            $this->lastname = $lastname;
        }

        public function setEmail(String $email): void {
            $this->email = $email;
        }

        public function setRol(String $rol): void {
            $this->rol = $rol;
        }

        public function setPassword(String $password): void {
            $this->password = $password;
        }

        public static function getErrors() : array{
            return self::$errors;
        }

        public static function setErrores( array $errors) : void{
            self::$errors = $errors;
        }

        public function validar(){
            self::$errors = [];

            if(empty($this->name)){
                self::$errors['name'] = 'el Nombre es obligatorio';
            }

            return empty(self::$errors) ? false : true;
        }

        public function sanitize() {

        }

        public static function fromArray(array $data) : User{
            return new User(
                id: $data['id'] ?? null,
                name: $data['name'],
                lastname: $data['lastname'],
                email: $data['email'],
                password: $data['password'],
                rol: $data['rol']
            );
        }
    }
?>  