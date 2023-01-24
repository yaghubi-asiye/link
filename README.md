# link_task
Link Task 2


# Setup Database
### Create Config Folder
- create <code>.env</code> file in <code>root</code> project
- put these code in the <code>.env</code> file (for mysql database):
```laravel
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=DB_NAME
    DB_USERNAME=DB_USER
    DB_PASSWORD=DB_USER_PASS
```

# Run
```bash
# install packages
composer install

# migration and seeder
 php artisan migrate 

# create user
create a fake user in phpmyadmin

# run server
php artisan serve

# postman import
import file Irapardaz.postman_collection.json in your postman

```
## License
[MIT](https://choosealicense.com/licenses/mit/)

