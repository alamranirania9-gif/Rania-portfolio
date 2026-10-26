<?php
declare(strict_types=1);

/* ============================================================
   PORTFOLIO — RANIA AL AMRANI   (PHP seul, sans base de données)
   >>> Tout ce que tu veux changer est juste en dessous. <<<
   ============================================================ */

date_default_timezone_set('Europe/Paris');

$nom       = 'Rania Al Amrani';
$initiales = 'RA';
$poste     = 'Étudiante en développement web';
$accroche  = "J’apprends, je pratique, et je note chaque étape de mon parcours.";
$email     = 'rania@example.com';

/* --- Tes photos : fichiers placés dans le dossier public/images --- */
$photo_profil = '/images/PH3.jpeg';
$photos       = [
    ['src' => '/images/PH3.jpeg', 'legende' => 'Mon atelier du Module 1'],
    ['src' => '/images/PH7.jpeg', 'legende' => 'Mon atelier du Module 2'],
];

/* --- Tes documents : fichiers placés dans le dossier public/docs --- */
$ateliers = [
    [
        'titre'  => 'Atelier 2 — Module 1',
        'fichier'=> '/docs/ATELIER2.docx',
        'texte'  => 'Premier atelier : découverte de l’environnement de travail et mise en pratique des bases.',
    ],
    [
        'titre'  => 'Atelier 5 — Module 2',
        'fichier'=> '/docs/AT5.docx',
        'texte'  => 'Atelier du Module 2 : travail guidé, captures d’écran et comptes rendus des étapes.',
    ],
];

/* ============================================================
   OU TES TÂCHES SONT ENREGISTREES — une vraie base de données.
   Elles restent en place après un redémarrage ou un redéploiement.
   >> Mets ces infos en variables d'environnement chez ton hébergeur
      (Vercel : Settings > Environment Variables). <<
   Si la base n'est pas encore reglee, les tâches sont gardées
   dans un fichier journal.json (repli temporaire).
   ============================================================ */
$db = [
    'hote'         => getenv('DB_HOST') ?: 'localhost',
    'port'         => getenv('DB_PORT') ?: '3306',
    'nom'          => getenv('DB_NAME') ?: 'rania_portfolio',
    'user'         => getenv('DB_USER') ?: 'root',
    'mot_de_passe' => getenv('DB_PASS') ?: '',
    'dsn'          => getenv('DB_DSN') ?: '',   // optionnel : sqlite:/chemin/taches.db
];

$journal  = __DIR__ . '/journal.json';
if (!is_dir(__DIR__) || !is_writable(__DIR__)) {
    $journal = sys_get_temp_dir() . '/journal_rania.json';
}

$bd_ok      = false;   // true = les tâches sont en base de données
$bd_message = '';

function bd(string $fichier): ?PDO
{
    global $db, $bd_ok, $bd_message;
    static $pdo = null;
    static $essai = false;
    if ($essai) {
        return $pdo;
    }
    $essai = true;

    try {
        if ($db['dsn'] !== '') {
            $pdo = new PDO($db['dsn']);
        } else {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $db['hote'], $db['port'], $db['nom']);
            $pdo = new PDO($dsn, $db['user'], $db['mot_de_passe']);
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver === 'sqlite') {
            $pdo->exec('CREATE TABLE IF NOT EXISTS taches (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                texte TEXT NOT NULL,
                date_ecrite TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP)');
        } else {
            $pdo->exec('CREATE TABLE IF NOT EXISTS taches (
                id INT AUTO_INCREMENT PRIMARY KEY,
                texte TEXT NOT NULL,
                date_ecrite DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        }

        // reprend une seule fois les tâches déjà dans le fichier
        $nb = (int) $pdo->query('SELECT COUNT(*) FROM taches')->fetchColumn();
        if ($nb === 0 && is_file($fichier)) {
            $ancien = json_decode((string) file_get_contents($fichier), true);
            if (is_array($ancien)) {
                $ins = $pdo->prepare('INSERT INTO taches (texte) VALUES (?)');
                foreach (array_reverse($ancien) as $t) {
                    if (!empty($t['texte'])) {
                        $ins->execute([(string) $t['texte']]);
                    }
                }
            }
            @rename($fichier, $fichier . '.bak');
        }

        $bd_ok = true;
        return $pdo;
    } catch (Throwable $e) {
        $pdo = null;
        $bd_message = 'Base de données indisponible pour l’instant : ' . $e->getMessage();
        return null;
    }
}

function journal_ajouter(string $texte, string $fichier): bool
{
    $pdo = bd($fichier);
    if ($pdo) {
        $pdo->prepare('INSERT INTO taches (texte) VALUES (?)')->execute([$texte]);
        return true;
    }
    $taches = journal_lire($fichier);
    array_unshift($taches, ['date' => date('d/m/Y') . ' à ' . date('H:i'), 'texte' => $texte]);
    return file_put_contents($fichier, json_encode($taches, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}

function journal_lire(string $fichier): array
{
    $pdo = bd($fichier);
    if ($pdo) {
        $rows = $pdo->query('SELECT texte, date_ecrite FROM taches ORDER BY id DESC LIMIT 100')->fetchAll();
        $out = [];
        foreach ($rows as $r) {
            $date = (string) ($r['date_ecrite'] ?? '');
            try {
                $dt = new DateTime($date);
                $date = $dt->format('d/m/Y') . ' à ' . $dt->format('H:i');
            } catch (Throwable $e) {
                // la date reste telle quelle
            }
            $out[] = ['date' => $date, 'texte' => (string) $r['texte']];
        }
        return $out;
    }
    if (!is_file($fichier)) {
        return [];
    }
    $data = json_decode((string) file_get_contents($fichier), true);
    return is_array($data) ? $data : [];
}


/* --- Ajout d'une tâche (la date du jour est mise toute seule) --- */
$erreur  = '';
$ajout_ok = false;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $tache = trim((string) ($_POST['tache'] ?? ''));
    if ($tache === '') {
        $erreur = 'Écris ta tâche du jour avant de cliquer sur Ajouter.';
    } else {
        if (journal_ajouter($tache, $journal)) {
            $ajout_ok = true;
        } else {
            $erreur = 'Je n’arrive pas à enregistrer sur ce serveur. Essaie un autre hébergement PHP.';
        }
    }
}

$taches = journal_lire($journal);

?><!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($nom) ?> — Portfolio</title>
<meta name="description" content="Portfolio de <?= htmlspecialchars($nom) ?> : ateliers du Module 1 et du Module 2, photos et journal quotidien.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
    :root{
        --rose:#FF2D78;
        --rose-fonce:#C2185B;
        --blush:#FFF1F6;
        --blush2:#FFE3EE;
        --prune:#33112B;
        --gris:#7A5C6E;
        --blanc:#FFFFFF;
        --ombre:0 18px 45px rgba(255,45,120,.14);
        --rond:22px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    body{
        font-family:'DM Sans',system-ui,sans-serif;
        background:var(--blush);
        color:var(--prune);
        line-height:1.65;
    }
    h1,h2,h3{font-family:'Playfair Display',Georgia,serif;line-height:1.15}
    a{color:var(--rose-fonce)}
    .wrap{max-width:1080px;margin:0 auto;padding:0 22px}

    /* ---- Navigation ---- */
    nav{
        position:sticky;top:0;z-index:20;
        background:rgba(255,241,246,.92);
        backdrop-filter:blur(8px);
        border-bottom:1px solid var(--blush2);
    }
    .nav-inner{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:14px 0;flex-wrap:wrap}
    .logo{font-family:'Playfair Display',serif;font-weight:700;font-size:20px;color:var(--prune);text-decoration:none}
    .logo span{color:var(--rose)}
    .nav-links{display:flex;gap:18px;flex-wrap:wrap}
    .nav-links a{text-decoration:none;color:var(--gris);font-weight:500;font-size:15px}
    .nav-links a:hover{color:var(--rose)}

    /* ---- Accueil avec nom + photo ---- */
    .hero{padding:60px 0 70px}
    .hero-grid{display:grid;grid-template-columns:1.15fr .85fr;gap:48px;align-items:center}
    .etiquette{
        display:inline-block;background:var(--blush2);color:var(--rose-fonce);
        font-size:13px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
        padding:7px 14px;border-radius:999px;margin-bottom:18px;
    }
    .hero h1{font-size:clamp(38px,6vw,62px);margin-bottom:14px}
    .hero h1 em{color:var(--rose);font-style:italic}
    .hero .poste{font-size:19px;font-weight:700;color:var(--rose-fonce);margin-bottom:12px}
    .hero p{color:var(--gris);font-size:17px;max-width:46ch}
    .hero-btns{display:flex;gap:12px;flex-wrap:wrap;margin-top:26px}
    .btn{
        display:inline-block;text-decoration:none;font-weight:700;font-size:15px;
        padding:13px 24px;border-radius:999px;border:2px solid var(--rose);
    }
    .btn-rose{background:var(--rose);color:#fff}
    .btn-rose:hover{background:var(--rose-fonce);border-color:var(--rose-fonce)}
    .btn-vide{background:transparent;color:var(--rose-fonce)}
    .btn-vide:hover{background:var(--blush2)}

    /* ---- Cadre photo ---- */
    .photo-cadre{
        position:relative;width:min(340px,80vw);margin:0 auto;aspect-ratio:4/5;
        border-radius:200px 200px var(--rond) var(--rond);
        background:var(--blush2);
        box-shadow:var(--ombre);
        overflow:hidden;
        border:6px solid #fff;
    }
    .photo-cadre::before{
        content:"";position:absolute;inset:-40px;z-index:-1;
        background:radial-gradient(circle at 70% 20%,var(--rose) 0%,transparent 55%);
        opacity:.18;
    }
    .photo-cadre img{width:100%;height:100%;object-fit:cover;display:block}
    .photo-initiales{
        display:none;position:absolute;inset:0;
        align-items:center;justify-content:center;
        font-family:'Playfair Display',serif;font-size:74px;font-weight:700;color:var(--rose-fonce);
    }
    .photo-cadre.sans-photo img{display:none}
    .photo-cadre.sans-photo .photo-initiales{display:flex}
    .photo-nom{
        text-align:center;margin-top:16px;font-weight:700;color:var(--rose-fonce);font-size:15px;
    }

    /* ---- Sections ---- */
    section{padding:52px 0}
    .section-tete{margin-bottom:28px}
    .section-tete h2{font-size:32px}
    .section-tete h2::after{content:"";display:block;width:64px;height:4px;background:var(--rose);border-radius:4px;margin-top:10px}
    .section-tete p{color:var(--gris);margin-top:10px}
    .carte{
        background:var(--blanc);border-radius:var(--rond);padding:26px;
        box-shadow:var(--ombre);border:1px solid var(--blush2);
    }
    .grille{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:22px}
    .carte h3{font-size:21px;margin-bottom:8px}
    .carte p{color:var(--gris);font-size:15px;margin-bottom:16px}
    .module{
        display:inline-block;background:var(--blush2);color:var(--rose-fonce);
        font-size:12px;font-weight:700;padding:5px 12px;border-radius:999px;margin-bottom:12px;
    }

    /* ---- Galerie ---- */
    .galerie{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px}
    .galerie figure{background:#fff;border-radius:var(--rond);overflow:hidden;box-shadow:var(--ombre);border:1px solid var(--blush2)}
    .galerie img{width:100%;height:230px;object-fit:cover;display:block}
    .galerie figcaption{padding:14px 16px;font-size:14px;font-weight:500;color:var(--gris)}

    /* ---- Journal ---- */
    .journal{background:linear-gradient(180deg,#fff 0%,var(--blush) 100%);border-radius:var(--rond);border:1px solid var(--blush2);padding:28px;box-shadow:var(--ombre)}
    form{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:22px}
    textarea{
        flex:1 1 260px;min-height:74px;resize:vertical;
        border:2px dashed var(--blush2);background:#fff;border-radius:16px;
        padding:14px;font:inherit;color:var(--prune);
    }
    textarea:focus{outline:none;border-color:var(--rose)}
    form button{
        border:0;background:var(--rose);color:#fff;font:inherit;font-weight:700;
        padding:0 26px;border-radius:16px;cursor:pointer;
    }
    form button:hover{background:var(--rose-fonce)}
    .msg{padding:12px 16px;border-radius:14px;font-weight:500;margin-bottom:18px}
    .msg-ok{background:#E8F8EF;color:#1B7A45}
    .msg-erreur{background:#FFF0F3;color:var(--rose-fonce)}
    .liste{list-style:none;display:grid;gap:12px}
    .liste li{background:#fff;border-left:5px solid var(--rose);border-radius:14px;padding:14px 18px;box-shadow:0 6px 18px rgba(255,45,120,.08)}
    .liste time{display:block;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--rose)}
    .liste p{font-size:16px}
    .vide{color:var(--gris);font-style:italic}
    .ou{font-size:13px;font-weight:700;letter-spacing:.04em;color:var(--rose-fonce);background:var(--blush2);border-radius:999px;padding:8px 16px;display:inline-block;margin-bottom:18px}


    footer{background:var(--prune);color:#fff;padding:38px 0;margin-top:40px;text-align:center}
    footer a{color:#FFB3CE;font-weight:700;text-decoration:none}
    footer small{display:block;margin-top:12px;color:#C9A9BC}

    @media(max-width:820px){
        .hero-grid{grid-template-columns:1fr;gap:34px}
        .photo-cadre{order:-1;width:min(280px,72vw)}
    }
</style>
</head>
<body>

<nav>
    <div class="wrap nav-inner">
        <a class="logo" href="#haut"><?= htmlspecialchars(explode(' ', $nom)[0]) ?><span>.</span></a>

        <div class="nav-links">
            <a href="#apropos">À propos</a>
            <a href="#ateliers">Ateliers</a>
            <a href="#galerie">Photos</a>
            <a href="#journal">Journal</a>
            <a href="#contact">Contact</a>
        </div>
    </div>
</nav>

<header class="hero wrap" id="haut">
    <div class="hero-grid">
        <div>
            <span class="etiquette">Mon portfolio</span>
            <h1><?= htmlspecialchars($nom) ?></h1>
            <p class="poste"><?= htmlspecialchars($poste) ?></p>
            <p><?= htmlspecialchars($accroche) ?></p>
            <div class="hero-btns">
                <a class="btn btn-rose" href="#ateliers">Voir mes ateliers</a>
                <a class="btn btn-vide" href="#journal">Mon journal</a>
            </div>
        </div>
        <div>
            <div class="photo-cadre" id="photo">
                <img src="<?= htmlspecialchars($photo_profil) ?>" alt="Photo de <?= htmlspecialchars($nom) ?>"
                     onerror="this.parentNode.classList.add('sans-photo')">
                <span class="photo-initiales"><?= htmlspecialchars($initiales) ?></span>
            </div>
            <p class="photo-nom"><?= htmlspecialchars($nom) ?></p>
        </div>
    </div>
</header>

<section id="apropos" class="wrap">
    <div class="section-tete"><h2>À propos</h2></div>
    <div class="carte">
        <p>Je m’appelle <strong><?= htmlspecialchars($nom) ?></strong>. Sur cette page je rassemble les
        ateliers que je réalise, les photos de mon travail, et un journal où j’ajoute une tâche chaque jour.
        Le but : garder une trace claire de ce que j’apprends, étape par étape.</p>
    </div>
</section>

<section id="ateliers" class="wrap">
    <div class="section-tete">
        <h2>Mes ateliers</h2>
        <p>Module 1 et Module 2.</p>
    </div>
    <div class="grille">
        <?php foreach ($ateliers as $a): ?>
            <article class="carte">
                <span class="module">Atelier</span>
                <h3><?= htmlspecialchars($a['titre']) ?></h3>
                <p><?= htmlspecialchars($a['texte']) ?></p>
                <a class="btn btn-vide" href="<?= htmlspecialchars($a['fichier']) ?>">Voir</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section id="galerie" class="wrap">
    <div class="section-tete">
        <h2>Photos</h2>
        <p>Quelques images de mes ateliers.</p>
    </div>
    <div class="galerie">
        <?php foreach ($photos as $p): ?>
            <figure>
                <img src="<?= htmlspecialchars($p['src']) ?>" alt="<?= htmlspecialchars($p['legende']) ?>"
                     onerror="this.style.display='none'">
                <figcaption><?= htmlspecialchars($p['legende']) ?></figcaption>
            </figure>
        <?php endforeach; ?>
    </div>
</section>

<section id="journal" class="wrap">
    <div class="section-tete">
        <h2>Mon journal quotidien</h2>
        <p>Chaque jour j’écris ma tâche : elle s’ajoute tout de suite, avec la date du jour.</p>
    </div>

    <div class="journal">
        <?php if ($ajout_ok): ?>
            <div class="msg msg-ok">Ta tâche a bien été ajoutée.</div>
        <?php elseif ($erreur !== ''): ?>
            <div class="msg msg-erreur"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <p class="ou">
            <?php if ($bd_ok): ?>
                Enregistré dans une base de données : tes tâches restent après un redémarrage ou un redéploiement.
            <?php else: ?>
                Enregistré pour l’instant dans un fichier sur ce serveur. Connecte une base de données pour tout garder après un redéploiement.
            <?php endif; ?>
        </p>
        <?php if ($bd_message !== ''): ?>
            <div class="msg msg-erreur"><?= htmlspecialchars($bd_message) ?></div>
        <?php endif; ?>


        <form method="post" action="#journal">
            <textarea name="tache" placeholder="Ex : aujourd’hui j’ai fini l’atelier 5 du Module 2" required></textarea>
            <button type="submit">Ajouter</button>
        </form>

        <?php if ($taches): ?>
            <ul class="liste">
                <?php foreach ($taches as $t): ?>
                    <li>
                        <time><?= htmlspecialchars($t['date'] ?? '') ?></time>
                        <p><?= nl2br(htmlspecialchars($t['texte'] ?? '')) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="vide">Aucune tâche pour l’instant. Écris la première ci-dessus.</p>
        <?php endif; ?>
    </div>
</section>

<footer id="contact">
    <div class="wrap">
        <p><strong><?= htmlspecialchars($nom) ?></strong> — <?= htmlspecialchars($poste) ?></p>
        <p><a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a></p>
        <small>© <?= date('Y') ?> <?= htmlspecialchars($nom) ?></small>
    </div>
</footer>

</body>
</html>
