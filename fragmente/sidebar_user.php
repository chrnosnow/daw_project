<?php
require_once __DIR__ . "/../lib/common.php";

//TODO: verify user (admin or user) and expire session
// Simulăm autentificarea utilizatorului pentru demonstrație
// Într-o aplicație reală, se vor folosi baze de date pentru autentificare și datele utilizatorului
$_SESSION['user_type'] = 'admin'; // Sau 'user'

function getMenuByUserType($userType)
{
    if ($userType === 'admin') {
        return [
            'CARTI' => ['Adauga o carte' => '../pagini/add_book.php', 'Gestioneaza o carte' => '../pagini/manage_book.php'],
            'IMPRUMUTURI' => ['Acorda un imprumut' => '../pagini/borrow_book.php', 'Toate imprumuturile' => '../pagini/all_borrowed_books.php'],
            'RETURNARI' => ['Returneaza o carte' => '../pagini/return_book.php', 'Toate returnarile' => '../pagini/all_returned_books.php'],
            'UTILIZATORI' => ['Gestioneaza un utilizator' => '../pagini/manage_users.php'],
            'PROFIL' => ['Date personale' => '../pagini/personal_info.php', 'Modifica parola' => '../pagini/change_password.php'],
            'Deconectare' => '../pagini/logout.php'
        ];
    } elseif ($userType === 'user') {
        return [
            'CARTI' => ['Cere o carte', 'Imprumuturi'],
            'PROFIL' => ['Date personale', 'Modifica profil', 'Sterge cont'],
            'Deconectare' => '../pagini/logout.php'
        ];
    }

    return [];
}

$userType = $_SESSION['user_type'] ?? 'guest';
$menu = getMenuByUserType($userType);
?>

<div class="container-sidebar">
    <div class="side-bar">
        <ul>
            <?php foreach ($menu as $category => $subItems): ?>
                <li id="categ">
                    <?php if (!is_array($subItems)): ?>
                        <a id="categ" href="<?php echo $subItems[0] ?>"><?php echo $category; ?></a>
                    <?php else: ?>
                        <?php echo $category; ?>
                    <?php endif; ?>
                    <?php if (is_array($subItems)): ?>
                        <ul>
                            <?php foreach ($subItems as $subItem => $link): ?>
                                <li><a href="<?php echo $link ?>"><?php echo $subItem; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>