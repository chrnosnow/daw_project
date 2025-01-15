<?php
define('ALLOWED_ACCESS', true);


require __DIR__ . '/../lib/common.php';
require_once __DIR__ . '/../lib/pdf.php';


require_role(['user']);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();

$save_type = $_GET['saveAs'] ?? '';

if (is_get_req() && !empty($save_type)) {
    $user['id'] = $_SESSION['user']['id'];
    $user['username'] = $_SESSION['user']['username'];
    $user['email'] = $_SESSION['user']['email'];
    $user['card_no'] = $_SESSION['user']['card_no'];
    $errors = get_user_summary($user['id']); //$books, $books_count, $books_fees, $total_late_fee

    //create pdf
    if ($save_type === 'pdf') {
        $fee_pdf = new UserFeeListPDF('P', 'mm', 'A4');
        $fee_pdf->AliasNbPages(); // total pages number
        $fee_pdf->AddPage();
        $fee_pdf->UserInfo($user);
        $fee_pdf->SetDocTitleAndDate('Penalitati de intarziere');
        $header = ['Nr. crt.', 'Detalii carte', 'Data scadenta', 'Intarziere (zile)', 'Penalizare (lei)'];
        $widths = [15, 75, 30, 25, 25];
        $fee_pdf->CreateTableHeader($header, $widths, 19, 109, 10);
        $table_data = []; // borrowed books that produced late fee
        foreach ($books_fees as $i => $arr) {
            // if ($arr['late_fee'] > 0) {
            $table_data[] = [$arr['title'] . ", " . $arr['isbn'] . ", " . $arr['authors'], substr($arr['due_date'], 0, 10), $arr['days_late'], $arr['late_fee']];
            // }
        }
        $alignCellPositions = ['C', 'L', 'C', 'C', 'C'];
        $fee_pdf->FillTable($table_data, $widths, 20, 120, 5, $alignCellPositions);
        $message = "Va rugam sa achitati penalitatile de intarziere pentru a beneficia din nou de serviciile noastre de imprumut a cartilor.";
        $fee_pdf->writeMessageAlert([20, -70], array_sum($widths), $message);
        $current_time = new DateTime('now', new DateTimeZone('Europe/Bucharest'));
        $fee_pdf->Output('I', "penalizari-" . $user['card_no'] . "-" . $current_time->format('Ymd') . ".pdf");
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
    }
} else {
    redirect_to('../pagini/access_denied.php');
}
