<?php
/**
 * @package     EtdInterfaces
 *
 * @version     0.0.1
 * @copyright   Copyright (C) 2014 ETD Solutions, SARL Etudoo. Tous droits réservés.
 * @license     http://etd-solutions.com/LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

namespace EtdSolutions\EtdGithubUtils\Helper;

class ApiHelper {

    /**
     * Ajoute l'entête Link à la réponse
     *
     * @param \EtdSolutions\Pagination\Pagination $pagination
     * @param \EtdSolutions\Application\Rest      $app
     */
    public static function setLinkHeader($pagination, $app) {

        $links   = [];
        $baseUri = $app->get('uri.base.full');

        if ($pagination->pagesCurrent > 1) {

            // First
            $links[] = '<' . $baseUri . 'users?start=0&limit=' . $pagination->limit . '>; rel="first"';

            // Prev
            $links[] = '<' . $baseUri . 'users?start=' . (($pagination->pagesCurrent - 2) * $pagination->limit) . '&limit=' . $pagination->limit . '>; rel="prev"';

        }

        if ($pagination->pagesCurrent < $pagination->pagesTotal) {

            // Next
            $links[] = '<' . $baseUri . 'users?start=' . ($pagination->pagesCurrent * $pagination->limit) . '&limit=' . $pagination->limit . '>; rel="next"';

            // Last
            $links[] = '<' . $baseUri . 'users?start=' . ($pagination->pagesTotal * $pagination->limit) . '&limit=' . $pagination->limit . '>; rel="last"';

        }

        if (!empty($links)) {
            $app->setHeader('Link', implode(", ", $links));
        }

    }

    public static function validateJSON($json) {

        json_decode($json);

        return (json_last_error() == JSON_ERROR_NONE);

    }

}