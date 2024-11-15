# Progetto web
> 💡 REPO:
> - src
> - mockup
> - relazione

## Warning ⚠️
- mobile first
- browser compability
- accessibility

##### possibles Features
- Posizione mostra nazione
- Preordinare
- Newsletter 
- Suggerimenti in base a:
    - nazione genere artisti preferiti

##### API che possiamo usare:
- gravatar -> prendere il profilo (immagine pfp) di un account gravatar (il "portafoglio digitale" per l'email), se l'utente lo ha altrimenti si mostra un icona di default.
- spotify -> permette di dare suggerimenti in base al proprio account (possibilità di loggarsi nel sito usando spotify).
- nominatim (open street map) -> autocompletamento degli indirizzi.
- ...

# PER SAM:
allora sam stavo pensando, che te puoi partire con il fare pagine dove non serve l'autenticazione, almeno finchè non è pronta.
magari inizia con fare delle richieste api [GET] che restituiscono json delle query.
Tipo /api/artist [GET] -> restituisce un json di artisti, poi la evolvi man mano aggiungendo parametri, filtrandola ecc...

Se hai delle idee inseriscile qui nel README cosi sappiamo cosa dobbiamo fare man mano che ci lavoriamo.

## Installation:
Si può usare docker eseguendo un : ``` docker compose up ```
Oppure copiare il progetto su XAMPP:
- injectando il [`db`](/db/init.sql).
- spostando il contenuto di [`src`](/src/) dentro la cartella `htdocs`.

## Pages
- /vinyls
- /artists
- /cart -> also if u r not logged have a cart but its stored in $SESSION

- /privacy -> bla bla bla
- /api -> api docs
- /devs -> this README.md! 

##### [user]
- /orders
- /shipment

##### [⭐️ admin]
- /dashboard



### APIs (/api/...) -> return json
#### basic (no auth needed)
- /api/vinyls [GET] + '?id_vinyl=' -> vinyl with this id.
    -  '+ &album=' -> vinyls of this album (title).
    -  '+ &track=' -> vinyls that contain this track (title).
    -  '+ &artist=' -> vinyls created by artist (name).

- /api/artists [GET] + '?id_artist=' -> return the artists or the artist with `id_artist`.
- /api/tracks [GET] + '?id_track=' -> track with this id.
    -  '+ &title=' -> tracks with this like title.

- /api/cart [GET]  -> 
- /api/cart [POST] -> 

#### user [need barer token (no admin privileges)]
- /api/user [GET] -> user data.
##### [Orders]
- /api/orders [GET] ->
- /api/shipment [GET] ->


#### admin ⭐️ (need barer token with 'su'= 1 (admin privileges))
##### [Vinyls]
- /api/vinyl [POST] -> create a new vinyl if artist is not present insert also the artist and tracks.
    example json (complete: artists and tracks)
    ```
    {
        "title":"From Zero Vinile",
        "album": {
            "title":"From Zero",
            "genere":"Alternative",
            "img":"/resources/img/fromzero.webp",
            "data_pubblicazione":"24 Settembre 2024",
            "artist": {"nome":"LINKIN PARK"}
        },
        "tracks":[
            {
                "title":"The Emptiness Machine",
                "durata":"3:10"
            },
            {
                "title":"Heavy Is The Crown",
                "durata":"2:47"
            },
            {
                "title":"Over Each Other",
                "durata":"2:50"
            }
        ]
    }
    ```json
- /api/vinyl [DELETE] + '?id_vinyl=' -> delete a vinyl.

##### [User]
- /api/user [POST] -> add / modify user credentials.
- /api/user [GET] + '?mail' -> get user credentials.

##### [orders]
