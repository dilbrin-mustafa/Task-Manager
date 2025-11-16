# Laravel Task Manager

This is a responsive, single-page task management application built with Laravel and Tailwind CSS. It uses a refactored, robust backend with Form Request validation, service-like model methods, and full project management capabilities.

## Features

* **Task Management:** Create, Edit, and Delete tasks.
* **Project Management:**
    * Create new projects via a modal.
    * Filter the task list by project.
* **Drag-and-Drop Reordering:** Tasks can be reordered, and their priority is automatically saved to the database.
* **Responsive Design:** Clean, modern, and mobile-friendly interface built with Tailwind CSS.
* **Robust Backend:**
    * Uses Form Request classes for all validation.
    * Clean controllers with logic abstracted to Eloquent models.
    * Handles all operations via AJAX/Fetch (for reordering) or standard form posts.

## 🛠️ Setup & Installation

Follow these steps to get the application running on your local machine.

### 1. Prerequisites

* [PHP](https://www.php.net/) (>= 8.1)
* [Composer](https://getcomposer.org/)
* A MySQL database

(Note: Node.js is **not** required for this setup, as the project uses the Tailwind CSS CDN and vanilla JavaScript.)

### 2. Create Laravel Project

After creating the project, you will replace the default files with the ones provided (Controllers, Models, Routes, Views, etc.).

### 3. Configure Environment

1.  Copy the example environment file:
    ```bash
    cp .env.example .env
    ```

2.  Open your `.env` file and update your database credentials. You must create a database in MySQL (e.g., `task_manager`) first.

    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=task_manager
    DB_USERNAME=root
    DB_PASSWORD=your_database_password
    ```

3.  Generate your application key:
    ```bash
    php artisan key:generate
    ```

### 4. Database Migrations & Seeding

1.  **Run the migrations:** This will create the `projects` and `tasks` tables.
    ```bash
    php artisan migrate
    ```

2.  **Seed the database:** This will run the `ProjectSeeder` to create your initial "Work" and "Personal" projects.
    ```bash
    php artisan db:seed
    ```

### 5. Run the Application

You are now ready to run the application!

```bash
php artisan serve
```
Open http://127.0.0.1:8000/tasks in your web browser to access the task manager.

## 🚀 Deployment

Here are the general steps to deploy your application to a live server.

### Option 1: Managed Hosting (PaaS)

Using a service like **Laravel Vapor**, **Heroku**, or **DigitalOcean App Platform** is the simplest method.

1.  **Push to Git:** Ensure your project is a Git repository and pushed to GitHub, GitLab, or Bitbucket.
2.  **Connect Service:** Connect your Git repository to the hosting service.
3.  **Set Environment Variables:** In the service's dashboard, set your production environment variables.
    * `APP_ENV=production`
    * `APP_DEBUG=false`
    * `APP_KEY` (copy your local one or generate a new one)
    * `DB_HOST`, `DB_DATABASE`, etc. (for your production database)
4.  **Run Migrations:** Most services have a "run" or "post-deploy" command hook. Set this to run `php artisan migrate --force`.
5.  **Deploy:** Click the "Deploy" button. The service will handle the rest.

### Option 2: VPS (e.g., DigitalOcean Droplet)

This gives you full control but requires manual server setup. Using **Laravel Forge** can automate this entire process for you.

If setting up manually:

1.  **Provision Server:** Create a new Ubuntu server with Nginx, MySQL, and the correct PHP version.
2.  **Clone Repository:** `git clone ...` your project into a directory (e.g., `/var/www/task-manager`).
3.  **Install Dependencies:**
    ```bash
    composer install --no-dev --optimize-autoloader
    ```
4.  **Configure Environment:**
    * `cp .env.example .env`
    * Edit `.env` with your production database credentials and `APP_ENV=production`.
    * **Important:** Run `php artisan key:generate` on the server.
5.  **Optimize:** Cache your configuration for a speed boost.
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```
6.  **Run Migrations:**
    ```bash
    php artisan migrate --force
    ```
7.  **Set Permissions:** Give the web server write access to the storage and cache folders.
    ```bash
    sudo chown -R www-data:www-data storage bootstrap/cache
    sudo chmod -R 775 storage bootstrap/cache
    ```
8.  **Configure Nginx:** Edit your Nginx site configuration to point the `root` to your project's `/public` directory and handle PHP requests via FPM. A standard Laravel Nginx config is required.
9.  **Restart Nginx:**
    ```bash
    sudo systemctl restart nginx
    ```

Your application should now be live at your server's IP address or domain.
