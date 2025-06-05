<!DOCTYPE html>
<html>
<head>
    <title>Registracija</title>
</head>
<body>
    <h2>Registracija korisnika</h2>
    <form method="POST" action="index.php?url=korisnik/sacuvaj">
        <label>Ime:</label><br>
        <input type="text" name="ime" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Lozinka:</label><br>
        <input type="password" name="lozinka" required><br><br>
        <button type="submit">Registruj se</button>
    </form>
</body>
</html>
