<?php
require_once __DIR__ . "/../models/Notes.php";

class NotesController
{
    private $model;
    private $userId;

    public function __construct($koneksi)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $this->model = new NoteModel($koneksi);
        $this->userId = $_SESSION['id_user']; 
    }

    public function index()
    {
        $notes = $this->model->getAllNotesByUser($this->userId);
        $areas = $this->model->getAreas();
        include __DIR__ . "/../views/notes/index.php";
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->create(
                $_POST['date'], 
                $_POST['description'], 
                $_POST['id_area'], 
                $_POST['jenis'], 
                $_POST['target'], 
                $_POST['material'], 
                $this->userId
            );
            header("Location: index.php?page=user_dashboard");
            exit();
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->update(
                $id, 
                $_POST['date'], 
                $_POST['description'], 
                $_POST['id_area'], 
                $_POST['jenis'], 
                $_POST['target'], 
                $_POST['material'], 
                $this->userId
            );
            header("Location: index.php?page=user_dashboard");
            exit();
        }
    }

    public function delete($id)
    {
         $this->model->delete($id, $this->userId);
        header("Location: index.php?page=user_dashboard");
        exit();
    }
}
