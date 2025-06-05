<!DOCTYPE html>
<html>
<head>
    <title>Admin panel - Filtrirane prijave</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h2, h3 {
            color: #333;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form select {
            padding: 5px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            vertical-align: top;
            text-align: left;
        }
        img {
            max-width: 150px;
            height: auto;
            display: block;
            margin-top: 5px;
        }
        .btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 2px 2px 2px 0;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #28a745;
        }
    </style>
</head>
<body>

<a href="index.php" class="btn back-button">Nazad na početnu</a>

<h2>Sve prijave (Admin)</h2>

<form method="GET" action="index.php" class="filter-form">
    <input type="hidden" name="url" value="korisnik/adminPanel">
    <label for="status">Filtriraj po statusu:</label>
    <select name="status" id="status" onchange="this.form.submit()">
        <option value="">Sve</option>
        <option value="cekanje" <?= isset($_GET['status']) && $_GET['status'] == 'cekanje' ? 'selected' : '' ?>>Čekanje</option>
        <option value="prihvaceno" <?= isset($_GET['status']) && $_GET['status'] == 'prihvaceno' ? 'selected' : '' ?>>Prihvaćeno</option>
        <option value="zavrseno" <?= isset($_GET['status']) && $_GET['status'] == 'zavrseno' ? 'selected' : '' ?>>Završeno</option>
    </select>
</form>

<?php if (!empty($prijave)): ?>
    <table>
        <thead>
            <tr>
                <th>Korisnik</th>
                <th>Opis + Slika</th>
                <th>Status</th>
                <th>Datum</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prijave as $prijava): ?>
                <tr>
                    <td><?= htmlspecialchars($prijava['ime']) ?></td>
                    <td>
                        <strong><?= htmlspecialchars($prijava['opis']) ?></strong><br>
                        <?php if (!empty($prijava['slika'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($prijava['slika']) ?>" alt="Prijava slika">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($prijava['status']) ?></td>
                    <td><?= $prijava['datum_prijave'] ?></td>
                    <td>
                        <form method="POST" action="index.php?url=korisnik/promeniStatus" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $prijava['id'] ?>">
                            <button type="submit" name="status" value="prihvaceno" class="btn">Prihvati</button>
                            <button type="submit" name="status" value="zavrseno" class="btn">Završi</button>
                        </form>
                        <form method="POST" action="index.php?url=korisnik/obrisiPrijavu" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $prijava['id'] ?>">
                            <button type="submit" class="btn" onclick="return confirm('Da li ste sigurni da želite da obrišete prijavu?')">Obriši</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nema prijava za prikaz.</p>
<?php endif; ?>

<hr>
<h3>Prijave (učitane iz API-ja)</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Opis</th>
            <th>Status</th>
            <th>Datum</th>
        </tr>
    </thead>
    <tbody id="api-prijave">
    </tbody>
</table>

<script src="/sup25/vk/public/js/loadPrijaveStatus.js?v=2"></script>
<script>
    const CSRF_TOKEN = "<?= $_SESSION['csrf_token'] ?? '' ?>";
</script>
</body>
</html>
