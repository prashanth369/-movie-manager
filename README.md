This is the Application main Readme file,

Please follow the following commands/instructions to run the application successfully on your local;

1. Setup
    You need to have following installed on your computer before running;
    1. Composer 
    2. PHP

2. ENV setup
    After the 1st step, you need to add the details into the .env file, if you do not have a .env file, then you shopuld create one with the fields mentioned in .env.example file, please make sure that you enter the details correctly for database and it's credentials

3. Migrations
    Once you have all the above installed, then you need to run the migration scripts to have all the databases created in your system;

    `php artisan migrate:fresh` -> this command will remove all the other databases you have within your system with the same names as the ones used in this project

4. Seed
    Once the tables are created, please followup with the seed command to populate the necessary database talbes with some data, this is important for adding/inserting movies becase it will need to get some data from this seeder data
    `php artisan db:seed` -> this is the seed command