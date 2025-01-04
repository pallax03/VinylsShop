# Progetto web - VinylsShop
#### ( 5h per day: | 5d per week )
##### expected deadline: 5 Jan 2025 (hours: 100)
##### realistic deadline: 14 Jan 2025 (hours: 120)

> 💡 REPO:
> - src
> - mockup
> - relazione

## COSA DOBBIAMO FARE: ⚠️
1. dashboard 
2. checkout (lo sta facendo: alex)
3. SISTEMARE ASSOLUTAMENTE IL TRACKING DEGLI ORDINI. (pensare ad una roba realistica)
4. NEWSLETTER: notifiche!!!!!!!!!!
    le implementiamo come delle variabili interne (non sessione):
    come mappe [orario => HH:mm , azione => stringa o array boh]
    fare nel main.js un fetch ogni 1 minuto al backend '/newsletter'
    se l'orario Now(), corrisponde ad un orario della mappa stampa attraverso il fetch la notifica.
    LA MAPPA AGGIUNGERA LE NOTIFICHE QUANDO:
    - viene modificata la quantità di un vinile (se qualcuno la ha nel carrello (o magari solo se l'utente la ha nel carrello (PER QUESTO SI PUÒ USARE UN ARRAY COME 'AZIONE'))) (termine di un acquisto o modifica da parte di un admin).
    - VIENE AGGIUNTO UN NUOVO VINILE (PER TUTTI)
    - 🚩 VIENE MODIFICATO L'UTENTE
    - UN ORDINE ARRIVA?????
5. SISTEMARE LINK DEL FOOTER.


### Se proprio abbiamo altro tempo da perdere
1. aiuto inserimento degli indirizzi con nominatim API.
2. Suggerimenti in base a:
    - API browser -> mostra nazione (in base alla posizione),  nazione genere artisti preferiti



### Database Schema:
![Database Schema](/db/RELAZIONALE.png)

## Installation:
Si può usare [docker](https://www.docker.com/) eseguendo un: ``` docker compose up ```
### con XAMPP:
- injectando il [`db`](/db/init.sql).
- spostando il contenuto di [`src`](/src/) dentro la cartella `htdocs`.

## [Routing](/src/utility/Routing.php)
### Pages (aka Views) (🏠)
- no auth 🌎:
    - /     -> home
    - /user -> login / signup page
    - /cart -> also if u r not logged have a cart but its stored in $SESSION
    - /devs -> this README.md!

- user auth 🔐:
    - /user -> user's infos, and orders.
    - /user/addresses -> user's addresses management.
    - /user/cards -> user's cards management. 
    - /checkout -> checkout page with defaults info and cart items.
    - /order + '?id_order=' -> if nothing as id show the last one.


- admin auth ⭐️:
    - /dashboard -> automatically redirected here from *every page* if logged as admin.

### APIs (🍽️) -> return json
- no auth 🌎:
    - Home 🏠:
        - /login [POST] -> mail and password, can be passed from json or form.
        - /logout [GET] -> remove cookies and refresh session (redirect to /).
        - /cache [GET]-> destroy all the session. (without logout).
        - /search [GET] + '?id_vinyl=' -> vinyl with this id.
            -  '&album=' -> vinyls of this album (title).
            -  '&genre=' -> vinyls of this album (genre).
            -  '&track=' -> vinyls that contain this track (title).
            -  '&artist=' -> vinyls created by artist (name).
    - Cart 🛒:
        - /cart/get [GET] -> get ([cart](#Cart)) of the logged user.
        - /cart/manage  [POST]  -> add / delete / modify ([vinyl](#Vinyl-Cart)) to cart into the session.

- user auth 🔐:
    - User 👤:
        - /user/get [GET] '?id_user=' -> get all user info, an admin can get any of them, if not specified, the logged.
        - /user/defaults [POST]   -> set user default address and payment:
            - if '?id_card=' || '&id_address=' -> set as default.
        - /user/address [GET] + '?id_address='  -> get all or a specific user's address.
        - /user/address [DELETE] '?id_address=' -> delete a specific address.
        - /user/address [POST]  -> add an address and set it as default.
        - /user/card    [GET]    '?id_card=' -> get all or a specific user's card.
        - /user/card    [POST]  -> add a card and set it as default.
        - /user/card    [DELETE] '?id_card=' -> delete a specific card.
    - Cart 🛒:
        - /cart/sync    [GET]   -> sync cart from session to db.
        - /checkout     [POST]  -> try to do the checkout, if successfull:
            - make the order.
            - make the shipping.
            - pop cart vinyls to Checkouts table.
            - redirect to /user.
    - Order 📦:
        - /orders       [GET] '?id_user='   -> list of all the orders, of the specified user, if not the logged. (an admin can get of any).

- admin auth ⭐️:
    - Dashboard 📊:
        - /vinyl        [POST]  -> manage (add / update / delete) a vinyl (and other). (completed json: (Album, Artist, Track))
        - /users        [GET] -> list users (🚩).
        - /user         [POST] -> manage user (🚩).
    

### Jsons
##### User 
```json
{
   "id_user":int,
   "mail":string,
   "balance":float,
   "newsletter":bool,
   "default_card":int,
   "card_number":string,
   "default_address":int,
   "name":string,
   "street_number":string,
   "city":string,
   "postal_code":string
}
```

##### User Addresses (/user/address)
```json
[
   {
      "id_address":int,
      "name":string,
      "street_number":string,
      "city":string,
      "postal_code":string
   }
   ...
]
```

##### User Cards (/user/card)
```json
[
   {
      "id_card":int,
      "card_number":string
   },
   ...
]
```


##### Vinyl 
```json
[
   {
        "id_vinyl":int,
        "quantity":int,
        "cost":float,
        "rpm":int,
        "inch":int,
        "type":string,
        "title":string,
        "genre":string,
        "cover":string,
        "artist_name":string
   },
   ...
]
```

##### Completed Vinyl 


##### Cart 
```json
{
   "cart":[
      {
         "vinyl":{
            "id_vinyl":int,
            "quantity":int,
            "cost":float,
            "rpm":int,
            "inch":int,
            "type":string,
            "title":string,
            "genre":string,
            "cover":string,
            "artist_name":string
         },
         "quantity":int
      },
      ...
   ],
   "total":float
}
```

##### Vinyl Cart
```json
{
    "id_vinyl":int,
    "quantity":int
}
```