
# 🚀 IT Management System

A web application to efficiently manage IT assets, user accounts, and service requests within an organization.

Streamline your IT operations with a centralized management platform.

![License](https://img.shields.io/github/license/Manusi4hiu/it-management-system)
![GitHub stars](https://img.shields.io/github/stars/Manusi4hiu/it-management-system?style=social)
![GitHub forks](https://img.shields.io/github/forks/Manusi4hiu/it-management-system?style=social)
![GitHub issues](https://img.shields.io/github/issues/Manusi4hiu/it-management-system)
![GitHub pull requests](https://img.shields.io/github/issues-pr/Manusi4hiu/it-management-system)
![GitHub last commit](https://img.shields.io/github/last-commit/Manusi4hiu/it-management-system)

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [Demo](#demo)
- [Quick Start](#quick-start)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [API Reference](#api-reference)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [Testing](#testing)
- [Deployment](#deployment)
- [FAQ](#faq)
- [License](#license)
- [Support](#support)
- [Acknowledgments](#acknowledgments)

## About

The IT Management System is a comprehensive web application designed to help organizations efficiently manage their IT infrastructure. It provides a centralized platform for tracking IT assets, managing user accounts, handling service requests, and generating reports. This system aims to streamline IT operations, improve efficiency, and enhance overall IT service delivery.

This project addresses the challenges faced by IT departments in managing a growing number of assets and user accounts, as well as the need for efficient service request handling. The target audience includes IT administrators, help desk staff, and managers responsible for IT operations within small to medium-sized businesses.

The system is built using the Laravel framework, a robust PHP framework known for its elegant syntax and developer-friendly features. The front-end utilizes Blade templating engine, JavaScript, HTML, and CSS. This architecture provides a scalable and maintainable solution for managing IT resources. The database used is typically MySQL or PostgreSQL, but can be configured to use other database systems supported by Laravel.

## ✨ Features

- 🎯 **Asset Management**: Track and manage all IT assets, including hardware, software, and licenses.
- 👤 **User Account Management**: Create, modify, and manage user accounts and permissions.
- 🎫 **Service Request Management**: Log, track, and resolve service requests from users.
- 📊 **Reporting and Analytics**: Generate reports on asset utilization, service request trends, and other key metrics.
- 🔒 **Role-Based Access Control**: Control access to different features based on user roles.
- ⚡ **Efficient Workflow**: Streamlines IT processes and reduces manual effort.
- 📱 **Responsive Design**: Accessible and usable on various devices, including desktops, tablets, and smartphones.
- 🛠️ **Customizable**: Adaptable to specific organizational needs and workflows.

## 🎬 Demo

🔗 **Live Demo**: [https://your-demo-url.com](https://your-demo-url.com)

### Screenshots
![Asset Management](screenshots/asset-management.png)
*Asset management interface showing asset details and status*

![Service Request Dashboard](screenshots/service-request-dashboard.png)
*Dashboard displaying service request statistics and status updates*

## 🚀 Quick Start

Clone and run in 3 steps:
```bash
git clone https://github.com/Manusi4hiu/it-management-system.git
cd it-management-system
composer install
npm install && npm run dev
php artisan migrate
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000) to view it in your browser.

## 📦 Installation

### Prerequisites
- PHP 8.1+
- Composer
- Node.js 18+ and npm
- MySQL or PostgreSQL
- Git

### Option 1: From Source
```bash
# Clone repository
git clone https://github.com/Manusi4hiu/it-management-system.git
cd it-management-system

# Install PHP dependencies
composer install

# Copy .env.example to .env and configure database settings
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database settings in .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database_name
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run database migrations
php artisan migrate

# Install JavaScript dependencies
npm install

# Build assets
npm run dev

# Start development server
php artisan serve
```

## 💻 Usage

### Basic Usage
After installation, access the application through your web browser.

```
http://localhost:8000
```

Log in with the default admin credentials (if seeded) or create a new user account.

### User Account Management
Navigate to the User Management section to create, edit, and manage user accounts. Assign roles and permissions to control access to different features.

### Asset Management
Use the Asset Management module to add, update, and track IT assets. Record details such as asset type, serial number, purchase date, and warranty information.

### Service Request Management
Users can submit service requests through the system. IT staff can then track, assign, and resolve these requests.

## ⚙️ Configuration

### Environment Variables
Create a `.env` file in the root directory based on `.env.example`:

```env
APP_NAME=ITManagementSystem
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=it_management
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mail.example.com
MAIL_PORT=587
MAIL_USERNAME=your_email@example.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your_email@example.com"
MAIL_FROM_NAME="${APP_NAME}"

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1

TELESCOPE_ENABLED=true
```

### Configuration File
Laravel's configuration files are located in the `config` directory.  You can customize various aspects of the application by modifying these files.

## API Reference

This project currently doesn't expose a public API. All functionality is accessed through the web interface. If API access is required, it can be implemented using Laravel's API resources and authentication mechanisms.

## 📁 Project Structure

```
it-management-system/
├── 📁 app/
│   ├── 📁 Models/          # Eloquent models
│   ├── 📁 Http/            # Controllers and middleware
│   ├── 📁 Providers/       # Service providers
│   ├── 📁 Console/         # Artisan commands
│   └── 📁 Exceptions/      # Exception handling
├── 📁 database/
│   ├── 📁 migrations/      # Database migrations
│   ├── 📁 seeders/         # Database seeders
│   └── 📄 factories/       # Model factories
├── 📁 resources/
│   ├── 📁 views/          # Blade templates
│   ├── 📁 sass/           # Sass files
│   ├── 📁 js/             # JavaScript files
│   └── 📁 lang/           # Language files
├── 📁 routes/              # Route definitions
├── 📁 config/              # Configuration files
├── 📁 public/              # Public assets
├── 📁 storage/             # Storage directory
├── 📁 tests/               # Test files
├── 📄 .env                 # Environment variables
├── 📄 .gitignore           # Git ignore rules
├── 📄 composer.json        # PHP dependencies
├── 📄 package.json         # JavaScript dependencies
├── 📄 README.md            # Project documentation
└── 📄 LICENSE              # License file
```

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) (create this file) for details.

### Quick Contribution Steps
1. 🍴 Fork the repository
2. 🌟 Create your feature branch (```git checkout -b feature/AmazingFeature```)
3. ✅ Commit your changes (```git commit -m 'Add some AmazingFeature'```)
4. 📤 Push to the branch (```git push origin feature/AmazingFeature```)
5. 🔃 Open a Pull Request

### Development Setup
```bash
# Fork and clone the repo
git clone https://github.com/yourusername/it-management-system.git

# Install dependencies
composer install
npm install

# Create a new branch
git checkout -b feature/your-feature-name

# Make your changes and test
npm run test

# Commit and push
git commit -m "Description of changes"
git push origin feature/your-feature-name
```

### Code Style
- Follow existing code conventions (PSR-12 for PHP)
- Run `composer lint` before committing
- Add tests for new features
- Update documentation as needed

## Testing

### Running Tests
```bash
# Run PHPUnit tests
php artisan test

# Run JavaScript tests (if applicable, configure with Jest/Vitest)
npm run test
```

## Deployment

### Deployment to a Web Server
1.  Upload the project files to your web server.
2.  Configure the web server to point to the `public` directory.
3.  Set up the database and configure the `.env` file with the correct database credentials.
4.  Run database migrations: `php artisan migrate`
5.  Ensure proper file permissions are set for the `storage` and `bootstrap/cache` directories.

### Deployment with Docker
A Dockerfile can be created to containerize the application for easier deployment.

```dockerfile
# Use an official PHP runtime as a parent image
FROM php:8.1-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apk update && apk add --no-cache \
    git \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy existing application source code
COPY . /var/www/html

# Install composer dependencies
RUN composer install --no-ansi --no-interaction --no-dev --optimize-autoloader

# Copy the .env file
COPY .env /var/www/html/.env

# Generate application key
RUN php artisan key:generate

# Run database migrations
RUN php artisan migrate --force

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm", "-F"]
```

## FAQ

**Q: How do I change the default admin password?**

A: You can change the default admin password by logging in as the admin user and updating the password in the user profile settings.

**Q: How do I customize the look and feel of the application?**

A: You can customize the look and feel of the application by modifying the Blade templates and CSS files located in the `resources/views` and `resources/sass` directories, respectively.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

### License Summary
- ✅ Commercial use
- ✅ Modification
- ✅ Distribution
- ✅ Private use
- ❌ Liability
- ❌ Warranty

## 💬 Support

- 📧 **Email**: your.email@example.com
- 🐛 **Issues**: [GitHub Issues](https://github.com/Manusi4hiu/it-management-system/issues)
- 📖 **Documentation**: [Full Documentation](https://docs.your-site.com)

## 🙏 Acknowledgments

- 🎨 **Design inspiration**: [Bootstrap Admin Templates](https://startbootstrap.com/)
- 📚 **Libraries used**:
  - [Laravel Framework](https://laravel.com/) - The PHP Framework For Web Artisans
  - [Bootstrap](https://getbootstrap.com/) - Front-end component library
- 👥 **Contributors**: Thanks to all [contributors](https://github.com/Manusi4hiu/it-management-system/contributors)
