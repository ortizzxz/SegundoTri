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

        public function validation(User $user): bool{
            $validation = $user->validation();
            return $validation;
        }

    }