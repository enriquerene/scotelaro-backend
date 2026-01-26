# FightGym API (Laravel/PHP Edition)

**A Hexagonal Architecture (Ports & Adapters) Boilerplate for Martial Arts Gym Management**

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4) ![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20) ![Architecture](https://img.shields.io/badge/Architecture-Hexagonal-orange) ![API](https://img.shields.io/badge/API-REST%20%26%20GraphQL-blue)

## 🥊 Project Overview

**FightGym API** is a robust backend system designed to manage the operations of a combat sports academy (BJJ, Muay Thai, MMA).

This project treats **Laravel** not as the "whole application," but strictly as the **Infrastructure Layer**. The core business logic is decoupled from the framework, allowing the domain to evolve independently of the underlying HTTP delivery mechanism (REST or GraphQL) or database ORM.

### Key Features
*   **Role-Based Access:** Distinct capabilities for **Athletes**, **Coaches**, and **Admins**.
*   **Dual API Exposure:** Fully functional REST API and GraphQL Endpoint.
*   **Training Tracker:** Class check-ins, frequency calculation, and history logs.
*   **Progression System:** Belt management, stripe grading, and sparring reviews.
*   **Financial Hub:** Subscription plans, payment history, and payment gateway integration.
*   **Gym Board:** Scheduled events, seminars, and push notifications.

---

## ⬡ Architecture: The Hexagon

We strictly separate the **Framework** (Laravel) from the **Domain** (Business Rules).

1.  **Domain Layer (Pure PHP):**
    *   Contains Entities, Value Objects, and Domain Services.
    *   **Rule:** No `Illuminate\` (Laravel) dependencies allowed here. No Eloquent.
2.  **Application Layer (Use Cases):**
    *   Orchestrates the flow of data.
    *   Defines **Ports** (Interfaces) for Repositories and External Services.
    *   **Rule:** Can use Collections or DTOs, but no HTTP/Controller logic.
3.  **Infrastructure Layer (Laravel):**
    *   **Driving Adapters:** HTTP Controllers (REST), GraphQL Resolvers (Lighthouse), Artisan Commands.
    *   **Driven Adapters:** Eloquent Repositories, Mailables, Jobs, Payment Gateways.
    *   **Rule:** This is where the framework lives.

### Data Flow
`Request` → `Laravel Controller / GraphQL Resolver` → `Application Use Case` → `Domain Entity` → `Repository Implementation (Eloquent)` → `Database`

---

## 📂 Directory Structure

We utilize a custom namespace structure. The `src/` directory holds the hexagon, while standard Laravel folders act as the infrastructure wiring.

```text
root/
├── app/                        # Infrastructure Layer (Laravel Framework)
│   ├── Http/
│   │   ├── Controllers/        # REST Adapters
│   │   └── Middleware/
│   ├── GraphQL/                # GraphQL Schema & Resolvers (Lighthouse)
│   ├── Models/                 # Eloquent Models (DB Schema representation only)
│   └── Providers/              # DI Binding (binds Ports to Adapters)
│
├── src/                        # The Core Hexagon (Mapped in composer.json)
│   ├── Domain/                 # Pure Business Logic
│   │   ├── Identity/           # Users, Roles, Auth
│   │   ├── Training/           # Classes, Attendance, Schedules
│   │   ├── Finance/            # Payments, Subscriptions
│   │   └── Shared/             # Value Objects (Email, UUID, Money)
│   │
│   ├── Application/            # Use Cases & Port Definitions
│   │   ├── Identity/
│   │   ├── Training/
│   │   │   ├── UseCases/       # e.g. CheckInAthlete.php
│   │   │   └── Ports/          # e.g. AttendanceRepositoryInterface.php
│   │   └── Finance/
│   │
│   └── Infrastructure/         # Framework-Agnostic Implementations
│       ├── Persistence/        # Repository Implementations using Eloquent
│       └── Services/           # e.g. StripePaymentService
│
├── tests/
│   ├── Unit/                   # Tests src/Domain (Fast, no DB)
│   └── Feature/                # Tests app/Http (Slow, hits DB)
```

---

## 🥋 Roles & Permissions (RBAC)

Access is controlled via Laravel **Gates/Policies** resolving to Domain Roles.

| Role | Scope | Capabilities |
| :--- | :--- | :--- |
| **Athlete** | `user` | View own profile, check into scheduled classes, view own payments, receive notifications. |
| **Coach** | `staff` | Manage assigned classes, validate student attendance, promote students (grade belts), view roster. |
| **Admin** | `root` | Full system access. Manage subscriptions, financials, create users, global announcements. |

---

## 🔌 API Documentation

### 1. REST API
Standard JSON:API compliant endpoints.

*   **Endpoint:** `/api/v1/...`
*   **Auth:** Bearer Token (Sanctum/Passport)

**Example: Check-in to a class**
```http
POST /api/v1/classes/{id}/check-in
Content-Type: application/json

{
    "athlete_id": "uuid-v4",
    "coordinates": "40.712,-74.006"
}
```

### 2. GraphQL
Powered by [Lighthouse PHP](https://lighthouse-php.com/).

*   **Endpoint:** `/graphql`
*   **Playground:** `/graphiql` (Dev only)

**Example: Fetch User History**
```graphql
query GetAthleteHistory {
  athlete(id: "uuid-v4") {
    name
    currentBelt
    attendance(limit: 5) {
      classDate
      instructor { name }
      technique
    }
    payments(status: PENDING) {
      amount
      dueDate
    }
  }
}
```

---

## 💻 Code Examples

### The Port (Interface)
Located in `src/Application/Training/Ports/AttendanceRepositoryInterface.php`:
```php
namespace FightGym\Application\Training\Ports;

use FightGym\Domain\Training\Entities\Attendance;

interface AttendanceRepositoryInterface {
    public function save(Attendance $attendance): void;
    public function exists(string $athleteId, string $classId): bool;
}
```

### The Adapter (Eloquent Implementation)
Located in `src/Infrastructure/Persistence/EloquentAttendanceRepository.php`:
```php
namespace FightGym\Infrastructure\Persistence;

use FightGym\Application\Training\Ports\AttendanceRepositoryInterface;
use FightGym\Domain\Training\Entities\Attendance as DomainAttendance;
use App\Models\Attendance as EloquentModel; // Laravel Model

class EloquentAttendanceRepository implements AttendanceRepositoryInterface {
    public function save(DomainAttendance $attendance): void {
        EloquentModel::updateOrCreate(
            ['id' => $attendance->getId()],
            $attendance->toArray()
        );
    }
    // ...
}
```

### Dependency Injection (Laravel Service Provider)
Located in `app/Providers/RepositoryServiceProvider.php`:
```php
public function register(): void {
    $this->app->bind(
        \FightGym\Application\Training\Ports\AttendanceRepositoryInterface::class,
        \FightGym\Infrastructure\Persistence\EloquentAttendanceRepository::class
    );
}
```

---

## 🚀 Getting Started

### Prerequisites
*   PHP 8.2+
*   Composer
*   Docker & Laravel Sail (Recommended)

### Installation

1.  **Clone & Install Dependencies**
    ```bash
    git clone https://github.com/your-org/fight-gym-api.git
    cd fight-gym-api
    composer install
    ```

2.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Start Containers (Sail)**
    ```bash
    ./vendor/bin/sail up -d
    ```

4.  **Run Migrations & Seeders**
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

5.  **Access**
    *   API: `http://localhost/api`
    *   GraphiQL: `http://localhost/graphiql`

## 🧪 Testing Strategy

We separate tests based on the Hexagonal layers:

1.  **Unit Tests (`tests/Unit`)**:
    *   Target: `src/Domain` and `src/Application`.
    *   Mocks: Repositories are mocked.
    *   Speed: Very Fast (No DB connection).
    ```bash
    ./vendor/bin/sail test --testsuite=Unit
    ```

2.  **Feature Tests (`tests/Feature`)**:
    *   Target: `app/Http` (Controllers/Resolvers) and `src/Infrastructure` (Repositories).
    *   Real DB: Uses a testing database (SQLite/Postgres).
    *   Verifies that Laravel wiring works correctly.
    ```bash
    ./vendor/bin/sail test --testsuite=Feature
    ```

---

## 📜 Contributing

1.  **Domain First:** Always write the business logic in `src/Domain` before writing the Controller.
2.  **Strict Typing:** PHP 8.2 strict typing is enforced.
3.  **Commit Message:** Use Conventional Commits (feat, fix, chor, refactor).
4. **Be regorous with this rule:** "It's totally forbidden usage of `use Illuminate\...;` or `use App\Models\...;` in src/Domain directory 
