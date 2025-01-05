<?php
require __DIR__ . '/../lib/common.php';

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();

logout();
