<?php
// settings_panel.php - Settings panel component
?>

<div class="settings-tab" onclick="togglePanel('settings')">SETTINGS</div>

<div class="settings-panel" id="settingsPanel">
    <div class="panel-header">
        <h2 class="panel-title">Settings</h2>
        <button class="panel-close" onclick="togglePanel('settings')">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <div class="settings-nav">
        <div class="settings-nav-item active" onclick="switchSection('context')">Context</div>
        <div class="settings-nav-item" onclick="switchSection('account')">Account</div>
        <div class="settings-nav-item" onclick="switchSection('billing')">Billing</div>
        <div class="settings-nav-item" onclick="switchSection('privacy')">Privacy</div>
        <div class="settings-nav-item" onclick="switchSection('help')">Help</div>
    </div>

    <div class="settings-content">
        <?php 
        // Check if sections exist as separate files first
        if (file_exists('settings_sections/context.php')) {
            include 'settings_sections/context.php';
        } else {
            // Inline fallback
            include 'settings_context.php';
        }
        
        if (file_exists('settings_sections/account.php')) {
            include 'settings_sections/account.php';
        } else {
            include 'settings_account.php';
        }
        
        if (file_exists('settings_sections/billing.php')) {
            include 'settings_sections/billing.php';
        } else {
            include 'settings_billing.php';
        }
        
        if (file_exists('settings_sections/privacy.php')) {
            include 'settings_sections/privacy.php';
        } else {
            include 'settings_privacy.php';
        }
        
        if (file_exists('settings_sections/help.php')) {
            include 'settings_sections/help.php';
        } else {
            include 'settings_help.php';
        }
        ?>
    </div>
</div>