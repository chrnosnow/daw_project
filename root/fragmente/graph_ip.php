<?php
define('ALLOWED_ACCESS', true);
require_once __DIR__ . '/../lib/common.php';
require_role(['admin']);

require_once __DIR__ . '/../module/jpgraph-4.4.2/src/jpgraph.php';
require_once __DIR__ . '/../module/jpgraph-4.4.2/src/jpgraph_pie.php';


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
$width = 400;
$height = 400;

$accesses_per_ip = get_accesses_per_ip();
$sum = array_sum(array_column($accesses_per_ip, 'accessed_no'));
$access_percent = [];
foreach ($accesses_per_ip as $ip => $count) {
    $access_percent[] = number_format($count['accessed_no'] / $sum, 2);
}
$ip_addr = array_column($accesses_per_ip, 'ip_address');
$data   = $access_percent;
$labels = [];
foreach ($ip_addr as $i) {
    $labels[] = $i . "\n(%.1f%%)";
}

// Create the Pie Graph.
$graph = new PieGraph($width, $height);
$graph->SetShadow();


// Create pie plot
$p1 = new PiePlot($data);
$p1->SetTheme('earth');
$p1->SetCenter(0.5, 0.5);
$p1->SetSize(0.25);


// Enable and set policy for guide-lines. Make labels line up vertically
$p1->SetGuideLines(true, false);
$p1->SetGuideLinesAdjust(2.3);

// Setup the labels to be displayed
$p1->SetLabels($labels);
// This method adjust the position of the labels. This is given as fractions
// of the radius of the Pie. A value < 1 will put the center of the label
// inside the Pie and a value >= 1 will pout the center of the label outside the
// Pie. By default the label is positioned at 0.5, in the middle of each slice.
$p1->SetLabelPos(1);

// Setup the label formats and what value we want to be shown (The absolute)
// or the percentage.
$p1->SetLabelType(PIE_VALUE_PER);
$p1->value->Show();
$p1->value->SetFont(FF_DV_SANSSERIF, FS_NORMAL, 9);
$p1->value->SetColor(COLOR_TEXT);

// Add and stroke
$graph->Add($p1);
$graph->Stroke();
