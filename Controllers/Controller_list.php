<?php

class Controller_list extends Controller
{
    public function action_last()
    {
        $m = Model::getModel();
        $data = [
            "liste" => $m->getLast(),
        ];
        $this->render("last", $data);
    }

    public function action_default()
    {
        $this->action_last();
    }

    public function action_informations()
    {
        $data = false;

        if (isset($_GET["id"]) and preg_match("/^[1-9]\d*$/", $_GET["id"])) {
            $m = Model::getModel();
            $data = $m->getNobelPrizeInformations($_GET["id"]);
        }
        //Si on a bien un prix nobel d'identifiant$_GET["id"]
        if ($data !== false) {
            $this->render("informations", $data);
        } else {
            $this->action_error("There is no Nobel Prize with such ID!!!");
        }
    }

    public function action_pagination()
    {
        $start = 1;
        if (isset($_GET["start"]) and preg_match("/^\d+$/", $_GET["start"]) and $_GET["start"] > 0) {
            $start = $_GET["start"];
        }

        $m = Model::getModel();

        //Récupération du nombre total de prix nobel
        $nb_nobels = $m->getNbNobelPrizes();

        $nb_total_pages = ceil($nb_nobels / NB_RESULTATS_PAR_PAGE);
        if ($nb_total_pages < $start) {
            $this->action_error("The page does not exist!");
        }

        //Détermination du premier résultat à récupérer dans la base de données
        $offset = ($start - 1) * NB_RESULTATS_PAR_PAGE;

        //Détermination du début et de la fin des numéros de page à afficher
        $debut = $start - 5;
        if($debut <= 0 ){
            $debut = 1;
        }
        
        $fin = $debut + 9;
        if($fin > $nb_total_pages){
            $fin = $nb_total_pages;
        }
        
        $data = [
            //Nb prix nobels
            'nb_total_pages' => $nb_total_pages,

            //indice de la page de résultats visualisée
            'active' => $start,

            //Récupération des prix nobel de la page $start
            'liste' => $m->getNobelPrizesWithLimit($offset, NB_RESULTATS_PAR_PAGE),

            //Début et fin des urls des pages
            'debut' => $debut,

            'fin' => $fin
        ];

        //Affichage de la vue
        $this->render("pagination", $data);
    }
}
