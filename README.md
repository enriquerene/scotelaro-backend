# Scotelaro - Martial Arts Academy Management System

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=flat-square&logo=livewire)
![Filament](https://img.shields.io/badge/Filament-3.x-FF5C00?style=flat-square&logo=filamentphp)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-06B6D4?style=flat-square&logo=tailwindcss)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat-square&logo=alpine.js)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=flat-square&logo=mysql)

A comprehensive martial arts academy management system built with modern Laravel stack. The system provides separate interfaces for administrators, staff (instructors), and students with features for class management, student onboarding, billing, and progress tracking.

## 📋 Project Status

**✅ Production Ready** - All core features implemented and tested

### Current Implementation Status

| Feature | Status | Notes |
|---------|--------|-------|
| **Admin Panel (Filament v3)** | ✅ Complete | Full CRUD with visual distinctiveness and financial guardrails |
| **Student PWA (Livewire)** | ✅ Complete | Mobile-friendly student dashboard |
| **Invite System** | ✅ Complete | Token-based registration with WhatsApp integration |
| **Onboarding Wizard** | ✅ Complete | 4-step wizard with automatic redirection and mock payment |
| **Staff Scopes & Policies** | ✅ Complete | Role-based data filtering with EnrollmentPolicy |
| **Notification System** | ✅ Complete | Database notifications via Filament |
| **Authentication** | ✅ Complete | Fortify with phone/email login |
| **Database Schema** | ✅ Complete | All migrations created with visual/commercial fields |
| **Visual Distinctiveness** | ✅ Complete | Color, icons, reorderable tables for modalities |
| **Commercial Definition** | ✅ Complete | Pricing tiers with billing periods, frequency types, modality scopes |
| **Financial Guardrails** | ✅ Complete | Strict "no-edit" strategy for enrollments with Infolists |
| **Financial Management Section** | ✅ Complete | Incoming payments dashboard, expenses tracking, and resources inventory |
| **PWA Setup** | ⚠️ Partial | Basic setup, needs service worker optimization |
| **Payment Integration** | ✅ Mock Complete | Full payment flow with mock processing for testing |
| **Production Deployment** | ✅ Ready | Configuration optimized for production |

## ✨ Features

### 🎯 Core Philosophy: "Guardrails for Financials, Freedom for Operations"
The system implements a high-integrity admin experience with strict financial controls while allowing operational flexibility.

### 🏢 Admin & Staff Panel (`/admin`)
- **Visual Distinctiveness**: Color pickers, icon selectors, and reorderable tables for modalities
- **Commercial Definition**: Advanced pricing tiers with billing periods, frequency types, and modality scopes
- **Financial Guardrails**: Strict "no-edit" strategy for enrollments with read-only views using Filament Infolists
- **Role-Based Access Control** using Filament Shield with granular permissions
- **Staff Scoped Views** - Instructors only see their students and classes with proper policy enforcement
- **Invite Management** - Generate and track registration invites with WhatsApp integration
- **Notification System** - Send announcements to students/staff via database notifications
- **Financial Management** - Complete financial tracking with three dedicated sections:
  - **Incoming Payments Dashboard** - View all student payments, subscriptions, and billing status
  - **Outcomes/Expenses Tracking** - Manage staff payments, maintenance costs, marketing expenses, and other operational costs
  - **Resources Inventory** - Track academy resources like first aid kits, equipment, marketing materials with maintenance scheduling

### 📱 Student PWA (`/app`)
- **Mobile-First Interface** with responsive design
- **Class Enrollment** - Browse and join available classes
- **Progress Tracking** - View graduation history and attendance
- **Subscription Management** - View current plan and billing
- **Notifications** - Real-time updates from academy
- **Profile Management** - Update personal information

### 🔐 Authentication & Security
- **Dual Login** with phone number or email
- **Two-Factor Authentication** (2FA) support
- **Invite-Only Registration** for controlled access
- **Role-Based Permissions** (Admin, Staff, Student)
- **Password Validation** with Laravel Fortify

### 📊 Business Logic
- **Flexible Pricing** - Tier-based pricing with billing periods (monthly, quarterly, annual)
- **Frequency Types** - Unlimited vs fixed class frequency with class caps
- **Modality Scopes** - Pricing tiers can be scoped to specific modalities
- **Financial Guardrails** - Strict "no-edit" strategy for enrollments ensures contract immutability
- **Automatic Billing** - Subscription-based payment system with next billing date tracking
- **Attendance Tracking** - Record and monitor student presence
- **Graduation System** - Track belt/rank progression
- **Capacity Management** - Class enrollment limits
- **Visual Identity** - Modalities have colors and icons for visual distinctiveness

## 🚀 Quick Start

### Prerequisites
- Docker and Docker Compose
- Git
- Node.js 18+ (optional, handled by Sail)

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd scotelaro-backend
   ```

2. **Start the development environment**
   ```bash
   ./vendor/bin/sail up -d
   ```

3. **Install dependencies**
   ```bash
   ./vendor/bin/sail composer install
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run build
   ```

4. **Run database migrations and seeders**
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

5. **Create admin user**
   After running migrations with seeders, create an admin user via Tinker:
   ```bash
   ./vendor/bin/sail artisan tinker
   ```
   Then run:
   ```php
   User::create([
       'name' => 'Admin User',
       'email' => 'admin@scotelaro.com',
       'password' => Hash::make('password'),
       'email_verified_at' => now(),
   ])->assignRole('admin');
   ```
6. **Access the application**
  - Main Application: http://localhost:8080
  - Admin Panel: http://localhost:8080/admin
  - Student PWA: http://localhost:8080/app
  - MySQL: localhost:3306 (user: `sail`, password: `password`)

## 👥 Test Users & Credentials

After running the database seeder, the following test users are created for development and testing purposes:

### Primary Test Accounts

| User | Email | Password | Role | Phone | Purpose |
|------|-------|----------|------|-------|---------|
| João Silva | `joao.silva@example.com` | `password` | Student | `+55 (11) 98765-4321` | **Test onboarding flow** - No subscription, will be redirected to onboarding |
| Maria Santos | `maria.santos@example.com` | `password` | Student | `+55 (21) 99876-5432` | **Test app access** - Has active subscription, can access app directly |
| Admin User | `admin@scotelaro.com` | `password` | Admin | `+55 (31) 91234-5678` | **Create resources manually** - Full admin access |
| Carlos Oliveira | `carlos.oliveira@example.com` | `password` | Staff | `+55 (41) 92345-6789` | **Test staff role** - Limited access |

### Additional Users
- 3 random student users with Brazilian phone numbers
- All users have password: `password`
- All emails are verified

## 🔄 Onboarding Flow (Automatic Redirection)

The system now implements automatic onboarding redirection for students without subscriptions:

### Expected User Flow:
1. **New Student (No Subscription)**
  - Login or accept invite → Redirected to `/onboarding`
  - Step 1: Select modalities → Step 2: Select classes → Step 3: Choose pricing → Step 4: Mock payment
  - After completion: Subscription created → Redirected to main app

2. **Existing Student (With Subscription)**
  - Login → Direct access to `/app` (main student dashboard)
  - No onboarding required

3. **Admin/Staff Users**
  - Login → Access respective interfaces
  - Bypass subscription check (different roles)

### Key Components:
- **Middleware**: `CheckSubscription` - Automatically redirects students without active subscriptions
- **Onboarding Wizard**: 4-step process with validation and mock payment
- **Invite System**: New users created via invites are checked for subscription status

## 🏗️ Project Architecture

### Technology Stack
- **Backend**: Laravel 12.x with PHP 8.3
- **Frontend**: Livewire 3.x, Alpine.js 3.x, Tailwind CSS 4.x
- **Admin Panel**: Filament PHP 3.x
- **Database**: MySQL 8.x
- **Authentication**: Laravel Fortify
- **Development**: Laravel Sail (Docker)
- **Asset Bundling**: Vite

### Directory Structure
```
app/
├── Filament/Resources/     # Admin panel resources
├── Livewire/              # Livewire components
│   ├── App/              # Student PWA components
│   ├── Settings/         # User settings
│   └── OnboardingWizard.php
├── Http/Controllers/     # Traditional controllers
├── Models/              # Eloquent models
└── Providers/           # Service providers
```

### Key Components

#### 1. Invite System
- **Controller**: `app/Http/Controllers/InviteController.php`
- **View**: `resources/views/invite/accept.blade.php`
- **Model**: `app/Models/Invite.php`
- **Routes**: `/invite/{token}`

#### 2. Onboarding Wizard
- **Component**: `app/Livewire/OnboardingWizard.php`
- **View**: `resources/views/livewire/onboarding-wizard.blade.php`
- **Route**: `/onboarding`

#### 3. Staff Scopes & Policies
- **Enrollment Policy**: `app/Policies/EnrollmentPolicy.php` - Strict "no-edit" strategy with role-based permissions
- **Student Scopes**: `app/Filament/Resources/StudentResource.php` - Role-based filtering for staff
- **Visual Resources**: `app/Filament/Resources/ModalityResource.php` - Color, icons, reorderable tables
- **Commercial Resources**: `app/Filament/Resources/PricingTierResource.php` - Billing periods, frequency types, modality scopes
- **Financial Guardrails**: `app/Filament/Resources/EnrollmentResource.php` - Read-only views with custom actions (cancel, renew, change payment)

#### 4. Database Schema Enhancements
- **Visual Fields Migration**: `database/migrations/2026_02_07_195638_add_visual_fields_to_modalities_table.php`
- **Commercial Fields Migration**: `database/migrations/2026_02_07_195820_add_commercial_fields_to_pricing_tiers_table.php`
- **Pivot Table Migration**: `database/migrations/2026_02_07_195902_create_pricing_tier_modality_table.php`
- **Financial Fields Migration**: `database/migrations/2026_02_07_200138_add_financial_fields_to_enrollments_table.php`

## 📖 Usage Guide

### For Administrators
1. Log in at `/admin` with admin credentials
2. Navigate to **Invites** to create new user invitations
3. Use **Modalities** with visual distinctiveness (colors, icons, reorderable tables)
4. Configure **Pricing Tiers** with commercial definitions (billing periods, frequency types, modality scopes)
5. Manage **Enrollments** with strict financial guardrails (read-only views, custom actions only)
6. Monitor **Students** with role-based scopes and filtering
7. Use **Archive** actions for pricing tiers with active subscriptions
8. Enforce **Financial Contract Immutability** - enrollments cannot be edited once created

### For Staff/Instructors
1. Log in at `/admin` with staff credentials
2. View only your assigned classes and students (enforced by EnrollmentPolicy)
3. **Cannot edit enrollments** - Financial contracts are immutable
4. Can view enrollment details in read-only mode using Filament Infolists
5. Record attendance and update student progress
6. Send notifications to your students
7. Access is scoped based on role and class assignments

### For Students
1. Accept invitation via WhatsApp link
2. Complete onboarding wizard to select classes and payment
3. Access student dashboard at `/app`
4. View schedule, track progress, and manage subscription

## 🚢 Deployment

### Production Requirements
- PHP 8.2+ with extensions: mbstring, pdo_mysql, tokenizer, xml, ctype, json
- MySQL 8.0+ or MariaDB 10.3+
- Composer 2.0+
- Node.js 18+ (for asset compilation)
- Web server (Nginx/Apache)

### Deployment Steps

1. **Prepare the application**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm run build
   php artisan key:generate
   php artisan storage:link
   ```

2. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with production values
   ```

3. **Set up database**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

4. **Optimize for production**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

5. **Configure web server**
   - Point document root to `public/`
   - Configure rewrite rules for Laravel
   - Set proper permissions for `storage/` and `bootstrap/cache/`

### Hostinger WordPress Server Deployment

Although designed for VPS deployment, the application can run on Hostinger's WordPress hosting with adjustments:

#### Prerequisites
- Hostinger account with WordPress hosting (PHP 8.2+ support)
- FTP/SFTP access or File Manager
- MySQL database created via Hostinger control panel

#### Steps
1. **Prepare locally**: Run `composer install --optimize-autoloader --no-dev` and `npm run build`
2. **Upload files**: Upload entire project (excluding `node_modules`, `.git`) to `public_html/laravel/`
3. **Configure database**: Update `.env` with Hostinger MySQL credentials
4. **Set permissions**: Make `storage` and `bootstrap/cache` writable (755)
5. **Adjust paths**: Move `public/*` to web root or configure document root
6. **Run migrations**: Via SSH or PHPMyAdmin: `php artisan migrate --force`

#### Troubleshooting Hostinger
- **White screen**: Check `storage/logs/laravel.log`, enable debug mode temporarily
- **404 errors**: Ensure `.htaccess` is present and mod_rewrite enabled
- **Database errors**: Verify credentials and MySQL remote access

**Recommendation**: For production use, upgrade to Hostinger VPS for better performance and control.

## 🧪 Testing

The project uses PestPHP for testing. Run tests with:

```bash
./vendor/bin/sail artisan test
```

Or for specific test suites:
```bash
./vendor/bin/sail artisan test --testsuite=Feature
./vendor/bin/sail artisan test --testsuite=Unit
```

## 🔧 Development

### Common Sail Commands
```bash
# Start/stop containers
./vendor/bin/sail up -d
./vendor/bin/sail down

# Run artisan commands
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan make:model Product

# Run composer commands
./vendor/bin/sail composer require package-name

# Run npm commands
./vendor/bin/sail npm run dev
./vendor/bin/sail npm run build

# View logs
./vendor/bin/sail logs -f
```

### Environment Variables
Key environment variables for development:
```env
APP_PORT=8080
VITE_PORT=5173
DB_HOST=mysql
DB_DATABASE=scotelaro
DB_USERNAME=sail
DB_PASSWORD=password
```

### Code Style
The project uses Laravel Pint for code formatting:
```bash
./vendor/bin/sail pint
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation accordingly
- Use meaningful commit messages

## 📄 License

This project is proprietary software. All rights reserved.

## 📞 Support

For technical support or questions:
- Create an issue in the repository
- Contact the development team

## 🎯 Roadmap

### Planned Features
- [ ] Full payment gateway integration (MercadoPago/Asaas)
- [ ] Advanced PWA features (offline mode, push notifications)
- [ ] Mobile app (React Native/Ionic)
- [ ] Advanced reporting and analytics
- [ ] Integration with accounting software
- [ ] Bulk SMS/WhatsApp messaging

### Known Limitations
- Payment integration currently uses stub implementation
- PWA service workers need optimization for offline functionality
- Some advanced filtering features pending in admin panel

---

**Built with ❤️ using the TALL Stack (Tailwind, Alpine, Laravel, Livewire) + Filament**

*Last Updated: February 7, 2026*