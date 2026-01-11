# Plan: Profile page implementation

## Phase 1: Database & Model Preparation [checkpoint: 9c38414]
Prepare the underlying structure to support the new security features.

- [x] **Task: Add MFA column to Users table** 1ba73e9
    - [ ] Implementation Phase: Create and run a migration to add `has_email_authentication` (boolean, default false) to the `users` table.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Verify the column exists in the database schema.
- [x] **Task: Update User Model for MFA** a521b78
    - [ ] Implementation Phase: Update `User.php` to implement `HasEmailAuthentication` and use the `InteractsWithEmailAuthentication` trait.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Write a unit test to ensure the model correctly handles the MFA trait/interface.
- [x] **Task: Conductor - User Manual Verification 'Database & Model Preparation' (Protocol in workflow.md)**

## Phase 2: Filament Feature Activation
Enable the profile and multi-factor authentication features in the UI.

- [ ] **Task: Enable Profile & Email MFA in AdminPanelProvider**
    - [ ] Implementation Phase: Update `AdminPanelProvider.php` to enable the `profile()` feature and `multiFactorAuthentication()` with `EmailAuthentication::make()`.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Write a feature test to ensure the profile link is visible and the MFA settings are present.
- [ ] **Task: Conductor - User Manual Verification 'Filament Feature Activation' (Protocol in workflow.md)**

## Phase 3: Verification & Polish
Ensure the end-to-end security flow and user experience are seamless.

- [ ] **Task: Verify MFA Login Flow**
    - [ ] Implementation Phase: Ensure no further logic is needed for the email code challenge during login.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Perform a manual end-to-end test of enabling MFA and logging in with an email code.
- [ ] **Task: Verify Notifications & Redirection**
    - [ ] Implementation Phase: Confirm notifications and redirections match project guidelines.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Run full test suite to ensure 99% coverage.
- [ ] **Task: Conductor - User Manual Verification 'Verification & Polish' (Protocol in workflow.md)**
