<?php
require_once __DIR__ . "/../lib/common.php";


// Simulăm autentificarea utilizatorului pentru demonstrație
// Într-o aplicație reală, se vor folosi baze de date pentru autentificare și datele utilizatorului
$_SESSION['user_type'] = 'admin'; // Sau 'user'

function getMenuByUserType($userType)
{
  if ($userType === 'admin') {
    return [
      'CARTI' => ['Adauga o carte', 'Modifica sau sterge o carte'],
      'IMPRUMUTURI' => [],
      'PROFIL' => ['Date personale', 'Modifica profil'],
      'Delogare' => []
    ];
  } elseif ($userType === 'user') {
    return [
      'CARTI' => ['Cere o carte', 'Imprumuturi'],
      'PROFIL' => ['Date personale', 'Modifica profil', 'Sterge cont'],
      'Delogare' => []
    ];
  }

  return [];
}

$userType = $_SESSION['user_type'] ?? 'guest';
$menu = getMenuByUserType($userType);
?>

<head>
  <?php require_once __DIR__ . "/head.php"; ?>
  <link rel="stylesheet" href="../resurse/css/nav_user.css" type="text/css">

</head>

<body>
  <header>
    <div class="top-bar">
      <div class="site-logo">
        <a href="/" rel="home">
          <picture class="header-logo">
            <source srcset="../resurse/imagini/logo_mba_800.avif" media="(max-width:800px)" />
            <img alt="Biblioteca Mica bufnita a Atenei" src="../resurse/imagini/logo_mba.avif" />
          </picture>
        </a>
      </div>
      <div class="search-bar container mt-4">
        <form action="../pagini/list_books.php" method="get" class="mb-3">
          <div class="form-group">
            <input type="text" class="form-control search-box" name="search" placeholder="Cauta in catalog...">
          </div>
          <button type="submit" class="btn btn-primary search-btn"><i class="fa fa-search"></i>
          </button>
        </form>
      </div>
      <div class="menu">
        <a href="user/auth.php"><i class="fa-solid fa-user"></i></a>
        <a href="#">Acasa</a>
        <a href="#">Contact</a>
        <a href="#">Program</a>
      </div>
    </div>

    <div class="container-sidebar">
      <div class="side-bar">
        <ul>
          <?php foreach ($menu as $category => $subItems): ?>
            <li>
              <a id="categ" href="#"><?php echo $category; ?></a>
              <?php if (!empty($subItems)): ?>
                <ul>
                  <?php foreach ($subItems as $subItem): ?>
                    <li><a href="#"><?php echo $subItem; ?></a></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

  </header>

  <main>