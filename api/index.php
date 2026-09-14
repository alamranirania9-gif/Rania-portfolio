<?php
/* =========================================================
   PORTFOLIO PHP - RANIA
   Un seul fichier : PHP + HTML + CSS
   Les images sont récupérées automatiquement depuis /images
   ========================================================= */

/* =========================
   CONFIGURATION
========================= */

$nomSite = "MyProjects";

$dossierImages = __DIR__ . "/images/";
$urlImages = "images/";

$extensionsAutorisees = [
    "jpg",
    "jpeg",
    "png",
    "gif",
    "webp"
];


/* =========================
   RÉCUPÉRATION DES PHOTOS
========================= */

$images = [];

if (is_dir($dossierImages)) {

    $fichiers = scandir($dossierImages);

    foreach ($fichiers as $fichier) {

        if ($fichier === "." || $fichier === "..") {
            continue;
        }

        $chemin = $dossierImages . $fichier;

        if (!is_file($chemin)) {
            continue;
        }

        $extension = strtolower(
            pathinfo($fichier, PATHINFO_EXTENSION)
        );

        if (in_array($extension, $extensionsAutorisees)) {
            $images[] = $fichier;
        }
    }
}

/* Trier les photos */
sort($images);


/* =========================
   STATISTIQUES
========================= */

$nombreProjets = count($images);

$technologies = [
    "HTML",
    "CSS",
    "JavaScript",
    "PHP",
    "MySQL",
    "PDO",
    "AJAX",
    "JSON"
];

$nombreTechnologies = count($technologies);


/* =========================
   NOM DU PROJET
========================= */

function nomProjet($fichier)
{
    $nom = pathinfo(
        $fichier,
        PATHINFO_FILENAME
    );

    $nom = str_replace(
        ["_", "-"],
        " ",
        $nom
    );

    return ucfirst($nom);
}


/* =========================
   DESCRIPTION
========================= */

function descriptionProjet($fichier)
{
    $nom = strtolower(
        pathinfo(
            $fichier,
            PATHINFO_FILENAME
        )
    );

    if (strpos($nom, "php") !== false) {
        return "Application web développée avec PHP, MySQL et PDO.";
    }

    if (
        strpos($nom, "ajax") !== false ||
        strpos($nom, "json") !== false
    ) {
        return "Formulaire dynamique utilisant JavaScript, AJAX, API et JSON.";
    }

    if (
        strpos($nom, "mcd") !== false ||
        strpos($nom, "mld") !== false ||
        strpos($nom, "mpd") !== false
    ) {
        return "Conception d'une base de données avec MCD, MLD et MPD.";
    }

    if (
        strpos($nom, "boutique") !== false ||
        strpos($nom, "shop") !== false ||
        strpos($nom, "ecommerce") !== false
    ) {
        return "Projet de boutique en ligne avec présentation des produits.";
    }

    return "Projet web réalisé avec différentes technologies.";
}

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($nomSite) ?>
    </title>


    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            background: #f1f5f9;
            color: #1e293b;
            line-height: 1.6;
        }


        /* =====================================================
           NAVIGATION
        ===================================================== */

        header {
            background: #0f172a;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow:
                0 3px 15px rgba(15, 23, 42, 0.25);
        }


        nav {
            max-width: 1200px;
            margin: auto;
            padding: 18px 25px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }


        .logo {
            color: white;
            text-decoration: none;
            font-size: 25px;
            font-weight: bold;
        }


        .logo span {
            color: #38bdf8;
        }


        .nav-links {
            list-style: none;

            display: flex;

            gap: 30px;
        }


        .nav-links a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s;
        }


        .nav-links a:hover {
            color: #38bdf8;
        }


        /* =====================================================
           HERO
        ===================================================== */

        .hero {

            min-height: 600px;

            background:
                linear-gradient(
                    135deg,
                    #0f172a,
                    #1e3a8a,
                    #2563eb
                );

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            text-align: center;

            padding: 80px 20px;
        }


        .hero-content {
            max-width: 850px;
        }


        .hero h1 {
            font-size: 58px;
            margin-bottom: 20px;
        }


        .hero h1 span {
            color: #7dd3fc;
        }


        .hero p {
            font-size: 20px;
            color: #dbeafe;

            max-width: 700px;

            margin: auto;

            margin-bottom: 35px;
        }


        .hero-buttons {

            display: flex;

            justify-content: center;

            gap: 15px;

            flex-wrap: wrap;
        }


        .btn {

            display: inline-block;

            padding: 13px 28px;

            border-radius: 8px;

            text-decoration: none;

            font-weight: bold;

            transition: 0.3s;
        }


        .btn-primary {

            background: #38bdf8;

            color: #082f49;
        }


        .btn-primary:hover {

            background: #7dd3fc;

            transform: translateY(-3px);
        }


        .btn-secondary {

            border: 1px solid #93c5fd;

            color: white;
        }


        .btn-secondary:hover {

            background: rgba(255,255,255,0.1);

            transform: translateY(-3px);
        }


        /* =====================================================
           STATISTIQUES
        ===================================================== */

        .stats {

            max-width: 1000px;

            margin: -50px auto 0;

            background: white;

            border-radius: 15px;

            padding: 30px;

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;

            position: relative;

            box-shadow:
                0 10px 30px
                rgba(15, 23, 42, 0.12);
        }


        .stat {

            text-align: center;

            border-right:
                1px solid #e2e8f0;
        }


        .stat:last-child {
            border-right: none;
        }


        .stat h2 {

            color: #2563eb;

            font-size: 32px;
        }


        .stat p {
            color: #64748b;
        }


        /* =====================================================
           PROJETS
        ===================================================== */

        .projects {

            max-width: 1200px;

            margin: auto;

            padding: 100px 25px;
        }


        .section-title {

            text-align: center;

            margin-bottom: 50px;
        }


        .section-title h2 {

            font-size: 38px;

            color: #0f172a;

            margin-bottom: 10px;
        }


        .section-title p {

            color: #64748b;

            font-size: 17px;
        }


        .project-grid {

            display: grid;

            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(280px, 1fr)
                );

            gap: 25px;
        }


        /* =====================================================
           CARTE
        ===================================================== */

        .project-card {

            background: white;

            border-radius: 14px;

            overflow: hidden;

            border: 1px solid #e2e8f0;

            box-shadow:
                0 5px 20px
                rgba(15, 23, 42, 0.08);

            transition: 0.3s;
        }


        .project-card:hover {

            transform: translateY(-8px);

            box-shadow:
                0 15px 35px
                rgba(15, 23, 42, 0.15);
        }


        /* =====================================================
           PHOTO
        ===================================================== */

        .project-image {

            height: 220px;

            width: 100%;

            overflow: hidden;

            background: #e2e8f0;
        }


        .project-image img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            display: block;

            transition: 0.4s ease;
        }


        .project-card:hover
        .project-image img {

            transform: scale(1.08);
        }


        /* =====================================================
           CONTENU CARTE
        ===================================================== */

        .project-content {

            padding: 25px;
        }


        .project-content h3 {

            color: #0f172a;

            margin-bottom: 10px;

            font-size: 22px;
        }


        .project-content p {

            color: #64748b;

            margin-bottom: 20px;
        }


        .project-link {

            color: #2563eb;

            text-decoration: none;

            font-weight: bold;
        }


        .project-link:hover {

            color: #0284c7;
        }


        /* =====================================================
           AUCUN PROJET
        ===================================================== */

        .empty {

            grid-column: 1 / -1;

            background: white;

            padding: 60px;

            text-align: center;

            border-radius: 15px;

            border: 1px solid #e2e8f0;
        }


        .empty h3 {

            color: #0f172a;

            margin-bottom: 10px;
        }


        .empty p {

            color: #64748b;
        }


        /* =====================================================
           TECHNOLOGIES
        ===================================================== */

        .technologies {

            background: #e2e8f0;

            padding: 80px 25px;
        }


        .tech-container {

            max-width: 1000px;

            margin: auto;

            text-align: center;
        }


        .tech-container h2 {

            font-size: 35px;

            color: #0f172a;

            margin-bottom: 35px;
        }


        .tech-list {

            display: flex;

            justify-content: center;

            gap: 15px;

            flex-wrap: wrap;
        }


        .tech {

            background: white;

            color: #334155;

            padding: 12px 22px;

            border-radius: 25px;

            border:
                1px solid #cbd5e1;

            font-weight: bold;

            transition: 0.3s;
        }


        .tech:hover {

            background: #2563eb;

            color: white;

            border-color: #2563eb;
        }


        /* =====================================================
           CONTACT
        ===================================================== */

        .contact {

            max-width: 900px;

            margin: auto;

            padding: 100px 25px;

            text-align: center;
        }


        .contact h2 {

            font-size: 38px;

            color: #0f172a;

            margin-bottom: 15px;
        }


        .contact p {

            color: #64748b;

            margin-bottom: 30px;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        footer {

            background: #0f172a;

            color: #cbd5e1;

            text-align: center;

            padding: 30px 20px;
        }


        footer strong {

            color: #38bdf8;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 768px) {

            nav {

                flex-direction: column;

                gap: 15px;
            }


            .nav-links {

                gap: 12px;

                flex-wrap: wrap;

                justify-content: center;
            }


            .nav-links a {

                font-size: 14px;
            }


            .hero h1 {

                font-size: 40px;
            }


            .hero p {

                font-size: 17px;
            }


            .stats {

                margin: -30px 20px 0;

                grid-template-columns: 1fr;
            }


            .stat {

                border-right: none;

                border-bottom:
                    1px solid #e2e8f0;

                padding-bottom: 15px;
            }


            .stat:last-child {

                border-bottom: none;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVIGATION
===================================================== -->

<header>

    <nav>

        <a
            href="index.php"
            class="logo"
        >
            My<span>Projects</span>
        </a>


        <ul class="nav-links">

            <li>
                <a href="#accueil">
                    Accueil
                </a>
            </li>

            <li>
                <a href="#projets">
                    Projets
                </a>
            </li>

            <li>
                <a href="#technologies">
                    Technologies
                </a>
            </li>

            <li>
                <a href="#contact">
                    Contact
                </a>
            </li>

        </ul>

    </nav>

</header>



<!-- =====================================================
     ACCUEIL
===================================================== -->

<section
    class="hero"
    id="accueil"
>

    <div class="hero-content">

        <h1>

            Bienvenue dans

            <span>
                mes projets
            </span>

        </h1>


        <p>

            Découvrez mes différents projets web,
            applications et travaux réalisés avec
            différentes technologies.

        </p>


        <div class="hero-buttons">

            <a
                href="#projets"
                class="btn btn-primary"
            >
                Voir mes projets
            </a>


            <a
                href="#contact"
                class="btn btn-secondary"
            >
                Me contacter
            </a>

        </div>

    </div>

</section>



<!-- =====================================================
     STATISTIQUES
===================================================== -->

<section class="stats">


    <div class="stat">

        <h2>

            <?= str_pad(
                $nombreProjets,
                2,
                "0",
                STR_PAD_LEFT
            ) ?>

        </h2>

        <p>
            Projets
        </p>

    </div>


    <div class="stat">

        <h2>

            <?= str_pad(
                $nombreTechnologies,
                2,
                "0",
                STR_PAD_LEFT
            ) ?>

        </h2>

        <p>
            Technologies
        </p>

    </div>


    <div class="stat">

        <h2>
            100%
        </h2>

        <p>
            Motivation
        </p>

    </div>


</section>



<!-- =====================================================
     PROJETS
===================================================== -->

<section
    class="projects"
    id="projets"
>


    <div class="section-title">

        <h2>
            Mes projets
        </h2>

        <p>
            Une sélection de mes travaux et réalisations.
        </p>

    </div>



    <div class="project-grid">


        <?php if (count($images) > 0): ?>


            <?php foreach ($images as $image): ?>

                <?php

                $nom = nomProjet($image);

                $description =
                    descriptionProjet($image);

                $cheminImage =
                    $urlImages . $image;

                ?>


                <article class="project-card">


                    <!-- PHOTO -->

                    <div class="project-image">

                        <img

                            src="<?= htmlspecialchars(
                                $cheminImage
                            ) ?>"

                            alt="<?= htmlspecialchars(
                                $nom
                            ) ?>"

                            loading="lazy"

                        >

                    </div>



                    <!-- TEXTE -->

                    <div class="project-content">


                        <h3>

                            <?= htmlspecialchars(
                                $nom
                            ) ?>

                        </h3>


                        <p>

                            <?= htmlspecialchars(
                                $description
                            ) ?>

                        </p>


                        <a

                            href="<?= htmlspecialchars(
                                $cheminImage
                            ) ?>"

                            target="_blank"

                            class="project-link"

                        >

                            Voir le projet →

                        </a>


                    </div>


                </article>


            <?php endforeach; ?>


        <?php else: ?>


            <div class="empty">

                <h3>
                    Aucun projet
                </h3>

                <p>

                    Ajoutez vos photos dans le dossier
                    <strong>images</strong>.

                </p>

            </div>


        <?php endif; ?>


    </div>

</section>



<!-- =====================================================
     TECHNOLOGIES
===================================================== -->

<section
    class="technologies"
    id="technologies"
>


    <div class="tech-container">


        <h2>
            Technologies utilisées
        </h2>


        <div class="tech-list">


            <?php foreach ($technologies as $tech): ?>

                <span class="tech">

                    <?= htmlspecialchars(
                        $tech
                    ) ?>

                </span>

            <?php endforeach; ?>


        </div>


    </div>


</section>



<!-- =====================================================
     CONTACT
===================================================== -->

<section
    class="contact"
    id="contact"
>


    <h2>
        Vous avez un projet ?
    </h2>


    <p>

        Découvrez mes réalisations ou contactez-moi
        pour discuter d'un nouveau projet.

    </p>


    <a
        href="mailto:contact@example.com"
        class="btn btn-primary"
    >

        Me contacter

    </a>


</section>



<!-- =====================================================
     FOOTER
===================================================== -->

<footer>

    <p>

        © <?= date("Y") ?>

        <strong>
            MyProjects
        </strong>

        .

        Tous droits réservés.

    </p>

</footer>


</body>

</html>