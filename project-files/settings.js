// settings.js - Settings panel functionality with enhanced context saving

// Switch between settings sections
function switchSection(section) {
    // Update nav items
    const navItems = document.querySelectorAll('.settings-nav-item');
    navItems.forEach(item => {
        item.classList.remove('active');
        if (item.textContent.toLowerCase() === section) {
            item.classList.add('active');
        }
    });

    // Update sections
    const sections = document.querySelectorAll('.settings-section');
    sections.forEach(sec => {
        sec.classList.remove('active');
        sec.style.display = 'none';
    });
    
    const targetSection = get_element(section + '-section');
    if (targetSection) {
        targetSection.classList.add('active');
        targetSection.style.display = 'block';
    }
}

// Save context settings - ENHANCED
function saveContext() {
    const contextFields = [
        'communicationStyle',
        'industry',
        'roleLevel',
        'department',
        'conflictApproach',
        'decisionStyle',
        'negotiationAuthority',
        'userGender'
    ];
    
    // Save each field to localStorage
    contextFields.forEach(field => {
        const element = get_element(field);
        if (element && element.value) {
            localStorage.setItem(field, element.value);
        }
    });
    
    // Handle custom gender input
    const genderSelect = get_element('userGender');
    if (genderSelect && genderSelect.value === 'other') {
        const otherGender = get_element('other-gender');
        if (otherGender && otherGender.value) {
            localStorage.setItem('userGenderOther', otherGender.value);
        }
    } else {
        localStorage.removeItem('userGenderOther');
    }
    
    // Handle legal context toggle
    const legalToggle = get_element('legalContext');
    if (legalToggle) {
        localStorage.setItem('legalContext', legalToggle.classList.contains('active'));
    }
    
    // Also save to session via AJAX for server-side processing
    const context = {};
    contextFields.forEach(field => {
        const element = get_element(field);
        if (element) {
            context[field] = element.value;
        }
    });
    
    // Add custom gender if applicable
    if (context.userGender === 'other') {
        context.userGenderOther = get_element('other-gender').value;
    }
    
    // Add legal context
    context.legalContext = get_element('legalContext').classList.contains('active');
    
    ajax_post('save_context', context, function(response) {
        if (response.success) {
            show_notification('Context settings saved successfully', 'success');
            
            // Close settings panel after save
            setTimeout(function() {
                togglePanel('settings');
            }, 1500);
        } else {
            show_notification('Failed to save settings', 'error');
        }
    });
}

// Update account info
function updateAccountInfo() {
    const data = {
        email: get_element('accountEmail').value,
        username: get_element('accountUsername').value
    };
    
    if (!data.email || !data.username) {
        show_notification('Please fill in all fields', 'warning');
        return;
    }
    
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(data.email)) {
        show_notification('Please enter a valid email address', 'warning');
        return;
    }
    
    ajax_post('update_account', data, function(response) {
        if (response.success) {
            show_notification('Account updated successfully', 'success');
        } else {
            show_notification('Failed to update account', 'error');
        }
    });
}

// Update password
function updatePassword() {
    const current = get_element('currentPassword').value;
    const newPass = get_element('newPassword').value;
    const confirm = get_element('confirmPassword').value;
    
    if (!current || !newPass || !confirm) {
        show_notification('Please fill in all password fields', 'warning');
        return;
    }
    
    if (newPass !== confirm) {
        show_notification('New passwords do not match', 'error');
        return;
    }
    
    if (newPass.length < 8) {
        show_notification('Password must be at least 8 characters', 'warning');
        return;
    }
    
    // Check password strength
    const hasNumber = /\d/.test(newPass);
    const hasLetter = /[a-zA-Z]/.test(newPass);
    if (!hasNumber || !hasLetter) {
        show_notification('Password must contain both letters and numbers', 'warning');
        return;
    }
    
    ajax_post('update_password', {
        current: current,
        new: newPass
    }, function(response) {
        if (response.success) {
            show_notification('Password updated successfully', 'success');
            // Clear fields
            get_element('currentPassword').value = '';
            get_element('newPassword').value = '';
            get_element('confirmPassword').value = '';
        } else {
            show_notification('Current password is incorrect', 'error');
        }
    });
}

// Toggle switch helper
function toggleSwitch(element) {
    element.classList.toggle('active');
    const isActive = element.classList.contains('active');
    
    // Handle specific toggles
    if (element.id === 'twoFactorToggle') {
        ajax_post('toggle_2fa', { enabled: isActive }, function(response) {
            if (response.success) {
                show_notification('Two-factor authentication ' + (isActive ? 'enabled' : 'disabled'), 'success');
            }
        });
    } else if (element.id === 'legalContext') {
        // Just save the state locally
        localStorage.setItem('legalContext', isActive);
    }
}

// Account actions
function pauseAccount() {
    if (confirm('Are you sure you want to pause your account? You can reactivate it at any time.')) {
        ajax_post('pause_account', {}, function(response) {
            if (response.success) {
                show_notification('Account paused. Check your email for reactivation instructions.', 'success');
                setTimeout(function() {
                    window.location.href = '/paused';
                }, 2000);
            }
        });
    }
}

function deleteAccount() {
    const confirmText = prompt('This will permanently delete your account and all data. Type DELETE to confirm:');
    
    if (confirmText === 'DELETE') {
        ajax_post('delete_account', {}, function(response) {
            if (response.success) {
                window.location.href = '/goodbye';
            }
        });
    } else if (confirmText !== null) {
        show_notification('Account deletion cancelled', 'info');
    }
}

// Toggle other gender input
function toggleOtherGender(value) {
    const otherContainer = get_element('other-gender-container');
    const otherInput = get_element('other-gender');
    
    if (value === 'other') {
        otherContainer.style.display = 'block';
        otherInput.focus();
    } else {
        otherContainer.style.display = 'none';
        otherInput.value = '';
    }
}

// Initialize settings on load
document.addEventListener('DOMContentLoaded', function() {
    // Load saved context values if on settings page
    const contextSection = get_element('context-section');
    if (contextSection) {
        const contextFields = [
            'communicationStyle',
            'industry', 
            'roleLevel',
            'department',
            'conflictApproach',
            'decisionStyle',
            'negotiationAuthority',
            'userGender'
        ];
        
        contextFields.forEach(field => {
            const savedValue = localStorage.getItem(field);
            if (savedValue) {
                const element = get_element(field);
                if (element) {
                    element.value = savedValue;
                    
                    // Handle gender other display
                    if (field === 'userGender' && savedValue === 'other') {
                        toggleOtherGender('other');
                        const otherValue = localStorage.getItem('userGenderOther');
                        if (otherValue) {
                            get_element('other-gender').value = otherValue;
                        }
                    }
                }
            }
        });
        
        // Load legal context toggle
        const legalContext = localStorage.getItem('legalContext');
        if (legalContext === 'true') {
            const legalToggle = get_element('legalContext');
            if (legalToggle) {
                legalToggle.classList.add('active');
            }
        }
    }
    
    // Initialize settings sections - show HELP by default
    const helpSection = get_element('help-section');
    if (helpSection) {
        // Hide all sections first
        document.querySelectorAll('.settings-section').forEach(section => {
            section.classList.remove('active');
            section.style.display = 'none';
        });
        
        // Show help section
        helpSection.classList.add('active');
        helpSection.style.display = 'block';
    }
});