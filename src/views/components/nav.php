<nav aria-label="Main navigation">
    <ul>
        <li>
            <a href="/">
                <div class="vinyl"></div>
                <p>Shop</p>
            </a>
        </li>
        <li class="search-container">
            <a href="" class="search">
                <img class="svg" src="/resources/svg/ui/magnifyingglass.svg" alt="">
                <p>Search</p>
            </a>
            <!-- Elemento di input per la barra di ricerca -->
            <div class="search-bar">
                <label for="search-input" class="sr-only">Search</label>
                <input id="search-input" type="text" placeholder="Search...">

                <div class="select-wrapper">
                    <label for="search-select" class="sr-only">Search in</label>
                    <span class="label" aria-hidden="true">in</span>
                    <select id="search-select" aria-label="Search in">
                        <option value="album">album</option>
                        <option value="artist">artist</option>
                        <option value="genre">genre</option>
                        <option value="track">track</option>
                    </select>
                </div>

                <button class="close-search" aria-label="Close search">
                    <img class="svg" src="/resources/svg/ui/xmark.svg" alt="">
                </button>
            </div>
        </li>
        <li>
            <a href="/cart">
                <img class="svg" src="/resources/svg/ecommerce/bag.fill.svg" alt="">
                <p>Cart</p>
            </a>
        </li>
        <li>
            <a href="/user">
                <img class="svg" src="/resources/svg/ui/person.fill.svg" alt="">
                <p>User</p>
            </a>
        </li>
    </ul>
</nav>