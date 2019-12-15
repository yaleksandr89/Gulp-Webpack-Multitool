<?php
namespace app\php;

require_once '../../vendor/autoload.php';

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

define('ROOT', dirname(__DIR__));

class FreakMailer extends PHPMailer
{
    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);
        $this->emailTemplatesDir = ROOT . '/template/email';
    }

    public function sendEmail()
    {
        $mailer = $this->createPhpMailer();

        $mailer->From = 'a.yurchenko23@yandex.ru';
        $mailer->FromName = 'Адаптивные письма';
        $mailer->isHTML(true);

        if (count($_POST) > 0) {
            if (!empty($_POST['subject_recipient'])) {
                $mailer->Subject = $_POST['subject_recipient'];
            } else {
                throw new RuntimeException('Не указана тема письма.');
            }

            if (!empty($_POST['template_mail'])) {
                $mailer->Body = $this->loadHtmlTemplate($_POST['template_mail']);
                $mailer->AltBody = file_get_contents(ROOT . '/template/email/text.txt');
            } else {
                throw new RuntimeException('Не получен шаблон письма.');
            }

            if (!empty($_POST['email_recipient'])) {
                $mailer->addAddress($_POST['email_recipient']);
            } else {
                throw new RuntimeException('Не указана почта для отправки.');
            }
            //$mailer->SMTPDebug = 1;
        }
        try {
            if ($mailer->send()) {
                $response = 1;
            } else {
                throw new Exception($mailer->ErrorInfo);
            }
            return $response;
        } catch (Exception $exception) {
            file_put_contents('error.txt', '[' . date('Y-m-d H:i:s') . ']:' . PHP_EOL . "Ошибка! {$exception->getMessage()}" . PHP_EOL . '======================');
        } finally {
            $mailer->clearAddresses();
            $mailer->clearAttachments();
        }
    }

    private function createPhpMailer()
    {
        $mailer = new PHPMailer();

        require ROOT . '/config.php';

        $data = $this->prepareData($smtp);
        $mailer->isSMTP();
        $mailer->Host = $data['host'];
        $mailer->SMTPAuth = true;
        $mailer->Username = $data['username'];
        $mailer->Password = $data['password'];
        $mailer->SMTPSecure = $data['encryption'];
        $mailer->Port = $data['port'];
        $mailer->CharSet = 'UTF-8';

        return $mailer;
    }

    private function prepareData($data)
    {
        $preparedData = [];
        foreach ($data as $key => $value) {
            $preparedData[trim(htmlspecialchars($key))] = trim(htmlspecialchars($value));
        }
        return $preparedData;
    }

    private function loadHtmlTemplate($template)
    {
        $emailTemplate = file_get_contents("{$this->emailTemplatesDir}/{$template}.html");
        if ($emailTemplate === false) {
            throw new RuntimeException("Выбранный для отправки письма шаблон: '{$template}', не существует или поврежден!");
        }
        return $emailTemplate;
    }
}

$handler = new FreakMailer();
if ($handler->sendEmail()) {
    echo 'ok';
} else {
    echo 'error';
}