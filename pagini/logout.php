<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/../lib/common.php';

require_role(['admin', 'user']);

logout();
