<?php
define('ALLOWED_ACCESS', true);

require __DIR__ . '/../lib/common.php';

require_role(['admin']);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="ro">

<?php
view('head', ['title' => 'Gestiune carti']);
require_once __DIR__ . '/../fragmente/header_user.php';
?>

<div class="wrapper">
    <?php
    require_once __DIR__ . "/../fragmente/sidebar_user.php";
    ?>
    <div class="wrapper-user-account ">
        <div class="title">
            <h2>Adauga o carte</h2>
        </div>
        <div class="form-wrapper">
            <?php
            if (isset($_SESSION['errors'])) {
                display_alert('errors');
            }
            if (isset($_SESSION['success'])) {
                display_alert('success');
            }
            ?>
            <?php
            include __DIR__ . "/../fragmente/book_form.php";
            ?>
        </div>
    </div>
</div>
</main>
</body>

</html>