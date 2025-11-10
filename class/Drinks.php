<?php 
    require_once 'config/db.php';

    class Drinks {
        private $db;

        public function __construct(){
            $this->db = (new Database())->conn;
        }

        public function getAllDrinks(){
            $stmt = $this->db->query("SELECT * FROM drinks");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function updateDrinks($id, $stok){
            $stmt = $this->db->prepare("UPDATE drinks SET stock = ? WHERE id = ?");
            return $stmt->execute([$stok,$id]);
        }
    }
?>