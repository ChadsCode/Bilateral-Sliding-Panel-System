<?php
// settings_sections/context.php - Context settings section
?>
<div class="settings-section active" id="context-section">
    <div class="settings-group">
        <h3 class="settings-group-title">Analysis Context</h3>
        <p style="color: var(--text-secondary); margin-bottom: 20px;">
            Provide context to improve tone analysis accuracy. All information is processed locally and never stored.
        </p>

        <div class="form-group">
            <label class="form-label">Your Typical Communication Style</label>
            <select class="form-select" id="communicationStyle">
                <option value="">Select your typical style...</option>
                <option value="direct">Direct & Concise</option>
                <option value="diplomatic">Diplomatic & Careful</option>
                <option value="friendly">Friendly & Casual</option>
                <option value="formal">Formal & Professional</option>
                <option value="analytical">Analytical & Detailed</option>
            </select>
            <div class="form-helper">Helps detect deviations from your baseline</div>
        </div>

        <div class="form-group">
            <label class="form-label">Your Industry</label>
            <select class="form-select" id="industry">
                <option value="">Select your industry...</option>
                <?php include 'form_options/industries.php'; ?>
            </select>
            <div class="form-helper">Industry context helps interpret communication norms</div>
        </div>

        <div class="form-group">
            <label class="form-label">Your Role Level</label>
            <select class="form-select" id="roleLevel">
                <option value="">Select your level...</option>
                <?php include 'form_options/roles.php'; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Department</label>
            <select class="form-select" id="department">
                <option value="">Select your department...</option>
                <?php include 'form_options/departments.php'; ?>
            </select>
        </div>
    </div>

    <button class="btn btn-primary" onclick="saveContext()">Save Context Settings</button>
</div>