<?php
require_once 'Config/Database.php';

class Enrollment {
    private $table = "enrollments";
    private $conn;
    
    // Properties
    public $id;
    public $student_id;
    public $course_id;
    public $enrollment_date;
    public $grade;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Mendapatkan semua data pendaftaran mata kuliah dengan join ke tabel student dan course
    public function getAll() {
        $query = "SELECT e.*, s.name as student_name, s.nim, c.course_code, c.course_name 
                  FROM " . $this->table . " e 
                  JOIN students s ON e.student_id = s.id 
                  JOIN courses c ON e.course_id = c.id";
        $result = $this->conn->query($query);
        return $result;
    }
    
    // Mendapatkan data pendaftaran berdasarkan ID
    public function getById($id) {
        $query = "SELECT e.*, s.name as student_name, s.nim, c.course_code, c.course_name 
                  FROM " . $this->table . " e 
                  JOIN students s ON e.student_id = s.id 
                  JOIN courses c ON e.course_id = c.id 
                  WHERE e.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Menambahkan data pendaftaran baru
    public function create() {
        $query = "INSERT INTO " . $this->table . " (student_id, course_id, enrollment_date, grade) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiss", $this->student_id, $this->course_id, $this->enrollment_date, $this->grade);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    // Mengupdate data pendaftaran
    public function update() {
        $query = "UPDATE " . $this->table . " SET student_id = ?, course_id = ?, enrollment_date = ?, grade = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iissi", $this->student_id, $this->course_id, $this->enrollment_date, $this->grade, $this->id);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    // Menghapus data pendaftaran
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    // Mendapatkan semua mahasiswa untuk dropdown
    public function getAllStudents() {
        $query = "SELECT id, name, nim FROM students";
        $result = $this->conn->query($query);
        return $result;
    }
    
    // Mendapatkan semua mata kuliah untuk dropdown
    public function getAllCourses() {
        $query = "SELECT id, course_code, course_name FROM courses";
        $result = $this->conn->query($query);
        return $result;
    }
}