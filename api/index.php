<!-- =========================
     PROJECTS
========================= -->

<style>
    :root {
        --deep-violet: #2D1B4E;
        --royal-violet: #5B3A9C;
        --electric-blue: #3D5AFE;
        --ice-blue: #E8ECFF;
        --ink: #17122A;
        --paper: #FAF9FC;
    }

    .projects {
        background: var(--paper);
        padding: 100px 24px;
    }

    .section-title {
        max-width: 640px;
        margin: 0 auto 64px;
        text-align: left;
    }

    .section-title span {
        color: var(--royal-violet);
        font-weight: 600;
        font-size: 0.95rem;
        letter-spacing: 0.02em;
    }

    .section-title h2 {
        font-size: clamp(2rem, 4vw, 2.75rem);
        color: var(--ink);
        margin: 8px 0 16px;
        line-height: 1.1;
    }

    .section-title p {
        color: #5c5470;
        font-size: 1.05rem;
        line-height: 1.6;
        max-width: 52ch;
    }

    .projects-container {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 28px;
    }

    .project-card {
        position: relative;
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #eae7f2;
        box-shadow: 0 4px 18px rgba(45, 27, 78, 0.06);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        display: flex;
        flex-direction: column;
    }

    .project-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(61, 90, 254, 0.18);
    }

    .project-number {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 2;
        background: rgba(23, 18, 42, 0.55);
        backdrop-filter: blur(6px);
        color: #fff;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 999px;
        letter-spacing: 0.03em;
    }

    .project-image {
        width: 100%;
        height: 190px;
        object-fit: cover;
        display: block;
        background: linear-gradient(135deg, var(--deep-violet), var(--electric-blue));
    }

    .project-card h3 {
        color: var(--ink);
        font-size: 1.2rem;
        margin: 20px 20px 8px;
        line-height: 1.3;
    }

    .project-card p {
        color: #6a6480;
        font-size: 0.95rem;
        line-height: 1.55;
        margin: 0 20px 20px;
        flex-grow: 1;
    }

    .project-link {
        margin: 0 20px 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
        color: var(--royal-violet);
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        border-bottom: 2px solid var(--ice-blue);
        padding-bottom: 2px;
        transition: border-color 0.2s ease, color 0.2s ease;
    }

    .project-link:hover {
        color: var(--electric-blue);
        border-color: var(--electric-blue);
    }

    @media (max-width: 640px) {
        .projects { padding: 64px 18px; }
        .section-title { margin-bottom: 40px; }
    }
</style>

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

        <!-- PROJET 1 -->
        <div class="project-card">
            <div class="project-number">01 — M201</div>

            <a href="projet-m201.php">
                <img src="PH7.jpeg" alt="Projet web" class="project-image">
            </a>

            <h3>Préparation d'un projet web</h3>
            <p>Exercices et travaux pratiques réalisés.</p>

            <a href="projet-m201.php" class="project-link">Voir le travail</a>
        </div>

        <!-- PROJET 2 -->
        <div class="project-card">
            <div class="project-number">02 — M202</div>

            <a href="projet-m202.php">
                <img src="PH3.jpeg" alt="Approche agile" class="project-image">
            </a>

            <h3>Approche agile</h3>
            <p>Exercices de manipulation du DOM, événements et validation.</p>

            <a href="projet-m202.php" class="project-link">Voir le travail</a>
        </div>

        <!-- PROJET 3 -->
        <div class="project-card">
            <div class="project-number">03 — M203</div>

            <a href="projet-m203.php">
                <img src="PH8.jpeg" alt="Gestion des données" class="project-image">
            </a>

            <h3>Gestion des données</h3>
            <p>Gestion des données des applications.</p>

            <a href="projet-m203.php" class="project-link">Voir le travail</a>
        </div>

    </div>

</section>