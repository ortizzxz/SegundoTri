<?php
    namespace Models;
    
    class User{
        protected static array $errors = [];
        public function __construct(
                private int | null $id, 
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

        public function validation(): bool {
            self::$errors = []; 
        
            if (empty($this->name)) {
                self::$errors['name'] = 'El Nombre es obligatorio';
            }
        
            if (empty($this->lastname)) {
                self::$errors['lastname'] = 'El Apellido es obligatorio';
            }
        
            if (empty($this->email)) {
                self::$errors['email'] = 'El Email es obligatorio';
            } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                self::$errors['email'] = 'El Email no es válido';
            }
        
            if (empty($this->password)) {
                self::$errors['password'] = 'El Password es obligatorio';
            }
        
            //si no hay errores, sanitizar
            if (empty(self::$errors)) {
                $this->sanitize();
            }
        
            return empty(self::$errors);
        }
        
        public function sanitize() {
            $this->name = htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
            $this->lastname = htmlspecialchars($this->lastname, ENT_QUOTES, 'UTF-8');
            $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        }
        

        public static function fromArray(array $data) : User{
            return new User(
                id: $data['id'] ?? null,
                name: $data['nombre'],
                lastname: $data['apellidos'],
                email: $data['email'],
                password: $data['password'],
                rol: $data['rol']
            );
        }
    }
?>  