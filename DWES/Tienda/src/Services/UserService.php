<?php
    namespace Services;
    use Repositories\UserRepository;
    use Models\User;

    class UserService{
        private UserRepository $userRepository;

        public function __construct() {
            $this->userRepository = new UserRepository();
        }

        /* AUTH */

        public function save(User $user) : bool{
            $isSave = $this->userRepository->save($user);
            return $isSave;
        }
        
        /* USER FINDING */
        
        public function findByEmail(string $email){
            $user = $this->userRepository->findByEmail($email);
            return $user;
        }
       
        
        /* USER VALIDATION */
        public function validation(User $user): bool{
            $validation = $user->validation();
            return $validation;
        }

        public function validateEmail(string $email): bool{
            $validation = filter_var($email, FILTER_VALIDATE_EMAIL);
            return $validation;
        }
    }