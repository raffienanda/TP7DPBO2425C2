<?php 
    require_once 'config/db.php';

    class Orders {
        private $db;

        public function __construct(){
            $this->db = (new Database())->conn;
        }

        public function getAllOrders(){
            $query = "
                SELECT 
                    o.id, 
                    f.food_name, 
                    d.drink_name, 
                    t.table_name, 
                    m.member_name, 
                    o.order_date,
                    f.harga AS food_price,
                    d.harga AS drink_price
                FROM orders o
                JOIN foods f ON o.food_id = f.id
                JOIN drinks d ON o.drink_id = d.id
                JOIN tables t ON o.table_id = t.id
                JOIN members m ON o.member_id = m.id
                ORDER BY o.order_date DESC
            ";
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function createOrder($food_id, $drink_id, $table_id, $member_id){
            $order_date = date('Y-m-d H:i:s');
            $stmt = $this->db->prepare("INSERT INTO orders (food_id, drink_id, table_id, member_id, order_date) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$food_id, $drink_id, $table_id, $member_id, $order_date]);
        }
        
        public function getOrderById($id){
            $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateOrder($id, $food_id, $drink_id, $table_id, $member_id){
            $stmt = $this->db->prepare("UPDATE orders SET food_id = ?, drink_id = ?, table_id = ?, member_id = ? WHERE id = ?");
            return $stmt->execute([$food_id, $drink_id, $table_id, $member_id, $id]);
        }
        
        public function deleteOrder($id){
            $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }
?>