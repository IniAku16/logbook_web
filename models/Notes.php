<?php
class NoteModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getAllNotes()
    {
        $sql = "SELECT `notes`.*, tb_area.nama_area 
                FROM `notes` 
                LEFT JOIN tb_area ON `notes`.id_area = tb_area.id_area 
                ORDER BY `notes`.date DESC";
        return mysqli_query($this->db, $sql);
    }

    public function getAllNotesByUser($user_id)
    {
        $sql = "SELECT `notes`.*, tb_area.nama_area 
                FROM `notes` 
                LEFT JOIN tb_area ON `notes`.id_area = tb_area.id_area 
                WHERE `notes`.user_id = ?
                ORDER BY `notes`.date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAreas()
    {
        return mysqli_query($this->db, "SELECT * FROM `tb_area`");
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM notes WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($date, $desc, $id_area, $jenis, $target, $material, $user_id, $foto_before)
    {
        $sql = "INSERT INTO notes (date, description, id_area, jenis, target, material, user_id, foto_before) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssisssis", $date, $desc, $id_area, $jenis, $target, $material, $user_id, $foto_before);
        return $stmt->execute();
    }

    public function update($id, $date, $desc, $id_area, $jenis, $target, $material, $user_id, $foto_after)
    {
        if ($foto_after) {
            $sql = "UPDATE notes SET date=?, description=?, id_area=?, jenis=?, target=?, material=?, foto_after=? 
                WHERE id=? AND user_id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssissssii", $date, $desc, $id_area, $jenis, $target, $material, $foto_after, $id, $user_id);
        } else {
            $sql = "UPDATE notes SET date=?, description=?, id_area=?, jenis=?, target=?, material=? 
                WHERE id=? AND user_id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssisssii", $date, $desc, $id_area, $jenis, $target, $material, $id, $user_id);
        }
        return $stmt->execute();
    }

    public function delete($id, $user_id)
    {
        $sql = "DELETE FROM notes WHERE id=? AND user_id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }
}
