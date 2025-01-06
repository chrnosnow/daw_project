<?php
define('ALLOWED_ACCESS', true);
require_once __DIR__ . '/../lib/common.php';

require_role(['admin', 'user']);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="ro">
<?php
view('head', ['title' => 'Profil administrator']);
require_once __DIR__ . '/../fragmente/header_user.php';
?>
<div class="wrapper">
    <?php
    require_once __DIR__ . "/../fragmente/sidebar_user.php";
    ?>
    <div class="wrapper-user-account">
        <div class="title">
            <h2>Profil administrator</h2>
        </div>

    </div>
</div>
</main>
</body>

</html>