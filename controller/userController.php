<?php
require_once '../model/database.php';

class Controller {
    private $model;

    public function __construct() {
        $this->model = new Database('mysql:host=localhost;dbname=db_users', 'KodyWeigel', 'password');
    }

    public function showData() {
        $data = $this->model->getData();
        require '../view/userList.php';
    }
}
?>