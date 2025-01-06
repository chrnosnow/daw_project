<?php
require_once __DIR__ . '/../lib/common.php';
?>


<div class="container mt-4 wrapper-book">
    <form id="form" action="../contact/verify_recaptcha.php" method="post" autocomplete="off">
        <div class="form-group">
            <label for="uname">Username*</label>
            <input type="text" class="form-control" id="uname" name="uname">
        </div>
        <div class="form-group">
            <label for="email">Email*</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="subject">Subiect</label>
            <input type="text" class="form-control" id="subject" name="subject">
        </div>
        <div class="form-group">
            <label for="content">Mesaj</label>
            <textarea class="form-control" id="content" name="content" placeholder="Scrie un mesaj..." rows="7"></textarea>
        </div>
        <div class="g-recaptcha" data-sitekey="6LcJwK8qAAAAAPI7kG1_uzec48Ong5rTHkWQMzsb"></div>
        <input class="btn btn-primary btn-info" type="submit" name="submit" value="Trimite">
    </form>
</div>