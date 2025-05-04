<?php
require_once 'Models/Enrollment.php';
require_once 'Views/EnrollmentView.php';

class EnrollmentController {
    private $enrollment;
    private $view;
    
    public function __construct() {
        $this->enrollment = new Enrollment();
        $this->view = new EnrollmentView();
    }
    
    // Menampilkan semua data pendaftaran
    public function index() {
        $enrollments = $this->enrollment->getAll();
        $this->view->index($enrollments);
    }
    
    // Menampilkan form untuk menambah data
    public function create() {
        $students = $this->enrollment->getAllStudents();
        $courses = $this->enrollment->getAllCourses();
        $this->view->create($students, $courses);
    }
    
    // Menyimpan data pendaftaran baru
    public function store() {
        if(isset($_POST['submit'])) {
            $this->enrollment->student_id = $_POST['student_id'];
            $this->enrollment->course_id = $_POST['course_id'];
            $this->enrollment->enrollment_date = $_POST['enrollment_date'];
            $this->enrollment->grade = $_POST['grade'];
            
            if($this->enrollment->create()) {
                header('Location: index.php?controller=enrollment&action=index');
            } else {
                echo "Gagal menambahkan data pendaftaran";
            }
        }
    }
    
    // Menampilkan form untuk mengedit data
    public function edit() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $enrollmentData = $this->enrollment->getById($id);
            $students = $this->enrollment->getAllStudents();
            $courses = $this->enrollment->getAllCourses();
            $this->view->edit($enrollmentData, $students, $courses);
        } else {
            header('Location: index.php?controller=enrollment&action=index');
        }
    }
    
    // Mengupdate data pendaftaran
    public function update() {
        if(isset($_POST['submit'])) {
            $this->enrollment->id = $_POST['id'];
            $this->enrollment->student_id = $_POST['student_id'];
            $this->enrollment->course_id = $_POST['course_id'];
            $this->enrollment->enrollment_date = $_POST['enrollment_date'];
            $this->enrollment->grade = $_POST['grade'];
            
            if($this->enrollment->update()) {
                header('Location: index.php?controller=enrollment&action=index');
            } else {
                echo "Gagal mengupdate data pendaftaran";
            }
        }
    }
    
    // Menghapus data pendaftaran
    public function delete() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            
            if($this->enrollment->delete($id)) {
                header('Location: index.php?controller=enrollment&action=index');
            } else {
                echo "Gagal menghapus data pendaftaran";
            }
        } else {
            header('Location: index.php?controller=enrollment&action=index');
        }
    }
}
