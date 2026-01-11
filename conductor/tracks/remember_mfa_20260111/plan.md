# Plan: Add custom Remember Me option for Email Verification MFA

## Phase 1: Extension & UI Implementation
Extend the default Filament Email MFA provider to include the "Remember Me" option in the UI.

- [x] **Task: Create Custom MFA Provider** d86e0cd
    - [ ] Implementation Phase: Create `App\Auth\MultiFactor\CustomEmailAuthentication` extending the base provider and register it in `AdminPanelProvider.php`.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Write and run a test to ensure the custom provider is active.
- [x] **Task: Add "Remember Me" Checkbox to Form** 8c54106
    - [ ] Implementation Phase: Customize the MFA challenge form components to add the "Remember this device for 90 days" checkbox.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Write and run a feature test to verify the checkbox is visible on the MFA entry page.
- [ ] **Task: Conductor - User Manual Verification 'Extension & UI Implementation' (Protocol in workflow.md)**

## Phase 2: Cookie & Bypass Logic
Implement the backend logic to set the trusted device cookie and bypass MFA when it is present.

- [ ] **Task: Implement Cookie Setting Logic**
    - [ ] Implementation Phase: Update the MFA submission logic to set a secure, encrypted cookie for 90 days when the checkbox is selected and the code is valid.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Write and run a test to verify the cookie is correctly set after a successful MFA challenge.
- [ ] **Task: Implement MFA Bypass Check**
    - [ ] Implementation Phase: Update the provider logic to check for the presence and validity of the trusted device cookie before initiating the email code flow.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Write and run a test to verify that subsequent logins from the same "device" (browser with cookie) bypass the MFA challenge.
- [ ] **Task: Conductor - User Manual Verification 'Cookie & Bypass Logic' (Protocol in workflow.md)**

## Phase 3: Final Verification & Polish
Ensure the implementation aligns with security standards and project guidelines.

- [ ] **Task: Verify Security & Redirection**
    - [ ] Implementation Phase: Ensure the trusted device cookie is user-specific and properly encrypted. Verify redirection follows the project guidelines.
    - [ ] Cache Optimization Phase: Run `php artisan filament:optimize-clear && php artisan optimize:clear`.
    - [ ] Testing Phase: Run the full test suite to ensure 99% coverage.
- [ ] **Task: Conductor - User Manual Verification 'Final Verification & Polish' (Protocol in workflow.md)**
