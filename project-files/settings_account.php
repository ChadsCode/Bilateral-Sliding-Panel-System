<?php
// settings_account.php - Account settings section
?>
<div class="settings-section" id="account-section">
    <div class="settings-group">
        <h3 class="settings-group-title">Account Information</h3>

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-input" id="accountEmail" value="">
        </div>

        <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" class="form-input" id="accountUsername" value="">
        </div>

        <button class="btn btn-primary" onclick="updateAccountInfo()">Update Account Info</button>
    </div>

    <div class="settings-group">
        <h3 class="settings-group-title">Security</h3>

        <div class="form-group">
            <label class="form-label">Current Password</label>
            <input type="password" class="form-input" id="currentPassword">
        </div>

        <div class="form-group">
            <label class="form-label">New Password</label>
            <input type="password" class="form-input" id="newPassword">
        </div>

        <div class="form-group">
            <label class="form-label">Confirm New Password</label>
            <input type="password" class="form-input" id="confirmPassword">
        </div>

        <button class="btn btn-primary" onclick="updatePassword()">Update Password</button>

        <div class="toggle-group" style="margin-top: 24px;">
            <span class="toggle-label">Two-Factor Authentication</span>
            <div class="toggle-switch" id="twoFactorToggle" onclick="toggleSwitch(this)"></div>
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label class="form-label">Security Question</label>
            <select class="form-select">
                <option value="">Select a security question..</option>
                <option value="pet">What was your first pet's name?</option>
                <option value="school">What elementary school did you attend?</option>
                <option value="city">In what city were you born?</option>
                <option value="mother">What is your mother's maiden name?</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Security Answer</label>
            <input type="text" class="form-input">
        </div>
    </div>

    <div class="settings-group">
        <h3 class="settings-group-title">Login History</h3>
        <div class="list-item">
            <div>
                <div class="list-item-title">Device</div>
                <div class="list-item-meta">Your Location • 2 hours ago</div>
            </div>
            <span class="list-item-action">Current</span>
        </div>
        <div class="list-item">
            <div>
                <div class="list-item-title">Device</div>
                <div class="list-item-meta">Your Location • Time</div>
            </div>
            <a class="list-item-action">Revoke</a>
        </div>
    </div>

    <div class="settings-group">
        <h3 class="settings-group-title">Account Management</h3>
        
        <div class="alert alert-warning">
            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong>Privacy First</strong><br>
                We store zero user data. Your account only contains login credentials.
            </div>
        </div>

        <div class="btn-group">
            <button class="btn btn-warning" onclick="pauseAccount()">Pause Account</button>
            <button class="btn btn-danger" onclick="deleteAccount()">Delete Account</button>
        </div>
    </div>
</div>