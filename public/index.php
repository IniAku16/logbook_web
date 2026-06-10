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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $action    = $_POST['action'] ?? '';
    $form      = $_POST['form'] ?? '';

    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        if ($action === 'submit_forget_password') {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Sesi kadaluarsa, refresh halaman.']);
            exit();
        }
        $_SESSION['error_msg'] = "Sesi kadaluarsa, silahkan coba lagi.";
        header("Location: index.php");
        exit();
    }

    if ($action === 'submit_forget_password') {
        header('Content-Type: application/json');
        $input = trim($_POST['input_user'] ?? '');
        $res = $userModel->kirimPermintaanReset($input);
        echo json_encode([
            'status' => $res ? 'success' : 'error',
            'message' => $res ? 'Permintaan terkirim! Tunggu admin memproses.' : 'User tidak ditemukan!'
        ]);
        exit();
    }

    if ($form === 'login') {
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel->username = $login;
        $userModel->password = $password;

        if ($userModel->login()) {
            session_regenerate_id(true);
            $_SESSION['id_user']        = $userModel->id_user;
            $_SESSION['username']       = $userModel->username;
            $_SESSION['role']           = $userModel->role;
            $_SESSION['is_first_login'] = $userModel->is_first_login;

            $userModel->updateLastActivity($_SESSION['id_user']);

            if ($_SESSION['is_first_login'] == 1) {
                header("Location: index.php?page=change_password_required");
                exit();
            }

            $redirect = ($_SESSION['role'] === 'admin') ? 'admin_dashboard' : 'user_dashboard';
            header("Location: index.php?page=" . $redirect);
            exit();
        }

        $_SESSION['error_msg'] = "Username atau Password salah!";
        header("Location: index.php");
        exit();
    }

    if ($form === 'reset_password') {
        $identifier      = $_SESSION['username'] ?? '';
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_msg'] = "Konfirmasi password tidak cocok!";
            header("Location: index.php?page=change_password_required");
            exit();
        }

        if ($userModel->changePasswordByUser($identifier, $newPassword)) {
            $_SESSION['is_first_login'] = 0;
            $_SESSION['success_msg'] = "Password berhasil diperbarui!";
            $redirect = ($_SESSION['role'] === 'admin') ? 'admin_dashboard' : 'user_dashboard';
            header("Location: index.php?page=" . $redirect);
            exit();
        } else {
            $_SESSION['error_msg'] = "Gagal memperbarui password.";
            header("Location: index.php?page=change_password_required");
            exit();
        }
    }
}

$page   = $_GET['page'] ?? null;
$action = $_GET['action'] ?? 'index';
$id     = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!isset($_SESSION['id_user'])) {
    if ($page === 'forgot_password') {
        include __DIR__ . "/../views/auth/forget_password.php";
        exit();
    }
    include __DIR__ . "/../views/auth/login.php";
    exit();
}

if ($_SESSION['is_first_login'] == 1 && $page !== 'change_password_required' && $page !== 'logout') {
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

if (!isset($access_map[$page]) || !in_array($role, $access_map[$page])) {
    $page = ($role === 'admin') ? 'admin_dashboard' : 'user_dashboard';
}

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
        case 'reset_password':
            $adminCtrl->reset_password($id);
            break;
        case 'monitoring':
            $adminCtrl->monitoring();
            break;
        case 'user_detail':
            $adminCtrl->detail_user($id);
            break;
        case 'hapus_notif_reset':
            $adminCtrl->hapus_notif_reset($id);
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
