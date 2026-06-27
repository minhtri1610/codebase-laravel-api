# Backend API (Laravel 11)

This project uses Laravel 11 as a Headless API for a Next.js frontend.

## API Design Patterns & Best Practices

To maintain a clean, scalable, and standardized codebase, this API strictly adheres to the **"Fat Models, Skinny Controllers"** philosophy, leveraging the Action and Resource patterns.

### 1. Controllers (Skinny Controllers)
- **Rule:** Controllers must be extremely thin. They should NOT contain any business logic.
- **Responsibility:** Receive HTTP request -> Call an Action -> Return an API Resource.
- **Exceptions:** Do NOT use `try-catch` blocks inside controllers. Let the Global Exception Handler handle and format exceptions automatically.

### 2. Actions (Business Logic)
- **Rule:** All core business logic goes into single-responsibility Action classes in `app/Actions`.
- **Pattern:** Use the `__invoke` magic method to make the action class callable like a function (e.g., `$action($data)`).
- **Example:** `LoginAction`, `RegisterAction`.

### 3. API Resources (Transformers)
- **Rule:** Never return raw Eloquent Models directly from controllers.
- **Responsibility:** Use `app/Http/Resources` to map Eloquent models to a standardized JSON structure. Hide sensitive fields and convert `snake_case` column names to `camelCase` to match JavaScript/Next.js conventions (e.g., `email_verified_at` -> `emailVerifiedAt`).

### 4. Form Requests (Validation)
- **Rule:** Do NOT validate data in controllers.
- **Responsibility:** Use Form Requests (`app/Http/Requests`) to validate incoming data before it even reaches the controller.

### 5. Standardized JSON Responses (ApiResponse Trait)
- **Rule:** All API responses must follow a consistent structure.
- **Implementation:** Controllers use `App\Traits\ApiResponse` which provides `successResponse` and `errorResponse`. This guarantees every API response has `success`, `message`, and `data`/`errors` keys.

### 6. Global Exception Handling
- **Rule:** API errors (401 Unauthenticated, 422 Validation Error, 500 Server Error) are automatically caught and formatted.
- **Location:** See `bootstrap/app.php`. The `$exceptions->render()` closure intercepts and formats errors uniformly for all `api/*` routes.

### 7. Authentication
- **Driver:** Laravel Sanctum.
- **Mechanism:** Token-based authentication using Bearer tokens (via `createToken('api_token')->plainTextToken`).
