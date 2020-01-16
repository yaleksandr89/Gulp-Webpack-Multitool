import $ from 'jquery';
import 'popper.js';
import 'bootstrap/dist/js/bootstrap.min'

$(function () {

    // Вызов модалок
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    });

    // Ajax запрос на отправку письма
    $('.email-layout').on('submit', function (event) {
        event.preventDefault();
        let errors = false;
        $(this).find('small').empty();
        $(this).find('input, select').each(function () {
            if ($.trim($(this).val()) === '') {
                errors = true;
                if ($.trim($(this).attr('id')) === 'template_mail') {
                    $(this).next().html('No template is selected!');
                } else {
                    $(this).next().html('Field is not filled!');
                }
            }
        });
        /* global setTimeout alert */
        if (!errors) {
            let data = $('.email-layout').serialize();
            $.ajax({
                url: 'php/FreakMailer.php',
                type: 'POST',
                data: data,
                beforeSend: function () {
                    $('#submit').text('Отправляю...').toggleClass('btn-outline-dark btn-warning').prop('disabled', true);
                },
                success: function (result) {
                    if (result === 'ok') {
                        $('#submit').text('Отправлено').toggleClass('btn-warning btn-success').prop('disabled', true);
                        setTimeout(function () {
                            $('.email-layout').find('input').val('');
                            $('#submit').text('Отправить').toggleClass('btn-success btn-outline-dark').prop('disabled', false);
                        }, 1000);
                        console.log('Письмо отправлено');
                    } else {
                        $('#submit').next().empty();
                        console.log('Ошибка отправки');
                    }
                },
                error: function () {
                    alert('Ошибка при выполнении Ajax запроса!');
                }
            });
        }
        return false;
    });

});