# Progetto web - VinylsShop
##### expected deadline: 14 Jan 2025
##### real deadline: 15 23:59 Jan 2025

## utenti già esistenti:
admin: admin
alexmaz03@hotmail.it: a

### Database Schema:
![Database Schema](/db/RELAZIONALE.png)

## Installation:
Si può usare [docker](https://www.docker.com/) eseguendo un: ``` docker compose up ```
### con XAMPP:
- injectando il [`db`](/db/init.sql) e [`db populate`](/db/populate.sql) 
- spostando il contenuto di [`src`](/src/) dentro la cartella `htdocs`.

## [Routing](/src/utility/Routing.php)