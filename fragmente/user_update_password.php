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

    <form action="../user/update.php" method="post" autocomplete="off">
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