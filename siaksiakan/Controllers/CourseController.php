<?php
require_once 'Models/Course.php';
require_once 'Views/CourseView.php';

class CourseController {
    private $course;
    private $view;
    
    public function __construct() {
        $this->course = new Course();
        $this->view = new CourseView();
    }
    
    // Menampilkan semua data mata kuliah
    public function index() {
        $courses = $this->course->getAll();
        $this->view->index($courses);
    }
    
    // Menampilkan form untuk menambah data
    public function create() {
        $this->view->create();
    }
    
    // Menyimpan data mata kuliah baru
    public function store() {
        if(isset($_POST['submit'])) {
            $this->course->course_code = $_POST['course_code'];
            $this->course->course_name = $_POST['course_name'];
            $this->course->credit = $_POST['credit'];
            $this->course->semester = $_POST['semester'];
            
            if($this->course->create()) {
                header('Location: index.php?controller=course&action=index');
            } else {
                echo "Gagal menambahkan data mata kuliah";
            }
        }
    }
    
    // Menampilkan form untuk mengedit data
    public function edit() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $courseData = $this->course->getById($id);
            $this->view->edit($courseData);
        } else {
            header('Location: index.php?controller=course&action=index');
        }
    }
    
    // Mengupdate data mata kuliah
    public function update() {
        if(isset($_POST['submit'])) {
            $this->course->id = $_POST['id'];
            $this->course->course_code = $_POST['course_code'];
            $this->course->course_name = $_POST['course_name'];
            $this->course->credit = $_POST['credit'];
            $this->course->semester = $_POST['semester'];
            
            if($this->course->update()) {
                header('Location: index.php?controller=course&action=index');
            } else {
                echo "Gagal mengupdate data mata kuliah";
            }
        }
    }
    
    // Menghapus data mata kuliah
    public function delete() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            
            if($this->course->delete($id)) {
                header('Location: index.php?controller=course&action=index');
            } else {
                echo "Gagal menghapus data mata kuliah";
            }
        } else {
            header('Location: index.php?controller=course&action=index');
        }
    }
}
