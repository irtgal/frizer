POSILJANJE MAILOV
.env:

SEND_MAILS=true
MAIL_DRIVER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_FROM_NAME=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=ssl
QUEUE_CONNECTION=database

php artisan queue:table

php artisan migrate

php artisan queue:work
