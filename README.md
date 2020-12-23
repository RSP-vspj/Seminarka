# Seminarka
Seminární práce do předmětu RSP

# Vytvoreni databaze pres prikazovou radku
Vytvoreni databaze jmenem Symfony

`php bin/console doctrine:database:create`

Vygenerovani tabulky podle objektoveho modelu v Symfony, v pripade zmeny v objektovem modelu s pomoci tehoz prikazu upgraduji

`php bin/console doctrine:schema:update --force`

# Vytvoreni uzivatele
Role: 0 admin, 1 uzivatel, 2 redaktor, 3 recenzent, 4 sefredaktor, 5 neregistrovany autor

Hesla kóduji pomocí bcryptu. Aby se dalo vůbec zalogovat, musí se v databázi ručně vytvořit admin a zadat mu tam zakódované heslo. Dá se to udělat tímto: https://bcrypt-generator.com/
