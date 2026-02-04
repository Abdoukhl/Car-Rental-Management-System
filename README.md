# AETHORIA Car Rental Management System

A comprehensive car rental management system built with Laravel 11, featuring multi-role support, real-time booking management, and payment processing.

![Laravel](https://img.shields.io/badge/Laravel-11.0-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![Livewire](https://img.shields.io/badge/Livewire-3.6-orange)
![License](https://img.shields.io/badge/License-MIT-green)

## 🚀 Features

### Core Functionality
- **Multi-Role System**: Admin, Agency, and Customer roles with specific permissions
- **Car Fleet Management**: Complete vehicle inventory with features, pricing, and availability
- **Real-time Booking System**: Reservation management with calendar integration
- **Payment Processing**: Secure payment handling with Stripe integration
- **Document Management**: Verification documents for agencies and customers
- **Rating & Review System**: Customer feedback and vehicle ratings
- **Messaging System**: Internal communication between users

### Advanced Features
- **Subscription Plans**: Agency subscription management with different tiers
- **Notification System**: Real-time alerts and email notifications
- **Insurance Management**: Comprehensive insurance tracking
- **Contract Generation**: Automated rental contract creation
- **Dashboard Analytics**: Performance metrics and reporting
- **Responsive Design**: Mobile-first approach with TailwindCSS

## 🛠️ Technical Stack

### Backend
- **Framework**: Laravel 11
- **Language**: PHP 8.2+
- **Database**: SQLite (configurable for MySQL/PostgreSQL)
- **Authentication**: Laravel Breeze
- **Queue System**: Redis/Database
- **Image Processing**: Intervention Image

### Frontend
- **UI Framework**: Livewire 3.6 + Volt
- **Styling**: TailwindCSS
- **Icons**: Font Awesome
- **JavaScript**: Alpine.js (via Livewire)

### Third-party Services
- **Payment**: Stripe
- **Email**: SMTP (configurable)
- **File Storage**: Local/Cloud (configurable)

## 📋 Requirements

- PHP 8.2 or higher
- Composer 2.0 or higher
- Node.js 18 or higher
- NPM or Yarn
- SQLite, MySQL, or PostgreSQL

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/Abdoukhl/Car-Rental-Management-System.git
cd Car-Rental-Management-System
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Edit your `.env` file with your database credentials:
```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=car_rental
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5. Database Migration
```bash
php artisan migrate
php artisan db:seed
```

### 6. Frontend Compilation
```bash
npm run build
```

### 7. Start the Application
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 👥 User Roles

### Admin
- Full system administration
- User management and approval
- Agency subscription management
- System analytics and reporting

### Agency
- Vehicle fleet management
- Booking management
- Customer communication
- Subscription plan management

### Customer
- Vehicle browsing and booking
- Payment processing
- Review and rating system
- Profile management

## 🔧 Configuration

### Environment Variables
Key environment variables to configure:

```env
APP_NAME=AETHORIA Rental
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=sqlite

# Stripe Payment
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
```

### Default Admin Account
After running database seeds, you can access the admin panel with:
- **Email**: `admin@example.com`
- **Password**: `password`

⚠️ **Important**: Change the default credentials in production!

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Livewire/            # Livewire components
│   ├── Models/              # Eloquent models
│   └── Notifications/       # Notification classes
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   └── lang/               # Translation files
├── routes/                 # Route definitions
└── public/                 # Public assets
```

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

## 📦 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Run `php artisan config:cache`
3. Run `php artisan route:cache`
4. Run `php artisan view:cache`
5. Configure your web server to point to the `public` directory

### Docker Deployment
```bash
docker-compose up -d
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

If you have any questions or issues, please:
- Open an issue on GitHub
- Contact the development team

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com/)
- [Livewire](https://livewire.laravel.com/)
- [TailwindCSS](https://tailwindcss.com/)
- [Stripe](https://stripe.com/)

---

**AETHORIA Car Rental System** - Where innovation meets automotive excellence. 
