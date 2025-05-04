<?php
require_once 'Views/Template.class.php';

class CourseView
{
    // Render the index page (list of courses)
    public function index($courses)
    {
        $dataCourses = "";
        $no = 1;
        
        if ($courses->num_rows > 0) {
            while ($row = $courses->fetch_assoc()) {
                $dataCourses .= "<tr>
                    <td>" . $no++ . "</td>
                    <td>{$row['course_code']}</td>
                    <td>{$row['course_name']}</td>
                    <td>{$row['credit']}</td>
                    <td>{$row['semester']}</td>
                    <td>
                        <a href='index.php?controller=course&action=edit&id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='index.php?controller=course&action=delete&id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")'>Hapus</a>
                    </td>
                </tr>";
            }
        } else {
            $dataCourses = "<tr><td colspan='6' class='text-center'>Tidak ada data mata kuliah</td></tr>";
        }
        
        $tpl = new Template("Views/templates/index.html");
        
        $tpl->replace("JUDUL", "Daftar Mata Kuliah");
        $tpl->replace("CONTROLLER", "course");
        $tpl->replace("PAGE_TITLE", "Data Mata Kuliah");
        $tpl->replace("ADD_BUTTON_TEXT", "Tambah Mata Kuliah");
        $tpl->replace("TABLE_HEADER", "
            <th>No</th>
            <th>Kode MK</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Aksi</th>
        ");
        $tpl->replace("TABLE_CONTENT", $dataCourses);
        
        $tpl->write();
    }
    
    // Render the create form
    public function create()
    {
        $tpl = new Template("Views/templates/form.html");
        
        $tpl->replace("JUDUL", "Tambah Mata Kuliah");
        $tpl->replace("CONTROLLER", "course");
        $tpl->replace("CARD_TITLE", "Tambah Data Mata Kuliah");
        $tpl->replace("CARD_HEADER_CLASS", "bg-primary text-white");
        $tpl->replace("FORM_ACTION", "index.php?controller=course&action=store");
        $tpl->replace("FORM_CONTENT", '
            <div class="mb-3">
                <label for="course_code" class="form-label">Kode Mata Kuliah</label>
                <input type="text" class="form-control" id="course_code" name="course_code" required>
            </div>
            <div class="mb-3">
                <label for="course_name" class="form-label">Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="course_name" name="course_name" required>
            </div>
            <div class="mb-3">
                <label for="credit" class="form-label">SKS</label>
                <input type="number" class="form-control" id="credit" name="credit" required>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select class="form-control" id="semester" name="semester" required>
                    <option value="">-- Pilih Semester --</option>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>
        ');
        $tpl->replace("SUBMIT_TEXT", "Simpan");
        $tpl->replace("CANCEL_URL", "index.php?controller=course&action=index");
        
        $tpl->write();
    }
    
    // Render the edit form
    public function edit($courseData)
    {
        $tpl = new Template("Views/templates/form.html");
        
        $tpl->replace("JUDUL", "Edit Mata Kuliah");
        $tpl->replace("CONTROLLER", "course");
        $tpl->replace("CARD_TITLE", "Edit Data Mata Kuliah");
        $tpl->replace("CARD_HEADER_CLASS", "bg-warning");
        $tpl->replace("FORM_ACTION", "index.php?controller=course&action=update");
        $tpl->replace("FORM_CONTENT", '
            <input type="hidden" name="id" value="' . $courseData['id'] . '">
            <div class="mb-3">
                <label for="course_code" class="form-label">Kode Mata Kuliah</label>
                <input type="text" class="form-control" id="course_code" name="course_code" value="' . $courseData['course_code'] . '" required>
            </div>
            <div class="mb-3">
                <label for="course_name" class="form-label">Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="course_name" name="course_name" value="' . $courseData['course_name'] . '" required>
            </div>
            <div class="mb-3">
                <label for="credit" class="form-label">SKS</label>
                <input type="number" class="form-control" id="credit" name="credit" value="' . $courseData['credit'] . '" required>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select class="form-control" id="semester" name="semester" required>
                    <option value="">-- Pilih Semester --</option>
                    <option value="Ganjil" ' . ($courseData['semester'] == 'Ganjil' ? 'selected' : '') . '>Ganjil</option>
                    <option value="Genap" ' . ($courseData['semester'] == 'Genap' ? 'selected' : '') . '>Genap</option>
                </select>
            </div>
        ');
        $tpl->replace("SUBMIT_TEXT", "Update");
        $tpl->replace("CANCEL_URL", "index.php?controller=course&action=index");
        
        $tpl->write();
    }
}
