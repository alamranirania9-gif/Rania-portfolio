```php
<?php
session_start();

/* Date actuelle */
$date = date("d/m/Y");

/* Gestion simple des visites */
$fichier_visites = "visites.txt";

if (!file_exists($fichier_visites)) {
    file_put_contents($fichier_visites, "0");
}

$visites = (int) file_get_contents($fichier_visites);
$visites++;

file_put_contents($fichier_visites, $visites);

/* Nom de l'utilisateur s'il est connecté */
$nom = $_SESSION['nom_utilisateur'] ?? null;
?>

<!DOCTYPE html>

<html lang="fr">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Accueil - Mon Site Web</title>

  <style>

    /* Réinitialisation de base */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      color: #333;
      line-height: 1.6;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* En-tête / Navigation */
    header {
      background-color: #ffffff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      padding: 1rem 2rem;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: bold;
      color: #2c3e50;
      text-decoration: none;
    }

    .nav-links {
      display: flex;
      list-style: none;
      gap: 1.5rem;
    }

    .nav-links a {
      text-decoration: none;
      color: #555;
      font-weight: 500;
      transition: color 0.3s;
    }

    .nav-links a:hover {
      color: #3498db;
    }

    /* Section Héro */
    .hero {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      text-align: center;
      padding: 6rem 2rem;
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .hero h1 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 600px;
      margin-bottom: 2rem;
      opacity: 0.9;
    }

    .btn {
      display: inline-block;
      background-color: #ffffff;
      color: #764ba2;
      padding: 0.8rem 2rem;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    /* Section Fonctionnalités */
    .features {
      max-width: 1200px;
      margin: 0 auto;
      padding: 4rem 2rem;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
    }

    .feature-card {
      background: #f9f9f9;
      padding: 2rem;
      border-radius: 8px;
      text-align: center;
      border: 1px solid #eee;
    }

    .feature-card h3 {
      margin-bottom: 1rem;
      color: #2c3e50;
    }

    /* Pied de page */
    footer {
      background-color: #2c3e50;
      color: white;
      text-align: center;
      padding: 1.5rem;
      margin-top: auto;
    }

    .info {
      margin-top: 20px;
      font-size: 14px;
      opacity: 0.8;
    }

  </style>

</head>

<body>

  <!-- Navigation -->

  <header>

    <nav>

      <a href="index.php" class="logo">
        MonSite
      </a>

      <ul class="nav-links">

        <li>
          <a href="index.php">Accueil</a>
        </li>

        <li>
          <a href="about.php">À propos</a>
        </li>

        <li>
          <a href="services.php">Services</a>
        </li>

        <li>
          <a href="contact.php">Contact</a>
        </li>

        <?php if ($nom): ?>

          <li>
            <a href="profil.php">
              Bonjour <?= htmlspecialchars($nom) ?>
            </a>
          </li>

        <?php else: ?>

          <li>
            <a href="connexion.php">
              Connexion
            </a>
          </li>

        <?php endif; ?>

      </ul>

    </nav>

  </header>


  <!-- Contenu principal -->

  <main>

    <!-- Section Héro -->

    <section class="hero">

      <?php if ($nom): ?>

        <h1>
          Bienvenue <?= htmlspecialchars($nom) ?> 👋
        </h1>

      <?php else: ?>

        <h1>
          Bienvenue sur notre plateforme
        </h1>

      <?php endif; ?>

      <p>
        Découvrez nos services exceptionnels et donnez
        une nouvelle dimension à vos projets dès aujourd'hui.
      </p>

      <a href="services.php" class="btn">
        En savoir plus
      </a>

      <div class="info">

        <p>
          📅 Date : <?= $date ?>
        </p>

        <p>
          👁️ Nombre de visites : <?= $visites ?>
        </p>

      </div>

    </section>


    <!-- Section Caractéristiques -->

    <section class="features">

      <div class="feature-card">

        <h3>
          Rapide
        </h3>

        <p>
          Une exécution fluide et optimisée pour une expérience
          utilisateur idéale.
        </p>

      </div>


      <div class="feature-card">

        <h3>
          Sécurisé
        </h3>

        <p>
          Vos données sont protégées grâce aux dernières
          technologies de sécurité.
        </p>

      </div>


      <div class="feature-card">

        <h3>
          Moderne
        </h3>

        <p>
          Un design épuré, responsive et adapté à tous
          les types d'écrans.
        </p>

      </div>

    </section>

  </main>

  <footer>

    <p>
      &copy; <?= date("Y") ?> MonSite.
      Tous droits réservés.
    </p>

  </footer>

</body>

</html>
```
