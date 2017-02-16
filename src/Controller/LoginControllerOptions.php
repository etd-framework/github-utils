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

class LoginControllerOptions extends Controller {

    /**
     * On valide les demandes CORS.
     */
    public function execute() {

        $app = $this->getApplication();
        $app->setHeader('Access-Control-Allow-Origin', '*');
        $app->setHeader('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
        $app->setHeader('Access-Control-Allow-Headers', 'Content-Type');
        $app->setHeader('Access-Control-Max-Age', '86400');
        $app->sendHeaders();

        $app->close(200);

    }

}