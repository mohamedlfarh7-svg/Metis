<?php
require_once 'Projet.php';

class ProjetCourt extends Projet
{
    public function calculerDuree(): string
    {
        return "- 6mois";
    }

    public function save()
    {
        $stmt = $this->db->prepare(
            "INSERT INTO projets (titre, budget, type)
             VALUES (:titre, :budget, 'court')"
        );

        return $stmt->execute([
            'titre' => $this->titre,
            'budget' => $this->budget
        ]);
    }
}


?>