<?php
require_once __DIR__ . "/../lib/common.php";

$user_type = $_SESSION['user']['is_admin'] ?? 'guest';
$menu = get_menu_by_user_type($user_type);
?>

<div class="container-sidebar">
    <div class="side-bar">
        <ul>
            <?php foreach ($menu as $category => $subItems): ?>
                <li id="categ">
                    <?php if (!is_array($subItems)): ?>
                        <a id="categ" href="<?= $subItems ?>"><?= $category; ?></a>
                    <?php else: ?>
                        <?= $category; ?>
                    <?php endif; ?>
                    <?php if (is_array($subItems)): ?>
                        <ul>
                            <?php foreach ($subItems as $subItem => $link): ?>
                                <li><a href="<?= $link ?>"><?= $subItem; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>