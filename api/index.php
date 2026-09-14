<?php
// Portfolio de Oumaima Elharti
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Oumaima Elharti | Portfolio</title>

    <meta name="description"
        content="Portfolio professionnel de Oumaima Elharti, étudiante en Développement Digital.">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #fff9fc;
            color: #2d2630;
            line-height: 1.6;
        }

        /* =========================
           NAVBAR
        ========================= */

        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 18px 8%;
            background: rgba(255, 249, 252, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            border-bottom: 1px solid #f1dce7;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #b85c82;
            text-decoration: none;
        }

        .logo span {
            color: #5f5261;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: #403640;
            font-weight: 500;
            transition: 0.3s;
        }

        nav ul li a:hover {
            color: #b85c82;
        }

        /* =========================
           HERO
        ========================= */

        .hero {
            min-height: 100vh;
            padding: 140px 8% 80px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;

            background:
                radial-gradient(circle at 85% 20%, #f7dce8 0, transparent 25%),
                radial-gradient(circle at 10% 80%, #eee1f4 0, transparent 25%),
                #fff9fc;
        }

        .hero-content {
            max-width: 650px;
        }

        .small-title {
            color: #b85c82;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .hero h1 {
            font-size: clamp(45px, 6vw, 75px);
            line-height: 1.05;
            margin-bottom: 25px;
            color: #302832;
        }

        .hero h1 span {
            color: #b85c82;
        }

        .hero p {
            font-size: 19px;
            color: #716672;
            max-width: 600px;
            margin-bottom: 35px;
        }

        .buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 13px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary {
            background: #b85c82;
            color: white;
            box-shadow: 0 10px 25px rgba(184, 92, 130, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            background: #a94d73;
        }

        .btn-secondary {
            border: 1px solid #d8a8bd;
            color: #9d4d70;
            background: white;
        }

        .btn-secondary:hover {
            background: #f9e8f0;
        }

        /* =========================
           PROFILE CARD
        ========================= */

        .profile-card {
            width: 330px;
            min-width: 280px;
            padding: 35px;

            background: rgba(255, 255, 255, 0.75);
            border: 1px solid #efd9e5;
            border-radius: 30px;

            text-align: center;

            box-shadow: 0 25px 60px rgba(100, 65, 90, 0.12);
        }

        .profile-circle {
            width: 150px;
            height: 150px;
            margin: auto auto 20px;

            border-radius: 50%;

            background: linear-gradient(135deg, #f1cbdc, #e8d9ef);

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9d4d70;
            font-size: 50px;
            font-weight: 700;
        }

        .profile-card h3 {
            margin-bottom: 8px;
        }

        .profile-card p {
            color: #817580;
        }

        /* =========================
           GENERAL SECTIONS
        ========================= */

        section {
            padding: 100px 8%;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title span {
            color: #b85c82;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .section-title h2 {
            font-size: 40px;
            margin-top: 8px;
        }

        .section-title p {
            color: #7b707b;
            max-width: 650px;
            margin: 15px auto 0;
        }

        /* =========================
           ABOUT
        ========================= */

        .about {
            background: white;
        }

        .about-container {
            max-width: 1000px;
            margin: auto;

            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .about-box {
            padding: 35px;
            border-radius: 25px;
            background: #fff8fb;
            border: 1px solid #f1dce7;
        }

        .about-box h3 {
            margin-bottom: 15px;
            color: #9d4d70;
        }

        .about-box p {
            color: #6f646e;
        }

        /* =========================
           SKILLS
        ========================= */

        .skills {
            background: #fff9fc;
        }

        .skills-container {
            max-width: 1100px;
            margin: auto;

            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .skill-card {
            padding: 30px;
            background: white;
            border: 1px solid #f0dce6;
            border-radius: 22px;
            transition: 0.3s;
        }

        .skill-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 35px rgba(100, 65, 90, 0.10);
        }

        .skill-card .icon {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .skill-card h3 {
            margin-bottom: 8px;
        }

        .skill-card p {
            color: #776d76;
        }

        /* =========================
           PROJECTS
        ========================= */

        .projects {
            background: white;
        }

        .projects-container {
            max-width: 1100px;
            margin: auto;

            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .project-card {
            padding: 30px;

            border-radius: 25px;
            border: 1px solid #efdce6;

            background: linear-gradient(
                145deg,
                #fff,
                #fff7fa
            );

            transition: 0.3s;
        }

        .project-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 40px rgba(100, 65, 90, 0.10);
        }

        .project-number {
            color: #b85c82;
            font-weight: 700;
            font-size: 14px;
        }

        .project-card h3 {
            margin: 12px 0;
        }

        .project-card p {
            color: #756b74;
            margin-bottom: 20px;
        }

        .project-link {
            text-decoration: none;
            color: #a34f73;
            font-weight: 600;
        }

        /* =========================
           CONTACT
        ========================= */

        .contact {
            background: #f8e8f0;
            text-align: center;
        }

        .contact-content {
            max-width: 700px;
            margin: auto;
        }

        .contact h2 {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .contact p {
            color: #6e626c;
            margin-bottom: 30px;
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            padding: 25px;
            text-align: center;
            background: #2f2830;
            color: #e9dfe5;
        }

        footer span {
            color: #e7a9c3;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero p {
                margin-left: auto;
                margin-right: auto;
            }

            .buttons {
                justify-content: center;
            }

            .skills-container,
            .projects-container {
                grid-template-columns: 1fr 1fr;
            }

        }

        @media (max-width: 650px) {

            nav {
                padding: 15px 5%;
            }

            nav ul {
                display: none;
            }

            section {
                padding: 80px 5%;
            }

            .about-container,
            .skills-container,
            .projects-container {
                grid-template-columns: 1fr;
            }

            .profile-card {
                width: 100%;
            }

        }

    </style>
</head>

<body>

    <!-- =========================
         NAVBAR
    ========================== -->

    <nav>

        <a href="/" class="logo">
            Oumaima<span>.</span>
        </a>

        <ul>
            <li><a href="#accueil">Accueil</a></li>
            <li><a href="#about">À propos</a></li>
            <li><a href="#skills">Compétences</a></li>
            <li><a href="#projects">Projets</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>

    </nav>


    <!-- =========================
         HERO
    ========================== -->

    <section class="hero" id="accueil">

        <div class="hero-content">

            <div class="small-title">
                Portfolio professionnel
            </div>

            <h1>
                Bonjour, je suis
                <span>Oumaima.</span>
            </h1>

            <p>
                Étudiante en Développement Digital, passionnée par
                la création de solutions web modernes, élégantes
                et fonctionnelles.
            </p>

            <div class="buttons">

                <a href="#projects" class="btn btn-primary">
                    Découvrir mes projets
                </a>

                <a href="#contact" class="btn btn-secondary">
                    Me contacter
                </a>

            </div>

        </div>


        <div class="profile-card">

            <div class="profile-circle">
                OE
            </div>

            <h3>Oumaima Elharti</h3>

            <p>
                Développement Digital
            </p>

            <p>
                2ème année
            </p>

        </div>

    </section>


    <!-- =========================
         ABOUT
    ========================== -->

    <section class="about" id="about">

        <div class="section-title">

            <span>À propos</span>

            <h2>Mon parcours</h2>

            <p>
                Un espace dédié à mon évolution et aux compétences
                développées durant ma formation.
            </p>

        </div>


        <div class="about-container">

            <div class="about-box">

                <h3>Qui suis-je ?</h3>

                <p>
                    Je suis Oumaima Elharti, étudiante en deuxième
                    année de Développement Digital à l'ISTA.
                    À travers ma formation, je développe progressivement
                    mes compétences en programmation, développement web
                    et gestion de bases de données.
                </p>

            </div>


            <div class="about-box">

                <h3>Mon objectif</h3>

                <p>
                    Construire une expérience solide dans le développement
                    web et créer des projets utiles, modernes et bien
                    structurés tout en continuant à améliorer mes
                    compétences techniques.
                </p>

            </div>

        </div>

    </section>


    <!-- =========================
         SKILLS
    ========================== -->

    <section class="skills" id="skills">

        <div class="section-title">

            <span>Compétences</span>

            <h2>Ce que j'apprends</h2>

            <p>
                Les technologies et domaines étudiés durant ma formation.
            </p>

        </div>


        <div class="skills-container">

            <div class="skill-card">

                <div class="icon">🌐</div>

                <h3>HTML & CSS</h3>

                <p>
                    Création de pages web structurées,
                    responsives et modernes.
                </p>

            </div>


            <div class="skill-card">

                <div class="icon">⚡</div>

                <h3>JavaScript</h3>

                <p>
                    Dynamisation des interfaces et manipulation
                    du DOM.
                </p>

            </div>


            <div class="skill-card">

                <div class="icon">💻</div>

                <h3>PHP</h3>

                <p>
                    Développement côté serveur et création
                    d'applications web dynamiques.
                </p>

            </div>


            <div class="skill-card">

                <div class="icon">🗄️</div>

                <h3>MySQL / PDO</h3>

                <p>
                    Gestion des bases de données et connexion
                    avec PHP.
                </p>

            </div>


            <div class="skill-card">

                <div class="icon">✨</div>

                <h3>jQuery</h3>

                <p>
                    Manipulation simplifiée du DOM et interactions
                    dynamiques.
                </p>

            </div>


            <div class="skill-card">

                <div class="icon">🔗</div>

                <h3>Git & GitHub</h3>

                <p>
                    Gestion des versions et organisation
                    de mes projets.
                </p>

            </div>

        </div>

    </section>


    <!-- =========================
         PROJECTS
    ========================== -->

    <section class="projects" id="projects">

        <div class="section-title">

            <span>Mon travail</span>

            <h2>Projets & Travaux</h2>

            <p>
                Retrouvez ici mes TP, TD, exercices et projets réalisés
                durant ma formation.
            </p>

        </div>


        <div class="projects-container">

            <div class="project-card">

                <div class="project-number">
                    01 — M201
                </div>

                <h3>Préparation d'un projet web</h3>

                <p>
                    Exercices et travaux pratiques réalisés
                    
                </p>

                <a href="#" class="project-link">
                    Voir le travail →
                </a>

            </div>


            <div class="project-card">

                <div class="project-number">
                    02 — M202
                </div>

                <h3>Approche agile</h3>

                <p>
                    Exercices de manipulation du DOM,
                    événements et validation.
                </p>

                <a href="#" class="project-link">
                    Voir le travail →
                </a>

            </div>


            <div class="project-card">

                <div class="project-number">
                    03 — M203
                </div>

                <h3>Gestion des données</h3>

                <p>
                  Gestion des données des application
                </p>

                <a href="#" class="project-link">
                    Voir le travail →
                </a>

            </div>

        </div>

    </section>


    <!-- =========================
         CONTACT
    ========================== -->

    <section class="contact" id="contact">

        <div class="contact-content">

            <h2>Travaillons ensemble</h2>

            <p>
                Vous souhaitez découvrir mon parcours,
                mes travaux ou échanger avec moi ?
            </p>

            <a href="mailto:tonemail@example.com"
               class="btn btn-primary">

                Me contacter

            </a>

        </div>

    </section>


    <!-- =========================
         FOOTER
    ========================== -->

    <footer>

        <p>
            © 2026 <span>Oumaima Elharti</span> —
            Portfolio professionnel
        </p>

    </footer>

</body>

</html>