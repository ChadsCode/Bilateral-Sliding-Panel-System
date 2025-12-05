// reflection-ui.js - Minimal UI handler for Reflection Loop
// No business logic - only UI updates

// Store references
let reflectionModal = null;
let originalText = '';
let textHash = '';
let highlightMarkers = [];

// Override analyze button behavior
document.addEventListener('DOMContentLoaded', function() {
    // Store the original processContent function
    if (window.processContent) {
        window.originalProcessContent = window.processContent;
        
        // Override with our version
        window.processContent = function() {
            const input = get_element('thoughtInput');
            const text = input.value.trim();
            
            if (!text) {
                show_notification('Please enter a message to analyze', 'warning');
                return;
            }
            
            // Show loading state
            showReflectionLoading();
            
            // Call server for detection
            checkForSensitiveData(text, function(result) {
                hideReflectionLoading();
                
                if (result.has_detections) {
                    showReflectionModal(result);
                } else {
                    // No detections, proceed normally
                    window.originalProcessContent();
                }
            });
        };
    }
});

// Check for sensitive data
function checkForSensitiveData(text, callback) {
    originalText = text;
    
    // Use XMLHttpRequest directly for better error handling
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/reflection_ajax.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    callback(response);
                } catch (e) {
                    console.error('Response was not JSON:', xhr.responseText);
                    // No detections, proceed normally
                    callback({ has_detections: false });
                }
            } else {
                console.error('Request failed:', xhr.status);
                // On error, proceed normally
                callback({ has_detections: false });
            }
        }
    };
    
    const params = 'action=detect&text=' + encodeURIComponent(text) + 
                   '&csrf_token=' + encodeURIComponent(getCSRFToken());
    xhr.send(params);
}

// Show loading state
function showReflectionLoading() {
    const btn = document.querySelector('.btn-executive.primary');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="btn-text">Checking...</span>';
    }
}

// Hide loading state
function hideReflectionLoading() {
    const btn = document.querySelector('.btn-executive.primary');
    if (btn) {
        btn.disabled = false;
        btn.innerHTML = '<span class="btn-text">Analyze</span>';
    }
}

// Show reflection modal
function showReflectionModal(detectionResult) {
    highlightMarkers = detectionResult.markers;
    
    // Build category summary HTML
    let summaryHTML = '';
    for (const [category, types] of Object.entries(detectionResult.categories)) {
        summaryHTML += `<div class="detection-category">`;
        summaryHTML += `<h5>${formatCategoryName(category)}</h5><ul>`;
        for (const [type, count] of Object.entries(types)) {
            summaryHTML += `<li>${count} ${type}${count > 1 ? 's' : ''}</li>`;
        }
        summaryHTML += `</ul></div>`;
    }
    
    // Create modal
    const modalHTML = `
        <div class="reflection-modal-overlay" id="reflectionModal">
            <div class="reflection-modal">
                <div class="reflection-header">
                    <h3>⚠️ Sensitive Information Detected</h3>
                    <button class="reflection-close" onclick="closeReflection()">×</button>
                </div>
                
                <div class="reflection-body">
                    <div class="detection-alert">
                        <strong>${detectionResult.count} potential PHI/PII item(s) found</strong>
                    </div>
                    
                    <div class="detection-summary">
                        ${summaryHTML}
                    </div>
                    
                    <div class="preview-section">
                        <h4>Your message with highlighted sensitive data:</h4>
                        <div class="text-preview" id="highlightedText">
                            ${createHighlightedPreview()}
                        </div>
                    </div>
                    
                    <div class="sanitized-section" id="sanitizedSection" style="display: none;">
                        <h4>Sanitized version (sensitive data removed):</h4>
                        <div class="text-preview sanitized" id="sanitizedText">
                            <div class="loading-sanitized">Preparing sanitized version...</div>
                        </div>
                    </div>
                    
                    <div class="reflection-notice">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        <p>This is a privacy protection feature. We do not store any data.</p>
                    </div>
                </div>
                
                <div class="reflection-footer">
                    <button class="btn-reflection secondary" onclick="closeReflection()">
                        Cancel
                    </button>
                    <button class="btn-reflection sanitize" onclick="previewSanitized()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v6m0 4v6m0 4v-2m-7-7h14"/>
                        </svg>
                        Preview Sanitized
                    </button>
                    <button class="btn-reflection warning" onclick="sendOriginal()">
                        Send with PHI/PII
                    </button>
                    <button class="btn-reflection safe" id="sendSanitizedBtn" style="display: none;" onclick="sendSanitized()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 11l3 3L22 4"/>
                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                        </svg>
                        Send Sanitized
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    reflectionModal = document.getElementById('reflectionModal');
    
    // Generate hash for verification
    generateTextHash(originalText);
}

// Create highlighted preview
function createHighlightedPreview() {
    let html = '';
    let lastEnd = 0;
    
    // Sort markers by start position
    const sortedMarkers = [...highlightMarkers].sort((a, b) => a.start - b.start);
    
    sortedMarkers.forEach(marker => {
        // Add text before marker
        html += escapeHtml(originalText.substring(lastEnd, marker.start));
        
        // Add highlighted text
        const highlightedText = originalText.substring(marker.start, marker.end);
        html += `<span class="phi-highlight" data-type="${marker.type}" data-category="${marker.category}">`;
        html += escapeHtml(highlightedText);
        html += `</span>`;
        
        lastEnd = marker.end;
    });
    
    // Add remaining text
    html += escapeHtml(originalText.substring(lastEnd));
    
    return html;
}

// Preview sanitized version
function previewSanitized() {
    const section = get_element('sanitizedSection');
    section.style.display = 'block';
    
    // Use XMLHttpRequest directly
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/reflection_ajax.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const result = JSON.parse(xhr.responseText);
                if (result.success) {
                    get_element('sanitizedText').textContent = result.sanitized;
                    get_element('sendSanitizedBtn').style.display = 'inline-flex';
                }
            } catch (e) {
                console.error('Sanitize response error:', xhr.responseText);
                get_element('sanitizedText').innerHTML = '<div class="loading-sanitized">Error preparing sanitized version</div>';
            }
        }
    };
    
    const params = 'action=confirm_sanitize&text=' + encodeURIComponent(originalText) + 
                   '&hash=' + encodeURIComponent(textHash) +
                   '&csrf_token=' + encodeURIComponent(getCSRFToken());
    xhr.send(params);
    
    section.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Send original with warning
function sendOriginal() {
    closeReflection();
    // Proceed with original analysis
    if (window.originalProcessContent) {
        window.originalProcessContent();
    }
}

// Send sanitized version
function sendSanitized() {
    const sanitizedText = get_element('sanitizedText').textContent;
    get_element('thoughtInput').value = sanitizedText;
    closeReflection();
    
    // Proceed with sanitized analysis
    if (window.originalProcessContent) {
        window.originalProcessContent();
    }
}

// Close modal
function closeReflection() {
    if (reflectionModal) {
        reflectionModal.remove();
        reflectionModal = null;
    }
    originalText = '';
    textHash = '';
    highlightMarkers = [];
}

// Helper functions
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatCategoryName(category) {
    const names = {
        'healthcare': 'Healthcare Information',
        'financial': 'Financial Data',
        'personal': 'Personal Identifiers',
        'legal': 'Legal Information',
        'digital': 'Digital Identifiers',
        'biometric': 'Biometric Data'
    };
    return names[category] || category;
}

function generateTextHash(text) {
    // Simple hash for client-side verification
    let hash = 0;
    for (let i = 0; i < text.length; i++) {
        const char = text.charCodeAt(i);
        hash = ((hash << 5) - hash) + char;
        hash = hash & hash;
    }
    textHash = Math.abs(hash).toString(36);
}

function getCSRFToken() {
    // Get from meta tag or hidden input
    return document.querySelector('meta[name="csrf-token"]')?.content || 
           document.querySelector('input[name="csrf_token"]')?.value || '';
}

// Handle escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && reflectionModal) {
        closeReflection();
    }
});