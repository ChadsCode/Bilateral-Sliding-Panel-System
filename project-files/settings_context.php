<?php
// settings_context.php - Context settings section with enhanced selectors
?>
<div class="settings-section active" id="context-section">
    <div class="settings-group">
        <h3 class="settings-group-title">Your Professional Profile</h3>
        <p style="color: var(--text-secondary); margin-bottom: 20px;">
            All fields are optional to enhance AI insights. Information is processed locally and never stored.
        </p>

        <div class="form-group">
            <label class="form-label">Your Typical Communication Style (Optional)</label>
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
            <label class="form-label">Your Industry (Optional)</label>
            <select class="form-select" id="industry">
                <option value="">Select your industry...</option>
                <optgroup label="Professional Services">
                    <option value="accounting">Accounting</option>
                    <option value="consulting">Consulting</option>
                    <option value="legal">Legal Services</option>
                    <option value="advertising">Advertising & Marketing</option>
                    <option value="architecture">Architecture & Engineering</option>
                </optgroup>
                <optgroup label="Financial Services">
                    <option value="banking">Banking</option>
                    <option value="insurance">Insurance</option>
                    <option value="investment">Investment Management</option>
                    <option value="real-estate">Real Estate</option>
                    <option value="fintech">Financial Technology</option>
                </optgroup>
                <optgroup label="Technology">
                    <option value="software">Software & SaaS</option>
                    <option value="hardware">Computer Hardware</option>
                    <option value="telecom">Telecommunications</option>
                    <option value="cybersecurity">Cybersecurity</option>
                    <option value="ai-ml">AI & Machine Learning</option>
                </optgroup>
                <optgroup label="Healthcare & Life Sciences">
                    <option value="healthcare">Healthcare Services</option>
                    <option value="pharma">Pharmaceuticals</option>
                    <option value="biotech">Biotechnology</option>
                    <option value="medical-devices">Medical Devices</option>
                    <option value="health-insurance">Health Insurance</option>
                </optgroup>
                <optgroup label="Manufacturing & Industry">
                    <option value="automotive">Automotive</option>
                    <option value="aerospace">Aerospace & Defense</option>
                    <option value="chemicals">Chemicals</option>
                    <option value="construction">Construction</option>
                    <option value="manufacturing">General Manufacturing</option>
                </optgroup>
                <optgroup label="Consumer & Retail">
                    <option value="retail">Retail</option>
                    <option value="ecommerce">E-commerce</option>
                    <option value="cpg">Consumer Packaged Goods</option>
                    <option value="hospitality">Hospitality & Tourism</option>
                    <option value="food-beverage">Food & Beverage</option>
                </optgroup>
                <optgroup label="Energy & Resources">
                    <option value="oil-gas">Oil & Gas</option>
                    <option value="renewable">Renewable Energy</option>
                    <option value="utilities">Utilities</option>
                    <option value="mining">Mining & Metals</option>
                </optgroup>
                <optgroup label="Media & Entertainment">
                    <option value="media">Media & Publishing</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="gaming">Gaming</option>
                    <option value="sports">Sports & Recreation</option>
                </optgroup>
                <optgroup label="Transportation & Logistics">
                    <option value="logistics">Logistics & Supply Chain</option>
                    <option value="transportation">Transportation</option>
                    <option value="airlines">Airlines</option>
                    <option value="shipping">Shipping & Maritime</option>
                </optgroup>
                <optgroup label="Other Sectors">
                    <option value="education">Education</option>
                    <option value="government">Government & Public Sector</option>
                    <option value="nonprofit">Non-profit</option>
                    <option value="agriculture">Agriculture</option>
                    <option value="other">Other</option>
                </optgroup>
            </select>
            <div class="form-helper">Industry context helps interpret communication norms</div>
        </div>

        <div class="form-group">
            <label class="form-label">Your Role Level (Optional)</label>
            <select class="form-select" id="roleLevel">
                <option value="">Select your level...</option>
                <optgroup label="Individual Contributors">
                    <option value="intern">Intern</option>
                    <option value="entry">Entry Level</option>
                    <option value="associate">Associate</option>
                    <option value="mid">Mid Level</option>
                    <option value="senior">Senior</option>
                    <option value="lead">Lead</option>
                    <option value="principal">Principal</option>
                </optgroup>
                <optgroup label="Management">
                    <option value="supervisor">Supervisor</option>
                    <option value="manager">Manager</option>
                    <option value="senior-manager">Senior Manager</option>
                    <option value="director">Director</option>
                    <option value="senior-director">Senior Director</option>
                    <option value="vp">Vice President</option>
                    <option value="svp">Senior Vice President</option>
                    <option value="evp">Executive Vice President</option>
                </optgroup>
                <optgroup label="Executive">
                    <option value="ceo">CEO</option>
                    <option value="cto">CTO</option>
                    <option value="cfo">CFO</option>
                    <option value="coo">COO</option>
                    <option value="cmo">CMO</option>
                    <option value="ciso">CISO</option>
                    <option value="other-c">Other C-Suite</option>
                </optgroup>
                <optgroup label="Other">
                    <option value="owner">Owner/Founder</option>
                    <option value="partner">Partner</option>
                    <option value="consultant">Consultant</option>
                    <option value="contractor">Contractor</option>
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Department (Optional)</label>
            <select class="form-select" id="department">
                <option value="">Select your department...</option>
                <optgroup label="Core Business">
                    <option value="executive">Executive/C-Suite</option>
                    <option value="operations">Operations</option>
                    <option value="strategy">Strategy & Planning</option>
                    <option value="business-dev">Business Development</option>
                </optgroup>
                <optgroup label="Revenue">
                    <option value="sales">Sales</option>
                    <option value="marketing">Marketing</option>
                    <option value="customer-success">Customer Success</option>
                    <option value="account-management">Account Management</option>
                    <option value="partnerships">Partnerships</option>
                </optgroup>
                <optgroup label="Product & Technology">
                    <option value="product">Product Management</option>
                    <option value="engineering">Engineering/Development</option>
                    <option value="design">Design/UX</option>
                    <option value="data">Data & Analytics</option>
                    <option value="it">IT/Technology</option>
                    <option value="security">Security</option>
                </optgroup>
                <optgroup label="Support Functions">
                    <option value="hr">Human Resources</option>
                    <option value="finance">Finance & Accounting</option>
                    <option value="legal">Legal & Compliance</option>
                    <option value="procurement">Procurement</option>
                    <option value="facilities">Facilities</option>
                </optgroup>
                <optgroup label="Specialized">
                    <option value="research">Research & Development</option>
                    <option value="quality">Quality Assurance</option>
                    <option value="risk">Risk Management</option>
                    <option value="supply-chain">Supply Chain</option>
                    <option value="communications">Communications/PR</option>
                </optgroup>
            </select>
        </div>
    </div>

    <!-- Behavioral Context Group -->
    <div class="settings-group">
        <h3 class="settings-group-title">Your Behavioral Profile</h3>
        <p style="color: var(--text-secondary); margin-bottom: 20px;">
            Understanding your approach helps Claude provide more personalized insights.
        </p>

        <div class="form-group">
            <label class="form-label">Conflict Approach (Optional)</label>
            <select class="form-select" id="conflictApproach">
                <option value="">How do you handle conflicts?</option>
                <option value="avoidant">Avoidant - sidesteps conflict</option>
                <option value="accommodating">Accommodating - yields often</option>
                <option value="competitive">Competitive - wins matter</option>
                <option value="collaborative">Collaborative - win-win seeker</option>
                <option value="compromising">Compromising - middle ground</option>
            </select>
            <div class="form-helper">Helps identify when messages might trigger your stress patterns</div>
        </div>

        <div class="form-group">
            <label class="form-label">Decision Making Style (Optional)</label>
            <select class="form-select" id="decisionStyle">
                <option value="">How do you make decisions?</option>
                <option value="analytical">Analytical - needs all data</option>
                <option value="intuitive">Intuitive - gut feeling</option>
                <option value="consensus">Consensus builder</option>
                <option value="directive">Directive - quick decisions</option>
            </select>
            <div class="form-helper">Helps tailor response strategies to your natural style</div>
        </div>

        <div class="form-group">
            <label class="form-label">Negotiation Authority (Optional)</label>
            <select class="form-select" id="negotiationAuthority">
                <option value="">Your typical decision authority...</option>
                <option value="none">No authority - must escalate</option>
                <option value="limited">Limited (< $10K)</option>
                <option value="moderate">Moderate ($10K-$100K)</option>
                <option value="significant">Significant ($100K-$1M)</option>
                <option value="full">Full authority</option>
            </select>
            <div class="form-helper">Helps gauge power dynamics in negotiations</div>
        </div>
    </div>

    <!-- Identity Context Group -->
    <div class="settings-group">
        <h3 class="settings-group-title">Identity Context</h3>
        <p style="color: var(--text-secondary); margin-bottom: 20px;">
            Optional information to help identify potential communication pattern biases.
        </p>

        <div class="form-group">
            <label class="form-label">Your Gender (Optional)</label>
            <select class="form-select" id="userGender" onchange="toggleOtherGender(this.value)">
                <option value="">-- Please select --</option>
                <option value="woman">Woman</option>
                <option value="man">Man</option>
                <option value="non-binary">Non-binary</option>
                <option value="transgender">Transgender</option>
                <option value="intersex">Intersex</option>
                <option value="prefer-not-to-say">Prefer not to say</option>
                <option value="other">Other (please specify)</option>
            </select>
            <div id="other-gender-container" style="display: none; margin-top: 10px;">
                <label class="form-label" for="other-gender">Please specify your gender (optional):</label>
                <input type="text" class="form-input" id="other-gender" name="other_gender" maxlength="100" placeholder="Your gender identity">
            </div>
            <div class="form-helper">Helps identify potential gender-based communication patterns</div>
        </div>

        <div class="toggle-group" style="margin-top: 24px;">
            <span class="toggle-label">This communication involves legal/compliance matters</span>
            <div class="toggle-switch" id="legalContext" onclick="toggleSwitch(this)"></div>
        </div>
        <div class="form-helper" style="margin-top: 8px;">Activates heightened analysis for regulatory considerations</div>
    </div>

    <button class="btn btn-primary" onclick="saveContext()">Save Context Settings</button>
    <p style="font-size: 12px; color: var(--text-muted); margin-top: 16px; text-align: center;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        All settings are stored locally in your browser only
    </p>
</div>

<script>
function toggleOtherGender(value) {
    const otherContainer = document.getElementById('other-gender-container');
    const otherInput = document.getElementById('other-gender');
    
    if (value === 'other') {
        otherContainer.style.display = 'block';
        otherInput.focus();
    } else {
        otherContainer.style.display = 'none';
        otherInput.value = '';
    }
}
</script>