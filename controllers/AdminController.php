<?php
require_once __DIR__ . "/../models/User.php";

class AdminController
{
    private $userModel;

    public function __construct($koneksi)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php");
            exit();
        }

        $this->userModel = new UserModel($koneksi);
    }

    public function index()
    {
        $usersResult = $this->userModel->getAllUsers();
        $users = [];
        while ($row = $usersResult->fetch_assoc()) {
            $users[] = $row;
        }

        $totalUsers = count($users);
        $adminCount = count(array_filter($users, fn($u) => $u['role'] == 'admin'));

        include __DIR__ . "/../views/admin/dashboard.php";
    }

    public function create()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) session_start();
        $csrf = $_POST['csrf_token'] ?? '';
        if (empty($csrf) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $email    = trim($_POST['email'] ?? '');
        $email    = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? 'user';

        if (empty($username) || empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak boleh kosong']);
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Email tidak valid']);
            exit();
        }

        $role = ($role === 'admin') ? 'admin' : 'user';

        $res = $this->userModel->createUser($username, $email, $password, $role);
        echo json_encode(['status' => $res ? 'success' : 'error', 'message' => $res ? 'User berhasil ditambah' : 'Gagal tambah user']);
        exit();
    }

    public function update($id)
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) session_start();
        $csrf = $_POST['csrf_token'] ?? '';
        if (empty($csrf) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $email    = trim($_POST['email'] ?? '');
        $email    = filter_var($email, FILTER_SANITIZE_EMAIL);
        $role     = $_POST['role'] ?? 'user';
        $password = !empty($_POST['password']) ? $_POST['password'] : null;

        if (empty($username) || empty($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Username dan email harus diisi']);
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Email tidak valid']);
            exit();
        }

        $role = ($role === 'admin') ? 'admin' : 'user';

        $res = $this->userModel->updateUser($id, $username, $email, $role, $password);
        echo json_encode(['status' => $res ? 'success' : 'error', 'message' => $res ? 'User berhasil diupdate' : 'Gagal update user']);
        exit();
    }

    public function delete($id)
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) session_start();
        $csrf = $_POST['csrf_token'] ?? '';
        if (empty($csrf) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
            exit();
        }

        $res = $this->userModel->deleteUser($id);
        echo json_encode(['status' => $res ? 'success' : 'error', 'message' => $res ? 'User berhasil dihapus' : 'Gagal hapus user']);
        exit();
    }

    public function monitoring()
    {
        $usersStats = $this->userModel->getUsersWithStats();
        $totalAktivitas = $this->userModel->getTotalSystemActivities();

        $stats = [];
        while ($row = $usersStats->fetch_assoc()) {
            $stats[] = $row;
        }

        include __DIR__ . "/../views/admin/monitoring.php";
    }

    public function detail_user($id)
    {
        $user = $this->userModel->getUserById($id); 
        $activities = $this->userModel->getUserActivityDetail($id);

        include __DIR__ . "/../views/admin/user_detail.php";
    }
}
