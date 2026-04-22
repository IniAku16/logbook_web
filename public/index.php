<?php
session_start();

require_once __DIR__ . "/../config/koneksi.php";
require_once __DIR__ . "/../controllers/NotesController.php";

$NotesController = new NotesController($koneksi);

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action){
    case 'create':
        $NotesController->create();
        break;
    
    case 'update':
        $NotesController->update($id);
        break;
    
    case 'delete':
        $NotesController->delete($id);
        break;

    default:
        $NotesController->index();
        break;
}

?>