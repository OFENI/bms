# Blood Management System (BMS)

A comprehensive Blood Management System built with Laravel 12 for managing blood donations, inventory, requests, and disbursements for hospitals and blood banks.

## Features

- **Admin Dashboard**: Complete administration panel for managing users, donors, institutions, and inventory
- **Hospital Dashboard**: Dedicated interface for hospitals to manage blood requests and inventory
- **Donor Management**: Track donor information, eligibility, and donation history
- **Inventory Management**: Real-time tracking of blood inventory with expiration monitoring
- **Blood Requests**: Hospital blood request system with approval workflow
- **Disbursements**: Track blood disbursements and history
- **Reports**: Generate PDF and CSV reports for various metrics
- **Multi-role System**: Admin and Hospital user roles with appropriate permissions

## Tech Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Database**: SQLite (development) / PostgreSQL (production)
- **Frontend**: Blade Templates with Tailwind CSS
- **PDF Generation**: DomPDF

## Quick Start

### Local Development

1. Clone the repository:
```bash
git clone https://github.com/OFENI/bms.git
cd bms
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations:
```bash
php artisan migrate
php artisan db:seed
```

5. Build assets:
```bash
npm run build
```

6. Start the server:
```bash
php artisan serve
```

## Deployment

This application can be deployed to free hosting platforms. See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed deployment instructions.

### Quick Deploy to Render.com (Free)

1. Sign up at [Render.com](https://render.com)
2. Create a PostgreSQL database
3. Create a new Web Service connected to this GitHub repository
4. Configure environment variables (see DEPLOYMENT.md)
5. Deploy!

For detailed step-by-step instructions, see [DEPLOYMENT.md](DEPLOYMENT.md).

## Project Structure

```
bms/
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Models/               # Eloquent models
│   └── Mail/                 # Email notifications
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── resources/
│   └── views/                # Blade templates
│       ├── admin/            # Admin views
│       └── hospital/         # Hospital views
└── routes/
    └── web.php               # Application routes
```

## Default Credentials

After seeding, you can create an admin user via tinker:
```bash
php artisan tinker
```

Then:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = Hash::make('password');
$user->role = 'admin';
$user->save();
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
