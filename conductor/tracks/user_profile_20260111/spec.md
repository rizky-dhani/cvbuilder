# Track Spec: Build the Core User Profile & Master Record System

## Overview
This track focuses on establishing the core data foundation for the CV Builder. It uses Laravel Filament for authentication and the main administrative/management dashboard, while implementing custom Eloquent models and migrations for storing comprehensive career data.

## Objectives
- Install and configure Filament v4.
- Setup MySQL database connection (as per tech stack).
- Implement the "Master Record" data structure.
- Provide a management interface for users to enter their data.

## Technical Requirements

### 1. Authentication & Dashboard (Filament)
- **Panel:** Create a Filament panel (e.g., `AppPanel`) to serve as the user dashboard.
- **Authentication:** Utilize Filament's built-in authentication features.
- **Access Control:** Ensure users can only see and manage their own records.

### 2. Database Schema (Master Record System)

#### `work_experiences`
- `id` (primary key)
- `user_id` (foreign key to `users`)
- `company` (string, required)
- `position` (string, required)
- `location` (string, optional)
- `start_date` (date, required)
- `end_date` (date, nullable)
- `is_current` (boolean, default false)
- `description` (text, optional)
- `timestamps`

#### `educations`
- `id` (primary key)
- `user_id` (foreign key to `users`)
- `institution` (string, required)
- `degree` (string, required)
- `field_of_study` (string, optional)
- `start_date` (date, required)
- `end_date` (date, nullable)
- `description` (text, optional)
- `timestamps`

#### `skills`
- `id` (primary key)
- `user_id` (foreign key to `users`)
- `name` (string, required)
- `level` (string: Beginner, Intermediate, Advanced, Expert)
- `category` (string: Technical, Soft, Language, etc.)
- `timestamps`

#### `certifications`
- `id` (primary key)
- `user_id` (foreign key to `users`)
- `name` (string, required)
- `issuer` (string, required)
- `issue_date` (date, required)
- `expiry_date` (date, nullable)
- `url` (string, optional)
- `timestamps`

### 3. Filament Resources
- Create Resources for `WorkExperience`, `Education`, `Skill`, and `Certification`.
- Each resource must:
    - Scope queries to the authenticated user.
    - Automatically associate new records with the authenticated user.
    - Provide appropriate form fields (dates, rich text for descriptions, selects for skill levels).

### 4. Quality Standards
- **Testing:** 99% coverage for all models, controllers (resources), and logic using Pest.
- **TDD:** Write tests before implementation for each custom model and resource.
- **Validation:** Strict validation in Filament Forms and via FormRequests if applicable.
