<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/../pagini/common.php';

require_role(['admin', 'user']);

logout();
