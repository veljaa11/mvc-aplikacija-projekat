<?php 
require_once '../core/Database.php';

class KorisnikController {

    public function registracija() {
        require_once '../app/views/korisnik/registracija.php';
    }

    public function sacuvaj() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ime = $_POST['ime'];
            $email = $_POST['email'];
            $lozinka = password_hash($_POST['lozinka'], PASSWORD_DEFAULT);

            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("INSERT INTO korisnici_vk (ime, email, lozinka) VALUES (?, ?, ?)");
            $stmt->execute([$ime, $email, $lozinka]);

            header("Location: index.php");
            exit;
        } else {
            echo "Neispravan zahtev.";
        }
    }

    public function login() {
        require_once '../app/views/korisnik/login.php';
    }

    public function prijava() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            $email = $_POST['email'];
            $lozinka = $_POST['lozinka'];

            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM korisnici_vk WHERE email = ?");
            $stmt->execute([$email]);
            $korisnik = $stmt->fetch();

            if ($korisnik && password_verify($lozinka, $korisnik['lozinka'])) {
                $_SESSION['korisnik'] = $korisnik;
                header("Location: home.php");
                exit;
            } else {
                echo "Pogrešan email ili lozinka.";
            }
        } else {
            echo "Neispravan zahtev.";
        }
    }

    public function prijavaForma() {
        session_start();
        require_once '../app/views/korisnik/prijava.php';
    }

    public function sacuvajPrijavu() {
        session_start();

        if (!isset($_SESSION['korisnik'])) {
            echo "Morate biti prijavljeni.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $opis = $_POST['opis'];
            $korisnik_id = $_SESSION['korisnik']['id'];

            $imeSlike = null;
            if (isset($_FILES['slika']) && $_FILES['slika']['error'] == UPLOAD_ERR_OK) {
                $tmp = $_FILES['slika']['tmp_name'];
                $ime = basename($_FILES['slika']['name']);
                $putanja = '../uploads/' . $ime;
                move_uploaded_file($tmp, $putanja);
                $imeSlike = $ime;
            }

            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("INSERT INTO prijave_vk (korisnik_id, opis, slika) VALUES (?, ?, ?)");
            $stmt->execute([$korisnik_id, $opis, $imeSlike]);

            header("Location: index.php");
            exit;
        } else {
            echo "Neispravan zahtev.";
        }
    }

    public function mojePrijave() {
        session_start();

        if (!isset($_SESSION['korisnik'])) {
            echo "Morate biti prijavljeni.";
            return;
        }

        $korisnik_id = $_SESSION['korisnik']['id'];

        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM prijave_vk WHERE korisnik_id = ? ORDER BY datum_prijave DESC");
        $stmt->execute([$korisnik_id]);
        $prijave = $stmt->fetchAll();

        require_once '../app/views/korisnik/moje_prijave.php';
    }

    public function adminPanel() {
        session_start();

        if (!isset($_SESSION['korisnik']) || $_SESSION['korisnik']['uloga'] !== 'admin') {
            echo "Pristup dozvoljen samo administratorima.";
            return;
        }

        $db = new Database();
        $conn = $db->getConnection();

        $status = $_GET['status'] ?? '';

        if ($status && in_array($status, ['cekanje', 'prihvaceno', 'zavrseno'])) {
            $stmt = $conn->prepare("SELECT p.*, k.ime FROM prijave_vk p JOIN korisnici_vk k ON p.korisnik_id = k.id WHERE p.status = ? ORDER BY datum_prijave DESC");
            $stmt->execute([$status]);
        } else {
            $stmt = $conn->query("SELECT p.*, k.ime FROM prijave_vk p JOIN korisnici_vk k ON p.korisnik_id = k.id ORDER BY datum_prijave DESC");
        }

        $prijave = $stmt->fetchAll();

        require_once '../app/views/korisnik/admin_panel.php';
    }

    public function promeniStatus() {
        session_start();

        if (!isset($_SESSION['korisnik']) || $_SESSION['korisnik']['uloga'] !== 'admin') {
            echo "Neovlašćen pristup.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Neispravan zahtev.";
            return;
        }

        if (!isset($_POST['id'], $_POST['status'])) {
            echo "Nedostaju parametri.";
            return;
        }

        $id = (int) $_POST['id'];
        $status = $_POST['status'];
        $dozvoljeni = ['cekanje', 'prihvaceno', 'zavrseno'];

        if (!in_array($status, $dozvoljeni)) {
            echo "Neispravan status.";
            return;
        }

        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("UPDATE prijave_vk SET status = ? WHERE id = ?");
        $uspeh = $stmt->execute([$status, $id]);

        if ($uspeh) {
            header("Location: index.php?url=korisnik/adminPanel");
            exit;
        } else {
            echo "Greška pri ažuriranju baze.";
        }
    }

    public function obrisiPrijavu() {
        session_start();

        if (!isset($_SESSION['korisnik']) || $_SESSION['korisnik']['uloga'] !== 'admin') {
            echo "Samo admin može brisati prijave.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("DELETE FROM prijave_vk WHERE id = ?");
            $stmt->execute([$id]);

            header("Location: index.php?url=korisnik/adminPanel");
            exit;
        }
    }
}
