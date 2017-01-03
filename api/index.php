<?php

if (version_compare(PHP_VERSION, '7.0', '<')) {
    die('Your host needs to use PHP 7.0 or higher to run this application.');
}

// Constantes de l'application
define('JPATH_BASE', __DIR__);
define('JPATH_ROOT', dirname(__DIR__));
define('JPATH_LOGS', JPATH_ROOT . '/logs');
define('JPATH_FORMS', JPATH_ROOT . '/forms');
define('JPATH_MEDIA', JPATH_BASE . '/media');
define('JPATH_TEMPLATES', JPATH_ROOT . '/templates');
define('APP_NAMESPACE', '\\EtdSolutions\\EtdGithubUtils');

// On s'assure d'avoir initialisé Composer
if (!file_exists(JPATH_ROOT . '/vendor/autoload.php')) {
    header('HTTP/1.1 500 Internal Server Error', null, 500);
    echo '<!DOCTYPE html><head><meta charset="utf-8"><title>Erreur Serveur</title></head><body><h1>Composer n\'est pas installé</h1><p>Composer n\'est pas correctement installé, exécuter "composer install".</p></body></html>';
    exit(500);
}

// On importe le chargeur.
require_once JPATH_ROOT . '/vendor/autoload.php';

try {

    $container = (new \Joomla\DI\Container)
        ->registerServiceProvider(new EtdSolutions\Service\ConfigurationProvider(JPATH_ROOT . '/etc/config.json'))
	    ->registerServiceProvider(new EtdSolutions\Service\LanguageFactoryProvider)
        ->registerServiceProvider(new EtdSolutions\Service\DatabaseProvider)
        ->registerServiceProvider(new EtdSolutions\Service\SessionProvider)
        ->registerServiceProvider(new EtdSolutions\Service\UserProvider);

    // On définit le rapport d'erreur en fonction de la config
    $errorReporting = (int) $container->get('config')->get('error_reporting', 0);
    $errorLog       = $container->get('config')->get('error_log', null);
    error_reporting($errorReporting);

    @ini_set('display_errors', '1');

    if (isset($errorLog)) {
        @ini_set('error_log', JPATH_LOGS . "/" . $errorLog);
        @ini_set('log_errors', '1');
    }

} catch (\Exception $e) {
    header('HTTP/1.1 500 Internal Server Error', null, 500);
    echo '<!DOCTYPE html><head><meta charset="utf-8"><title>Erreur pendant l\'initialisation du container</title></head><body><h1>Erreur pendant l\'initialisation du container</h1><p>Une erreur est apparue lors de la création du container DI : ' . $e->getMessage() . '</p></body></html>';
    exit(500);
}

// On exécute l'application.
(new EtdSolutions\EtdGithubUtils\Application\Api(null, $container->get('config')))
    ->setContainer($container)
    ->execute();