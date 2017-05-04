<?php

@set_time_limit(0);
@ini_set('max_execution_time ', 0);

// Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

$input  = new \Joomla\Input\Input();
$token  = $input->get('token', '', 'string');
$owner  = $input->get('owner', '', 'string');
$repo   = $input->get('repo', '', 'string');
$issues = $input->get('issues', false, 'bool');

if (empty($token) || empty($owner) || empty($repo)) {
    die('invalid params');
}

// GitHub

$options = new \Joomla\Registry\Registry;
$options->set('gh.token', $token);

$github = new \Joomla\Github\Github($options);

// Labels
$labels = json_decode(file_get_contents(__DIR__."/data/labels.json"));

echo "Owner : " . $owner . " | Repo : " . $repo;
echo "<hr>";
echo "<h1>Labels</h1>";

try {

    // On récupère tous les labels
    $existing = $github->issues->labels->getList($owner, $repo);

    // On supprime les labels existants.
    foreach ($existing as $label) {
        $github->issues->labels->delete($owner, $repo, $label->name);
    }

    echo count($existing) . " labels supprimés.<br>";


} catch (\Exception $e) {
    die($e->getCode() . " : " . $e->getMessage());
}

foreach ($labels AS $label => $color) {

    echo "Traitement du label &quot;" . htmlspecialchars($label) . "&quot;... ";

    try {

        // On tente de récupérer le label.
        $github->issues->labels->get($owner, $repo, $label);

        // Le label existe, on le met à jour.
        $github->issues->labels->update($owner, $repo, $label, $label, $color);

        echo "mis à jour !";


    } catch (\Exception $e) {

        // Le label n'existe pas, on le crée
        if ($e->getCode() == 404) {

            try {

                // Le label existe, on le met à jour.
                $github->issues->labels->create($owner, $repo, $label, $color);

                echo "créé !";

            } catch (\Exception $e) {
                die($e->getCode() . " : " . $e->getMessage());
            }

        } else {
            die($e->getCode() . " : " . $e->getMessage());
        }

    }

    echo "<br>";

}

echo "<hr>";
echo "<h1>Templates</h1>";

$issue_template = file_get_contents(__DIR__ . "/templates/ISSUE_TEMPLATE.md");
$pr_template    = file_get_contents(__DIR__ . "/templates/PULL_REQUEST_TEMPLATE.md");

try {

    $github->repositories->contents->create($owner, $repo, ".github/ISSUE_TEMPLATE.md", "issue template", base64_encode($issue_template));
    echo "ISSUE_TEMPLATE créé.<br>";
    $github->repositories->contents->create($owner, $repo, ".github/PULL_REQUEST_TEMPLATE.md", "PR template", base64_encode($pr_template));
    echo "PULL_REQUEST_TEMPLATE créé.<br>";

} catch (\Exception $e) {
    echo($e->getCode() . " : " . $e->getMessage());
}

if ($issues) {

    echo "<hr>";
    echo "<h1>Issues</h1>";

    $issues = json_decode(file_get_contents(__DIR__."/data/issues.json"));

    foreach ($issues AS $issue) {

        try {

            // On crée l'issue.
            $github->issues->create($owner, $repo, $issue->title, $issue->body, null, null, $issue->labels, []);

        } catch (\Exception $e) {
            die($e->getCode() . " : " . $e->getMessage());
        }

    }

    echo count($issues) . " issues créées.";

}