# PDO Workshop

This is the solution to the pdo workshop

## Configuration

1. Create a database with the name of your choice
2. In this database, create a table named 'story', with :
    * id as auto incremented primary key
    * title with max 255 characters
    * author with max 100 characters
    * content as text
3. Optionnal : create a new user and grant them select, insert, update, and delete rights on the database you created
4. Create a 'connec.php' file from the 'connec.php.dist' file, and configure it with your database's information
    * WARNING : if you plan on putting your files on GitHub or any other place on the internet, don't forget to create a '.gitignore' file and add your 'connec.php' file to it

## Use

1. Open your terminal and go to the place you stored this project ('cd /path/to/project')
2. Launch your php server with 'php -S localhost:8000'
    * Note : if the 8000 port is already in use, you can use another one, like 8001
