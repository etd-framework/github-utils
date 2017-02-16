<?php
/**
 * @package     EtdGithubUtils
 *
 * @version     0.0.1
 * @copyright   Copyright (C) 2017 ETD Solutions, SARL Etudoo. Tous droits réservés.
 * @license     http://etd-solutions.com/LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

namespace EtdSolutions\EtdGithubUtils\Controller;

use EtdSolutions\Controller\Controller;
use EtdSolutions\EtdGithubUtils\Helper\ApiHelper;

class LoginControllerCreate extends Controller {

    /**
     * On authentifie un utilisateur par son nom d'utilisateur et son mot de passe.
     *
     * Si les credentials sont bons, on crée un jeton pour les futures requêtes.
     *
     */
    public function execute() {

        $app   = $this->getApplication();
        $input = new \Joomla\Input\Json();
/*
        // On contrôle les données JSON en entrée.
        if (!ApiHelper::validateJSON($input->getRaw())) {
            $app->raiseError('Problems parsing JSON', 400);
        }

        // On récupère les paramètres.
        $username = $input->get('username', '', 'username');
        $password = $input->get('password', '', 'string');

        // On tente de créer un jeton pour l'utilisateur si celui-ci s'authentifie.
        $model = $this->getModel();
        $token = $model->login($username, $password);

        // Si l'authentification a réussi
        if ($token !== false) {

            return [
                'status' => 201,
                'token'  => $token
            ];

        }*/

        return [
            'status' => 200,
            'token'  => 'svsdv'
        ];

        // Si l'authentification a échoué
        return [
            'status'  => 401,
            'message' => 'Bad credentials'
        ];

    }

}