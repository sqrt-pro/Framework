# Сброс БД
bin/console db:clear

# Миграция до текущего состояния
bin/phinx migrate

# Заполнение данными по-умолчанию
bin/console db:fixture Users