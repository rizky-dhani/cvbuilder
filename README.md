# CV Builder

A comprehensive career management platform designed to manage professional narratives through robust CV versioning, application tracking, and achievement logging.

## 🚀 Vision

The CV Builder goes beyond static resume generation. It empowers users to take control of their entire career trajectory by providing a central repository for professional data and tools to tailor their presentation for any opportunity.

## ✨ Key Features

- **Master Record Management:** A centralized profile to manage work history, education, skills, and certifications.
- **Filament-Powered Dashboard:** A sophisticated administrative interface for seamless data entry and management.
- **Enhanced Security:** Built-in Email-based Multi-Factor Authentication (MFA) with "Remember Me" (90 days) support.
- **Data Isolation:** Secure, multi-tenant architecture ensuring users only access their own professional records.
- **Dynamic Previews:** Live updates and professional notifications for all management operations.

## 🛠️ Technology Stack

### Core Backend
- **Language:** PHP 8.4
- **Framework:** [Laravel 12.x](https://laravel.com)
- **Database:** MariaDB
- **Development Environment:** [Laravel Sail](https://laravel.com/docs/sail) (Docker)

### Frontend & UI
- **Framework:** [Livewire 3.x](https://livewire.laravel.com)
- **Styling:** [Tailwind CSS 4.x](https://tailwindcss.com)
- **Admin Panel:** [Filament v4](https://filamentphp.com)
- **Bundler:** Vite

### Quality & Tools
- **Testing:** [Pest](https://pestphp.com) (Targeting >99% coverage)
- **Email Testing:** [Mailpit](https://github.com/axllent/mailpit)
- **Code Style:** Laravel Pint
- **Methodology:** Conductor (Spec-driven development)

## 📦 Installation & Setup

### Prerequisites
- Docker & Docker Compose (for Laravel Sail)
- PHP 8.4+ and Composer (for local management)

### Getting Started

1. **Clone the repository:**
   ```bash
   git clone https://github.com/rizky-dhani/cvbuilder.git
   cd cvbuilder
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Start the development environment:**
   ```bash
   ./vendor/bin/sail up -d
   ```

5. **Run migrations:**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

6. **Build assets:**
   ```bash
   npm run dev
   ```

## 🧪 Testing

We maintain a high standard of quality with a focus on comprehensive testing.

```bash
# Run all tests
php artisan test --compact

# Run with coverage (requires Xdebug or PCOV)
php artisan test --coverage
```

## 🔐 Security

- **Email Verification:** Required for all accounts.
- **Multi-Factor Authentication:** Email-based MFA is available and recommended.
- **Device Trust:** Users can opt to trust their device for 90 days during the MFA challenge.

## 📜 License

The CV Builder is open-sourced software licensed under the [MIT license](LICENSE).