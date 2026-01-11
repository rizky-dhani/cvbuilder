# Track Spec: Profile page implementation

## Overview
This track implements the official Filament user profile feature, allowing users to manage their personal information and security settings. Crucially, it enables Email-based Multi-Factor Authentication (MFA) as the primary security layer.

## Objectives
- Enable the built-in Filament "Edit Profile" feature in the `AdminPanel`.
- Allow users to update their name and email address.
- Provide a secure interface for users to change their account password.
- **Implement Email-based Multi-Factor Authentication (MFA).**

## Technical Requirements

### 1. Database Schema
- **Users Table:** Add a `has_email_authentication` (boolean, default: false) column to the `users` table via a new migration.

### 2. User Model
- Implement the `Filament\Models\Contracts\HasEmailAuthentication` interface.
- Use the `Filament\Models\Concerns\InteractsWithEmailAuthentication` trait.

### 3. Filament Configuration (`AdminPanelProvider`)
- **Profile Feature:** Enable `profile()` on the `AdminPanel`.
- **MFA Feature:** 
    - Enable `multiFactorAuthentication()` in the panel configuration.
    - Register `EmailAuthentication::make()` as the MFA method.

### 4. Out of Scope
- Authenticator app (TOTP) based MFA.
- Avatar uploads.

## Acceptance Criteria
- A "Profile" link is visible in the Filament user menu.
- Users can successfully update their name and email.
- Users can successfully change their password.
- **Users can enable and disable Email-based MFA from their profile.**
- **When MFA is enabled, users must provide a code sent to their email during login.**
- All operations provide success notifications following the "(resource) successfully (action)" format.
- Users are redirected back to the index page after successful updates.
