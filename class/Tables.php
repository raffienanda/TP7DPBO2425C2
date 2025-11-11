<?php 
    require_once 'config/db.php';

    class Tables {
        private $db;

        public function __construct(){
            $this->db = (new Database())->conn;
        }

        public function getAllTables(){
            $stmt = $this->db->query("SELECT * FROM tables");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createTable($table_name){
            $stmt = $this->db->prepare("INSERT INTO tables (table_name) VALUES (?)");
            return $stmt->execute([$table_name]);
        }
        
        public function getTableById($id){
            $stmt = $this->db->prepare("SELECT * FROM tables WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateTable($id, $table_name){
            $stmt = $this->db->prepare("UPDATE tables SET table_name = ? WHERE id = ?");
            return $stmt->execute([$table_name, $id]);
        }
        
        public function deleteTable($id){
            $stmt = $this->db->prepare("DELETE FROM tables WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }
?>