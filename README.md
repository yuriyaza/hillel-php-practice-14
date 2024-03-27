### Мінімізатор URL (URL Shortener) на базі MongoDB

Сервіс для мінімізіції URL

**Роут для мінімізації URL:**<br>
/minimize?url=*ваш_повний_url*<br>

Наприклад:<br>
/minimize?url=https://www.google.com/search?q=What+is+URL+shortener

Буде сформовано мінімізований URL. Наприклад:<br>
/8ac9hw

**Роут для повернення повного URL за мінімізованим:**<br>
/*ваш_мінімізований_url*

Наприклад:<br>
/8ac9hw

Буде повернуто повний URL та виконано автоматичний перехід на нього.
