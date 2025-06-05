
<!DOCTYPE html>
<html>
<head>
    <title>Prijava kvara</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            max-width: 400px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-button {
            background-color: #28a745;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
    </style>

    <style>
        .btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .back-button {
            background-color: #28a745;
        }
    </style>
    
</head>
<body>

    <a href="index.php" class="back-button">Nazad na početnu</a>

    <h2>Prijava kvara</h2>
    <form method="POST" action="index.php?url=korisnik/sacuvajPrijavu" enctype="multipart/form-data">
        <label for="opis">Opis kvara:</label>
        <textarea name="opis" id="opis" required></textarea>

        <label for="slika">Dodaj sliku (opcionalno):</label>
        <input type="file" name="slika" id="slika" accept="image/*">

        <button type="submit">Pošalji prijavu</button>
    </form>

</body>
</html>
