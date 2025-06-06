# 🛒 Product Store - Advanced Laravel E-commerce Platform

![Dashboard Preview](store.png) 
## The first model look

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

## 📸 Application Screenshots

### 🏠 **Homepage & Product Catalog**
![Homepage](public/images/Screenshot%202025-06-07%20023124.png)
*Modern responsive homepage with featured products*

![Product Catalog](public/images/Screenshot%202025-06-07%20023224.png)
*Complete product catalog with search and filtering*

### 📊 **Admin Dashboard**
![Admin Dashboard](public/images/Screenshot%202025-06-07%20023319.png)
*Comprehensive admin dashboard with analytics*

![User Management](public/images/Screenshot%202025-06-07%20023431.png)
*Advanced user management with role-based permissions*

### 🛒 **Shopping Experience**
![Shopping Cart](public/images/Screenshot%202025-06-07%20023614.png)
*Intuitive shopping cart and checkout process*

![Order Management](public/images/Screenshot%202025-06-07%20023650.png)
*Complete order tracking and management system*

### 💼 **Business Management**
![Financial Dashboard](public/images/Screenshot%202025-06-07%20023715.png)
*Financial tracking and reporting interface*

![Inventory Management](public/images/Screenshot%202025-06-07%20023751.png)
*Stock management and supplier interface*

### 🔐 **Authentication System**
![Login System](public/images/Screenshot%202025-06-07%20023842.png)
*Secure login with social authentication options*

![User Profile](public/images/Screenshot%202025-06-07%20023904.png)
*User profile management and settings*

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

## 🚀 Live Demo Features

### 🎨 **Modern Design**
- Fully responsive design that works on all devices
- Clean and intuitive user interface
- Professional color scheme and typography
- Smooth animations and transitions

### 🔄 **Real-time Functionality**
- Live product search and filtering
- Real-time cart updates
- Instant notifications for actions
- Dynamic dashboard charts and statistics

### 📱 **Mobile Optimized**
- Touch-friendly interface
- Optimized for mobile shopping
- Fast loading times
- Progressive Web App features

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
- LinkedIn: [Connect with me](https://linkedin.com/in/mohamed-askar)
- Portfolio: [View my work](https://your-portfolio.com)

### 🛠️ **What I Built**
> "I developed this comprehensive e-commerce platform using Laravel 11 with advanced features including multi-role user management, social authentication, real-time analytics dashboard, and complete order management system. The application handles product catalogs, shopping carts, payment processing, and financial reporting - all built with modern technologies like TailwindCSS and AlpineJS."

### 💼 **Technical Highlights**
- ✅ Laravel 11 with Passport API authentication
- ✅ Spatie Permission package for role management  
- ✅ Social authentication (Google, GitHub, Discord)
- ✅ Real-time dashboard with analytics
- ✅ Complete e-commerce functionality
- ✅ Email verification and notification system
- ✅ Modern responsive UI with TailwindCSS
- ✅ Advanced financial management system
- ✅ Multi-role user access control

## 🙏 Acknowledgments

- Laravel Framework
- Spatie Packages
- AdminLTE Theme
- TailwindCSS
- All open-source contributors

---

*Built with ❤️ using Laravel 11*

> **Note**: More screenshots and images can be found in the [public/images folder](https://github.com/mohamedAskaarrr/Product-store/tree/main/public/images).
