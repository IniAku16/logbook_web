<?php
require_once __DIR__ . "/../models/Notes.php";

class NotesController {
    private $model;

    public function __construct($koneksi) {
        $this->model = new NoteModel($koneksi);
    }

    public function index() {
        $notes = $this->model->getAllNotes();
        $areas = $this->model->getAreas(); 
        include __DIR__ . "/../views/notes/index.php"; 
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->create($_POST['date'], $_POST['description'], $_POST['id_area'], $_POST['jenis'], $_POST['target'], $_POST['material']);
            header("Location: index.php?page=user_dashboard");
            exit();
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->update($id, $_POST['date'], $_POST['description'], $_POST['id_area'], $_POST['jenis'], $_POST['target'], $_POST['material']);
            header("Location: index.php?page=user_dashboard");
            exit();
        }
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?page=user_dashboard");
        exit();
    }
}