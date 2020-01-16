// Вывод текущей даты и времени в подвале сайта
let date = new Date();
// Дата
let year = date.getFullYear();
let month = date.getMonth();
let day = date.getDate();
// Преобразование месяца числом в письменный формат
let strMonth = '';
switch (month) {
    case 0:
        strMonth = 'Января';
        break;
    case 1:
        strMonth = 'февраля';
        break;
    case 2:
        strMonth = 'марта';
        break;
    case 3:
        strMonth = 'апреля';
        break;
    case 4:
        strMonth = 'мая';
        break;
    case 5:
        strMonth = 'июня';
        break;
    case 6:
        strMonth = 'июля';
        break;
    case 7:
        strMonth = 'августа';
        break;
    case 8:
        strMonth = 'сентября';
        break;
    case 9:
        strMonth = 'октября';
        break;
    case 10:
        strMonth = 'ноября';
        break;
    case 11:
        strMonth = 'декабря';
        break;
    default:
        console.log('Указан некорректный месяц!');
}
// Время
let hour = date.getHours();
let minutes = date.getMinutes();

let currentDate = ('Сегодня ' + day + ' ' + strMonth + ' ' + year + ' года' + ' | ' + 'Текущее время: ' + hour + ':' + minutes );
let element = document.getElementById('currentDate');
if (typeof element.textContent !== 'undefined') {
    // IE8-
    element.textContent = currentDate;
} else {
    // Нормальные браузеры
    element.textContent = currentDate;
}