<?php
require_once 'Projet.php';

class ProjetLong extends Projet
{
    public function calculerDuree(): string
    {
        return "+ 6 mois";
    }

    public function save()
    {
        $stmt = $this->db->prepare(
            "INSERT INTO projets (titre, budget, type)
             VALUES (:titre, :budget, 'long')"
        );

        return $stmt->execute([
            'titre' => $this->titre,
            'budget' => $this->budget
        ]);
    }
}

?>