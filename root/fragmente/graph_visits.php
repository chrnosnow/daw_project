<?php
define('ALLOWED_ACCESS', true);
require_once __DIR__ . '/../lib/common.php';
require_role(['admin']);

require_once __DIR__ . '/../module/jpgraph-4.4.2/src/jpgraph.php';
require_once __DIR__ . '/../module/jpgraph-4.4.2/src/jpgraph_bar.php';


const COLOR_TEXT = '#011627';
const DARK_BLUE = '#1a2e49';
const BEIGE = '#eccfa4';

$total_visits_per_page = get_visits_per_page(15) ?? $errors['visits_page'] = "A aparut o eroare la obtinerea datelor despre vizite.";
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}
$datay = array_column($total_visits_per_page, 'visits');
$datax = array_column($total_visits_per_page, 'full_url');

// Size of graph
$width = 1000;
$height = 500;

// Set the basic parameters of the graph
$graph = new Graph($width, $height, 'auto');
$graph->SetScale('textlin');

// Rotate graph 90 degrees and set margin
$graph->Set90AndMargin(450, 20, 20, 20);

// Nice shadow
$graph->SetShadow();


// Setup X-axis
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_DV_SANSSERIF, FS_NORMAL, 11);
$graph->xaxis->SetColor(COLOR_TEXT);


// Some extra margin looks nicer
$graph->xaxis->SetLabelMargin(10);

// Label align for X-axis
$graph->xaxis->SetLabelAlign('right', 'center');

// Add some grace to y-axis so the bars doesn't go
// all the way to the end of the plot area
$graph->yaxis->scale->SetGrace(20);

// We don't want to display Y-axis
$graph->yaxis->Hide();

// Now create a bar pot
$bplot = new BarPlot($datay);
$bplot->SetShadow();

//You can change the width of the bars if you like
$bplot->SetWidth(0.4);
// Set gradient fill for bars
$bplot->SetFillGradient(BEIGE, DARK_BLUE, GRAD_HOR);
// Add the bar to the graph
$graph->Add($bplot);


// We want to display the value of each bar at the top
$bplot->value->Show();
$bplot->value->SetFont(FF_DV_SANSSERIF, FS_NORMAL, 10);
$bplot->value->SetAlign('left', 'center');
$bplot->value->SetColor(COLOR_TEXT);
$bplot->value->SetFormat('%.0f');


// .. and stroke the graph
$graph->Stroke();
