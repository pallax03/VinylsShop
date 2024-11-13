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
Il progetto è nato come sia docker sia xampp, è possibile usare entrambi gli ambienti.
> se si vuole usare XAMPP usare la cartella `src` al posto della `htdocs`.
Se si sta usando xampp la connessione al database solitamente esplicitata nel file .env non sarà usata.
Vengono infatti usate le variabili dichiarate nella classe [DatabaseUtility](/src/utility/DatabaseUtility.php)

### env:
mandare una mail a prof di laboratorio per chiedere: (lista di API che si vogliono utilizzare e per cosa)
- gravatar -> prendere il profilo (immagine pfp) di un account gravatar (il "portafoglio digitale" per l'email), se l'utente lo ha altrimenti si mostra un icona di default.
- spotify -> permette di dare suggerimenti in base al proprio account (possibilità di loggarsi nel sito usando spotify).
- nominatim (open street map) -> autocompletamento degli indirizzi.
- 

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
### user
[Vinyls]
- /api/vinyls [GET] + '?id_vinyl=' -> vinyl with this id.
    -   + '&album=' -> vinyls of this album (title).
    -   + '&track=' -> vinyls that contain this track (title).
    -   + '&artist=' -> vinyls created by artist (name).

[Orders]
- /api/orders [GET] ->
- /api/shipment [GET] ->


### admin ⭐️ (need header auth: token (user auth))
[Vinyls]
- /api/vinyl [POST] -> create a new vinyl if artist is not present insert also the artist and tracks.

[User]
- /api/user [POST] -> add / modify user credentials.
- /api/user [GET] + '?mail' -> get user credentials.

[orders]