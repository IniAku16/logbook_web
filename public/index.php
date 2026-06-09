<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");

require_once __DIR__ . "/../config/koneksi.php";
require_once __DIR__ . "/../models/User.php";

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$userModel = new UserModel($koneksi);

if ($userModel->getUserCount() === 0) {
    $userModel->createUser('admin', 'admin@gmail.com', 'Admin123', 'admin');
    $_SESSION['success_msg'] = "Default admin dibuat: admin / Admin123";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST['form'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        $_SESSION['error_msg'] = "Invalid request token.";
        header("Location: index.php");
        exit();
    }

    if ($form === 'login') {
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($login) || empty($password)) {
            $_SESSION['error_msg'] = "Login gagal. Username/email dan password harus diisi.";
            header("Location: index.php");
            exit();
        }

        $userModel->username = $login;
        $userModel->password = $password;

        if ($userModel->login()) {
            session_regenerate_id(true);
            $_SESSION['id_user'] = $userModel->id_user;
            $_SESSION['username'] = $userModel->username;
            $_SESSION['role'] = $userModel->role;
            $_SESSION['is_first_login'] = $userModel->is_first_login;

            $userModel->updateLastActivity($userModel->id_user);

            if ($_SESSION['is_first_login'] == 1) {
                header("Location: index.php?page=change_password_required");
                exit();
            }

            $redirect = ($userModel->role === 'admin') ? 'admin_dashboard' : 'user_dashboard';
            header("Location: index.php?page=" . $redirect);
            exit();
        }

        $_SESSION['error_msg'] = "Login gagal! Periksa kembali data Anda.";
        header("Location: index.php");
        exit();
    }

    if ($form === 'reset_password') {
        $identifier = trim($_POST['identifier'] ?? '');
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($identifier) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error_msg'] = "Semua kolom harus diisi.";
            header("Location: index.php?page=forgot_password");
            exit();
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_msg'] = "Password baru dan konfirmasi tidak cocok.";
            header("Location: index.php?page=forgot_password");
            exit();
        }

        if ($userModel->updatePasswordAndStatusByIdentifier($identifier, $newPassword)) {
            $_SESSION['success_msg'] = "Password diperbarui! Silakan login kembali.";

            if (isset($_SESSION['id_user'])) {
                session_unset();
                session_destroy();
                session_start();
                $_SESSION['success_msg'] = "Password berhasil diperbarui. Silakan login.";
            }

            header("Location: index.php");
            exit();
        }

        $_SESSION['error_msg'] = "Username atau email tidak ditemukan.";
        header("Location: index.php?page=forgot_password");
        exit();
    }
}

if (!isset($_SESSION['id_user'])) {
    $page = $_GET['page'] ?? null;
    if ($page === 'forgot_password') {
        include __DIR__ . "/../views/auth/forget_password.php";
        exit();
    }
    include __DIR__ . "/../views/auth/login.php";
    exit();
}

$page = $_GET['page'] ?? null;

if ($_SESSION['is_first_login'] == 1 && !in_array($page, ['change_password_required', 'logout'])) {
    header("Location: index.php?page=change_password_required");
    exit();
}

if ($page === 'logout') {
    $userModel->setOffline($_SESSION['id_user']);
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

if ($page === 'change_password_required') {
    include __DIR__ . "/../views/auth/forget_password.php";
    exit();
}

$role = $_SESSION['role'];
$access_map = [
    'admin_dashboard' => ['admin'],
    'user_dashboard'  => ['user'],
];

if (!isset($access_map[$page]) || !in_array($role, $access_map[$page], true)) {
    $page = ($role === 'admin') ? 'admin_dashboard' : 'user_dashboard';
}

$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($page === 'admin_dashboard') {
    require_once __DIR__ . "/../controllers/AdminController.php";
    $adminCtrl = new AdminController($koneksi);
    switch ($action) {
        case 'add_user':
            $adminCtrl->create();
            break;
        case 'edit_user':
            $adminCtrl->update($id);
            break;
        case 'delete_user':
            $adminCtrl->delete($id);
            break;
        case 'monitoring':
            $adminCtrl->monitoring();
            break;
        case 'user_detail':
            $adminCtrl->detail_user($id);
            break;
        case 'export_excel':
            $adminCtrl->export_excel();
            break;
        case 'export_pdf':
            $adminCtrl->export_pdf();
            break;
        default:
            $adminCtrl->index();
            break;
    }
} elseif ($page === 'user_dashboard') {
    require_once __DIR__ . "/../controllers/NotesController.php";
    $notesController = new NotesController($koneksi);
    switch ($action) {
        case 'create':
            $notesController->create();
            break;
        case 'update':
            $notesController->update($id);
            break;
        case 'delete':
            $notesController->delete($id);
            break;
        default:
            $notesController->index();
            break;
    }
}
