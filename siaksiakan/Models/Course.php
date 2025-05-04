<?php
require_once 'Config/Database.php';

class Course {
    private $table = "courses";
    private $conn;
    
    // Properties
    public $id;
    public $course_code;
    public $course_name;
    public $credit;
    public $semester;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Mendapatkan semua data mata kuliah
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result;
    }
    
    // Mendapatkan data mata kuliah berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Menambahkan data mata kuliah baru
    public function create() {
        $query = "INSERT INTO " . $this->table . " (course_code, course_name, credit, semester) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssis", $this->course_code, $this->course_name, $this->credit, $this->semester);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    // Mengupdate data mata kuliah
    public function update() {
        $query = "UPDATE " . $this->table . " SET course_code = ?, course_name = ?, credit = ?, semester = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssisi", $this->course_code, $this->course_name, $this->credit, $this->semester, $this->id);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    // Menghapus data mata kuliah
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