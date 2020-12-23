# Seminarka
Seminární práce do předmětu RSP

# Vytvoreni databaze pres prikazovou radku
Vytvoreni databaze jmenem Symfony

`php bin/console doctrine:database:create`

Vygenerovani tabulky podle objektoveho modelu v Symfony, v pripade zmeny v objektovem modelu s pomoci tehoz prikazu upgraduji

`php bin/console doctrine:schema:update --force`