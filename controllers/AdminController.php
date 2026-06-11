<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../models/User.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $totalAktivitasSistem = $this->userModel->getTotalSystemActivities();

        $requestsResult = $this->userModel->getSemuaPermintaanReset();
        $requests = [];
        if ($requestsResult) {
            while ($row = $requestsResult->fetch_assoc()) {
                $requests[] = $row;
            }
        }

        include __DIR__ . "/../views/admin/dashboard.php";
    }

    public function hapus_notif_reset($id)
    {
        $this->userModel->hapusNotifikasiReset($id);
        header("Location: index.php?page=admin_dashboard");
        exit();
    }

    public function all_activities()
    {
        $allActivities = $this->userModel->getAllSystemActivities();
        include __DIR__ . "/../views/admin/all_activities.php";
    }

    private function generateStrongPassword($length = 12)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()-_=+[]{}|;:,.<>?';

        $password = '';
        $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
        $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
        $password .= $numbers[rand(0, strlen($numbers) - 1)];
        $password .= $symbols[rand(0, strlen($symbols) - 1)];

        $allChars = $uppercase . $lowercase . $numbers . $symbols;
        for ($i = 0; $i < $length - 4; $i++) {
            $password .= $allChars[rand(0, strlen($allChars) - 1)];
        }

        return str_shuffle($password);
    }

    public function create()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) session_start();
        $csrf = $_POST['csrf_token'] ?? '';
        if (empty($csrf) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
            echo json_encode(['status' => 'error', 'message' => 'Token keamanan tidak valid']);
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $role     = $_POST['role'] ?? 'user';

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            echo json_encode(['status' => 'error', 'message' => 'Username hanya boleh huruf, angka, dan underscore']);
            exit();
        }

        $generatedPassword = $this->generateStrongPassword(12);

        $res = $this->userModel->createUser($username, $email, $generatedPassword, $role);

        if ($res) {
            echo json_encode([
                'status' => 'success',
                'message' => 'User berhasil ditambah',
                'data' => [
                    'username' => $username,
                    'email' => $email,
                    'password' => $generatedPassword
                ]
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal simpan ke database (Mungkin username/email sudah terdaftar)']);
        }
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

    public function export_excel()
    {
        $data = $this->userModel->getAllSystemActivities();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Aktivitas');

        $sheet->setCellValue('A1', 'LAPORAN AKTIVITAS PENGGUNA - ACTIVITY DIGITAL');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Dicetak pada: ' . date('d F Y'));
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headers = ['NO', 'TANGGAL', 'USER INPUT', 'AREA KERJA', 'JENIS', 'DESKRIPSI PEKERJAAN', 'TARGET LUARAN', 'MATERIAL'];
        $sheet->fromArray($headers, NULL, 'A4');

        $styleHeader = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F110B']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
            ]
        ];
        $sheet->getStyle('A4:H4')->applyFromArray($styleHeader);
        $sheet->getRowDimension(4)->setRowHeight(25);

        $rowNum = 5;
        $no = 1;
        while ($row = $data->fetch_assoc()) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, date('d/m/Y', strtotime($row['date'])));
            $sheet->setCellValue('C' . $rowNum, $row['username']);
            $sheet->setCellValue('D' . $rowNum, $row['nama_area']);
            $sheet->setCellValue('E' . $rowNum, $row['jenis']);
            $sheet->setCellValue('F' . $rowNum, $row['description']);
            $sheet->setCellValue('G' . $rowNum, $row['target']);
            $sheet->setCellValue('H' . $rowNum, $row['material']);

            if ($rowNum % 2 == 0) {
                $sheet->getStyle('A' . $rowNum . ':H' . $rowNum)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FDF9F5');
            }

            $rowNum++;
        }

        $lastRow = $rowNum - 1;
        $styleBody = [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'C9B39F']]
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];
        $sheet->getStyle('A5:H' . $lastRow)->applyFromArray($styleBody);

        $sheet->getStyle('A5:C' . $lastRow)->getFont()->setBold(true);
        $sheet->getStyle('A5:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(45);
        $sheet->getStyle('F5:F' . $lastRow)->getAlignment()->setWrapText(true);

        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Aktivitas_' . date('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function export_pdf()
    {
        $data = $this->userModel->getAllSystemActivities();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);

        $html = '
    <style>
        @page { margin: 1cm; }
        body { font-family: Helvetica, Arial, sans-serif; color: #1F110B; line-height: 1.4; }
        .header-container { text-align: center; margin-bottom: 30px; border-bottom: 4px solid #D4A352; padding-bottom: 15px; }
        .title { font-size: 24pt; font-weight: bold; color: #1F110B; margin: 0; text-transform: uppercase; letter-spacing: -1px; }
        .title span { color: #D4A352; }
        .subtitle { font-size: 11pt; font-weight: bold; color: #A36B46; margin-top: 5px; }
        .meta-info { font-size: 9pt; color: #555; margin-top: 10px; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed; }
        th { 
            background-color: #1F110B; 
            color: #FFFFFF; 
            font-weight: bold; 
            text-transform: uppercase; 
            font-size: 9pt; 
            padding: 12px 8px; 
            border: 1px solid #1F110B;
            text-align: left;
        }
        td { 
            padding: 10px 8px; 
            border: 1px solid #C9B39F; 
            font-size: 9pt; 
            vertical-align: top; 
            word-wrap: break-word;
        }

        .odd { background-color: #FFFFFF; }
        .even { background-color: #FDF9F5; }

        .text-bold { font-weight: bold; }
        .text-caramel { color: #A36B46; }
        .center { text-align: center; }
        .badge-area { font-weight: bold; color: #1F110B; }
    </style>

    <div class="header-container">
        <div class="title">Activity <span>Digital.</span></div>
        <div class="subtitle">LAPORAN MONITORING AKTIVITAS SELURUH PENGGUNA</div>
        <div class="meta-info">Dicetak pada: ' . date('d F Y') . ' | Oleh: ' . htmlspecialchars($_SESSION['username']) . '</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30px" class="center">No</th>
                <th width="80px">Tanggal</th>
                <th width="90px">User</th>
                <th width="100px">Area Kerja</th>
                <th width="100px">Jenis</th>
                <th>Deskripsi Pekerjaan</th>
                <th width="100px">Target</th>
            </tr>
        </thead>
        <tbody>';

        $no = 1;
        while ($row = $data->fetch_assoc()) {
            $rowClass = ($no % 2 == 0) ? 'even' : 'odd';
            $html .= '<tr class="' . $rowClass . '">
                <td class="center">' . $no . '</td>
                <td class="text-bold text-caramel">' . date('d/m/Y', strtotime($row['date'])) . '</td>
                <td class="text-bold">' . htmlspecialchars($row['username']) . '</td>
                <td><span class="badge-area">' . htmlspecialchars($row['nama_area']) . '</span></td>
                <td class="text-bold">' . htmlspecialchars($row['jenis']) . '</td>
                <td>' . htmlspecialchars($row['description']) . '</td>
                <td class="text-bold">' . htmlspecialchars($row['target']) . '</td>
              </tr>';
            $no++;
        }

        if ($no === 1) {
            $html .= '<tr><td colspan="7" class="center">Tidak ada data aktivitas ditemukan.</td></tr>';
        }

        $html .= '</tbody></table>
    <div style="margin-top: 30px; text-align: right; font-size: 9pt; font-style: italic; color: #999;">
        Dokumen ini dihasilkan secara otomatis oleh Sistem Monitoring Digital.
    </div>';

        if (ob_get_length()) ob_end_clean();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Laporan_Aktivitas_" . date('Y-m-d') . ".pdf", ["Attachment" => 1]);
        exit();
    }

    public function reset_password($id)
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) session_start();
        $csrf = $_POST['csrf_token'] ?? '';
        if (empty($csrf) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
            exit();
        }

        $user = $this->userModel->getUserById($id);
        if (!$user) {
            echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan']);
            exit();
        }

        $newPassword = $this->generateStrongPassword(12);
        $res = $this->userModel->resetPasswordByAdmin($id, $newPassword);

        if ($res) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Password berhasil di-reset. Silahkan berikan password baru ini kepada user.',
                'data' => [
                    'username' => $user['username'],
                    'email'    => $user['email'],
                    'password' => $newPassword
                ]
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal reset database']);
        }
        exit();
    }

    public function proses_lupa_password()
    {
        header('Content-Type: application/json');
        $input = $_POST['input_user'] ?? '';

        if (!empty($input)) {
            $res = $this->userModel->kirimPermintaanReset($input);
            echo json_encode(['status' => $res ? 'success' : 'error']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Input kosong']);
        }
        exit();
    }
}
