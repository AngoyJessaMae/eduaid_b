Step 1: Set the Project Folder If using Laragon, go to: C:\laragon\www If using XAMPP, go to: C:\xampp\htdocs

Step 2: Clone the Repository Open your terminal inside the folder (www or htdocs) and run: git clone https://github.com/AngoyJessaMae/eduaid_b.git

Step 3: Navigate to the Project Directory cd eduaid_b

Step 4: Install Dependencies composer install

Step 5: Create the Environment File: cp .env.example .env

Step 6: Generate the Application Key: php artisan key:generate

Step 7: Configure the .env File Open the newly created .env file and update the following lines: DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=farmaitrix DB_USERNAME=root DB_PASSWORD=

Step 8: Run the Database Migrations: php artisan migrate
Step 8: Run Seeder: php artisan:db seed

Step 9: Serve the Application: php artisan serve
