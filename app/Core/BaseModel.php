<?php
require_once 'Database.php';

class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = $id";
        return $this->db->query($sql)->fetch();
    }


    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = $id";
        return $this->db->query($sql);
    }

    public function save($nom)
    {
        $sql = "INSERT INTO $this->table (nom) VALUES ('$nom')";
        return $this->db->query($sql);
    }
}
