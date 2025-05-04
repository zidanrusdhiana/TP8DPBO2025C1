<?php
require_once 'Models/Student.php';
require_once 'Views/StudentView.php';

class StudentController {
    private $student;
    private $view;
    
    public function __construct() {
        $this->student = new Student();
        $this->view = new StudentView();
    }
    
    // Menampilkan semua data mahasiswa
    public function index() {
        $students = $this->student->getAll();
        $this->view->index($students);
    }
    
    // Menampilkan form untuk menambah data
    public function create() {
        $this->view->create();
    }
    
    // Menyimpan data mahasiswa baru
    public function store() {
        if(isset($_POST['submit'])) {
            $this->student->name = $_POST['name'];
            $this->student->nim = $_POST['nim'];
            $this->student->phone = $_POST['phone'];
            $this->student->join_date = $_POST['join_date'];
            
            if($this->student->create()) {
                header('Location: index.php?controller=student&action=index');
            } else {
                echo "Gagal menambahkan data mahasiswa";
            }
        }
    }
    
    // Menampilkan form untuk mengedit data
    public function edit() {    
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $studentData = $this->student->getById($id);
            $this->view->edit($studentData);
        } else {
            header('Location: index.php?controller=student&action=index');
        }
    }
    
    // Mengupdate data mahasiswa
    public function update() {
        if(isset($_POST['submit'])) {
            $this->student->id = $_POST['id'];
            $this->student->name = $_POST['name'];
            $this->student->nim = $_POST['nim'];
            $this->student->phone = $_POST['phone'];
            $this->student->join_date = $_POST['join_date'];
            
            if($this->student->update()) {
                header('Location: index.php?controller=student&action=index');
            } else {
                echo "Gagal mengupdate data mahasiswa";
            }
        }
    }
    
    // Menghapus data mahasiswa
    public function delete() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            
            if($this->student->delete($id)) {
                header('Location: index.php?controller=student&action=index');
            } else {
                echo "Gagal menghapus data mahasiswa";
            }
        } else {
            header('Location: index.php?controller=student&action=index');
        }
    }
}
