<?php
require_once __DIR__ . '/../lib/common.php';
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
        <?php
        require_once __DIR__ . '/../fragmente/user_update_password.php';
        ?>
    </div>
</div>
</main>
</body>

</html>