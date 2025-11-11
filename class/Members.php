<?php 
    require_once 'config/db.php';

    class Members {
        private $db;

        public function __construct(){
            $this->db = (new Database())->conn;
        }

        public function getAllMembers(){
            $stmt = $this->db->query("SELECT * FROM members");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function createMember($member_name){
            $stmt = $this->db->prepare("INSERT INTO members (member_name) VALUES (?)");
            return $stmt->execute([$member_name]);
        }
        
        public function getMemberById($id){
            $stmt = $this->db->prepare("SELECT * FROM members WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateMember($id, $member_name){
            $stmt = $this->db->prepare("UPDATE members SET member_name = ? WHERE id = ?");
            return $stmt->execute([$member_name, $id]);
        }
        
        public function deleteMember($id){
            $stmt = $this->db->prepare("DELETE FROM members WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }
?>