<body>
  <header>
    <div class="top-bar">
      <div class="site-logo">
        <a href="../index.php" rel="home">
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
        <a href="../user/login.php"><i class="fa-solid fa-user"></i></a>
        <a href="../index.php">Acasa</a>
        <a href="../pagini/books_catalog.php?search=all">Catalog carti</a>
        <a href="../pagini/contact_us.php">Contact</a>

      </div>
    </div>
  </header>

  <main>