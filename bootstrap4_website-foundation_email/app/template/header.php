<header>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <span class="navbar-brand">Адаптивные шаблоны:</span>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarNavAltMarkup"
                            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <?php foreach ($emailTmp as $file) : ?>
                                <a class="nav-item nav-link" href="#" data-toggle="modal"
                                   data-target="#<?= pathinfo($file, PATHINFO_FILENAME) ?>">
                                    <?= pathinfo($file, PATHINFO_FILENAME) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>