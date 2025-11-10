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
    }
?>