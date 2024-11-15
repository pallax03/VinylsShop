# Progetto web
> 💡 REPO:
> - src
> - mockup
> - relazione (1 pagina: chiedere se farla direttamente sul README )

## Warning ⚠️
- mobile first
- browser compability
- accessibility

### possibles Features
- Posizione mostra nazione
- Preordinare
- Newsletter 
- Suggerimenti in base a nazione genere artisti preferiti


## Configuration:
Si può usare docker eseguendo un : ``` docker compose up ```
Oppure copiare il progetto su XAMPP:
- [injectando il db](/db/init.sql)
- e spostando il contenuto di [src](/src/) dentro la cartella `htdocs`

### API:
- gravatar -> prendere il profilo (immagine pfp) di un account gravatar (il "portafoglio digitale" per l'email), se l'utente lo ha altrimenti si mostra un icona di default.
- spotify -> permette di dare suggerimenti in base al proprio account (possibilità di loggarsi nel sito usando spotify).
- nominatim (open street map) -> autocompletamento degli indirizzi.
- ...

## Pages
- /vinyls
- /artists
- /cart -> also if u r not logged have a cart but its stored in $SESSION

[user]
- /orders
- /shipment

[⭐️ admin]
- /dashboard

[informations]
- /privacy -> bla bla bla
- /api -> api docs
- /devs -> this README.md! 

## APIs (/api/...)
### all (no auth needed)
- /api/vinyls [GET] + '?id_vinyl=' -> vinyl with this id.
    -   + '&album=' -> vinyls of this album (title).
    -   + '&track=' -> vinyls that contain this track (title).
    -   + '&artist=' -> vinyls created by artist (name).



### user [need barer token (no admin privileges)]
[Vinyls]


[Orders]
- /api/orders [GET] ->
- /api/shipment [GET] ->


### admin ⭐️ (need barer token with 'su'= 1 (admin privileges))
[Vinyls]
- /api/vinyl [POST] -> create a new vinyl if artist is not present insert also the artist and tracks.
- /api/vinyl [DELETE] -> delete a vinyl.

[User]
- /api/user [POST] -> add / modify user credentials.
- /api/user [GET] + '?mail' -> get user credentials.

[orders]