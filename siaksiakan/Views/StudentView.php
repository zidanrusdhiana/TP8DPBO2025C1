<?php
require_once 'Views/Template.class.php';

class StudentView
{
    // Render the index page (list of students)
    public function index($students)
    {
        $dataStudents = "";
        $no = 1;
        
        if ($students->num_rows > 0) {
            while ($row = $students->fetch_assoc()) {
                $dataStudents .= "<tr>
                    <td>" . $no++ . "</td>
                    <td>{$row['name']}</td>
                    <td>{$row['nim']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['join_date']}</td>
                    <td>
                        <a href='index.php?controller=student&action=edit&id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='index.php?controller=student&action=delete&id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")'>Hapus</a>
                    </td>
                </tr>";
            }
        } else {
            $dataStudents = "<tr><td colspan='6' class='text-center'>Tidak ada data mahasiswa</td></tr>";
        }
        
        $tpl = new Template("Views/templates/index.html");
        
        $tpl->replace("JUDUL", "Daftar Mahasiswa");
        $tpl->replace("CONTROLLER", "student");
        $tpl->replace("PAGE_TITLE", "Data Mahasiswa");
        $tpl->replace("ADD_BUTTON_TEXT", "Tambah Mahasiswa");
        $tpl->replace("TABLE_HEADER", "
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>No. Telepon</th>
            <th>Tanggal Bergabung</th>
            <th>Aksi</th>
        ");
        $tpl->replace("TABLE_CONTENT", $dataStudents);
        
        $tpl->write();
    }
    
    // Render the create form
    public function create()
    {
        $tpl = new Template("Views/templates/form.html");
        
        $tpl->replace("JUDUL", "Tambah Mahasiswa");
        $tpl->replace("CONTROLLER", "student");
        $tpl->replace("CARD_TITLE", "Tambah Data Mahasiswa");
        $tpl->replace("CARD_HEADER_CLASS", "bg-primary text-white");
        $tpl->replace("FORM_ACTION", "index.php?controller=student&action=store");
        $tpl->replace("FORM_CONTENT", '
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="join_date" class="form-label">Tanggal Bergabung</label>
                <input type="date" class="form-control" id="join_date" name="join_date" required>
            </div>
        ');
        $tpl->replace("SUBMIT_TEXT", "Simpan");
        $tpl->replace("CANCEL_URL", "index.php?controller=student&action=index");
        
        $tpl->write();
    }
    
    // Render the edit form
    public function edit($studentData)
    {
        $tpl = new Template("Views/templates/form.html");
        
        $tpl->replace("JUDUL", "Edit Mahasiswa");
        $tpl->replace("CONTROLLER", "student");
        $tpl->replace("CARD_TITLE", "Edit Data Mahasiswa");
        $tpl->replace("CARD_HEADER_CLASS", "bg-warning");
        $tpl->replace("FORM_ACTION", "index.php?controller=student&action=update");
        $tpl->replace("FORM_CONTENT", '
            <input type="hidden" name="id" value="' . $studentData['id'] . '">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="' . $studentData['name'] . '" required>
            </div>
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" value="' . $studentData['nim'] . '" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="' . $studentData['phone'] . '" required>
            </div>
            <div class="mb-3">
                <label for="join_date" class="form-label">Tanggal Bergabung</label>
                <input type="date" class="form-control" id="join_date" name="join_date" value="' . $studentData['join_date'] . '" required>
            </div>
        ');
        $tpl->replace("SUBMIT_TEXT", "Update");
        $tpl->replace("CANCEL_URL", "index.php?controller=student&action=index");
        
        $tpl->write();
    }
}
