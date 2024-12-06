# Progetto web - VinylsShop
> 💡 REPO:
> - src
> - mockup
> - relazione

## Warning ⚠️
- mobile first
- browser compability
- accessibility

##### Features possibili
- Suggerimenti in base a:
    - mostra nazione (in base alla posizione)
    - nazione genere artisti preferiti
- Newsletter 

###### API che possiamo usare:
- nominatim (open street map) -> autocompletamento degli indirizzi.
- spotify -> permette di dare suggerimenti in base al proprio account (possibilità di loggarsi nel sito usando spotify).

## db:
![Database Schema](/db/RELAZIONALE.png)

## Installation:
Si può usare [docker](https://www.docker.com/) eseguendo un : ``` docker compose up ```
### con XAMPP:
- injectando il [`db`](/db/init.sql).
- spostando il contenuto di [`src`](/src/) dentro la cartella `htdocs`.

## Pages (aka Views) (🏠)
- no auth:
    - /user 
    - /cart -> also if u r not logged have a cart but its stored in $SESSION
    - /devs -> this README.md!

- user auth:
    - /checkout
    - /order
    - /address (🚩)
    - /payment (🚩)

- admin auth ⭐️:
    - /dashboard -> automatically redirected here from *every page* if logged as admin.

### APIs (🍽️) -> return json
- no auth:
    - /search [GET] + '?id_vinyl=' -> vinyl with this id.
        -  '+ &album=' -> vinyls of this album (title).
        -  '+ &genre=' -> vinyls of this album (genre).
        -  '+ &track=' -> vinyls that contain this track (title).
        -  '+ &artist=' -> vinyls created by artist (name).
    - /cart/manage  [POST]  -> add vinyl to cart into the session.
    - /cart/sync    [GET]   -> sync cart from session to db.

- user auth:
    - /user/address
    - /user/card
    - /order/


- admin auth ⭐️:
    - /vinyl        [POST]  -> manage (add / update / delete) a vinyl. (completed json: (Album, Artist, Track))
    - /artist       [POST] -> manage an artist (🚩).
    - /user         [POST] -> manage a user (🚩).
    - /user         [POST] -> manage all the users (🚩).

#### basic (no auth needed)
- /api/vinyls [GET] + '?id_vinyl=' -> vinyl with this id.
    -  '+ &album=' -> vinyls of this album (title).
    -  '+ &genre=' -> vinyls of this album (genre).
    -  '+ &track=' -> vinyls that contain this track (title).
    -  '+ &artist=' -> vinyls created by artist (name).
    -  '+ &query=' -> the all-in-one ???.

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
