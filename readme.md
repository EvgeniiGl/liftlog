_ide_helper.phpINIT JS PROJECT (copy path and files into /public):
1. into './resources/js/react_elements' - $ npm run build

2. into './' - $ npm run prod

3. .env remove field session_domain (CSRF token not working on live server)


ВАЖНО: Carbon выдает ошибку форматирования (created_at, updated_at) при работе с базой данных MSSQL 2013 года, fix - добавить формат даты в модели "protected $dateFormat" без милисекунд.
