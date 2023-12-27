<?php

class Controller_search extends Controller
{
    public function action_default()
    {
        $this->action_form();
    }

    public function action_form()
    {
        $m = Model::getModel();
        $data = [
            'Categories' => $m->getCategories(),
        ];
        $this->render("form_search", $data);
    }

    /**
     * Affiche une page de la liste des résultats
     */
    public function action_results()
    {

        // Si le formulaire vient d'être soumis ou si les filtres n'ont pas été stockés dans la session
        if ((isset($_GET['submit']) and $_GET['submit'] === 'on') or (! isset($_SESSION['filters']))) {
            $_SESSION['filters'] = $this->filter_parameters();
        }

        // On récupère les filtres
        $filters = $_SESSION['filters'];

        // On détermine la page à afficher
        $start = 1;
        if (isset($_GET["start"]) and preg_match("/^\d+$/", $_GET["start"]) and $_GET["start"] > 0) {
            $start = $_GET["start"];
        }

        $m = Model::getModel();

        //Récupération du nombre total de prix nobel
        $nb_np = $m->nbFindNobelPrizes($filters);

        if ($nb_np == 0) {
            $this->render("search_noResults", ["filters" => $filters]);
        }

        $nb_total_pages = ceil($nb_np / NB_RESULTATS_PAR_PAGE);
        if ($nb_total_pages < $start) {
            $this->action_error("The page does not exist!");
        }

        //Détermination du premier résultat à récupérer dans la base de données
        $offset = ($start - 1) * NB_RESULTATS_PAR_PAGE;

        //Création du tableau data
        $data = [
            //Nb prix nobels
            'nb_np' => $nb_np,

            // Nombre de pages
            'nb_total_pages' => $nb_total_pages,

            //indice de la page de résultats visualisée
            'active' => $start,

            //Récupération des prix nobel de la page $start
            'liste' => $m->findNobelPrizes($filters, $offset, NB_RESULTATS_PAR_PAGE),

            //Récupération des urls des pages
            'links' => liste_pages($start, $nb_total_pages),

            'filters' => $filters,
        ];

        //Affichage de la vue
        $this->render("search_pagination", $data);
    }

    private function filter_parameters()
    {
        $filters = [];

        // Nom
        if (isset($_GET["name"]) and ! preg_match("/^ *$/", $_GET["name"])) {
            $filters['name'] = $_GET['name'];
        }

        // Année
        $signes = ['<=', '>=', '='];
        if (isset($_GET["year"], $_GET["sign"]) and preg_match("/^\d{4}$/", $_GET["year"]) and in_array($_GET['sign'], $signes)) {
            $filters['year'] = $_GET['year'];
            $filters['sign'] = $_GET['sign'];
        }

        // Catégories
        if (isset($_GET["categories"]) and is_array($_GET['categories']) and count($_GET['categories']) > 0) {
            $filters['categories'] = $_GET['categories'];
        }

        return $filters;
    }
}
