<?php 
    require_once 'config/db.php';

    class Orders {
        private $db;

        public function __construct(){
            $this->db = (new Database())->conn;
        }

        public function getAllOrders(){
            $stmt = $this->db->query("SELECT * FROM orders");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>