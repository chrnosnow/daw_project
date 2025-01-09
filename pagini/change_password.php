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
view('head', ['title' => 'Modifica parola']);
require_once __DIR__ . '/../fragmente/header_user.php';
?>
<div class="wrapper">
    <?php
    require_once __DIR__ . "/../fragmente/sidebar_user.php";
    ?>
    <div class="wrapper-user-account">
        <div class="title">
            <h2>Modifica parola</h2>
        </div>
        <div class="form-box personal-info ">

            <?php
            if (isset($_SESSION['errors'])) {
                display_alert('errors');
            }
            if (isset($_SESSION['alerts'])) {
                display_alert('alerts');
            }
            if (isset($_SESSION['success'])) {
                display_alert('success');
            }
            ?>

            <form id="form" action="../user/update.php" method="post" autocomplete="off">
                <input type="hidden" name="token_processing" value="<?= generate_form_token() ?>">
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="current_pass" placeholder=" " />
                    <label>Parola veche*</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="pass" placeholder=" " />
                    <label>Parola noua*</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="pass2" placeholder=" " />
                    <label>Confirma parola noua*</label>
                </div>
                <input type="submit" class="btn" name="savePassw" value="Salveaza"></input>
            </form>
        </div>
    </div>
</div>
</main>
</body>

</html>