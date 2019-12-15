<?php $emailTmp = glob(__DIR__ . '/template/email' . '/*.html'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="image/logotype.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <title>Layout of the letters</title>
</head>
<body class="wrapper">
//= template/header.php
<main>
    <div class="container main">
        <div class="ror justify-content-center">
            <div class="col-md-12">
                <form class="email-layout" method="POST" action="php/FreakMailer.php">
                    <div class="form-group">
                        <label for="email_recipient">На какую почту</label>
                        <input type="email" class="form-control" id="email_recipient" name="email_recipient"
                               aria-describedby="email_recipient"
                               value="<?php $_COOKIE['email_recipient'] = $_POST['email_recipient'] ?? null ?>">
                        <small id="email_recipient" class="form-text text-muted text-center"></small>
                    </div>
                    <div class="form-group">
                        <label for="subject_recipient">Тема отправляемого письма</label>
                        <input type="text" class="form-control" id="subject_recipient" name="subject_recipient"
                               aria-describedby="subject_recipient"
                               value="<?php $_COOKIE['subject_recipient'] = $_POST['subject_recipient'] ?? null ?>">
                        <small id="subject_recipient" class="form-text text-muted text-center"></small>
                    </div>
                    <div class="form-group mt-4">
                        <label for="template_mail">Какой шаблон для отправки использовать</label>
                        <select multiple class="form-control tmp_mail" id="template_mail" name="template_mail"
                                aria-describedby="sender_name">
                            <?php foreach ($emailTmp as $file) : ?>
                                <option value="<?= pathinfo($file, PATHINFO_FILENAME) ?>">
                                    <?= pathinfo($file, PATHINFO_FILENAME) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small id="template_mail" class="form-text text-muted text-center"></small>
                    </div>
                    <button id="submit" type="submit" name="submit"
                            class="btn btn-lg btn-outline-dark mb-2 w-100">
                        Отправить
                    </button>
                    <small id="submit_info" class="form-text text-muted text-center"></small>
                </form>
            </div>
        </div>
    </div>
</main>
//= template/footer.php
<script type='text/javascript' src='js/script.js'></script>
</body>
</html>