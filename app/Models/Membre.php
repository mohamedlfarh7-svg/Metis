<?php
require_once '../metisAPP/app/Core/BaseModel.php';

class Membre extends BaseModel
{
    protected string $table = "membres";
    private int $id = 0;
    private string $nom = "";
    private string $email = "";

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getEmail(): string { return $this->email; }

    public function setNom(string $nom) { $this->nom = $nom; }

    public function setEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email non valide");
        }
        $this->email = $email;
    }

    private function isEmailUnique(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM membres WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() == 0;
    }

    public function create()
    {
        if (!$this->isEmailUnique($this->email)) {
            throw new Exception("Email déjà utilisé");
        }
        $stmt = $this->db->prepare("INSERT INTO membres (nom,email) VALUES (:nom,:email)");
        $res = $stmt->execute(['nom' => $this->nom, 'email' => $this->email]);
        if ($res) {
            $this->id = (int) $this->db->lastInsertId();
        }
        return $res;
    }

    public function update(int $id = 0)
    {
        $idToUpdate = $id ?: $this->id;
        if ($idToUpdate === 0) {
            throw new Exception("ID du membre non défini");
        }
        $stmt = $this->db->prepare("UPDATE membres SET nom=:nom, email=:email WHERE id=:id");
        return $stmt->execute(['nom' => $this->nom, 'email' => $this->email, 'id' => $idToUpdate]);
    }

public function delete(int $id): bool
    {
        $idToDelete = $id ?: $this->id;
        if ($idToDelete === 0) {
            throw new Exception("ID du membre non défini");
        }

        $stmtCheck = $this->db->prepare("SELECT COUNT(*) FROM projets WHERE membre_id=:id");
        $stmtCheck->execute(['id'=>$idToDelete]);
        if ($stmtCheck->fetchColumn() > 0) {
            throw new Exception("Impossible de supprimer: le membre a des projets");
        }
        return parent::delete($idToDelete);
    }
}
?>
