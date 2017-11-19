<nav class="navbar is-transparent">
    <div class="navbar-brand">
        <a class="navbar-item" href="#">
            <b class="is-uppercase">Métodos computacionais</b>
        </a>
        <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="navbarExampleTransparentExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="https://bulma.io/">

            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="/documentation/overview/start/">
                    1ª parte
                </a>
                <div class="navbar-dropdown is-boxed">
                    <a class="navbar-item" href="11.php">
                        Regra do Trapézio Repetida
                    </a>
                    <a class="navbar-item" href="/<?= $_SERVER['SERVER_NAME'] ?>/method/1/2/">
                        1/3 de Simpson Repetida
                    </a>
                    <a class="navbar-item" href="/<?= $_SERVER['SERVER_NAME'] ?>/method/1/3/">
                        3/8 de Simpson Repetida
                    </a>
                    <a class="navbar-item" href="/<?= $_SERVER['SERVER_NAME'] ?>/method/1//">
                        Newton-Cotes para n = 4
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="https://bulma.io/documentation/elements/box/">
                        Elements
                    </a>
                    <a class="navbar-item is-active" href="https://bulma.io/documentation/components/breadcrumb/">
                        Components
                    </a>
                </div>
            </div>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="field is-grouped">
                    <p class="control">
                        <a class="bd-tw-button button" href="#">
                            <span class="icon">
                                <i class="fa fa-github"></i>
                            </span>
                            <span>Github</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</nav>