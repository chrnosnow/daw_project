<?php
define('ALLOWED_ACCESS', true);


require_once __DIR__ . '/../lib/common.php';

require_role(['admin', 'user']);
// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();

$errors = get_user_summary($_SESSION['user']['id']); //$books, $books_count, $books_fees, $total_late_fee

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}
?>

<!DOCTYPE html>
<html lang="ro">
<?php
view('head', ['title' => 'Contul meu']);
require_once __DIR__ . '/../fragmente/header_user.php';
?>

<div class="wrapper">
    <?php
    require_once __DIR__ . "/../fragmente/sidebar_user.php";
    ?>

    <div class="wrapper-user-account">
        <div class="title">
            <h2>Contul meu</h2>
        </div>

        <div class="user-greetings">
            <p>Bine ai venit, <?= $_SESSION['user']['username'] ?>! Sper ca ai o zi frumoasa.</p>
        </div>
        <?php
        if (isset($_SESSION['errors'])) {
            display_alert('errors');
        }
        ?>
        <div class="title">
            <h3>Sumar</h3>
        </div>
        <div>
            <p>Carti imprumutate: <?= htmlspecialchars($books_count) ?></p>
            <p>Total penalizari:
                <span style="color: darkred; font-weight: 600; font-size:1.1rem"><?= number_format($total_late_fee, 2) ?></span>&nbsp;-&nbsp;
                <a href="./user_borrowed_books.php">Detalii</a>
            </p>
        </div>
    </div>
</div>
</main>
</body>

</html>