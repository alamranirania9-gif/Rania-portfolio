<?php

/* =========================
   DONNÉES
========================= */

$name = "Rania Al Amrani";
$job  = "Développeuse Web";

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

/*
 * MODULES > ATELIERS > photos / vidéos / fichiers / ressources
 *
 * - Idéal : mettre les dossiers dans "public/" (Rania-portfolio/public/module 1/...).
 * - Si les dossiers sont à la racine du projet (à côté de "api"), le code les
 *   retrouve aussi et les sert lui-même.
 * - "photos", "videos", "fichiers" : chemins listés à la main (optionnel).
 *   Le code ajoute AUSSI automatiquement tout ce qui est trouvé dans le dossier.
 * - "ressources" : liens externes (cours, GitHub, Figma, YouTube...).
 */
$modules = [
    [
        "title"       => "Module 1",
        "description" => "Ateliers pratiques du premier module.",
        "ressources"  => [
            // ["label" => "Cours du module 1", "url" => "https://..."]
        ],
        "ateliers"    => [
            [
                "title"      => "Atelier 1",
                "folder"     => "module 1/atelier 1",
                "photos"     => [
                    "module 1/atelier 1/at1.jpeg",
                    "module 1/atelier 1/at11.jpeg"
                ],
                "videos"     => [],
                "fichiers"   => [],
                "ressources" => []
            ],
            [
                "title"      => "Atelier 2",
                "folder"     => "module 1/atelier2",
                "photos"     => [],
                "videos"     => [],
                "fichiers"   => [],
                "ressources" => [
                    // ["label" => "Maquette Figma", "url" => "https://www.figma.com/..."]
                ]
            ],
            [
                "title"      => "Atelier 3",
                "folder"     => "module 1/atelier3",
                "photos"     => [
                    "module 1/atelier3/photo.jpeg"
                ],
                "videos"     => [
                    "module 1/atelier3/vid1.mp4"
                ],
                "fichiers"   => [],
                "ressources" => []
            ]
        ]
    ],
    [
        "title"       => "Module 2",
        "description" => "Ateliers pratiques du deuxième module.",
        "ressources"  => [],
        "ateliers"    => [
            [
                "title"      => "AT5",
                "folder"     => "module2/AT5",
                "photos"     => [],
                "videos"     => [],
                "fichiers"   => [
                    "module2/AT5/AT5.docx"
                ],
                "ressources" => []
            ],
            [
                "title"      => "Atelier 2",
                "folder"     => "module2/ATELIER 2",
                "photos"     => [],
                "videos"     => [],
                "fichiers"   => [
                    "module2/ATELIER 2/ATELIER2.docx"
                ],
                "ressources" => []
            ],
            [
                "title"      => "Atelier 1",
                "folder"     => "module2/atelierse1",
                "photos"     => [
                    "module2/atelierse1/photos.jpeg"
                ],
                "videos"     => [],
                "fichiers"   => [],
                "ressources" => []
            ]
        ]
    ]
];

/* Extensions reconnues */
$EXT_PHOTOS  = ["jpg", "jpeg", "png", "webp", "gif"];
$EXT_VIDEOS  = ["mp4", "webm", "ogg", "mov"];
$EXT_FILES   = ["pdf", "doc", "docx", "ppt", "pptx", "xls", "xlsx", "zip", "rar", "txt", "sql", "fig"];

/* =========================
   FONCTIONS
========================= */

// Échappe le texte avant de l'afficher
function e($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

// Dossiers où chercher les fichiers : public/ d'abord, puis la racine du projet
function baseDirs()
{
    static $bases = null;
    if ($bases !== null) {
        return $bases;
    }

    $root = dirname(__DIR__);
    $candidates = [
        $root . '/public',
        $root,
        getcwd() . '/public',
        getcwd(),
    ];

    $bases = [];
    foreach ($candidates as $dir) {
        $real = realpath($dir);
        if ($real && is_dir($real) && !in_array($real, $bases, true)) {
            $bases[] = $real;
        }
    }
    return $bases;
}

// Retrouve un fichier ou un dossier, même si les majuscules/minuscules sont différentes.
// Retourne ['base' => ..., 'path' => chemin réel] ou null si introuvable.
function resolvePath($path)
{
    $parts = array_filter(explode('/', str_replace('\\', '/', $path)), function ($p) {
        return $p !== '' && $p !== '.' && $p !== '..';
    });

    foreach (baseDirs() as $base) {
        $current = $base;
        $real    = [];

        foreach ($parts as $part) {
            if (!is_dir($current)) {
                continue 2;
            }
            $found = null;
            if (file_exists($current . '/' . $part)) {
                $found = $part;
            } else {
                foreach (scandir($current) as $entry) {
                    if (strcasecmp($entry, $part) === 0) {
                        $found = $entry;
                        break;
                    }
                }
            }
            if ($found === null) {
                continue 2;
            }
            $current .= '/' . $found;
            $real[]   = $found;
        }

        if ($real) {
            return ['base' => $base, 'path' => implode('/', $real)];
        }
    }
    return null;
}

// Transforme "module 1/atelier 1/at1.jpeg" en URL valide (espaces encodés)
function webPath($path)
{
    return '/' . implode('/', array_map('rawurlencode', explode('/', $path)));
}

// URL d'un fichier : directe si il est dans public/, sinon via index.php
function mediaUrl($path)
{
    $r = resolvePath($path);
    if (!$r) {
        return webPath($path);
    }
    if (basename($r['base']) === 'public') {
        return webPath($r['path']);
    }
    return '/?media=' . rawurlencode($r['path']);
}

// Liste les fichiers d'un dossier selon leurs extensions
function filesIn($folder, array $extensions)
{
    $r = resolvePath($folder);
    if (!$r) {
        return [];
    }

    $dir = $r['base'] . '/' . $r['path'];
    if (!is_dir($dir)) {
        return [];
    }

    $result = [];
    foreach (scandir($dir) as $file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $extensions, true)) {
            $result[] = $r['path'] . '/' . $file;
        }
    }
    sort($result, SORT_NATURAL | SORT_FLAG_CASE);
    return $result;
}

// Fusionne la liste écrite à la main et celle trouvée dans le dossier (sans doublons)
function collect(array $manual, $folder, array $extensions)
{
    $folderFound = resolvePath($folder) !== null;
    $list = [];

    foreach ($manual as $path) {
        $r = resolvePath($path);
        if ($r) {
            $list[] = $r['path'];          // fichier trouvé : on prend le vrai nom
        } elseif (!$folderFound) {
            $list[] = $path;               // dossier illisible : on fait confiance au chemin écrit
        }
        // dossier lisible mais fichier absent : on l'ignore (pas d'image cassée)
    }

    return array_values(array_unique(array_merge($list, filesIn($folder, $extensions))));
}

// Type MIME d'une vidéo
function videoType($path)
{
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $types = ["mp4" => "video/mp4", "webm" => "video/webm", "ogg" => "video/ogg", "mov" => "video/quicktime"];
    return $types[$ext] ?? "video/mp4";
}

// Icône selon l'extension du fichier
function fileIcon($path)
{
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $icons = [
        "pdf" => "📄", "doc" => "📝", "docx" => "📝", "ppt" => "📊", "pptx" => "📊",
        "xls" => "📈", "xlsx" => "📈", "zip" => "🗜️", "rar" => "🗜️", "txt" => "📃",
        "sql" => "🗄️", "fig" => "🎨"
    ];
    return $icons[$ext] ?? "📎";
}

/* =========================
   ENVOI DES FICHIERS (si hors de public/)
   Utilisé par mediaUrl() : /?media=module%201/atelier%201/at1.jpeg
========================= */

if (isset($_GET['media'])) {
    $requested = str_replace('\\', '/', (string) $_GET['media']);
    $ext       = strtolower(pathinfo($requested, PATHINFO_EXTENSION));

    // Seuls les dossiers d'ateliers déclarés plus haut sont accessibles
    $allowedFolder = false;
    foreach ($modules as $m) {
        foreach ($m["ateliers"] as $a) {
            if (strpos(strtolower($requested), strtolower($a["folder"]) . '/') === 0) {
                $allowedFolder = true;
            }
        }
    }

    $allowedExt = array_merge($EXT_PHOTOS, $EXT_VIDEOS, $EXT_FILES);
    $r    = ($allowedFolder && in_array($ext, $allowedExt, true)) ? resolvePath($requested) : null;
    $file = $r ? $r['base'] . '/' . $r['path'] : null;

    if (!$file || !is_file($file)) {
        http_response_code(404);
        exit('Fichier introuvable');
    }

    $mimes = [
        "jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png",
        "webp" => "image/webp", "gif" => "image/gif",
        "mp4" => "video/mp4", "webm" => "video/webm", "ogg" => "video/ogg", "mov" => "video/quicktime",
        "pdf" => "application/pdf", "txt" => "text/plain; charset=utf-8"
    ];

    header('Content-Type: ' . ($mimes[$ext] ?? 'application/octet-stream'));
    header('Content-Length: ' . filesize($file));
    header('Cache-Control: public, max-age=86400');
    readfile($file);
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($name) ?> | Portfolio</title>

    <style>

        /* RESET */

        html {
            scroll-behavior: smooth;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #050505;
            color: #ffffff;
        }

        /* HEADER */

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

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #a855f7;
        }

        .logo span {
            color: white;
        }

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

        .burger {
            display: none;
            font-size: 26px;
            cursor: pointer;
            color: white;
        }

        /* SECTIONS */

        section {
            min-height: 100vh;
            padding: 120px 8% 70px;
        }

        /* HOME */

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

        /* BOUTON */

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

        /* PROFIL */

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

        /* TITRES */

        .title {
            text-align: center;
            font-size: 42px;
            margin-bottom: 55px;
        }

        .title span {
            color: #a855f7;
        }

        /* À PROPOS */

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

        /* COMPÉTENCES */

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
        }

        .skill:hover {
            transform: translateY(-8px);
            border-color: #8b5cf6;
            box-shadow: 0 0 25px rgba(139, 92, 246, 0.18);
        }

        /* MODULES */

        .modules {
            max-width: 1100px;
            margin: auto;
            display: flex;
            flex-direction: column;
            gap: 50px;
        }

        .module h3 {
            color: #a855f7;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .module > p {
            color: #c4c4c4;
            margin-bottom: 25px;
        }

        .ateliers {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            align-items: start;
        }

        .atelier {
            background: #111111;
            border: 1px solid #262626;
            border-radius: 15px;
            overflow: hidden;
            transition: 0.3s;
        }

        .atelier:hover {
            transform: translateY(-8px);
            border-color: #8b5cf6;
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.18);
        }

        .atelier-photos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 2px;
            background: #262626;
        }

        .atelier-photos img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }

        .atelier-videos video {
            width: 100%;
            display: block;
            background: #000;
            max-height: 260px;
        }

        .no-photo {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
            font-size: 14px;
        }

        .atelier-body {
            padding: 25px;
        }

        .atelier-body h4 {
            color: #a855f7;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .atelier-body h5 {
            color: #a1a1aa;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 18px 0 4px;
        }

        .atelier-body a,
        .module-resources a {
            display: block;
            color: #8b5cf6;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            margin-top: 8px;
            word-break: break-word;
        }

        .atelier-body a:hover,
        .module-resources a:hover {
            color: #a855f7;
        }

        .module-resources {
            margin-bottom: 25px;
        }

        .module-resources h5 {
            color: #a1a1aa;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* CONTACT */

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

        /* FOOTER */

        footer {
            text-align: center;
            padding: 25px;
            background: #020202;
            border-top: 1px solid #222;
            color: #777;
        }

        /* RESPONSIVE */

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

            .ateliers {
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

<!-- HEADER -->

<header>
    <nav>

        <div class="logo">
            Rania<span>.</span>
        </div>

        <ul id="navMenu">
            <li><a href="#home">Accueil</a></li>
            <li><a href="#about">À propos</a></li>
            <li><a href="#skills">Compétences</a></li>
            <li><a href="#modules">Modules</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>

        <div class="burger" onclick="document.getElementById('navMenu').classList.toggle('active')">
            ☰
        </div>

    </nav>
</header>

<!-- ACCUEIL -->

<section class="home" id="home">

    <div class="home-text">

        <h2>Bonjour, je suis</h2>

        <h1>Rania <span>Al Amrani</span></h1>

        <h2 class="job"><?= e($job) ?></h2>

        <p>
            Développeuse web passionnée par la création
            d'interfaces modernes et d'applications fonctionnelles.
        </p>

        <a href="#modules" class="btn">Voir mes modules</a>

    </div>

    <div class="profile">
        RA
    </div>

</section>

<!-- À PROPOS -->

<section id="about">

    <h2 class="title">À <span>propos</span></h2>

    <div class="about">
        <p>
            <?= e($about) ?>
            Je suis motivée, curieuse et passionnée
            par la création de solutions numériques.
            Mon objectif est de développer mes compétences
            en programmation et en conception d'interfaces.
        </p>
    </div>

</section>

<!-- COMPÉTENCES -->

<section id="skills">

    <h2 class="title">Mes <span>compétences</span></h2>

    <div class="skills">
        <?php foreach ($skills as $skill): ?>
            <div class="skill"><?= e($skill) ?></div>
        <?php endforeach; ?>
    </div>

</section>

<!-- MODULES -->

<section id="modules">

    <h2 class="title">Mes <span>modules</span></h2>

    <div class="modules">
        <?php foreach ($modules as $module): ?>
            <div class="module">

                <h3><?= e($module["title"]) ?></h3>
                <p><?= e($module["description"]) ?></p>

                <?php if (!empty($module["ressources"])): ?>
                    <div class="module-resources">
                        <h5>Ressources du module</h5>
                        <?php foreach ($module["ressources"] as $res): ?>
                            <a href="<?= e($res["url"]) ?>" target="_blank" rel="noopener">
                                🔗 <?= e($res["label"]) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="ateliers">
                    <?php foreach ($module["ateliers"] as $atelier): ?>
                        <?php
                            $folder     = $atelier["folder"];
                            $photos     = collect($atelier["photos"]   ?? [], $folder, $EXT_PHOTOS);
                            $videos     = collect($atelier["videos"]   ?? [], $folder, $EXT_VIDEOS);
                            $fichiers   = collect($atelier["fichiers"] ?? [], $folder, $EXT_FILES);
                            $ressources = $atelier["ressources"] ?? [];
                        ?>
                        <div class="atelier">

                            <?php if ($photos): ?>
                                <div class="atelier-photos">
                                    <?php foreach ($photos as $photo): ?>
                                        <img src="<?= e(mediaUrl($photo)) ?>"
                                             alt="<?= e($atelier["title"]) ?>"
                                             loading="lazy">
                                    <?php endforeach; ?>
                                </div>
                            <?php elseif (!$videos): ?>
                                <div class="no-photo">Aucune photo pour le moment</div>
                            <?php endif; ?>

                            <?php if ($videos): ?>
                                <div class="atelier-videos">
                                    <?php foreach ($videos as $video): ?>
                                        <video controls preload="metadata">
                                            <source src="<?= e(mediaUrl($video)) ?>" type="<?= e(videoType($video)) ?>">
                                            Votre navigateur ne supporte pas la vidéo.
                                        </video>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="atelier-body">
                                <h4><?= e($atelier["title"]) ?></h4>

                                <?php if ($fichiers): ?>
                                    <h5>Fichiers</h5>
                                    <?php foreach ($fichiers as $fichier): ?>
                                        <a href="<?= e(mediaUrl($fichier)) ?>" target="_blank" rel="noopener">
                                            <?= fileIcon($fichier) ?> <?= e(basename($fichier)) ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if ($videos): ?>
                                    <h5>Vidéos</h5>
                                    <?php foreach ($videos as $video): ?>
                                        <a href="<?= e(mediaUrl($video)) ?>" target="_blank" rel="noopener">
                                            🎬 <?= e(basename($video)) ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if ($ressources): ?>
                                    <h5>Ressources</h5>
                                    <?php foreach ($ressources as $res): ?>
                                        <a href="<?= e($res["url"]) ?>" target="_blank" rel="noopener">
                                            🔗 <?= e($res["label"]) ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</section>

<!-- CONTACT -->

<section class="contact" id="contact">

    <h2 class="title">Me <span>contacter</span></h2>

    <p><strong>Email :</strong> votre.vrai.email@gmail.com</p>

    <p><strong>Téléphone :</strong> +212 6 12 34 56 78</p>

    <p><strong>Localisation :</strong> Maroc</p>

    <a href="mailto:votre.vrai.email@gmail.com" class="btn">
        Contactez-moi
    </a>

</section>

<!-- FOOTER -->

<footer>
    © <?= date("Y") ?> <?= e($name) ?> — Portfolio
</footer>

<script>
    // Ferme le menu mobile après un clic sur un lien
    document.querySelectorAll('#navMenu a').forEach(function (link) {
        link.addEventListener('click', function () {
            document.getElementById('navMenu').classList.remove('active');
        });
    });
</script>

</body>
</html>