<?php

@set_time_limit(0);
@ini_set('max_execution_time ', 0);

// Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

$input  = new \Joomla\Input\Input();
$github_token  = $input->get('github_token', '', 'string');
$github_owner  = $input->get('github_owner', '', 'string');
$github_repo   = $input->get('github_repo', '', 'string');
$zenhub_token  = $input->get('zenhub_token', '', 'string');
$create_issues = $input->get('create_issues', false, 'bool');
$create_labels = $input->get('create_labels', false, 'bool');
$create_tmpl   = $input->get('create_templates', false, 'bool');

if (empty($github_token) || empty($github_owner) || empty($github_repo)) {
    die('invalid params');
}

// GitHub

$options = new \Joomla\Registry\Registry;
$options->set('gh.token', $github_token);

$github = new \Joomla\Github\Github($options);

echo "Owner : " . $github_owner . " | Repo : " . $github_repo;

// On récupère le repo sur GitHub.
try {
    $gh_repo = $github->repositories->get($github_owner, $github_repo);
} catch (\Exception $e) {
    die($e->getCode() . " : " . $e->getMessage());
}

// Labels
if ($create_labels) {

    $labels = json_decode(file_get_contents(__DIR__."/data/labels.json"));

    echo "<hr>";
    echo "<h1>Labels</h1>";

    try {

        // On récupère tous les labels
        $existing = $github->issues->labels->getList($github_owner, $github_repo);

        // On supprime les labels existants.
        foreach ($existing as $label) {
            $github->issues->labels->delete($github_owner, $github_repo, $label->name);
        }

        echo count($existing) . " labels supprimés.<br>";


    } catch (\Exception $e) {
        die($e->getCode() . " : " . $e->getMessage());
    }

    foreach ($labels AS $label => $color) {

        echo "Traitement du label &quot;" . htmlspecialchars($label) . "&quot;... ";

        try {

            // On tente de récupérer le label.
            $github->issues->labels->get($github_owner, $github_repo, $label);

            // Le label existe, on le met à jour.
            $github->issues->labels->update($github_owner, $github_repo, $label, $label, $color);

            echo "mis à jour !";


        } catch (\Exception $e) {

            // Le label n'existe pas, on le crée
            if ($e->getCode() == 404) {

                try {

                    // Le label existe, on le met à jour.
                    $github->issues->labels->create($github_owner, $github_repo, $label, $color);

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

}

if ($create_tmpl) {

    echo "<hr>";
    echo "<h1>Templates</h1>";

    $issue_template = file_get_contents(__DIR__ . "/templates/ISSUE_TEMPLATE.md");
    $pr_template    = file_get_contents(__DIR__ . "/templates/PULL_REQUEST_TEMPLATE.md");

    try {

        $github->repositories->contents->create($github_owner, $github_repo, ".github/ISSUE_TEMPLATE.md", "issue template", base64_encode($issue_template));
        echo "ISSUE_TEMPLATE créé.<br>";
        $github->repositories->contents->create($github_owner, $github_repo, ".github/PULL_REQUEST_TEMPLATE.md", "PR template", base64_encode($pr_template));
        echo "PULL_REQUEST_TEMPLATE créé.<br>";

    } catch (\Exception $e) {
        echo($e->getCode() . " : " . $e->getMessage());
    }

}

if ($create_issues) {

    echo "<hr>";
    echo "<h1>Issues</h1>";

    $issues = json_decode(file_get_contents(__DIR__."/data/issues.json"));

    if (!empty($zenhub_token)) {

        $options = new \Joomla\Registry\Registry;
        $options->set('zh.token', $zenhub_token);

        // On instancie ZenHub.
        $zenhub = new \EtdSolutions\Zenhub\Zenhub($options);

        // On récupère le board pour avoir l'id du pipeline Backlog.
        $zh_board = $zenhub->board->get($gh_repo->id);

    }

    foreach ($issues AS $issue) {

        try {

            // On crée l'issue.
            $gh_issue = $github->issues->create($github_owner, $github_repo, $issue->title, $issue->body, null, null, $issue->labels, []);

            // On lui donne les infos du Board
            if (!empty($zenhub_token)) {

                // Complexité
                if (isset($issue->estimate)) {
                    $zenhub->issues->estimate($gh_repo->id, $gh_issue->number, $issue->estimate);
                }

                // On passe l'issue sur le pipeline Backlog.
                $zenhub->issues->moves($gh_repo->id, $gh_issue->number, $zh_board->pipelines[2]->id, 'bottom');

                // Epic
                if (in_array("Epic", $issue->labels)) {
                    $zenhub->issues->convertToEpic($gh_repo->id, $gh_issue->number);
                }

            }

        } catch (\Exception $e) {
            die($e->getCode() . " : " . $e->getMessage());
        }

    }

    echo count($issues) . " issues créées.";

}