 Aplikacija za prijavu kvarova 

http://usp2022.epizy.com/sup25/vk/public/index.php
admin prijava: 
veljko.karanovic45@gmail.com
pass: 123456

Ova web aplikacija omogućava korisnicima da prijave tehničke kvarove i prati njihov status, dok administrator ima mogućnost pregleda, filtriranja, menjanja statusa i brisanja prijava.

  Tehnologije koje su korišćene

- PHP (bez frameworka)
- MySQL baza podataka
- HTML/CSS/JS
- AJAX (fetch API)
- MVC struktura (Model-View-Controller)
- InfinityFree hosting (besplatan)

  Korisničke uloge

  Registrovani korisnik:
- Registracija i prijava
- Slanje prijave kvara uz opcioni upload slike
- Pregled sopstvenih prijava i njihovog statusa

  Administrator:
- Pristup admin panelu
- Prikaz svih prijava
- Filtriranje prijava po statusu (čekanje, prihvaćeno, završeno)
- Promena statusa prijave
- Brisanje prijava
- Pregled prijava i putem API-ja

  Struktura aplikacije

```
/app
  /controllers       → PHP kontroleri
  /views             → HTML stranice (prikazi)
  /models            → (opciono) Modeli podataka
/core                → Router i Database konekcija
/public              → Javne datoteke (index.php, JS, CSS)
/uploads             → Otpremljene slike prijava
```

  Ključne funkcionalnosti

- Prijava korisnika i registracija
- Slanje prijava sa slikom
- Admin panel sa status menadžmentom
- API za dinamičko učitavanje prijava (JS)
- CSRF zaštita za POST zahteve
- Redirekcija korisnika nakon ključnih akcija
- Vizuelno uređen interfejs




- Aplikacija koristi sesije za autentifikaciju
- Statusi prijava se mogu menjati samo kroz administratorski panel
- Korisnici ne mogu videti prijave drugih korisnika

  Autor

Veljko Karanovic
2022/5024 FIT
Softversko upravljanje projektima
