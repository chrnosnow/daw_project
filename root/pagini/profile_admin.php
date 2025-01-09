<?php
define('ALLOWED_ACCESS', true);
require_once __DIR__ . '/../lib/common.php';

require_role(['admin']);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();


$total_visits = get_total_visits()[0]['total_visits'] ?? $errors['total_visits'] = "A aparut o eroare la interogarea numarului de utilizatori.";

$unique_visitors = get_total_unique_visitors()[0]['unique_visitors'] ?? $errors['unique_visitors'] = "A aparut o eroare la interogarea numarului de utilizatori unici.";

$unique_ip = get_unique_ip_list()[0] ?? $errors['unique_visitors'] = "A aparut o eroare la interogarea IP-urilor.";

// Configurare paginatie
$results_per_page = 6;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($current_page - 1) * $results_per_page;

$total_visits_per_page = get_visits_per_page() ?? $errors['visits_page'] = "A aparut o eroare la obtinerea datelor despre vizite.";
$num = sizeof($total_visits_per_page);
$total_pages = ceil($num / $results_per_page);

//Obtinem pagina curenta a listei de carti filtrare
$visits_per_page = get_visits_per_page($results_per_page, $offset);
var_dump(empty($offset));
var_dump($results_per_page);

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}

?>

<!DOCTYPE html>
<html lang="ro">
<?php
view('head', ['title' => 'Profil administrator']);
require_once __DIR__ . '/../fragmente/header_user.php';
?>
<div class="wrapper">
    <?php
    require_once __DIR__ . "/../fragmente/sidebar_user.php";
    ?>
    <div class="wrapper-user-account">
        <div class="title">
            <h2>Profil administrator</h2>
        </div>
        <div class="title">
            <h3>Statistici website</h3>
        </div>
        <?php
        if (isset($_SESSION['errors'])) {
            display_alert('errors');
        }
        ?>

        <!-- statistici site -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Numar accesari</th>
                    <th>Numar vizitatori unici</th>
                    <th>Lista IP-uri vizitatori</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($total_visits) || !empty($unique_visitors) || !empty($unique_ip) || !empty($unique_ip)): ?>
                    <tr>
                        <td><?= htmlspecialchars($total_visits) ?? '-' ?></td>
                        <td><?= htmlspecialchars($unique_visitors) ?? '-' ?></td>
                        <td>
                            <?php foreach ($unique_ip as $uip): ?>
                                <?= htmlspecialchars($uip) ?? '-' ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="4">
                            <p class="text-center">Nu s-au gasit date.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <table class="table table-bordered">
            <caption>Numar vizite per pagina</caption>
            <thead>
                <tr>
                    <th>Pagina</th>
                    <th>Numar vizite </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($visits_per_page)): ?>
                    <?php foreach ($visits_per_page as $index => $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['full_url']) ?? '-' ?></td>
                            <td><?= htmlspecialchars($row['visits']) ?? '-' ?></td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">
                            <p class="text-center">Nu s-au gasit date.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Paginare -->
        <nav>
            <ul class="pagination">
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $current_page - 1 ?>">Inapoi</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i === $current_page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $current_page + 1 ?>">Inainte</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

</div>
</main>
</body>

</html>