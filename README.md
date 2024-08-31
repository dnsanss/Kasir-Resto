<p>Kasir resto.</p>
This is my first project that I published on GitHub, which was also my 4th semester project when I was studying at Yudharta University Pasuruan. In this project I used the Laravel framework and added Laravel Filament to the framework. If you want to download the following source code, you can download it for free.

After you download, you have to create a database name first. in the source code I used **MySql** to create a database with the name "kasir".
after that you can run 

`php artisan migrate`

<br>in the terminal to migrate the database that has been created.</br>

note:
I differentiate between user and admin when logging in. You can see the code section of the app/Http/Middleware/VerifyIsAdmin folder marked with the number 1 in the is_admin column in the users table. If the admin is logged in then the admin can access the admin and cashier pages. If the user is logged in then the user cannot access the admin page.

Before running the server, you create a user first by typing.

`php artisan make:filament-user`

After that you can run the project with commands in the terminal

`php artisan serve`

You can access the following localhost server

http://127.0.0.1:8000/kasir/login
