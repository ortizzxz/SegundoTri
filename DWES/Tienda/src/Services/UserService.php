<?php
    namespace Services;
    use Repositories\UserRepository;
    use Models\User;

    class UserService{
        private UserRepository $userRepository;
        private User $user;

        public function __construct() {
            $this->$userRepository = new UserRepository();
        }

        public function save(User $user){
            $this->userRepository->save($user);
        }

    }