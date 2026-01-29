# Security Implementation Report - Los Pawlos Hermanos

This document outlines the security measures implemented in the **Los Pawlos Hermanos** e-commerce application to ensure data integrity, user privacy, and protection against common web vulnerabilities.

## 1. Authentication & Authorization
- **Laravel Sanctum Integrated**: Secure API authentication using Personal Access Tokens with distinct **abilities** (e.g., `admin` vs `read`).
- **Role-Based Access Control (RBAC)**: Users are assigned roles (`customer`, `admin`). Middleware like `ability:admin` protects sensitive administrative routes.
- **Google OAuth (Socialite)**: Secure third-party authentication reduces the need for users to manage multiple passwords, lowering the risk of credential stuffing attacks.

## 2. Protection Against Common Threats
- **SQL Injection (SQLi)**: 
    - **Parameterized Queries**: All database interactions use Eloquent ORM or DB bindings.
    - **Proof of Fix**: The `/api/vuln-sql` route was explicitly fixed to use `DB::select("... WHERE email = ?", [$email])` to demonstrate mastery over SQLi prevention.
- **Cross-Site Request Forgery (CSRF)**: All state-changing web routes are protected by Laravel's built-in CSRF middleware.
- **Cross-Site Scripting (XSS)**: Blade templating engine automatically escapes output using `{{ }}` syntax.
- **Password Hashing**: Passwords stored using the **BCRYPT** algorithm via Laravel's `Hash::make()`.

## 3. Data Integrity & Secure Payments
- **Database Transactions**: All financial operations (Order creation) are wrapped in `DB::beginTransaction()`. If any part of the order process fails (e.g., item creation, stock decrement), the entire operation rolls back to prevent "ghost orders."
- **Stripe API Integration**: Payment processing is offloaded to Stripe's secure infrastructure. Credit card details never touch our local database, ensuring PCI compliance.
- **Input Validation**: Strict server-side validation on all forms (Registration, Product Create/Edit, Checkout) to prevent malicious data entry.

## 4. API Security
- **Token Scopes**: Tokens issued via `/api/login` are restricted to specific capabilities based on the user's database role.
- **Stateful Protection**: Standard web routes use session-based authentication, while API routes are stateless and strictly require a `Bearer` token.

## 5. Deployment Considerations
- **Environment Management**: Sensitive keys (Stripe, Google, Database) are stored in `.env` and excluded from source control.
- **SSL/TLS**: (To be implemented upon hosting) The app is designed to require HTTPS for Google OAuth and Stripe webhooks.
