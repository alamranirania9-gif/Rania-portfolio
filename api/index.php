```html
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mon Espace Projets</title>

    <style>

        /* =========================
           RESET
        ========================= */

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


        /* =========================
           NAVIGATION
        ========================= */

        header {
            background: #0f172a;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 3px 15px rgba(15, 23, 42, 0.25);
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


        /* =========================
           HERO
        ========================= */

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


        /* =========================
           STATISTIQUES
        ========================= */

        .stats {
            max-width: 1000px;
            margin: -50px auto 0;

            background: white;

            border-radius: 15px;

            padding: 30px;

            display: grid;
            grid-template-columns: repeat(3, 1fr);

            gap: 20px;

            position: relative;

            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        }

        .stat {
            text-align: center;
            border-right: 1px solid #e2e8f0;
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


        /* =========================
           SECTION PROJETS
        ========================= */

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


        /* =========================
           CARTES PROJETS
        ========================= */

        .project-grid {
            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(280px, 1fr));

            gap: 25px;
        }

        .project-card {
            background: white;

            border-radius: 14px;

            overflow: hidden;

            border: 1px solid #e2e8f0;

            box-shadow:
                0 5px 20px rgba(15, 23, 42, 0.08);

            transition: 0.3s;
        }

        .project-card:hover {
            transform: translateY(-8px);

            box-shadow:
                0 15px 35px rgba(15, 23, 42, 0.15);
        }

        .project-image {
            height: 180px;

            display: flex;

            align-items: center;
            justify-content: center;

            color: white;

            font-size: 45px;

            font-weight: bold;
        }

        .blue {
            background:
                linear-gradient(
                    135deg,
                    #1e3a8a,
                    #2563eb
                );
        }

        .light-blue {
            background:
                linear-gradient(
                    135deg,
                    #0284c7,
                    #38bdf8
                );
        }

        .gray {
            background:
                linear-gradient(
                    135deg,
                    #334155,
                    #64748b
                );
        }

        .dark-blue {
            background:
                linear-gradient(
                    135deg,
                    #172554,
                    #1d4ed8
                );
        }

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


        /* =========================
           TECHNOLOGIES
        ========================= */

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
            background: #ffffff;

            color: #334155;

            padding: 12px 22px;

            border-radius: 25px;

            border: 1px solid #cbd5e1;

            font-weight: bold;

            transition: 0.3s;
        }

        .tech:hover {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }


        /* =========================
           CONTACT
        ========================= */

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


        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #0f172a;

            color: #cbd5e1;

            text-align: center;

            padding: 30px 20px;
        }

        footer strong {
            color: #38bdf8;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .nav-links {
                gap: 12px;
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
                border-bottom: 1px solid #e2e8f0;
                padding-bottom: 15px;
            }

            .stat:last-child {
                border-bottom: none;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         NAVIGATION
    ========================== -->

    <header>

        <nav>

            <a href="index.html" class="logo">
                My<span>Projects</span>
            </a>

            <ul class="nav-links">

                <li>
                    <a href="#accueil">Accueil</a>
                </li>

                <li>
                    <a href="#projets">Projets</a>
                </li>

                <li>
                    <a href="#technologies">Technologies</a>
                </li>

                <li>
                    <a href="#contact">Contact</a>
                </li>

            </ul>

        </nav>

    </header>



    <!-- =========================
         ACCUEIL
    ========================== -->

    <section class="hero" id="accueil">

        <div class="hero-content">

            <h1>
                Bienvenue dans
                <span>mes projets</span>
            </h1>

            <p>
                Découvrez mes différents projets web,
                applications et travaux réalisés avec
                différentes technologies.
            </p>

            <div class="hero-buttons">

                <a href="#projets" class="btn btn-primary">
                    Voir mes projets
                </a>

                <a href="#contact" class="btn btn-secondary">
                    Me contacter
                </a>

            </div>

        </div>

    </section>



    <!-- =========================
         STATISTIQUES
    ========================== -->

    <section class="stats">

        <div class="stat">

            <h2>06</h2>

            <p>
                Projets
            </p>

        </div>


        <div class="stat">

            <h2>05</h2>

            <p>
                Technologies
            </p>

        </div>


        <div class="stat">

            <h2>100%</h2>

            <p>
                Motivation
            </p>

        </div>

    </section>



    <!-- =========================
         PROJETS
    ========================== -->

    <section class="projects" id="projets">

        <div class="section-title">

            <h2>
                Mes projets
            </h2>

            <p>
                Une sélection de mes travaux et réalisations.
            </p>

        </div>


        <div class="project-grid">


            <!-- PROJET 1 -->

            <div class="project-card">

                <div class="project-image blue">
                    P1
                </div>

                <div class="project-content">

                    <h3>
                        Projet Web
                    </h3>

                    <p>
                        Site web moderne avec une interface
                        responsive et élégante.
                    </p>

                    <a href="projet1.html" class="project-link">
                        Voir le projet →
                    </a>

                </div>

            </div>



            <!-- PROJET 2 -->

            <div class="project-card">

                <div class="project-image light-blue">
                    P2
                </div>

                <div class="project-content">

                    <h3>
                        Boutique en ligne
                    </h3>

                    <p>
                        Application e-commerce permettant
                        de présenter des produits.
                    </p>

                    <a href="projet2.html" class="project-link">
                        Voir le projet →
                    </a>

                </div>

            </div>



            <!-- PROJET 3 -->

            <div class="project-card">

                <div class="project-image gray">
                    P3
                </div>

                <div class="project-content">

                    <h3>
                        Application PHP
                    </h3>

                    <p>
                        Application utilisant PHP, MySQL
                        et PDO pour gérer les données.
                    </p>

                    <a href="projet3.php" class="project-link">
                        Voir le projet →
                    </a>

                </div>

            </div>



            <!-- PROJET 4 -->

            <div class="project-card">

                <div class="project-image dark-blue">
                    P4
                </div>

                <div class="project-content">

                    <h3>
                        Formulaire AJAX
                    </h3>

                    <p>
                        Formulaire dynamique utilisant
                        JavaScript, AJAX, API et JSON.
                    </p>

                    <a href="projet4.html" class="project-link">
                        Voir le projet →
                    </a>

                </div>

            </div>



            <!-- PROJET 5 -->

            <div class="project-card">

                <div class="project-image blue">
                    P5
                </div>

                <div class="project-content">

                    <h3>
                        Base de données
                    </h3>

                    <p>
                        Conception MCD, MLD et MPD avec
                        une base de données relationnelle.
                    </p>

                    <a href="projet5.html" class="project-link">
                        Voir le projet →
                    </a>

                </div>

            </div>



            <!-- PROJET 6 -->

            <div class="project-card">

                <div class="project-image gray">
                    P6
                </div>

                <div class="project-content">

                    <h3>
                        Nouveau projet
                    </h3>

                    <p>
                        Ajoutez ici votre prochain projet
                        et présentez ses fonctionnalités.
                    </p>

                    <a href="#" class="project-link">
                        Voir le projet →
                    </a>

                </div>

            </div>


        </div>

    </section>



    <!-- =========================
         TECHNOLOGIES
    ========================== -->

    <section class="technologies" id="technologies">

        <div class="tech-container">

            <h2>
                Technologies utilisées
            </h2>

            <div class="tech-list">

                <span class="tech">HTML</span>

                <span class="tech">CSS</span>

                <span class="tech">JavaScript</span>

                <span class="tech">PHP</span>

                <span class="tech">MySQL</span>

                <span class="tech">PDO</span>

                <span class="tech">AJAX</span>

                <span class="tech">JSON</span>

            </div>

        </div>

    </section>



    <!-- =========================
         CONTACT
    ========================== -->

    <section class="contact" id="contact">

        <h2>
            Vous avez un projet ?
        </h2>

        <p>
            Découvrez mes réalisations ou contactez-moi
            pour discuter d'un nouveau projet.
        </p>

        <a href="contact.html" class="btn btn-primary">
            Me contacter
        </a>

    </section>



    <!-- =========================
         FOOTER
    ========================== -->

    <footer>

        <p>
            © 2026
            <strong>MyProjects</strong>.
            Tous droits réservés.
        </p>

    </footer>


</body>

</html>
```
