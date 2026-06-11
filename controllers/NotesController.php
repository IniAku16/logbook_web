<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../models/Notes.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Dompdf\Dompdf;
use Dompdf\Options;

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
            $foto_before = null;
            if (isset($_FILES['foto_before']) && $_FILES['foto_before']['error'] === 0) {
                $targetDir = __DIR__ . "/../public/uploads/";
                $ext = pathinfo($_FILES['foto_before']['name'], PATHINFO_EXTENSION);
                $foto_before = "BEFORE_" . time() . "_" . uniqid() . "." . $ext;
                move_uploaded_file($_FILES['foto_before']['tmp_name'], $targetDir . $foto_before);
            }

            $this->model->create(
                $_POST['date'],
                $_POST['description'],
                $_POST['id_area'],
                $_POST['jenis'],
                $_POST['target'],
                $_POST['material'],
                $this->userId,
                $foto_before
            );

            $this->logModel->save(
                $_SESSION['user_id'],
                'CREATE',
                'Notes',
                'Menambah catatan baru: ' . $_POST['description'],
                null,
                $_POST
            );
            header("Location: index.php?page=user_dashboard");
            exit();
        }
    }


    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $foto_after = null;
            if (isset($_FILES['foto_after']) && $_FILES['foto_after']['error'] === 0) {
                $targetDir = __DIR__ . "/../public/uploads/";
                $ext = pathinfo($_FILES['foto_after']['name'], PATHINFO_EXTENSION);
                $foto_after = "AFTER_" . time() . "_" . uniqid() . "." . $ext;
                move_uploaded_file($_FILES['foto_after']['tmp_name'], $targetDir . $foto_after);
            }

            $this->model->update(
                $id,
                $_POST['date'],
                $_POST['description'],
                $_POST['id_area'],
                $_POST['jenis'],
                $_POST['target'],
                $_POST['material'],
                $this->userId,
                $foto_after
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

    public function export_excel()
    {
        if (ob_get_length()) ob_end_clean();

        $data = $this->model->getAllNotesByUser($this->userId);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'LAPORAN AKTIVITAS DIGITAL - ' . strtoupper($_SESSION['username']));
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headers = ['No', 'Tanggal', 'Hari', 'Area', 'Jenis', 'Deskripsi Kegiatan', 'Target / Status', 'Material'];
        $sheet->fromArray($headers, NULL, 'A3');

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '5d3a00'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];
        $sheet->getStyle('A3:H3')->applyFromArray($headerStyle);
        $sheet->getRowDimension('3')->setRowHeight(25);

        $rowNum = 4;
        $no = 1;
        while ($row = $data->fetch_assoc()) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, date('d-m-Y', strtotime($row['date'])));
            $sheet->setCellValue('C' . $rowNum, date('l', strtotime($row['date'])));
            $sheet->setCellValue('D' . $rowNum, $row['nama_area']);
            $sheet->setCellValue('E' . $rowNum, $row['jenis']);
            $sheet->setCellValue('F' . $rowNum, $row['description']);
            $sheet->setCellValue('G' . $rowNum, $row['target']);
            $sheet->setCellValue('H' . $rowNum, $row['material']);
            $sheet->getStyle('A' . $rowNum . ':H' . $rowNum)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle('A' . $rowNum . ':C' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . $rowNum)->getAlignment()->setWrapText(true);
            $sheet->getStyle('A' . $rowNum . ':H' . $rowNum)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

            $rowNum++;
        }

        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->getColumnDimension('F')->setWidth(50);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        for ($i = 4; $i < $rowNum; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle('A' . $i . ':H' . $i)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFF9F0');
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Activity_Report_' . $_SESSION['username'] . '_' . date('Ymd') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function export_pdf()
    {
        if (ob_get_length()) ob_end_clean();

        $data = $this->model->getAllNotesByUser($this->userId);
        $username = $_SESSION['username'];

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $html = '
    <style>
        body { 
            font-family: "Helvetica", "Arial", sans-serif; 
            font-size: 11px; 
            color: #333;
        }
        .header-container {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #5d3a00; 
            border-radius: 10px;
        }
        .header-container h2 { 
            margin: 0; 
            color: #ffffff; 
            font-size: 24px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .header-container p {
            color: #ffda85;
            margin: 5px 0 0 0;
            font-size: 13px;
            font-weight: bold;
        }

        .info-section {
            margin-bottom: 15px;
            font-size: 12px;
        }
        .info-section strong {
            color: #5d3a00;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            border: 1px solid #5d3a00;
        }
        th { 
            background-color: #5d3a00; 
            color: #ffffff; 
            text-transform: uppercase; 
            padding: 12px 10px;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #4a2e00;
        }
        td { 
            border: 1px solid #d4a373; 
            padding: 10px; 
            vertical-align: top;
            line-height: 1.4;
        }
        
        tbody tr:nth-child(even) {
            background-color: #fff9f0;
        }
        
        .text-center { text-align: center; }
        .bold { font-weight: bold; color: #5d3a00; }
        
        .footer { 
            margin-top: 30px; 
            text-align: right; 
            font-size: 10px; 
            color: #888;
            border-top: 2px solid #5d3a00;
            padding-top: 10px;
        }
    </style>

    <div class="header-container">
        <h2>LAPORAN AKTIVITAS DIGITAL</h2>
    </div>

    <div class="info-section">
        <table style="border:none; width: 100%;">
            <tr style="background:none;">
                <td style="border:none; padding:0; width:50%;">
                    <strong>NAMA USER :</strong> ' . strtoupper(htmlspecialchars($username)) . '
                </td>
                <td style="border:none; padding:0; width:50%; text-align:right;">
                    <strong>TANGGAL CETAK :</strong> ' . date('d F Y') . '
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">NO</th>
                <th width="12%">TANGGAL</th>
                <th width="18%">AREA</th>
                <th width="15%">KATEGORI</th>
                <th>DESKRIPSI KEGIATAN</th>
                <th width="15%">STATUS</th>
            </tr>
        </thead>
        <tbody>';

        $no = 1;
        while ($row = $data->fetch_assoc()) {
            $html .= "<tr>
                <td class='text-center'>{$no}</td>
                <td class='text-center bold'>" . date('d M Y', strtotime($row['date'])) . "</td>
                <td class='bold'>" . htmlspecialchars($row['nama_area']) . "</td>
                <td>" . htmlspecialchars($row['jenis']) . "</td>
                <td>" . nl2br(htmlspecialchars($row['description'])) . "</td>
                <td class='bold' style='color:#8b5e00;'>" . htmlspecialchars($row['target']) . "</td>
              </tr>";
            $no++;
        }

        if ($no == 1) {
            $html .= "<tr><td colspan='6' class='text-center' style='padding: 30px;'>Belum ada data aktivitas yang tercatat.</td></tr>";
        }

        $html .= '</tbody></table>
              <div class="footer">
                Printed via <strong>Activity Digital System</strong> - ' . date('Y') . '
              </div>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Activity_Report_{$username}.pdf", ["Attachment" => 1]);
        exit();
    }
}
