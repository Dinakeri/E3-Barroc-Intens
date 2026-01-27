# BARROC-INTENS
 
## Getting Started
 
### Prerequisites
 
Before you begin, make sure you have the following installed:
 
- PHP
- sqllite
- Composer
- npm
 
### Installation
 
Follow these steps to set up the project locally:
 
1. Fork the repository (or receive a repository through GitHub Education).
2. Clone your forked repository to a location that is easy to find  
4. Navigate to the project directory.
5. Copy the `.env.example` file and rename it to `.env`.
6. Open the project in your code editor and edit the `.env` file.
7. Update the following database values:
   - `DB_DATABASE` → name of the database you created
   - `DB_USERNAME` → `root` (default for local setups)
   - `DB_PASSWORD` → empty (default for local setups)
 
8. Open a terminal in the project directory and run the following commands **in order**:
 
```bash
composer install
php artisan key:generate
php artisan migrate:seed
npm install
npm run dev
```

## Troubleshooting
 
If a command fails:
1. Carefully read the error message
2. Scroll up and focus on the main error (ignore long stack traces)
3. Double-check the following in your .env file:
```bash
DB_DATABASE
 
DB_USERNAME
 
DB_PASSWORD
```
Make sure:
1. The database exists in sqllite
4. The database name is correct
