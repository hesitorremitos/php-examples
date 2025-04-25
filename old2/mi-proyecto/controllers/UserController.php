<?php
// controllers/UserController.php

require_once 'models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        $usuarios = $this->userModel->getAll();
        include 'views/user/index.php';
    }

     public function getUserById($user_id) {
        $user = $this->userModel->getUserById($user_id);
        return $user;
    }
}
?>
