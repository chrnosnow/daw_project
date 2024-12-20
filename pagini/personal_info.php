<?php
require_once __DIR__ . '/../lib/common.php';
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
        <?php
        require_once __DIR__ . '/../fragmente/user_update_details.php';
        ?>
    </div>
</div>
</main>
</body>

</html>