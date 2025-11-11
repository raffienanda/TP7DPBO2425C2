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

        public function createDrinks($drink_name, $harga, $stok){
            $stmt = $this->db->prepare("INSERT INTO drinks (drink_name, harga, stok) VALUES (?, ?, ?)");
            return $stmt->execute([$drink_name, $harga, $stok]);
        }
        
        public function getDrinkById($id){
            $stmt = $this->db->prepare("SELECT * FROM drinks WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateDrinks($id, $drink_name, $harga, $stok){
            $stmt = $this->db->prepare("UPDATE drinks SET drink_name = ?, harga = ?, stok = ? WHERE id = ?");
            return $stmt->execute([$drink_name, $harga, $stok, $id]);
        }
        
        public function deleteDrinks($id){
            $stmt = $this->db->prepare("DELETE FROM drinks WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }
?>