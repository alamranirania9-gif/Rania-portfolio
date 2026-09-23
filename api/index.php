<?php

$name = "Rania Al Amrani";
$job = "Développeuse Web";

$about = "Je suis étudiante en Développement Digital à l'OFPPT. 
Je m'intéresse au développement web, à la programmation, 
aux bases de données et au design UI/UX.";

$skills = [
    "HTML / CSS",
    "JavaScript",
    "PHP",
    "MySQL",
    "Python",
    "Bootstrap",
    "Figma",
    "UI / UX Design"
];

$projects = [
    [
        "title" => "Portfolio Web",
        "description" => "Création d'un portfolio personnel moderne et responsive.",
        "tech" => "HTML • CSS • JavaScript • PHP",
        "image" => "images/PH7.jpeg"
    ],
    [
        "title" => "Application CRUD",
        "description" => "Application de gestion permettant d'ajouter, modifier, supprimer et afficher des données.",
        "tech" => "PHP • MySQL • Bootstrap",
        "image" => "images/PH3.jpeg"
    ],
    [
        "title" => "UI / UX Design",
        "description" => "Conception d'interfaces modernes et intuitives avec Figma.",
        "tech" => "Figma • UI • UX",
        "image" => "figma/atelier 1/at1.jpeg"
    ]
];

?>
<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $name ?> | Portfolio</title>

    <style>

        /* =========================
           RESET
        ========================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        /* =========================
           BODY
        ========================= */

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #050505;
            color: #ffffff;
        }

        /* =========================
           HEADER
        ========================= */

        header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            background: rgba(5, 5, 5, 0.95);
            border-bottom: 1px solid #222;
        }

        nav {
            max-width: 1200px;
            margin: auto;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        /* LOGO */

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #a855f7;
        }

        .logo span {
            color: white;
        }

        /* MENU */

        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 15px;
            transition: 0.3s;
        }

        nav ul li a:hover {
            color: #a855f7;
        }

        /* BURGER (mobile) */

        .burger {
            display: none;
            font-size: 26px;
            cursor: pointer;
            color: white;
        }

        /* =========================
           SECTIONS
        ========================= */

        section {
            min-height: 100vh;
            padding: 120px 8% 70px;
        }

        /* =========================
           HOME
        ========================= */

        .home {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            max-width: 1200px;
            margin: auto;
        }

        .home-text {
            max-width: 650px;
        }

        .home-text h2 {
            color: #a1a1aa;
            margin-bottom: 15px;
        }

        .home-text h1 {
            font-size: 58px;
            margin-bottom: 15px;
        }

        .home-text h1 span {
            color: #a855f7;
        }

        .home-text .job {
            color: #a855f7;
            font-size: 28px;
            margin-bottom: 25px;
        }

        .home-text p {
            color: #c4c4c4;
            line-height: 1.8;
            font-size: 17px;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 14px 28px;
            background: #8b5cf6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.25);
        }

        .btn:hover {
            background: #a855f7;
            transform: translateY(-4px);
            box-shadow: 0 0 30px rgba(168, 85, 247, 0.45);
        }

        /* =========================
           PROFILE
        ========================= */

        .profile {
            width: 280px;
            height: 280px;
            border-radius: 50%;
            border: 5px solid #8b5cf6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 70px;
            font-weight: bold;
            color: #a855f7;
            background: #111111;
            box-shadow:
                0 0 30px rgba(139, 92, 246, 0.25),
                0 0 80px rgba(139, 92, 246, 0.12);
            overflow: hidden;
        }

        .profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        /* =========================
           TITLES
        ========================= */

        .title {
            text-align: center;
            font-size: 42px;
            margin-bottom: 55px;
        }

        .title span {
            color: #a855f7;
        }

        /* =========================
           ABOUT
        ========================= */

        .about {
            max-width: 850px;
            margin: auto;
            text-align: center;
        }

        .about p {
            color: #c4c4c4;
            line-height: 2;
            font-size: 18px;
        }

        /* =========================
           SKILLS
        ========================= */

        .skills {
            max-width: 1100px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .skill {
            background: #111111;
            border: 1px solid #262626;
            padding: 30px 20px;
            text-align: center;
            border-radius: 12px;
            transition: 0.3s;
            color: #ffffff;
        }

        .skill:hover {
            transform: translateY(-8px);
            border-color: #8b5cf6;
            box-shadow: 0 0 25px rgba(139, 92, 246, 0.18);
        }

        /* =========================
           PROJECTS
        ========================= */

        .projects {
            max-width: 1100px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .project {
            background: #111111;
            border: 1px solid #262626;
            border-radius: 15px;
            overflow: hidden;
            transition: 0.3s;
        }

        .project:hover {
            transform: translateY(-8px);
            border-color: #8b5cf6;
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.18);
        }

        .project img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }

        .project-body {
            padding: 30px;
        }

        .project h3 {
            color: #a855f7;
            margin-bottom: 18px;
            font-size: 22px;
        }

        .project p {
            color: #c4c4c4;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .tech {
            color: #8b5cf6;
            font-size: 14px;
            font-weight: bold;
        }

        /* =========================
           CONTACT
        ========================= */

        .contact {
            text-align: center;
            min-height: auto;
        }

        .contact p {
            color: #c4c4c4;
            margin: 15px;
        }

        .contact strong {
            color: #a855f7;
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            text-align: center;
            padding: 25px;
            background: #020202;
            border-top: 1px solid #222;
            color: #777;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .burger {
                display: block;
            }

            nav ul {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #050505;
                padding: 20px;
                gap: 18px;
                border-bottom: 1px solid #222;
            }

            nav ul.active {
                display: flex;
            }

            .home {
                flex-direction: column;
                text-align: center;
                padding-top: 150px;
            }

            .home-text h1 {
                font-size: 42px;
            }

            .skills {
                grid-template-columns: repeat(2, 1fr);
            }

            .projects {
                grid-template-columns: 1fr;
            }

            .profile {
                width: 220px;
                height: 220px;
                font-size: 55px;
            }
        }

        @media (max-width: 500px) {

            section {
                padding-left: 20px;
                padding-right: 20px;
            }

            .skills {
                grid-template-columns: 1fr;
            }

            .home-text h1 {
                font-size: 35px;
            }

            .title {
                font-size: 32px;
            }
        }

    </style>

</head>
<body>

<!-- =========================
     HEADER
========================= -->

<header>
    <nav>

        <div class="logo">
            Rania<span>.</span>
        </div>

        <ul id="navMenu">
            <li><a href="#home">Accueil</a></li>
            <li><a href="#about">À propos</a></li>
            <li><a href="#skills">Compétences</a></li>
            <li><a href="#projects">Projets</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>

        <div class="burger" onclick="document.getElementById('navMenu').classList.toggle('active')">
            ☰
        </div>

    </nav>
</header>

<!-- =========================
     HOME
========================= -->

<section class="home" id="home">

    <div class="home-text">

        <h2>Bonjour, je suis</h2>

        <h1>Rania <span>Al Amrani</span></h1>

        <h2 class="job"><?= $job ?></h2>

        <p>
            Développeuse web passionnée par la création
            d'interfaces modernes et d'applications fonctionnelles.
        </p>

        <a href="#projects" class="btn">Voir mes projets</a>

    </div>

    <div class="profile">
        <img src="images/PH3.jpeg" alt="Photo de <?= $name ?>">
    </div>

</section>

<!-- =========================
     ABOUT
========================= -->

<section id="about">

    <h2 class="title">À <span>propos</span></h2>

    <div class="about">
        <p>
            <?= $about ?>
            Je suis motivée, curieuse et passionnée
            par la création de solutions numériques.
            Mon objectif est de développer mes compétences
            en programmation et en conception d'interfaces.
        </p>
    </div>

</section>

<!-- =========================
     SKILLS
========================= -->

<section id="skills">

    <h2 class="title">Mes <span>compétences</span></h2>

    <div class="skills">
        <?php foreach ($skills as $skill): ?>
            <div class="skill"><?= $skill ?></div>
        <?php endforeach; ?>
    </div>

</section>

<!-- =========================
     PROJECTS
========================= -->

<section id="projects">

    <h2 class="title">Mes <span>projets</span></h2>

    <div class="projects">
        <?php foreach ($projects as $project): ?>
            <div class="project">
                <img src="<?= $project["image"] ?>" alt="<?= $project["title"] ?>">
                <div class="project-body">
                    <h3><?= $project["title"] ?></h3>
                    <p><?= $project["description"] ?></p>
                    <div class="tech"><?= $project["tech"] ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</section>

<!-- =========================
     CONTACT
========================= -->

<section class="contact" id="contact">

    <h2 class="title">Me <span>contacter</span></h2>

    <p><strong>Email :</strong> votre.vrai.email@gmail.com</p>

    <p><strong>Téléphone :</strong> +212 6 12 34 56 78</p>

    <p><strong>Localisation :</strong> Maroc</p>

    <a href="mailto:votre.vrai.email@gmail.com" class="btn">
        Contactez-moi
    </a>

</section>

<!-- =========================
     FOOTER
========================= -->

<footer>
    © <?= date("Y") ?> <?= $name ?> — Portfolio
</footer>

</body>
</html>