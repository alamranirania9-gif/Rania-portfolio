<?php
session_start();

/* =========================
   CONFIGURATION
========================= */

$titre = "Mon Application PHP";
$message = "Bienvenue dans mon application";

/* Compteur de visites */
if (!isset($_SESSION['visites'])) {
    $_SESSION['visites'] = 0;
}

$_SESSION['visites']++;

/* Date et heure */
$date = date("d/m/Y");
$heure = date("H:i:s");

/* =========================
   TRAITEMENT DU FORMULAIRE
========================= */

$nom = "";
$email = "";
$messageFormulaire = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = htmlspecialchars($_POST["nom"] ?? "");
    $email = htmlspecialchars($_POST["email"] ?? "");
    $messageFormulaire = htmlspecialchars($_POST["message"] ?? "");
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $titre ?></title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #071827, #123b5d, #526575);
            color: white;
            min-height: 100vh;
        }

        header {
            background: rgba(0, 0, 0, 0.35);
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-weight: bold;
        }

        nav a:hover {
            color: #8fd3ff;
        }

        .hero {
            text-align: center;
            padding: 70px 20px 40px;
        }

        .hero h1 {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 19px;
            color: #d8e8f2;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: auto;
        }

        .photos {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin: 35px 0;
        }

        .card {
            background: rgba(255,255,255,0.12);
            border-radius: 18px;
            padding: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }

        .card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 14px;
            display: block;
        }

        .card h2 {
            margin: 15px 5px 5px;
        }

        .card p {
            color: #d6e5ee;
            margin: 5px;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
        }

        .stat {
            background: rgba(255,255,255,0.12);
            padding: 20px 35px;
            border-radius: 15px;
            text-align: center;
        }

        .stat strong {
            display: block;
            font-size: 28px;
            color: #8fd3ff;
        }

        form {
            background: rgba(255,255,255,0.12);
            padding: 30px;
            border-radius: 18px;
            max-width: 650px;
            margin: 40px auto;
        }

        input,
        textarea {
            width: 100%;
            padding: 13px;
            margin: 8px 0 15px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #2879ad;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #3f94c9;
        }

        .success {
            background: rgba(0, 150, 100, 0.3);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        footer {
            text-align: center;
            padding: 30px;
            margin-top: 40px;
            background: rgba(0,0,0,0.3);
            color: #d1dce3;
        }

        @media(max-width: 700px) {

            .photos {
                grid-template-columns: 1fr;
            }

            header {
                flex-direction: column;
                gap: 15px;
            }

            nav a {
                margin: 0 8px;
            }

            .hero h1 {
                font-size: 32px;
            }
        }

    </style>
</head>

<body>

<header>

    <div class="logo">
        Mon Application
    </div>

    <nav>
        <a href="index.php">Accueil</a>
        <a href="#photos">Photos</a>
        <a href="#contact">Contact</a>
        <a href="api.php">API</a>
    </nav>

</header>


<section class="hero">

    <h1><?= $titre ?></h1>

    <p><?= $message ?></p>

</section>


<div class="container">

    <!-- STATISTIQUES -->

    <div class="stats">

        <div class="stat">
            <strong><?= $_SESSION['visites'] ?></strong>
            Visites
        </div>

        <div class="stat">
            <strong><?= $date ?></strong>
            Date
        </div>

        <div class="stat">
            <strong><?= $heure ?></strong>
            Heure
        </div>

    </div>


    <!-- PHOTOS -->

    <section id="photos">

        <div class="photos">

            <div class="card">

                <img src="../public/images/PH3.jpeg"
                     alt="Photo PH3">

                <h2>Photo 1</h2>

                <p>
                    Première image de mon application.
                </p>

            </div>


            <div class="card">

                <img src="../public/images/PH7.jpeg"
                     alt="Photo PH7">

                <h2>Photo 2</h2>

                <p>
                    Deuxième image de mon application.
                </p>

            </div>

        </div>

    </section>


    <!-- FORMULAIRE -->

    <section id="contact">

        <form method="POST" action="index.php">

            <h2>Contactez-nous</h2>

            <br>

            <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>

                <div class="success">
                    Merci <?= $nom ?> ! Votre formulaire a été envoyé.
                </div>

            <?php endif; ?>


            <label>Nom</label>

            <input
                type="text"
                name="nom"
                placeholder="Votre nom"
                required
            >


            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Votre email"
                required
            >


            <label>Message</label>

            <textarea
                name="message"
                placeholder="Votre message"
                required
            ></textarea>


            <button type="submit">
                Envoyer
            </button>

        </form>

    </section>

</div>


<footer>

    <p>
        © <?= date("Y") ?> - Mon Application PHP
    </p>

</footer>

</body>
</html>