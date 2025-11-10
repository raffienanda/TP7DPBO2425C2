<?php 
    require_once 'config/db.php';

    class Foods {
        private $db;

        public function __construct(){
            $this->db = (new Database())->conn;
        }

        public function getAllFoods(){
            $stmt = $this->db->query("SELECT * FROM foods");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function updateFoods($id, $stok){
            $stmt = $this->db->prepare("UPDATE foods SET stock = ? WHERE id = ?");
            return $stmt->execute([$stok,$id]);
        }
    }
?>