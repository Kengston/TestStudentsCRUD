1. Install the PHP dependencies using Composer.
   composer install
2. Install the Javascript dependencies using npm.
   npm install
3. Compile the asset files using npm.
   npm run build
4. Create the SQLite database for your Symfony application.
   php bin/console doctrine:database:create
5. Update the database schema to match your Symfony application's
   php bin/console doctrine:schema:update --force
6. Run the Symfony development server
   symfony serve --no-tls
7. Open a web browser and navigate to the following URL
   http://127.0.0.1:8000/students
