# Progetto web - VinylsShop
> 💡 REPO:
> - src
> - mockup
> - relazione

## Warning ⚠️
- mobile first
- browser compability
- accessibility

### Features possibili
- Suggerimenti in base a:
    - mostra nazione (in base alla posizione)
    - nazione genere artisti preferiti
- Newsletter 

### API che possiamo usare:
- nominatim (open street map) -> autocompletamento degli indirizzi.
- spotify -> permette di dare suggerimenti in base al proprio account (possibilità di loggarsi nel sito usando spotify).

### Database Schema:
![Database Schema](/db/RELAZIONALE.png)

## Installation:
Si può usare [docker](https://www.docker.com/) eseguendo un : ``` docker compose up ```
### con XAMPP:
- injectando il [`db`](/db/init.sql).
- spostando il contenuto di [`src`](/src/) dentro la cartella `htdocs`.

## Pages (aka Views) (🏠)
- no auth 🌎:
    - /user -> login / signup page
    - /cart -> also if u r not logged have a cart but its stored in $SESSION
    - /devs -> this README.md!

- user auth 🔐:
    - /user -> user infos (+ default card - address) + orders - shipping list
    - /checkout -> checkout page with defaults info and cart items.
    - /order + '?id_order=' -> if nothing as id show the last one made, check if the order id is made by the right user.

- admin auth ⭐️:
    - /dashboard -> automatically redirected here from *every page* if logged as admin.

## APIs (🍽️) -> return json
- no auth 🌎:
    Home 🏠:
    - /login [POST] -> mail and password, can be passed from json or form.
    - /logout [GET] -> remove cookies and refresh session (redirect to /).
    - /search [GET] + '?id_vinyl=' -> vinyl with this id.
        -  '&album=' -> vinyls of this album (title).
        -  '&genre=' -> vinyls of this album (genre).
        -  '&track=' -> vinyls that contain this track (title).
        -  '&artist=' -> vinyls created by artist (name).
    Cart 🛒:
    - /cart/manage  [POST]  -> add / delete / modify ([vinyl](#vinyl-cart-json)) to cart into the session.



- user auth 🔐:
    User 👤:
    - /user/default [GET]   -> get user default address and payment:
        - if '?id_card=' || '&id_address=' -> set as default.
    - /user/address [GET] + '?id_address='  -> get all or a specific user's address.
    - /user/address [DELETE] '?id_address=' -> delete a specific address.
    - /user/address [POST]  -> add an address and set it as default.
    - /user/card    [GET]    '?id_card=' -> get all or a specific user's card.
    - /user/card    [POST]  -> add a card and set it as default.
    - /user/card    [DELETE] '?id_card=' -> delete a specific card.
    Cart 🛒:
    - /cart/sync    [GET]   -> sync cart from session to db.
    - /checkout     [POST]  -> try to do the checkout, if successfull:
        - make the order.
        - make the shipping.
        - pop cart vinyls to Checkouts table.
    Order 📦:
    - /orders       [GET]   -> list of all the orders (🚩)



- admin auth ⭐️:
    Dashboard 📊:
    - /vinyl        [POST]  -> manage (add / update / delete) a vinyl. (completed json: (Album, Artist, Track))
    - /artist       [POST] -> manage an artist (🚩).
    - /users        [GET] -> list users (🚩).
    - /user         [POST] -> manage user (🚩).
    
    

### Jsons

##### Vinyl Cart Json
```json
{

}
```