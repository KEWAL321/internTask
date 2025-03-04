<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../../core/Controller.php";

class HomeController extends Controller {
    public function index(){
        $userModel = new User();
        $users = $userModel->getAllUsers();
        $this->view("home", ["users" => $users]); 
    }
}
?>