<?php
// settings_privacy.php - Privacy settings section
?>
<div class="settings-section" id="privacy-section">
    <div class="settings-group">
        <h3 class="settings-group-title">Your Privacy</h3>
        
        <div class="info-card" style="background: #DCFCE7; border-color: #22C55E;">
            <div class="info-card-title" style="color: #166534;">Zero Data Retention</div>
            <div style="color: #166534; margin-top: 8px;">
                We process your text in real-time and immediately discard it. No logs, no storage, no exceptions.
            </div>
        </div>

        <h4 style="font-size: 14px; margin: 24px 0 16px 0;">Data Flow</h4>
        <ol style="margin-left: 20px; color: var(--text-secondary);">
            <li>Your text enters our secure processing pipeline</li>
            <li>AI analysis happens in isolated memory</li>
            <li>Results return to you instantly</li>
            <li>All data is permanently erased</li>
        </ol>
    </div>

    <div class="settings-group">
        <h3 class="settings-group-title">Compliance & Certifications</h3>
        
        <div class="help-grid">
            <div class="help-card">
                <div class="help-card-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <div class="help-card-title">GDPR Compliant</div>
                <div class="help-card-desc">EU privacy standards</div>
            </div>
        </div>
    </div>

    <div class="settings-group">
        <h3 class="settings-group-title">Legal Documents</h3>
        
        <div class="list-item">
            <div class="list-item-title">Privacy Policy</div>
            <a class="list-item-action" href="#" onclick="showSheet('privacy')">View</a>
        </div>
        
        <div class="list-item">
            <div class="list-item-title">Terms of Service</div>
            <a class="list-item-action" href="#" onclick="showSheet('terms')">View</a>
        </div>
        
        <div class="list-item">
            <div class="list-item-title">Data Processing Agreement</div>
            <a class="list-item-action" href="#" onclick="showSheet('dpa')">Download PDF</a>
        </div>
    </div>
</div>