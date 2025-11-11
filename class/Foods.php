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

        public function createFoods($food_name, $harga, $stok){
            $stmt = $this->db->prepare("INSERT INTO foods (food_name, harga, stok) VALUES (?, ?, ?)");
            return $stmt->execute([$food_name, $harga, $stok]);
        }
        
        public function getFoodById($id){
            $stmt = $this->db->prepare("SELECT * FROM foods WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateFoods($id, $food_name, $harga, $stok){
            $stmt = $this->db->prepare("UPDATE foods SET food_name = ?, harga = ?, stok = ? WHERE id = ?");
            return $stmt->execute([$food_name, $harga, $stok, $id]);
        }
        
        public function deleteFoods($id){
            $stmt = $this->db->prepare("DELETE FROM foods WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }
?>