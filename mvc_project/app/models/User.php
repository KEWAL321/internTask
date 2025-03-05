<?php
require_once __DIR__ . '/../../core/Model.php';

class User extends Model {
    public function getAllUsers(){
        $stmt = $this->conn->prepare("select * from users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>