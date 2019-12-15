<footer>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <p id="currentDate" class="currentDate"></p>
            </div>
        </div>
    </div>
</footer>
<?php foreach ($emailTmp as $file) : ?>
    <div class="modal fade" id="<?= pathinfo($file, PATHINFO_FILENAME) ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"><?= pathinfo($file, PATHINFO_FILENAME) ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="image/email/<?= pathinfo($file, PATHINFO_FILENAME) ?>.jpg" alt="<?= pathinfo($file, PATHINFO_FILENAME) ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark w-100"
                            onclick="window.open('template/email/<?= pathinfo($file, PATHINFO_BASENAME) ?>', '_blank')">
                        Открыть <?= pathinfo($file, PATHINFO_FILENAME) ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>