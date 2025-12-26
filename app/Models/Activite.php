<?php
require_once '../metisAPP/app/Core/BaseModel.php';

class Activite extends BaseModel
{
    protected string $table = "activites";
    private int $projet_id;
    private string $description;
    private string $date_activite;

    public function __construct(int $projet_id = 0, string $description = "")
    {
        parent::__construct();
        $this->projet_id = $projet_id;
        $this->description = $description;
        $this->date_activite = date('Y-m-d');
    }

    public function save()
    {
        $stmt = $this->db->prepare(
            "INSERT INTO activites (projet_id, description, date_activite)
             VALUES (:projet_id, :description, :date)"
        );
        return $stmt->execute([
            ':projet_id' => $this->projet_id,
            ':description' => $this->description,
            ':date' => $this->date_activite
        ]);
    }

    public function update(int $id, string $newDescription): bool
    {
        $stmt = $this->db->prepare("UPDATE activites SET description = :desc WHERE id = :id");
        return $stmt->execute([':desc' => $newDescription, ':id' => $id]);
    }

    public function historiqueProjet(int $projet_id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM activites WHERE projet_id = :id ORDER BY date_activite DESC");
        $stmt->execute([':id' => $projet_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
