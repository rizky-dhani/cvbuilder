# Track Spec: Add custom Remember Me option for Email Verification MFA

## Overview
This track enhances the Email-based Multi-Factor Authentication (MFA) flow by adding a "Remember Me" option. This allows users to trust their current device/browser for a specified duration (90 days), bypassing the MFA code requirement on subsequent logins from that same device.

## Objectives
- Add a "Remember this device for 90 days" checkbox to the Filament MFA code entry page.
- Implement logic to set a secure, encrypted cookie when the checkbox is selected and the code is valid.
- Update the MFA challenge logic to check for the presence and validity of this cookie, bypassing the email code if found.

## Technical Requirements

### 1. UI Components
- **MFA Challenge Page:** Modify the existing Filament MFA code entry form to include a checkbox labeled "Remember this device for 90 days".

### 2. Implementation Details
- **Cookie Management:**
    - Name: `filament_mfa_trusted_device` (or similar).
    - Duration: 90 days.
    - Security: Secure, HttpOnly, SameSite=Lax, and encrypted.
- **Bypass Logic:**
    - Before triggering the MFA code email, check for the trusted device cookie.
    - If the cookie is present and valid for the current user, bypass the MFA challenge and proceed to the dashboard.

### 3. Out of Scope
- Management interface for users to "forget" or list trusted devices (to be handled in a future track).
- Database-backed device tracking (using cookie-only approach for this track).

## Acceptance Criteria
- A "Remember this device for 90 days" checkbox is visible on the MFA code entry page.
- Selecting the checkbox and entering a valid code allows the user to log in and sets the trusted device cookie.
- Logging out and logging back in on the same browser (within 90 days) bypasses the MFA code request.
- Deleting the cookie or using a different browser/device correctly triggers the MFA code request again.
- All operations provide success notifications following the "(resource) successfully (action)" format where applicable.
