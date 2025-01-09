<?php
define('ALLOWED_ACCESS', true);
require_once __DIR__ . '/../pagini/common.php';

require_role(['admin', 'user']);
// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();
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

    </div>
</div>
</main>
</body>

</html>