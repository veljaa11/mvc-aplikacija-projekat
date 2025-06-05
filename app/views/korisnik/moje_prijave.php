<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Moje prijave</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .no-data {
            margin-top: 20px;
            color: #777;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<a href="index.php" class="back-button">Nazad na početnu</a>

<h2>Vaše prijavljene intervencije</h2>

<?php if (!empty($prijave)): ?>
    <table>
        <thead>
            <tr>
                <th>Opis</th>
                <th>Status</th>
                <th>Datum</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prijave as $prijava): ?>
                <tr>
                    <td><?= htmlspecialchars($prijava['opis']) ?></td>
                    <td><?= htmlspecialchars($prijava['status']) ?></td>
                    <td><?= $prijava['datum_prijave'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="no-data">Nemate nijednu prijavu.</p>
<?php endif; ?>

</body>
</html>
