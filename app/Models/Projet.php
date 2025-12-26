<?php
require_once '../metisAPP/app/Core/BaseModel.php';

abstract class Projet extends BaseModel
{
    protected string $titre;
    protected float $budget;

    public function __construct(string $titre, float $budget)
    {
        parent::__construct();
        $this->titre = $titre;
        $this->budget = $budget;
    }

    abstract public function calculerDuree(): string;
    abstract public function save();
}
?>
