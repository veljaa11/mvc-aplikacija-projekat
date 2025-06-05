<?php
session_start();
$korisnik = $_SESSION['korisnik'] ?? null;
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Prijava kvarova - Početna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Prijava Kvarova</span>
            <div>
                <?php if ($korisnik): ?>
                    <span class="text-light me-3"><?= htmlspecialchars($korisnik['ime']) ?> (<?= $korisnik['uloga'] ?>)</span>
                    <a href="logout.php" class="btn btn-sm btn-outline-light">Odjavi se</a>
                <?php else: ?>
                    <a href="index.php?url=korisnik/login" class="btn btn-sm btn-outline-light me-2">Prijava</a>
                    <a href="index.php?url=korisnik/registracija" class="btn btn-sm btn-outline-light">Registracija</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1 class="mb-3">Dobrodošli u sistem za prijavu kvarova</h1>
        <p class="lead">Prijavite tehnički kvar u vašem prostoru jednostavno i efikasno.</p>

        <?php if (!$korisnik): ?>
            <div class="alert alert-info mt-4 d-inline-block">
                Da biste koristili aplikaciju, prijavite se ili registrujte.
                <div class="mt-3">
                    <a href="index.php?url=korisnik/login" class="btn btn-primary me-2">Prijava</a>
                    <a href="index.php?url=korisnik/registracija" class="btn btn-secondary">Registracija</a>
                </div>
            </div>
        <?php else: ?>
            <div class="mt-4">
                <a href="index.php?url=korisnik/prijavaForma" class="btn btn-success me-2">➕ Prijavi kvar</a>
                <a href="index.php?url=korisnik/mojePrijave" class="btn btn-outline-primary me-2">📂 Moje prijave</a>
                <?php if ($korisnik['uloga'] === 'admin'): ?>
                    <a href="index.php?url=korisnik/adminPanel" class="btn btn-outline-danger">🛠 Admin panel</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
