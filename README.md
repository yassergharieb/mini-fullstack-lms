# Mini Fullstack LMS

A powerful and elegant Learning Management System built with **Laravel 11+**, designed for speed, security, and a premium user experience.

## 🚀 Features

-   **Seamless Enrollment**: Idempotent enrollment system with draft course protection.
-   **Granular Progress Tracking**: Real-time lesson tracking with automated course completion detection.
-   **Advanced Video Player**: Integrated **Plyr.js** for a premium video experience.
-   **Automated Workflows**: Back-grounded email automation (Welcome & Completion) using Laravel Jobs.
-   **Security First**: Role-based access control (RBAC) with **Spatie Permission**, securing the admin panel and student data.
-   **Powerful Admin Panel**: Fully customized **Filament** dashboard with real-time stats and visual charts.
-   **Comprehensive Testing**: Mission-critical features covered by a robust **Pest** test suite (45+ tests).

---

## 🏗️ Technology Stack

-   **Backend**: Laravel, MySQL, Redis
-   **Frontend**: Blade, Alpine.js, Vanilla CSS, Plyr.js
-   **Admin**: Filament PHP
-   **Security**: Spatie Laravel Permission
-   **Testing**: Pest PHP
-   **Emails**: Mailpit (local testing)

---

## 🐳 Docker Environment

The project is fully containerized using Docker for a consistent development experience.

### Services
-   **app**: PHP 8.4-FPM (where the application logic runs).
-   **nginx**: High-performance web server accessible at `http://localhost:8000`.
-   **mysql**: MySQL 8.0 database (accessible at port `3307` on localhost).
-   **redis**: Key-value store for caching and queues.
-   **mailpit**: Local email testing server (Web UI at `http://localhost:8025`).
-   **phpmyadmin**: Database management UI at `http://localhost:9000`.

### Quick Start
1.  **Start the environment**:
    ```bash
    docker-compose up -d
    ```
2.  **Install dependencies**:
    ```bash
    docker exec -it lms_app composer install
    docker exec -it lms_app npm install && npm run build
    ```
3.  **Setup Database**:
    ```bash
    docker exec -it lms_app php artisan migrate:fresh --seed
    ```

---

## 🛠️ Developer Guide

### Authentication & Roles
-   **Super Admin**: Has full access to the Filament Dashboard (`/admin`).
-   **Student**: Default role for new registrations. Prevented from accessing the admin panel.
-   **Default Admin Credentials**:
    -   **Email**: `admin@lms.test`
    -   **Password**: `password`

### Background Jobs
We use Laravel's background processing for heavy tasks:
-   **SendWelcomeEmailJob**: Sent immediately upon registration.
-   **SendCourseCompletionEmailJob**: Sent when a student finishes the last lesson.
-   **UploadVideoJob**: Handles lesson video storage and notification in a non-blocking way.

To process jobs locally:
```bash
php artisan queue:work
```

### Running Tests
Our test suite ensures data integrity and security:
```bash
php artisan test
```

---

## 📉 Admin Dashboard
The dashboard provides a birds-eye view of your LMS:
-   **Stats Overview**: Real-time tracking of Total Students, Courses, and Completion Rates.
-   **Popular Courses Chart**: Visual bar chart showing enrollment distribution.
-   **Detailed Relations**: Manage students and track their progress percentage directly from the Course edit page.

---

## 📂 Project Structure
-   `app/Services`: Core business logic (Enrollment, Progress).
-   `app/Jobs`: Non-blocking automated tasks.
-   `app/Filament`: Admin panel configuration and custom widgets.
-   `tests/Feature`: Pest feature and logic tests.

---

## 📝 License
This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
