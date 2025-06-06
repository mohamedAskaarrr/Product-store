# 🛒 Product Store - Advanced Laravel E-commerce Platform

![Dashboard Preview](store.png)

A comprehensive e-commerce platform built with Laravel 11, featuring multi-role management, advanced authentication, and complete business operations management.

## ✨ Features

### 🛍️ **E-commerce Core**
- Product catalog with categories and search
- Shopping cart and checkout system
- Order management and tracking
- Product reviews and ratings
- Favorites/wishlist functionality
- Stock management and inventory tracking

### 👥 **Multi-Role System**
- **Admin**: Full system control, user management, financial oversight
- **Manager**: Dashboard access, sales management, reports
- **Employee**: Customer support, limited admin functions  
- **Customer**: Shopping, order history, profile management
- **Supplier**: Stock management, product updates

### 🔐 **Advanced Authentication**
- Laravel Passport API authentication
- Social login integration (Google, GitHub, Discord)
- Email verification system
- Password reset functionality
- Role-based permissions using Spatie Laravel Permission

### 📊 **Admin Dashboard**
- Real-time sales analytics
- Monthly statistics and charts
- User management interface
- Financial tracking and reporting
- Order management system

### 💰 **Financial Management**
- Sales tracking and reporting
- Expense management
- Profit calculation and analysis
- Credit request system
- Refund processing

### 🎨 **Modern UI/UX**
- Responsive design with TailwindCSS
- AdminLTE dashboard theme
- AlpineJS for interactive components
- Mobile-friendly interface

## 🚀 Technology Stack

### **Backend**
- **Laravel 11** - PHP framework
- **Laravel Passport** - API authentication
- **Spatie Laravel Permission** - Role & permission management
- **Laravel Socialite** - Social authentication
- **MySQL** - Database

### **Frontend**
- **Blade Templates** - Server-side rendering
- **TailwindCSS** - Utility-first CSS framework
- **AlpineJS** - Lightweight JavaScript framework
- **AdminLTE** - Admin dashboard theme
- **Vite** - Build tool and asset bundling

### **Development Tools**
- **Laravel Pint** - Code style fixer
- **Laravel Sail** - Docker development environment
- **Faker** - Test data generation

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL database

### Setup Steps

1. **Clone the repository**
```bash
git clone https://github.com/mohamedAskaarrr/Product-store.git
cd Product-store
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node.js dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Database configuration**
```bash
# Update .env with your database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_store
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations and seeders**
```bash
php artisan migrate
php artisan db:seed
```

7. **Install Laravel Passport**
```bash
php artisan passport:install
```

8. **Build assets**
```bash
npm run build
# or for development
npm run dev
```

9. **Start the development server**
```bash
# Option 1: Use Laravel's built-in server
php artisan serve

# Option 2: Use the convenient dev script
composer dev
```

The application will be available at `http://localhost:8000`

## 🔑 Default Credentials

After seeding, you can use these default accounts:

- **Admin**: admin@example.com / password
- **Customer**: customer@example.com / password

## 🎯 Key Functionalities

### **For Customers**
- Browse and search products
- Add items to cart and checkout
- View order history and track orders
- Leave product reviews and ratings
- Manage favorites/wishlist
- Request refunds

### **For Admins**
- Complete user management
- Product inventory control
- Sales and financial reporting
- Order processing and management
- System configuration

### **API Features**
- RESTful API with Passport authentication
- User registration and authentication endpoints
- Product and order management APIs
- Complete CRUD operations

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── Web/           # Web controllers
│   └── Api/           # API controllers
├── Models/            # Eloquent models
├── Mail/              # Email templates
└── ...

resources/
├── views/             # Blade templates
├── js/                # JavaScript files
└── css/               # Stylesheets

routes/
├── web.php            # Web routes
└── api.php            # API routes
```

## 🛡️ Security Features

- CSRF protection on all forms
- SQL injection prevention through Eloquent ORM
- XSS protection via Blade templating
- Secure password hashing with bcrypt
- API rate limiting
- Role-based access control

## 📸 Screenshots

### Dashboard
![Dashboard](screenshots/dashboard.png)

### Product Catalog
![Products](screenshots/products.png)

### Order Management
![Orders](screenshots/orders.png)

*Add more screenshots to showcase your application*

## 🚀 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure production database
4. Set up proper file permissions
5. Configure web server (Apache/Nginx)
6. Set up SSL certificate
7. Configure email settings for production

### Recommended Hosting
- **Shared Hosting**: Any Laravel-compatible hosting
- **VPS**: DigitalOcean, Linode, AWS EC2
- **Managed**: Laravel Forge, Vapor

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Developer

**Mohamed Askar**
- GitHub: [@mohamedAskaarrr](https://github.com/mohamedAskaarrr)
- Email: [your-email@example.com]

## 🙏 Acknowledgments

- Laravel Framework
- Spatie Packages
- AdminLTE Theme
- TailwindCSS
- All open-source contributors

---

*Built with ❤️ using Laravel 11*
