
<?php
declare(strict_types=1);

/* =========================
   INFORMATIONS
========================= */

$name = "Rania Al Amrani";
$job = "Développeuse Web";

$about = "Je suis étudiante en Développement Digital à l'OFPPT. Je m'intéresse au développement web, à la programmation, aux bases de données et au design UI/UX.";

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
 * Les fichiers doivent être placés dans public/.
 * Les URL ci-dessous sont relatives à la racine publique.
 */
$modules = [
    [
        "title" => "Module 1",
        "description" => "Ateliers pratiques du premier module.",
        "ateliers" => [
            [
                "title" => "Atelier 1",
                "photos" => [
                    "/module%201/atelier%201/at1.jpeg",
                    "/module%201/atelier%201/at11.jpeg"
                ],
                "videos" => [],
                "fichiers" => [],
                "ressources" => []
            ],
            [
                "title" => "Atelier 2",
                "photos" => [],
                "videos" => [],
                "fichiers" => [
                    [
                        "url" => "/module%201/atelier2/maquettes_application_annoncez.pdf",
                        "label" => "maquettes_application_annoncez.pdf"
                    ]
                ],
                "ressources" => []
            ],
            [
                "title" => "Atelier 3",
                "photos" => [
                    "/module%201/atelier3/photo.jpeg"
                ],
                "videos" => [
                    [
                        "url" => "/module%201/atelier3/vid1.mp4",
                        "label" => "vid1.mp4",
                        "type" => "video/mp4"
                    ]
                ],
                "fichiers" => [],
                "ressources" => []
            ]
        ]
    ],
    [
        "title" => "Module 2",
        "description" => "Ateliers pratiques du deuxième module.",
        "ateliers" => [
            [
                "title" => "AT5",
                "photos" => [],
                "videos" => [],
                "fichiers" => [
                    [
                        "url" => "/module2/AT5/AT5.docx",
                        "label" => "AT5.docx"
                    ]
                ],
                "ressources" => []
            ],
            [
                "title" => "ATELIER 2",
                "photos" => [],
                "videos" => [],
                "fichiers" => [
                    [
                        "url" => "/module2/ATELIER%202/ATELIER2.docx",
                        "label" => "ATELIER2.docx"
                    ]
                ],
                "ressources" => []
            ],
            [
                "title" => "Atelier 1",
                "photos" => [
                    "/module2/atelierse1/photos.jpeg"
                ],
                "videos" => [],
                "fichiers" => [],
                "ressources" => []
            ]
        ]
    ]
];

/* =========================
   FONCTION DE SÉCURITÉ
========================= */

function e($value): string
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($name) ?> | Portfolio</title>

<style>
html{scroll-behavior:smooth}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Arial,Helvetica,sans-serif;background:#050505;color:#fff}
header{position:fixed;width:100%;top:0;left:0;z-index:1000;background:rgba(5,5,5,.95);border-bottom:1px solid #222}
nav{max-width:1200px;margin:auto;padding:20px 30px;display:flex;justify-content:space-between;align-items:center;position:relative}
.logo{font-size:28px;font-weight:bold;color:#a855f7}
.logo span{color:white}
nav ul{display:flex;list-style:none;gap:30px}
nav ul li a{text-decoration:none;color:white;font-size:15px;transition:.3s}
nav ul li a:hover{color:#a855f7}
.burger{display:none;background:none;border:0;font-size:26px;cursor:pointer;color:white}
section{min-height:100vh;padding:120px 8% 70px}
.home{display:flex;align-items:center;justify-content:space-between;gap:60px;max-width:1200px;margin:auto}
.home-text{max-width:650px}
.home-text h2{color:#a1a1aa;margin-bottom:15px}
.home-text h1{font-size:58px;margin-bottom:15px}
.home-text h1 span{color:#a855f7}
.home-text .job{color:#a855f7;font-size:28px;margin-bottom:25px}
.home-text p{color:#c4c4c4;line-height:1.8;font-size:17px}
.btn{display:inline-block;margin-top:30px;padding:14px 28px;background:#8b5cf6;color:white;text-decoration:none;border-radius:8px;font-weight:bold;transition:.3s;box-shadow:0 0 20px rgba(139,92,246,.25)}
.btn:hover{background:#a855f7;transform:translateY(-4px)}
.profile{width:280px;height:280px;flex-shrink:0;border-radius:50%;border:5px solid #8b5cf6;display:flex;align-items:center;justify-content:center;font-size:70px;font-weight:bold;color:#a855f7;background:#111;box-shadow:0 0 30px rgba(139,92,246,.25),0 0 80px rgba(139,92,246,.12);overflow:hidden}
.profile img{width:100%;height:100%;object-fit:cover;border-radius:50%}
.title{text-align:center;font-size:42px;margin-bottom:55px}
.title span{color:#a855f7}
.about{max-width:850px;margin:auto;text-align:center}
.about p{color:#c4c4c4;line-height:2;font-size:18px}
.skills{max-width:1100px;margin:auto;display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.skill{background:#111;border:1px solid #262626;padding:30px 20px;text-align:center;border-radius:12px;transition:.3s}
.skill:hover{transform:translateY(-8px);border-color:#8b5cf6;box-shadow:0 0 25px rgba(139,92,246,.18)}
.modules{max-width:1100px;margin:auto;display:flex;flex-direction:column;gap:50px}
.module h3{color:#a855f7;font-size:28px;margin-bottom:10px}
.module>p{color:#c4c4c4;margin-bottom:25px}
.ateliers{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:25px;align-items:start}
.atelier{background:#111;border:1px solid #262626;border-radius:15px;overflow:hidden;transition:.3s;scroll-margin-top:100px}
.atelier:hover{transform:translateY(-5px);border-color:#8b5cf6}
.atelier-photos{display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:2px;background:#262626}
.atelier-photos img{width:100%;height:180px;object-fit:cover;display:block}
.atelier-photos a{display:block;overflow:hidden}
.atelier-photos img:hover{opacity:.85}
.atelier-nav{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:25px}
.atelier-nav a{padding:8px 16px;border:1px solid #262626;border-radius:20px;color:#c4c4c4;font-size:14px;text-decoration:none}
.atelier-nav a:hover{border-color:#8b5cf6;color:#a855f7}
.atelier-videos video{width:100%;display:block;background:#000;max-height:260px}
.no-photo{height:100px;display:flex;align-items:center;justify-content:center;color:#777;font-size:14px}
.atelier-body{padding:25px}
.atelier-body h4{color:#a855f7;font-size:20px;margin-bottom:15px}
.atelier-body h5{color:#a1a1aa;font-size:12px;letter-spacing:1px;text-transform:uppercase;margin:18px 0 4px}
.atelier-body a{display:block;color:#8b5cf6;font-size:14px;font-weight:bold;text-decoration:none;margin-top:8px;word-break:break-word}
.atelier-body a:hover{color:#a855f7}
.contact{text-align:center;min-height:auto}
.contact p{color:#c4c4c4;margin:15px}
.contact strong{color:#a855f7}
footer{text-align:center;padding:25px;background:#020202;border-top:1px solid #222;color:#777}
@media(max-width:900px){
.burger{display:block}
nav ul{display:none;flex-direction:column;position:absolute;top:100%;left:0;width:100%;background:#050505;padding:20px;gap:18px;border-bottom:1px solid #222}
nav ul.active{display:flex}
.home{flex-direction:column;text-align:center;padding-top:150px}
.home-text h1{font-size:42px}
.skills{grid-template-columns:repeat(2,1fr)}
.ateliers{grid-template-columns:1fr}
.profile{width:220px;height:220px;font-size:55px}
}
@media(max-width:500px){
section{padding-left:20px;padding-right:20px}
.skills{grid-template-columns:1fr}
.home-text h1{font-size:35px}
.title{font-size:32px}
}
</style>
</head>
<body>

<header>
<nav>
    <div class="logo">Rania<span>.</span></div>
    <button class="burger" id="burger" aria-label="Ouvrir le menu" aria-expanded="false">☰</button>
    <ul id="navMenu">
        <li><a href="#home">Accueil</a></li>
        <li><a href="#about">À propos</a></li>
        <li><a href="#skills">Compétences</a></li>
        <li><a href="#modules">Modules</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
</nav>
</header>

<section class="home" id="home">
    <div class="home-text">
        <h2>Bonjour, je suis</h2>
        <h1>Rania <span>Al Amrani</span></h1>
        <h2 class="job"><?= e($job) ?></h2>
        <p>Développeuse web passionnée par la création d'interfaces modernes et d'applications fonctionnelles.</p>
        <a href="#modules" class="btn">Voir mes modules</a>
    </div>
    <div class="profile">
        <img src="/images/PH7.jpeg" alt="Photo de profil de Rania"
             onerror="this.style.display='none';this.parentElement.textContent='RA'">
    </div>
</section>

<section id="about">
    <h2 class="title">À <span>propos</span></h2>
    <div class="about">
        <p><?= e($about) ?> Je suis motivée, curieuse et passionnée par la création de solutions numériques. Mon objectif est de développer mes compétences en programmation et en conception d'interfaces.</p>
    </div>
</section>

<section id="skills">
    <h2 class="title">Mes <span>compétences</span></h2>
    <div class="skills">
        <?php foreach ($skills as $skill): ?>
            <div class="skill"><?= e($skill) ?></div>
        <?php endforeach; ?>
    </div>
</section>

<section id="modules">
    <h2 class="title">Mes <span>modules</span></h2>
    <div class="modules">
        <?php foreach ($modules as $mi => $module): ?>
            <div class="module" id="module-<?= $mi + 1 ?>">
                <h3><?= e($module['title']) ?></h3>
                <p><?= e($module['description']) ?></p>

                <div class="atelier-nav">
                    <?php foreach ($module['ateliers'] as $ai => $atelier): ?>
                        <a href="#m<?= $mi + 1 ?>-a<?= $ai + 1 ?>"><?= e($atelier['title']) ?></a>
                    <?php endforeach; ?>
                </div>

                <div class="ateliers">
                    <?php foreach ($module['ateliers'] as $ai => $atelier): ?>
                        <article class="atelier" id="m<?= $mi + 1 ?>-a<?= $ai + 1 ?>">
                            <?php if (!empty($atelier['photos'])): ?>
                                <div class="atelier-photos">
                                    <?php foreach ($atelier['photos'] as $photo): ?>
                                        <a href="<?= e($photo) ?>" target="_blank" rel="noopener">
                                            <img src="<?= e($photo) ?>"
                                                 alt="<?= e($atelier['title']) ?>"
                                                 loading="lazy">
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php elseif (empty($atelier['videos'])): ?>
                                <div class="no-photo">Aucune photo pour le moment</div>
                            <?php endif; ?>

                            <?php if (!empty($atelier['videos'])): ?>
                                <div class="atelier-videos">
                                    <?php foreach ($atelier['videos'] as $video): ?>
                                        <video controls preload="metadata">
                                            <source src="<?= e($video['url']) ?>" type="<?= e($video['type']) ?>">
                                            Votre navigateur ne supporte pas la vidéo.
                                        </video>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="atelier-body">
                                <h4><?= e($atelier['title']) ?></h4>

                                <?php if (!empty($atelier['fichiers'])): ?>
                                    <h5>Fichiers</h5>
                                    <?php foreach ($atelier['fichiers'] as $file): ?>
                                        <a href="<?= e($file['url']) ?>" target="_blank" rel="noopener">
                                            📄 <?= e($file['label']) ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="contact" id="contact">
    <h2 class="title">Me <span>contacter</span></h2>
    <p><strong>Email :</strong> votre.vrai.email@gmail.com</p>
    <p><strong>Téléphone :</strong> +212 6 12 34 56 78</p>
    <p><strong>Localisation :</strong> Maroc</p>
    <a href="mailto:votre.vrai.email@gmail.com" class="btn">Contactez-moi</a>
</section>

<footer>
    © <?= date('Y') ?> <?= e($name) ?> — Portfolio
</footer>

<script>
const burger = document.getElementById('burger');
const menu = document.getElementById('navMenu');

burger.addEventListener('click', function () {
    const active = menu.classList.toggle('active');
    burger.setAttribute('aria-expanded', String(active));
});

menu.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
        menu.classList.remove('active');
        burger.setAttribute('aria-expanded', 'false');
    });
});
</script>

</body>
</html>
