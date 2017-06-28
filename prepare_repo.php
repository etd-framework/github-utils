<?php

// Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Method to detect the requested URI from server environment variables.
 *
 * @return  string  The requested URI
 *
 * @since   1.0
 */
function detectRequestUri() {

    $input = new \Joomla\Input\Input();
    $_SERVER;
    $serverSSLVar    = $input->server->getString('HTTPS', '');
    $isSslConnection = (!empty($serverSSLVar) && strtolower($serverSSLVar) != 'off');

    $scheme = $isSslConnection ? 'https://' : 'http://';

    $phpSelf    = $input->server->getString('PHP_SELF', '');
    $requestUri = $input->server->getString('REQUEST_URI', '');

    // If PHP_SELF and REQUEST_URI are both populated then we will assume "Apache Mode".
    if (!empty($phpSelf) && !empty($requestUri)) {
        $uri = $scheme . $input->server->getString('HTTP_HOST') . $requestUri;
    } else {
        // IIS uses the SCRIPT_NAME variable instead of a REQUEST_URI variable... thanks, MS
        $uri       = $scheme . $input->server->getString('HTTP_HOST') . $input->server->getString('SCRIPT_NAME');
        $queryHost = $input->server->getString('QUERY_STRING', '');

        // If the QUERY_STRING variable exists append it to the URI string.
        if (!empty($queryHost)) {
            $uri .= '?' . $queryHost;
        }
    }

    return trim($uri);
}

// SSL !!!!!!

$uri = new \Joomla\Uri\Uri(detectRequestUri());

if (!$uri->isSSL()) {
    $uri->setScheme("https");
    header('Location: ' . $uri->toString());
    die;
}

?>
<!doctype html>
<html class="no-js" lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Préparation d'un repo</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        html,body{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;text-rendering:optimizeLegibility}
        body{background: #fff url(bg.jpg) no-repeat center fixed;background-size: cover}
    </style>
</head>
<body onload="document.getElementById('submit').disabled=false;document.getElementById('submit').innerHTML='boum !'">

<form action="/do_prepare.php" method="post" class="panel panel-default" style="width:400px;margin:80px auto" onsubmit="document.getElementById('submit').disabled=true;document.getElementById('submit').innerHTML='en cours...'">
    <div class="panel-heading">
        <h3 class="panel-title">Préparation d'un repo</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="github_token">Token GitHub</label>
            <input type="password" name="github_token" value="" class="form-control" id="github_token" required>
        </div>
        <div class="form-group">
            <label for="github_owner">Owner</label>
            <input type="text" name="github_owner" value="jbanety" class="form-control" id="github_owner" required>
        </div>
        <div class="form-group">
            <label for="github_repo">Repo</label>
            <input type="text" name="github_repo" value="" class="form-control" id="github_repo" required>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="create_labels" value="1" autocomplete="off" checked> Créer les labels
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="create_templates" value="1" autocomplete="off" checked> Créer les templates
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="create_issues" value="1" autocomplete="off" checked onchange="document.getElementById('zenhub').style.display=(this.checked)?'block':'none'"> Créer les issues
                </label>
            </div>
        </div>
        <div id="zenhub">
            <div class="form-group">
                <label for="project_type">Type de projet</label>
                <select class="form-control" id="project_type" name="project_type">
                    <option value="vitrine">Site vitrine</option>
                    <option value="seo">SEO</option>
                </select>
            </div>
            <div class="form-group">
                <label for="github_token">Token ZenHub</label>
                <input type="password" name="zenhub_token" value="" class="form-control" id="zenhub_token">
            </div>
        </div>
        <button id="submit" type="submit" class="btn btn-lg btn-success btn-block" autocomplete="off">boum !</button>
    </div>

</form>

</body>
</html>
