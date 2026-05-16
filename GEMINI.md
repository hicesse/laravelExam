<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.5
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- phpunit/phpunit (PHPUNIT) - v12

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
    - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== phpunit/core rules ===

# PHPUnit

- This application uses PHPUnit for testing. All tests must be written as PHPUnit classes. Use `php artisan make:test --phpunit {name}` to create a new test.
- If you see a test using "Pest", convert it to PHPUnit.
- Every time a test has been updated, run that singular test.
- When the tests relating to your feature are passing, ask the user if they would like to also run the entire test suite to make sure everything is still passing.
- Tests should cover all happy paths, failure paths, and edge cases.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files; these are core to the application.

## Running Tests

- Run the minimal number of tests, using an appropriate filter, before finalizing.
- To run all tests: `php artisan test --compact`.
- To run all tests in a file: `php artisan test --compact tests/Feature/ExampleTest.php`.
- To filter on a particular test name: `php artisan test --compact --filter=testName` (recommended after making a change to a related file).

=== project specific rules ===

# Tax Calculation Application Rules

## Main Objective

Build a Laravel 13 web application for PT. XYZ to calculate employee tax based on income using the provided tax rate table.

The application must:

- use Laravel conventions
- use Query Builder for tax lookup logic
- use Middleware for validation
- use Blade for the UI
- use Tailwind CSS for styling
- use migration and seeder for database setup
- avoid hardcoded tax logic in controller

The UI should:

- look clean and modern
- use responsive Tailwind layouts
- center the tax form properly
- display validation errors clearly
- display calculation result clearly
- use proper spacing, rounded corners, and readable typography

---

# Database Requirements

## Table: tax_rates

The application must create a `tax_rates` table using migration.

Required columns:

- id
- income_from (bigInteger)
- income_to (bigInteger)
- percentage (decimal(5,2))
- timestamps

Example migration structure:

- income_from represents minimum income
- income_to represents maximum income
- percentage represents tax percentage

---

# Tax Rate Dataset

The AI agent MUST insert the following tax rate data into the database using seeder.

| income_from | income_to    | percentage |
| ----------- | ------------ | ---------- |
| 0           | 5400000      | 0.00       |
| 5400000     | 5650000      | 0.25       |
| 5650000     | 5950000      | 0.50       |
| 5950000     | 6300000      | 0.75       |
| 6300000     | 6750000      | 1.00       |
| 6750000     | 7500000      | 1.25       |
| 7500000     | 8550000      | 1.50       |
| 8550000     | 9650000      | 1.75       |
| 9650000     | 10050000     | 2.00       |
| 10050000    | 10350000     | 2.25       |
| 10350000    | 10700000     | 2.50       |
| 10700000    | 11050000     | 3.00       |
| 11050000    | 11600000     | 3.50       |
| 11600000    | 12500000     | 4.00       |
| 12500000    | 13750000     | 5.00       |
| 13750000    | 15100000     | 6.00       |
| 15100000    | 16950000     | 7.00       |
| 16950000    | 19750000     | 8.00       |
| 19750000    | 24150000     | 9.00       |
| 24150000    | 999999999999 | 30.00      |

---

# Seeder Rules

The AI agent MUST:

- create a dedicated seeder for tax_rates
- insert all provided tax bracket data
- use bulk insert array format
- avoid inserting data manually in controller
- avoid hardcoded arrays inside routes

Seeder should safely refresh data:

- optionally truncate old records before insert
- prevent duplicated tax brackets

Preferred approach:

- DB::table('tax_rates')->truncate();
- DB::table('tax_rates')->insert([...]);

## Table: tax_rates

The application must create a `tax_rates` table using migration.

Required columns:

- id
- income_from (bigInteger)
- income_to (bigInteger)
- percentage (decimal)
- timestamps

Example structure:

| income_from | income_to | percentage |
| ----------- | --------- | ---------- |
| 0           | 5400000   | 0.00       |
| 5400000     | 5650000   | 0.25       |
| 5650000     | 5950000   | 0.50       |

Continue until all provided tax ranges are inserted.

---

# Seeder Rules

The tax rate data MUST be inserted using a seeder.

Do not manually insert data from controller or route.

Seeder should:

- truncate old data safely if needed
- insert all tax ranges from the case study
- use array insert for efficiency

---

# SQL Logic Rules

The tax lookup query must:

- find the matching tax bracket using employee income
- use optimized WHERE conditions
- return only one matching row

Expected logic example:

SELECT percentage
FROM tax_rates
WHERE income >= income_from
AND income <= income_to
LIMIT 1;

Laravel implementation must use Query Builder.

---

# Controller Rules

Create a TaxController.

Controller responsibilities:

- receive validated income input
- retrieve matching tax percentage from database
- calculate tax result
- return result to Blade view

Formula:

tax = income \* (percentage / 100)

Example:

- income = 5800000
- percentage = 0.50
- result = 29000

Do not place validation logic directly inside controller if middleware already handles it.

---

# Middleware Rules

Create custom middleware for validating:

- numeric input
- positive value
- non-empty input

If validation fails:

- redirect back
- send error message using session

Middleware must run before controller execution.

Hint:

- use is_numeric()
- ensure value > 0

---

# Route Rules

Use:

- GET /calculate
- POST /calculate

Both routes must:

- point to controller
- use middleware

Prefer named routes.

---

# Blade View Rules

View name:

- calculate.blade.php

UI requirements:

- income input field
- calculate button
- tax result display
- validation error display

Blade must:

- preserve old input
- display session errors properly

---

# Code Quality Rules

The AI agent must:

- follow Laravel 13 conventions
- use clear naming
- avoid duplicated logic
- avoid hardcoded percentages
- separate concerns properly
- keep code readable and beginner friendly

---

# Testing Considerations

The AI agent should ensure:

- negative input fails
- text input fails
- empty input fails
- valid income calculates correctly
- correct percentage bracket is selected

---

# Expected Deliverables

The AI agent should generate:

- migration
- seeder
- middleware
- controller
- Blade view
- routes
- optional feature test if appropriate
  </laravel-boost-guidelines>
