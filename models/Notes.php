<?php
class NoteModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function getAllNotes() {
        $sql = "SELECT notes.*, tb_area.nama_area 
                FROM notes 
                LEFT JOIN tb_area ON notes.id_area = tb_area.id_area 
                ORDER BY notes.date DESC";
        return mysqli_query($this->db, $sql);
    }

    public function getAreas() {
        return mysqli_query($this->db, "SELECT * FROM tb_area");
    }

    public function getById($id) {
        $sql = "SELECT * FROM notes WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($date, $desc, $id_area, $jenis, $target, $material) {
        $sql = "INSERT INTO notes (date, description, id_area, jenis, target, material) VALUES (?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssisss", $date, $desc, $id_area, $jenis, $target, $material);
        return $stmt->execute();
    }

    public function update($id, $date, $desc, $id_area, $jenis, $target, $material) {
        $sql = "UPDATE notes SET date=?, description=?, id_area=?, jenis=?, target=?, material=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssisssi", $date, $desc, $id_area, $jenis, $target, $material, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM notes WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}