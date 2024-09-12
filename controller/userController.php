<?php
require_once '../model/UserModel.php';

class UserController {
    public $model;

    public function __construct() {
        $this->model = UserModel::getInstance();
    }

    public function showData() {
        return $this->model->getData();
    }

    public function deleteUser($userId){
        $this->model->deleteUser($userId);
    }
    
}
?>