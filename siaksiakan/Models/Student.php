<?php
require_once 'Config/Database.php';

class Student {
    private $table = "students";
    private $conn;
    
    // Properties
    public $id;
    public $name;
    public $nim;
    public $phone;
    public $join_date;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Mendapatkan semua data mahasiswa
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result;
    }
    
    // Mendapatkan data mahasiswa berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Menambahkan data mahasiswa baru
    public function create() {
        $query = "INSERT INTO " . $this->table . " (name, nim, phone, join_date) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $this->name, $this->nim, $this->phone, $this->join_date);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    // Mengupdate data mahasiswa
    public function update() {
        $query = "UPDATE " . $this->table . " SET name = ?, nim = ?, phone = ?, join_date = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $this->name, $this->nim, $this->phone, $this->join_date, $this->id);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    // Menghapus data mahasiswa
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}