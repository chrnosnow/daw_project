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
view('head', ['title' => 'Date personale']);
require_once __DIR__ . '/../fragmente/header_user.php';
?>
<div class="wrapper">
    <?php
    require_once __DIR__ . "/../fragmente/sidebar_user.php";
    ?>
    <div class="wrapper-user-account">
        <div class="title">
            <h2>Date personale</h2>
        </div>
        <div class="form-box personal-info ">

            <?php
            if (isset($_SESSION['errors'])) {
                display_alert('errors');
            }
            if (isset($_SESSION['success'])) {
                display_alert('success');
            }
            ?>

            <form id="form" action="../user/update.php" method="post" autocomplete="off">
                <input type="hidden" name="token_processing" value="<?= generate_form_token() ?>">
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-user-tag"></i></span>
                    <input type="text" name="uname" placeholder=" " value="<?php echo $_SESSION['user']['username'] ?? '' ?>" />
                    <label>Nume utilizator</label>
                </div>
                <div class="input-box email">
                    <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" placeholder=" " value="<?php echo $_SESSION['user']['email'] ?? '' ?>" disabled />
                    <label>Email</label>
                </div>
                <div class="input-box card-no">
                    <span class="icon"><i class="fa-solid fa-address-card"></i></span>
                    <input type="text" name="card-no" placeholder=" " value="<?php echo $_SESSION['user']['card_no'] ?? '' ?>" disabled />
                    <label>Permis nr.</label>
                </div>
                <input type="submit" class="btn" name="saveDetails" value="Salveaza"></input>
            </form>
        </div>
    </div>
</div>
</main>
</body>

</html>