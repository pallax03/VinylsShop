# Progetto web
> 💡 REPO:
> - src
> - mockup
> - relazione (1 pagina: chiedere se farla direttamente sul README )

## Warning ⚠️
- mobile first
- browser compability
- accessibility

## Roadmap
1. Progettazione: 
    - [x] Idea
    - [ ] Sketch
    - [ ] SiteMap Tree
    - [ ] Database Idea
    - [ ] Mockup (max 4 punti) - 📝
    - [ ] Database
2. Deployment:
    - [ ] configs
        - [ ] envs (api keys + database vars)
        - [ ] database utility connection
        - [ ] session
    - [ ] MVC
        - [ ] Router (Routing)
        - [ ] Render (View)
        - [ ] Controller
        - [ ] Model (?)
    - [ ] Login
    - [ ] Cookie + Session
    - [ ] 
    - [ ] 
    - [ ] Notifiche
    - [ ]
3. WOOOW 
    - [ ] colori accessibili
    - [ ] scss animation
    - [ ] banner privacy (for cookie)
    - [ ] secure password
    - [ ] API spotify (+ others: soundcloud, apple music)
    - [ ] vinyl view customization (edizioni speciali - tenere conto nel database??)

- [ ] Relazione
---
## Features
- Spotify immagini scaricare nuovi vinili
- Posizione mostra nazione
- Preordinare
- Newsletter 
- Suggerimenti in base a nazione genere artisti preferiti
- Customize -> Varianti

## db
- utente + newsletter (?)
- ordini
- carrello
- vinili + edizioni speciali
- artisti
- generi
- giri
- album
- brani

## Configuration:
Il progetto è nato come sia docker sia xampp, è possibile usare entrambi gli ambienti.
> se si vuole usare XAMPP usare la cartella `src` al posto della `htdocs`.
Se si sta usando xampp la connessione al database solitamente esplicitata nel file .env non sarà usata.
Vengono infatti usate le variabili dichiarate nella classe [DatabaseUtility](/src/utility/DatabaseUtility.php)

### env:
Possiamo passare i file env direttamente alla prof via mail! (magari lo chiediamo al ricevimento)

### db:
È possibile utilizzare un file `.env` per dichiarare le variabili di configurazione. 
> 💡 Altrimenti: modificare nel [costruttore](./src/DatabaseUtility.php) le variabili di accesso al server mysql.

## Pages

## APIs
