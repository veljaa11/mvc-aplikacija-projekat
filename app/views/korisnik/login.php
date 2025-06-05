<?php
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Prijava korisnika</h2>

    <form method="POST" action="index.php?url=korisnik/prijava">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>

        <label>Lozinka:</label><br>
        <input type="password" name="lozinka" required><br><br>

        <input type="hidden" name="_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

        <button type="submit">Prijavi se</button>
    </form>
</body>
</html>
