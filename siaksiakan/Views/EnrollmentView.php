<?php
require_once 'Views/Template.class.php';

class EnrollmentView
{
    // Render the index page (list of enrollments)
    public function index($enrollments)
    {
        $dataEnrollments = "";
        $no = 1;
        
        if ($enrollments->num_rows > 0) {
            while ($row = $enrollments->fetch_assoc()) {
                $dataEnrollments .= "<tr>
                    <td>" . $no++ . "</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['nim']}</td>
                    <td>{$row['course_code']} - {$row['course_name']}</td>
                    <td>{$row['enrollment_date']}</td>
                    <td>{$row['grade']}</td>
                    <td>
                        <a href='index.php?controller=enrollment&action=edit&id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='index.php?controller=enrollment&action=delete&id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")'>Hapus</a>
                    </td>
                </tr>";
            }
        } else {
            $dataEnrollments = "<tr><td colspan='7' class='text-center'>Tidak ada data pendaftaran</td></tr>";
        }
        
        $tpl = new Template("Views/templates/index.html");
        
        $tpl->replace("JUDUL", "Daftar Pendaftaran Mata Kuliah");
        $tpl->replace("CONTROLLER", "enrollment");
        $tpl->replace("PAGE_TITLE", "Data Pendaftaran Mata Kuliah");
        $tpl->replace("ADD_BUTTON_TEXT", "Tambah Pendaftaran");
        $tpl->replace("TABLE_HEADER", "
            <th>No</th>
            <th>Mahasiswa</th>
            <th>NIM</th>
            <th>Mata Kuliah</th>
            <th>Tanggal Pendaftaran</th>
            <th>Nilai</th>
            <th>Aksi</th>
        ");
        $tpl->replace("TABLE_CONTENT", $dataEnrollments);
        
        $tpl->write();
    }
    
    // Render the create form
    public function create($students, $courses)
    {
        $studentOptions = "";
        $courseOptions = "";
        
        while ($student = $students->fetch_assoc()) {
            $studentOptions .= "<option value='{$student['id']}'>{$student['name']} ({$student['nim']})</option>";
        }
        
        while ($course = $courses->fetch_assoc()) {
            $courseOptions .= "<option value='{$course['id']}'>{$course['course_code']} - {$course['course_name']}</option>";
        }
        
        $tpl = new Template("Views/templates/form.html");
        
        $tpl->replace("JUDUL", "Tambah Pendaftaran Mata Kuliah");
        $tpl->replace("CONTROLLER", "enrollment");
        $tpl->replace("CARD_TITLE", "Tambah Data Pendaftaran");
        $tpl->replace("CARD_HEADER_CLASS", "bg-primary text-white");
        $tpl->replace("FORM_ACTION", "index.php?controller=enrollment&action=store");
        $tpl->replace("FORM_CONTENT", '
            <div class="mb-3">
                <label for="student_id" class="form-label">Mahasiswa</label>
                <select class="form-select" id="student_id" name="student_id" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    ' . $studentOptions . '
                </select>
            </div>
            <div class="mb-3">
                <label for="course_id" class="form-label">Mata Kuliah</label>
                <select class="form-select" id="course_id" name="course_id" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                    ' . $courseOptions . '
                </select>
            </div>
            <div class="mb-3">
                <label for="enrollment_date" class="form-label">Tanggal Pendaftaran</label>
                <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" required>
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">Nilai</label>
                <select class="form-select" id="grade" name="grade">
                    <option value="">-- Belum Ada Nilai --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>
        ');
        $tpl->replace("SUBMIT_TEXT", "Simpan");
        $tpl->replace("CANCEL_URL", "index.php?controller=enrollment&action=index");
        
        $tpl->write();
    }
    
    // Render the edit form
    public function edit($enrollmentData, $students, $courses)
    {
        $studentOptions = "";
        $courseOptions = "";
        
        while ($student = $students->fetch_assoc()) {
            $selected = ($student['id'] == $enrollmentData['student_id']) ? 'selected' : '';
            $studentOptions .= "<option value='{$student['id']}' {$selected}>{$student['name']} ({$student['nim']})</option>";
        }
        
        while ($course = $courses->fetch_assoc()) {
            $selected = ($course['id'] == $enrollmentData['course_id']) ? 'selected' : '';
            $courseOptions .= "<option value='{$course['id']}' {$selected}>{$course['course_code']} - {$course['course_name']}</option>";
        }
        
        $tpl = new Template("Views/templates/form.html");
        
        $tpl->replace("JUDUL", "Edit Pendaftaran Mata Kuliah");
        $tpl->replace("CONTROLLER", "enrollment");
        $tpl->replace("CARD_TITLE", "Edit Data Pendaftaran");
        $tpl->replace("CARD_HEADER_CLASS", "bg-warning");
        $tpl->replace("FORM_ACTION", "index.php?controller=enrollment&action=update");
        $tpl->replace("FORM_CONTENT", '
            <input type="hidden" name="id" value="' . $enrollmentData['id'] . '">
            <div class="mb-3">
                <label for="student_id" class="form-label">Mahasiswa</label>
                <select class="form-select" id="student_id" name="student_id" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    ' . $studentOptions . '
                </select>
            </div>
            <div class="mb-3">
                <label for="course_id" class="form-label">Mata Kuliah</label>
                <select class="form-select" id="course_id" name="course_id" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                    ' . $courseOptions . '
                </select>
            </div>
            <div class="mb-3">
                <label for="enrollment_date" class="form-label">Tanggal Pendaftaran</label>
                <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" value="' . $enrollmentData['enrollment_date'] . '" required>
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">Nilai</label>
                <select class="form-select" id="grade" name="grade">
                    <option value="">-- Belum Ada Nilai --</option>
                    <option value="A" ' . ($enrollmentData['grade'] == 'A' ? 'selected' : '') . '>A</option>
                    <option value="B" ' . ($enrollmentData['grade'] == 'B' ? 'selected' : '') . '>B</option>
                    <option value="C" ' . ($enrollmentData['grade'] == 'C' ? 'selected' : '') . '>C</option>
                    <option value="D" ' . ($enrollmentData['grade'] == 'D' ? 'selected' : '') . '>D</option>
                    <option value="E" ' . ($enrollmentData['grade'] == 'E' ? 'selected' : '') . '>E</option>
                </select>
            </div>
        ');
        $tpl->replace("SUBMIT_TEXT", "Update");
        $tpl->replace("CANCEL_URL", "index.php?controller=enrollment&action=index");
        
        $tpl->write();
    }
}
