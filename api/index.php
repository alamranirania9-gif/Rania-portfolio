<?php
/**
 * Portfolio — page unique
 * -----------------------------------------------------
 * Fonctionnalités :
 *  - Galerie de photos avec lightbox (clavier + tactile)
 *  - Upload AJAX (sans rechargement de page)
 *  - Suppression AJAX avec confirmation
 *  - Validation MIME réelle (pas seulement l'extension)
 *  - Génération de miniatures (GD) pour accélérer la galerie
 *  - Protection CSRF sur les actions d'écriture
 *  - Noms de fichiers hashés (pas de collision, pas d'info leak)
 */

declare(strict_types=1);
session_start();

// =========================================================
// CONFIGURATION
// =========================================================
final class Config
{
    public const UPLOAD_DIR    = __DIR__ . '/uploads/';
    public const THUMB_DIR     = __DIR__ . '/uploads/thumbs/';
    public const UPLOAD_URL    = 'uploads/';
    public const THUMB_URL     = 'uploads/thumbs/';
    public const MAX_SIZE      = 5 * 1024 * 1024; // 5 Mo
    public const THUMB_WIDTH   = 480;
    public const ALLOWED_MIME  = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];
}

// =========================================================
// COUCHE D'ACCÈS AUX FICHIERS / GALERIE
// =========================================================
final class Gallery
{
    public function __construct()
    
    }
    if (!is_dir(Config::UPLOAD_DIR) && !@mkdir(Config::UPLOAD_DIR, 0755, true) && !is_dir(Config::UPLOAD_DIR)) {
    throw new RuntimeException("Le dossier d'upload n'est pas accessible en écriture sur cet hébergement.");
}

    /** Retourne la liste des photos, les plus récentes en premier. */
    public function list(): array
    {
        $files = glob(Config::UPLOAD_DIR . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE) ?: [];
        usort($files, static fn($a, $b) => filemtime($b) <=> filemtime($a));

        return array_map(static function (string $path): array {
            $name = basename($path);
            return [
                'name'   => $name,
                'url'    => Config::UPLOAD_URL . rawurlencode($name),
                'thumb'  => is_file(Config::THUMB_DIR . $name)
                    ? Config::THUMB_URL . rawurlencode($name)
                    : Config::UPLOAD_URL . rawurlencode($name),
                'date'   => date('d/m/Y H:i', filemtime($path)),
            ];
        }, $files);
    }
  
   $photosDeBase = [
    ['url' => 'PH7.jpeg', 'thumb' => 'PH7.jpeg'],
    ['url' => 'PH3.jpeg', 'thumb' => 'PH3.jpeg'],
    ];

       <div class="gallery-grid" id="gallery-grid">
    <?php foreach ($photosDeBase as $p): ?>
        <div class="gallery-item" data-full="<?= htmlspecialchars($p['url']) ?>">
            <img src="<?= htmlspecialchars($p['thumb']) ?>" alt="Photo du portfolio" loading="lazy">
        </div>
    <?php endforeach; ?>
    <?php foreach ($photos as $p): ?>
        <!-- ... boucle existante des photos uploadées ... -->
    <?php endforeach; ?>
</div>

    /**
     * Valide et enregistre un fichier envoyé via $_FILES.
     * @throws RuntimeException si la validation échoue.
     */
    public function store(array $file): array
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new RuntimeException("Échec de l'envoi (code {$file['error']}).");
        }

        if ($file['size'] > Config::MAX_SIZE) {
            throw new RuntimeException('Fichier trop volumineux (5 Mo max).');
        }

        // Validation du VRAI type MIME, pas juste l'extension du nom de fichier
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file['tmp_name']);

        if (!isset(Config::ALLOWED_MIME[$mime])) {
            throw new RuntimeException('Format non supporté (JPG, PNG, GIF, WEBP uniquement).');
        }

        $ext      = Config::ALLOWED_MIME[$mime];
        $filename = bin2hex(random_bytes(16)) . '.' . $ext;
        $dest     = Config::UPLOAD_DIR . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            throw new RuntimeException("Impossible d'enregistrer le fichier.");
        }

        $this->makeThumbnail($dest, Config::THUMB_DIR . $filename, $mime);

        return ['name' => $filename, 'url' => Config::UPLOAD_URL . $filename];
    }

    /** Supprime une photo (et sa miniature) par nom de fichier. */
    public function delete(string $name): bool
    {
        // On interdit tout traversal de répertoire
        $name = basename($name);
        $ok   = true;

        foreach ([Config::UPLOAD_DIR, Config::THUMB_DIR] as $dir) {
            $path = $dir . $name;
            if (is_file($path)) {
                $ok = unlink($path) && $ok;
            }
        }

        return $ok;
    }

    private function makeThumbnail(string $source, string $dest, string $mime): void
    {
        if (!function_exists('imagecreatetruecolor')) {
            return; // extension GD absente : on se contente de l'image originale
        }

        $src = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($source),
            'image/png'  => @imagecreatefrompng($source),
            'image/gif'  => @imagecreatefromgif($source),
            'image/webp' => @imagecreatefromwebp($source),
            default      => null,
        };

        if (!$src) {
            return;
        }

        $w = imagesx($src);
        $h = imagesy($src);
        $ratio = Config::THUMB_WIDTH / $w;
        $tw = Config::THUMB_WIDTH;
        $th = (int) round($h * $ratio);

        $thumb = imagecreatetruecolor($tw, $th);

        if ($mime === 'image/png' || $mime === 'image/gif') {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
        }

        imagecopyresampled($thumb, $src, 0, 0, 0, 0, $tw, $th, $w, $h);

        match ($mime) {
            'image/jpeg' => imagejpeg($thumb, $dest, 82),
            'image/png'  => imagepng($thumb, $dest, 6),
            'image/gif'  => imagegif($thumb, $dest),
            'image/webp' => imagewebp($thumb, $dest, 82),
            default      => null,
        };

        imagedestroy($src);
        imagedestroy($thumb);
    }
}

// =========================================================
// CSRF
// =========================================================
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

function checkCsrf(?string $token): void
{
    if (!$token || !hash_equals($_SESSION['csrf'], $token)) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'error' => 'Jeton CSRF invalide.']);
        exit;
    }
}

// =========================================================
// ROUTAGE API (AJAX) — même fichier, endpoint par ?action=
// =========================================================
$gallery = new Gallery();

if (isset($_GET['action'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        switch ($_GET['action']) {
            case 'upload':
                checkCsrf($_POST['csrf'] ?? null);
                $result = $gallery->store($_FILES['photo'] ?? []);
                echo json_encode(['ok' => true, 'photo' => $result]);
                break;

            case 'delete':
                checkCsrf($_POST['csrf'] ?? null);
                $name = $_POST['name'] ?? '';
                echo json_encode(['ok' => $gallery->delete($name)]);
                break;

            default:
                http_response_code(404);
                echo json_encode(['ok' => false, 'error' => 'Action inconnue.']);
        }
    } catch (Throwable $e) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// =========================================================
// RENDU DE LA PAGE
// =========================================================
$photos = $gallery->list();
$csrf   = htmlspecialchars($_SESSION['csrf'], ENT_QUOTES);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon Portfolio</title>
<style>
:root {
    --deep-violet: #2D1B4E;
    --royal-violet: #5B3A9C;
    --electric-blue: #3D5AFE;
    --ice-blue: #E8ECFF;
    --ink: #17122A;
    --paper: #FAF9FC;
    --muted: #6a6480;
    --danger: #b3261e;
}
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: var(--paper);
    color: var(--ink);
    line-height: 1.5;
}
a { text-decoration: none; }

.hero {
    background: linear-gradient(135deg, var(--deep-violet) 0%, var(--royal-violet) 55%, var(--electric-blue) 100%);
    padding: 120px 24px 100px;
    color: #fff;
}
.hero-content { max-width: 680px; margin: 0 auto; }
.hero-eyebrow { color: var(--ice-blue); font-weight: 600; font-size: 0.95rem; }
.hero h1 { font-size: clamp(2.2rem, 5vw, 3.2rem); line-height: 1.1; margin: 16px 0 20px; }
.hero p { font-size: 1.1rem; color: rgba(255,255,255,0.85); max-width: 50ch; margin-bottom: 32px; }
.hero-nav { display: flex; gap: 16px; }
.hero-nav a {
    color: #fff; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3);
    padding: 10px 20px; border-radius: 999px; font-weight: 600; font-size: 0.95rem;
    transition: background .2s ease, transform .2s ease;
}
.hero-nav a:hover { background: #fff; color: var(--royal-violet); transform: translateY(-2px); }

.section-title { max-width: 640px; margin: 0 auto 48px; padding: 0 24px; }
.section-title span { color: var(--royal-violet); font-weight: 600; font-size: 0.9rem; }
.section-title h2 { font-size: clamp(1.8rem, 3.5vw, 2.4rem); margin: 8px 0 12px; }
.section-title p { color: var(--muted); font-size: 1rem; }

.gallery-section { padding: 90px 0 100px; }
.gallery-grid {
    max-width: 1100px; margin: 0 auto; padding: 0 24px;
    display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 18px;
}
.gallery-item {
    aspect-ratio: 1/1; border-radius: 14px; overflow: hidden; cursor: pointer; position: relative;
    box-shadow: 0 4px 14px rgba(45,27,78,0.08); transition: transform .25s ease, box-shadow .25s ease;
    background: #eee;
}
.gallery-item:hover { transform: translateY(-4px); box-shadow: 0 14px 28px rgba(61,90,254,0.2); }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gallery-item .delete-btn {
    position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; border-radius: 50%;
    background: rgba(23,18,42,0.6); color: #fff; border: none; font-size: 1rem; cursor: pointer;
    opacity: 0; transition: opacity .2s ease, background .2s ease;
    display: flex; align-items: center; justify-content: center;
}
.gallery-item:hover .delete-btn { opacity: 1; }
.gallery-item .delete-btn:hover { background: var(--danger); }

.empty-state {
    max-width: 1100px; margin: 0 auto; padding: 48px 24px; text-align: center; color: var(--muted);
    background: #fff; border: 1px dashed #d8d3ea; border-radius: 16px;
}

.upload-section { background: #fff; padding: 90px 0 110px; border-top: 1px solid #eee7fb; }
.upload-form { max-width: 560px; margin: 0 auto; padding: 0 24px; }
.upload-dropzone {
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px;
    border: 2px dashed #c9c0e6; border-radius: 16px; padding: 48px 24px; cursor: pointer;
    background: var(--ice-blue); transition: border-color .2s ease, background .2s ease; position: relative;
}
.upload-dropzone:hover, .upload-dropzone.dragging { border-color: var(--electric-blue); background: #dfe4ff; }
.upload-dropzone.has-file { border-color: var(--royal-violet); border-style: solid; }
.upload-icon { font-size: 2rem; color: var(--royal-violet); line-height: 1; }
.upload-text { color: var(--royal-violet); font-weight: 600; text-align: center; word-break: break-all; }
#photo-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

.upload-btn {
    margin-top: 20px; width: 100%; background: linear-gradient(135deg, var(--royal-violet), var(--electric-blue));
    color: #fff; border: none; padding: 14px; border-radius: 999px; font-weight: 600; font-size: 1rem;
    cursor: pointer; transition: opacity .2s ease, transform .2s ease;
}
.upload-btn:hover:not(:disabled) { opacity: 0.9; transform: translateY(-2px); }
.upload-btn:disabled { opacity: 0.5; cursor: not-allowed; }

.progress-bar { height: 4px; background: var(--ice-blue); border-radius: 999px; margin-top: 12px; overflow: hidden; display: none; }
.progress-bar.active { display: block; }
.progress-fill { height: 100%; width: 0%; background: var(--electric-blue); transition: width .15s ease; }

.form-message { max-width: 560px; margin: 0 auto 20px; padding: 14px 18px; border-radius: 10px; font-size: 0.95rem; display: none; }
.form-message.show { display: block; }
.form-message.success { background: #e6f7ee; color: #1a7f4f; border: 1px solid #b9e8cf; }
.form-message.error { background: #fdecec; color: var(--danger); border: 1px solid #f5c2c0; }

.lightbox {
    display: none; position: fixed; inset: 0; background: rgba(23,18,42,0.92); z-index: 999;
    align-items: center; justify-content: center; padding: 40px;
}
.lightbox.active { display: flex; }
.lightbox img { max-width: 100%; max-height: 100%; border-radius: 8px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); }
.lightbox-close { position: absolute; top: 24px; right: 32px; color: #fff; font-size: 2.5rem; cursor: pointer; line-height: 1; }
.lightbox-nav {
    position: absolute; top: 50%; transform: translateY(-50%); color: #fff; font-size: 2.5rem;
    cursor: pointer; padding: 12px 20px; user-select: none;
}
.lightbox-prev { left: 8px; }
.lightbox-next { right: 8px; }

@media (max-width: 640px) {
    .hero { padding: 90px 20px 70px; }
    .section-title { padding: 0 20px; }
    .gallery-grid { padding: 0 20px; grid-template-columns: repeat(2, 1fr); }
    .upload-form { padding: 0 20px; }
}
</style>
</head>
<body>

<header class="hero">
    <div class="hero-content">
        <span class="hero-eyebrow">Portfolio étudiant</span>
        <h1>Bienvenue sur mon espace de travail</h1>
        <p>Retrouvez ici mes projets, exercices et photos réalisés durant ma formation.</p>
        <nav class="hero-nav">
            <a href="#gallery">Galerie photos</a>
            <a href="#upload">Ajouter une photo</a>
        </nav>
    </div>
</header>

<section class="gallery-section" id="gallery">
    <div class="section-title">
        <span>Mes fichiers</span>
        <h2>Galerie photos</h2>
        <p>Cliquez sur une photo pour l'afficher en grand.</p>
    </div>

    <div class="gallery-grid" id="gallery-grid">
        <?php foreach ($photos as $p): ?>
            <div class="gallery-item" data-name="<?= htmlspecialchars($p['name']) ?>" data-full="<?= htmlspecialchars($p['url']) ?>">
                <img src="<?= htmlspecialchars($p['thumb']) ?>" alt="Photo du portfolio" loading="lazy">
                <button class="delete-btn" title="Supprimer" aria-label="Supprimer cette photo">&times;</button>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="empty-state" id="empty-state" style="<?= $photos ? 'display:none' : '' ?>">
        <p>Aucune photo pour le moment. Ajoutez-en une ci-dessous.</p>
    </div>
</section>

<section class="upload-section" id="upload">
    <div class="section-title">
        <span>Ajouter</span>
        <h2>Envoyer une nouvelle photo</h2>
        <p>Formats acceptés : JPG, PNG, GIF, WEBP — 5 Mo maximum.</p>
    </div>

    <div class="form-message" id="form-message"></div>

    <form class="upload-form" id="upload-form">
        <label for="photo-input" class="upload-dropzone" id="dropzone">
            <span class="upload-icon">+</span>
            <span class="upload-text" id="upload-text">Choisissez une photo ou glissez-la ici</span>
            <input type="file" name="photo" id="photo-input" accept=".jpg,.jpeg,.png,.gif,.webp" required>
        </label>
        <div class="progress-bar" id="progress-bar"><div class="progress-fill" id="progress-fill"></div></div>
        <button type="submit" class="upload-btn" id="upload-btn">Ajouter la photo</button>
    </form>
</section>

<div class="lightbox" id="lightbox">
    <span class="lightbox-close" id="lightbox-close">&times;</span>
    <span class="lightbox-nav lightbox-prev" id="lightbox-prev">&#8249;</span>
    <span class="lightbox-nav lightbox-next" id="lightbox-next">&#8250;</span>
    <img src="" alt="Photo agrandie" id="lightbox-img">
</div>

<script>
(() => {
    'use strict';

    const CSRF = <?= json_encode($_SESSION['csrf']) ?>;

    // ---------- Éléments ----------
    const grid        = document.getElementById('gallery-grid');
    const emptyState  = document.getElementById('empty-state');
    const form        = document.getElementById('upload-form');
    const input       = document.getElementById('photo-input');
    const dropzone    = document.getElementById('dropzone');
    const uploadText  = document.getElementById('upload-text');
    const uploadBtn   = document.getElementById('upload-btn');
    const progressBar = document.getElementById('progress-bar');
    const progressFill= document.getElementById('progress-fill');
    const messageBox  = document.getElementById('form-message');

    const lightbox     = document.getElementById('lightbox');
    const lightboxImg  = document.getElementById('lightbox-img');
    const lightboxClose= document.getElementById('lightbox-close');
    const lightboxPrev = document.getElementById('lightbox-prev');
    const lightboxNext = document.getElementById('lightbox-next');

    let currentIndex = -1;

    // ---------- Utilitaires ----------
    function items() {
        return Array.from(grid.querySelectorAll('.gallery-item'));
    }

    function showMessage(text, type) {
        messageBox.textContent = text;
        messageBox.className = `form-message show ${type}`;
        setTimeout(() => messageBox.classList.remove('show'), 4000);
    }

    function addGalleryItem(name, url) {
        emptyState.style.display = 'none';
        const div = document.createElement('div');
        div.className = 'gallery-item';
        div.dataset.name = name;
        div.dataset.full = url;
        div.innerHTML = `
            <img src="${url}" alt="Photo du portfolio" loading="lazy">
            <button class="delete-btn" title="Supprimer" aria-label="Supprimer cette photo">&times;</button>
        `;
        grid.prepend(div);
        bindItem(div);
    }

    // ---------- Lightbox ----------
    function openLightbox(index) {
        const list = items();
        if (!list.length) return;
        currentIndex = (index + list.length) % list.length;
        lightboxImg.src = list[currentIndex].dataset.full;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    lightboxClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => { if (e.target === lightbox) closeLightbox(); });
    lightboxPrev.addEventListener('click', (e) => { e.stopPropagation(); openLightbox(currentIndex - 1); });
    lightboxNext.addEventListener('click', (e) => { e.stopPropagation(); openLightbox(currentIndex + 1); });

    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') openLightbox(currentIndex - 1);
        if (e.key === 'ArrowRight') openLightbox(currentIndex + 1);
    });

    // ---------- Suppression ----------
    async function deletePhoto(name, el) {
        if (!confirm('Supprimer cette photo ?')) return;

        const body = new FormData();
        body.append('csrf', CSRF);
        body.append('name', name);

        try {
            const res = await fetch('?action=delete', { method: 'POST', body });
            const data = await res.json();
            if (data.ok) {
                el.remove();
                if (!items().length) emptyState.style.display = '';
            } else {
                showMessage(data.error || 'Suppression impossible.', 'error');
            }
        } catch {
            showMessage('Erreur réseau lors de la suppression.', 'error');
        }
    }

    function bindItem(el) {
        el.querySelector('img').addEventListener('click', () => {
            openLightbox(items().indexOf(el));
        });
        el.querySelector('.delete-btn').addEventListener('click', (e) => {
            e.stopPropagation();
            deletePhoto(el.dataset.name, el);
        });
    }

    items().forEach(bindItem);

    // ---------- Dropzone : sélection / glisser-déposer ----------
    input.addEventListener('change', () => {
        if (input.files.length) {
            uploadText.textContent = input.files[0].name;
            dropzone.classList.add('has-file');
        }
    });

    ['dragover', 'dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, (e) => {
            e.preventDefault();
            dropzone.classList.toggle('dragging', evt === 'dragover');
        });
    });

    dropzone.addEventListener('drop', (e) => {
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
    });

    // ---------- Upload AJAX avec barre de progression ----------
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!input.files.length) return;

        const body = new FormData();
        body.append('photo', input.files[0]);
        body.append('csrf', CSRF);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '?action=upload');

        xhr.upload.addEventListener('progress', (e) => {
            if (!e.lengthComputable) return;
            progressBar.classList.add('active');
            progressFill.style.width = `${(e.loaded / e.total) * 100}%`;
        });

        xhr.onload = () => {
            uploadBtn.disabled = false;
            progressBar.classList.remove('active');
            progressFill.style.width = '0%';

            let data;
            try { data = JSON.parse(xhr.responseText); }
            catch { showMessage('Réponse serveur invalide.', 'error'); return; }

            if (data.ok) {
                showMessage('Photo ajoutée avec succès.', 'success');
                addGalleryItem(data.photo.name, data.photo.url);
                form.reset();
                uploadText.textContent = 'Choisissez une photo ou glissez-la ici';
                dropzone.classList.remove('has-file');
            } else {
                showMessage(data.error || "Échec de l'envoi.", 'error');
            }
        };

        xhr.onerror = () => {
            uploadBtn.disabled = false;
            showMessage('Erreur réseau lors de l\'envoi.', 'error');
        };

        uploadBtn.disabled = true;
        xhr.send(body);
    });
})();
</script>

</body>
</html>
