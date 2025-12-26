<?php
require_once '../metisAPP/app/Models/Membre.php';
require_once '../metisAPP/app/Models/ProjetCourt.php';
require_once '../metisAPP/app/Models/ProjetLong.php';
require_once '../metisAPP/app/Models/Activite.php';
require_once '../metisAPP/app/database/database.php';

while (true) {
    echo PHP_EOL;
    echo "==============================" . PHP_EOL;
    echo "   GESTION DE L'APPLICATION   " . PHP_EOL;
    echo "==============================" . PHP_EOL;
    echo "1 - Gestion des membres" . PHP_EOL;
    echo "2 - Gestion des projets" . PHP_EOL;
    echo "3 - Gestion des activités" . PHP_EOL;
    echo "0 - Quitter" . PHP_EOL;

    $choix = readline("Votre choix : ");

    try {

        if ($choix == 1) {
            $membre = new Membre();
            while (true) {
                echo PHP_EOL;
                echo "1 - Ajouter un membre" . PHP_EOL;
                echo "2 - Lister les membres" . PHP_EOL;
                echo "3 - Modifier un membre" . PHP_EOL;
                echo "4 - Supprimer un membre" . PHP_EOL;
                echo "0 - Retour" . PHP_EOL;

                $c = readline("Votre choix : ");

                if ($c == 1) {
                    $membre->setNom(readline("Nom : "));
                    $membre->setEmail(readline("Email : "));
                    $membre->create();
                    echo "OK" . PHP_EOL;

                } elseif ($c == 2) {
                    foreach ($membre->getAll() as $m) {
                        echo "{$m['id']} | {$m['nom']} | {$m['email']}" . PHP_EOL;
                    }

                } elseif ($c == 3) {
                    $id = (int) readline("ID : ");
                    $membre->setNom(readline("Nom : "));
                    $membre->setEmail(readline("Email : "));
                    $membre->update($id);
                    echo "OK" . PHP_EOL;

                } elseif ($c == 4) {
                    $membre->delete((int) readline("ID : "));
                    echo "OK" . PHP_EOL;

                } elseif ($c == 0) break;
            }
        }

        elseif ($choix == 2) {
            while (true) {
                echo PHP_EOL;
                echo "1 - Ajouter projet court" . PHP_EOL;
                echo "2 - Ajouter projet long" . PHP_EOL;
                echo "3 - Lister les projets" . PHP_EOL;
                echo "4 - Durée projet" . PHP_EOL;
                echo "0 - Retour" . PHP_EOL;

                $c = readline("Votre choix : ");

                if ($c == 1 || $c == 2) {
                    $titre = readline("Titre : ");
                    $budget = (float) readline("Budget : ");
                    $projet = ($c == 1) ? new ProjetCourt($titre, $budget) : new ProjetLong($titre, $budget);
                    $projet->save();
                    echo "OK" . PHP_EOL;

                } elseif ($c == 3) {
                    $db = Database::connect();
                    $res = $db->query("SELECT * FROM projets");
                    foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $p) {
                        echo "{$p['id']} | {$p['titre']} | {$p['type']} | {$p['budget']}" . PHP_EOL;
                    }

                } elseif ($c == 4) {
                    $type = readline("Type (court/long) : ");
                    $projet = ($type === 'court') ? new ProjetCourt("", 0) : new ProjetLong("", 0);
                    echo $projet->calculerDuree() . PHP_EOL;

                } elseif ($c == 0) break;
            }
        }

        elseif ($choix == 3) {
            while (true) {
                echo PHP_EOL;
                echo "1 - Ajouter une activité" . PHP_EOL;
                echo "2 - Modifier une activité" . PHP_EOL;
                echo "3 - Historique projet" . PHP_EOL;
                echo "0 - Retour" . PHP_EOL;

                $c = readline("Votre choix : ");

                if ($c == 1) {
                    $activite = new Activite((int) readline("ID Projet : "), readline("Description : "));
                    $activite->save();
                    echo "OK" . PHP_EOL;

                } elseif ($c == 2) {
                    $activite = new Activite();
                    $activite->update((int) readline("ID activité : "), readline("Description : "));
                    echo "OK" . PHP_EOL;

                } elseif ($c == 3) {
                    $activite = new Activite();
                    $list = $activite->historiqueProjet((int) readline("ID Projet : "));
                    foreach ($list as $a) {
                        echo "{$a['date_activite']} | {$a['description']}" . PHP_EOL;
                    }

                } elseif ($c == 0) break;
            }
        }

        elseif ($choix == 0) exit;

    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage() . PHP_EOL;
    }
}
?>
