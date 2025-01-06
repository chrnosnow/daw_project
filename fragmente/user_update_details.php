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