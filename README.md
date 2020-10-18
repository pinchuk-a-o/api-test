Запрос на удаление

`DELETE ab FROM author_book ab
LEFT JOIN book b ON b.id = ab.book_id
WHERE b.id IS NULL
;`

на уровне базы данных за целостностью можно следить с помощью внешних ключей поможет добавление

`alter table author_book
    add constraint author_book_book_id_fk
        foreign key (book_id) references book (id)
            on delete cascade;`
            
#разворачивание проекта
в файле `.env` указать переменные окружения UID, GID. 
Их можно узнать выполнив команду `id`. Далее

`docker-compose up -d`

`docker-compose exec php php yii migrate/up`   

# задание 2

Хоть и напрашивается какое-то объединение action`ов контроллеров book и author.
Я не стал этого делать из соображений того, что в действительности так не бывает.
Подобную ситуацию уже встречал и создание отдельных классов экшенов привело
к тому, что в них просто появились проверки вида
- `if ($class instanceof Class1)`         
- `if ($class instanceof Class2)`      
- `...`   
- `if ($class instanceof ClassN)`         