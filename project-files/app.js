// app.js - Core functionality for ToneAnalysis

// Get DOM elements
function get_element(id) {
    return document.getElementById(id);
}

// AJAX helper
function ajax_post(action, data, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'process.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                callback(response);
            } catch (e) {
                console.error('JSON parse error:', e);
                show_notification('Error processing response', 'error');
            }
        }
    };
    
    const params = 'action=' + action + '&' + 
                   Object.keys(data).map(k => k + '=' + encodeURIComponent(data[k])).join('&');
    xhr.send(params);
}

// Show notification
function show_notification(message, type) {
    const notification = document.createElement('div');
    notification.className = 'notification notification-' + type;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(function() { notification.classList.add('show'); }, 10);
    setTimeout(function() {
        notification.classList.remove('show');
        setTimeout(function() { notification.remove(); }, 300);
    }, 3000);
}

// Update word count
function update_word_count() {
    const text = get_element('thoughtInput').value;
    const words = text.trim().split(/\s+/).filter(function(w) { return w.length > 0; }).length;
    get_element('wordCount').textContent = words;
}

// Clear content - updated to hide results
function clearContent() {
    if (confirm('Clear all content?')) {
        get_element('thoughtInput').value = '';
        get_element('resultsSection').style.display = 'none';
        get_element('wordCount').textContent = '0';
        // Scroll back to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// Copy content
function copyContent() {
    const text = get_element('thoughtInput').value;
    if (!text) {
        show_notification('Nothing to copy', 'warning');
        return;
    }
    
    navigator.clipboard.writeText(text).then(function() {
        show_notification('Copied to clipboard', 'success');
    }).catch(function(err) {
        console.error('Copy failed:', err);
        show_notification('Copy failed', 'error');
    });
}

// Enhanced toggle panels function with gap fixes
function togglePanel(type) {
    const panel = get_element(type + 'Panel');
    if (panel) {
        panel.classList.toggle('active');
        
        // Hide/show tabs when panels open/close
        const isActive = panel.classList.contains('active');
        const toolboxTab = document.querySelector('.toolbox-tab');
        const settingsTab = document.querySelector('.settings-tab');
        const analysisTab = document.querySelector('.analysis-tab');
        
        if (isActive) {
            // Hide all tabs when any panel is open
            if (toolboxTab) toolboxTab.style.display = 'none';
            if (settingsTab) settingsTab.style.display = 'none';
            if (analysisTab) analysisTab.style.display = 'none';
        } else {
            // Show all tabs when panel closes
            if (toolboxTab) toolboxTab.style.display = 'block';
            if (settingsTab) settingsTab.style.display = 'block';
            if (analysisTab) analysisTab.style.display = 'block';
        }
    }
}

// Select tool function (NEW)
function selectTool(toolName) {
    // Update session
    ajax_post('select_tool', { tool: toolName }, function(response) {
        if (response.success) {
            // Update active tool in UI
            document.querySelectorAll('.tool-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Mark selected tool as active
            const selectedTool = document.querySelector(`[data-tool="${toolName}"]`);
            if (selectedTool) {
                selectedTool.classList.add('active');
            }
            
            // Handle tool-specific behavior
            switch(toolName) {
                case 'tone':
                    // For "Analyze Message" - this is the default premium dashboard
                    // Just close the toolbox panel, stay on current page
                    togglePanel('toolbox');
                    show_notification('Ready to analyze messages', 'success');
                    break;
                    
                case 'grammar':
                    // Switch to grammar tool interface
                    updateToolInterface('grammar');
                    break;
                    
                case 'chain':
                    // Switch to chain analysis interface
                    updateToolInterface('chain');
                    break;
                    
                case 'write':
                    // Switch to email writer interface
                    updateToolInterface('write');
                    break;
                    
                case 'reply':
                    // Switch to reply generator interface
                    updateToolInterface('reply');
                    break;
                    
                default:
                    show_notification('Tool selected: ' + toolName, 'info');
            }
        }
    });
}

// Update tool interface (NEW)
function updateToolInterface(toolName) {
    const tools = {
        'grammar': {
            title: 'Spelling • Grammar • Punctuation • Sentence Structure',
            placeholder: 'Paste your text here for instant improvement...',
            buttonText: 'ANALYZE'
        },
        'chain': {
            title: 'Email Chain Analysis',
            placeholder: 'Paste email conversation here to analyze emotional dynamics...',
            buttonText: 'ANALYZE CHAIN'
        },
        'write': {
            title: 'AI Email Writer',
            placeholder: 'Describe the email you need: "Professional follow-up to client about project delay"',
            buttonText: 'GENERATE EMAIL'
        },
        'reply': {
            title: 'Smart Reply Generator',
            placeholder: 'Paste the email you need to reply to...',
            buttonText: 'GENERATE REPLY'
        }
    };
    
    const tool = tools[toolName];
    if (tool) {
        // Update page title
        const titleElement = document.querySelector('.tool-title, .section-title');
        if (titleElement) {
            titleElement.textContent = tool.title;
        }
        
        // Update input placeholder
        const inputElement = document.querySelector('#thoughtInput, .executive-input');
        if (inputElement) {
            inputElement.placeholder = tool.placeholder;
        }
        
        // Update button text
        const buttonElement = document.querySelector('.btn-executive.primary .btn-text');
        if (buttonElement) {
            buttonElement.textContent = tool.buttonText;
        }
        
        // Close toolbox
        togglePanel('toolbox');
        
        show_notification(`Switched to ${tool.title}`, 'success');
    }
}

// Analysis panel functions
function pullContent() {
    const content = get_element('thoughtInput').value;
    get_element('analysisInput').value = content;
    show_notification('Content pulled', 'success');
}

function pushContent() {
    const content = get_element('analysisInput').value;
    get_element('thoughtInput').value = content;
    update_word_count();
    show_notification('Content pushed', 'success');
}

function runAnalysis() {
    const content = get_element('analysisInput').value || get_element('thoughtInput').value;
    
    if (!content) {
        show_notification('No content to analyze', 'warning');
        return;
    }
    
    ajax_post('analyze', { content: content }, function(response) {
        get_element('toneValue').textContent = response.tone || 'Professional';
        get_element('sentimentValue').textContent = response.sentiment || 'Neutral';
        get_element('readabilityValue').textContent = response.readability || 'Moderate';
        get_element('wordCount').textContent = response.word_count || '0';
        
        // Update sentiment indicator
        const indicator = get_element('sentimentIndicator');
        if (indicator) {
            indicator.className = 'sentiment-indicator sentiment-' + (response.sentiment || 'neutral').toLowerCase();
        }
    });
}

function generateReport() {
    show_notification('Report feature coming soon', 'info');
}

// Sheet functions
function showSheet(type) {
    ajax_post('get_sheet', { type: type }, function(response) {
        get_element('sheetTitle').textContent = type.charAt(0).toUpperCase() + type.slice(1);
        get_element('sheetContent').innerHTML = response.content || '<p>Content not found</p>';
        get_element('bottomSheet').classList.add('active');
    });
}

function closeSheet() {
    get_element('bottomSheet').classList.remove('active');
}

// Auto-resize textarea and update word count
document.addEventListener('DOMContentLoaded', function() {
    const input = get_element('thoughtInput');
    
    if (input) {
        input.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 400) + 'px';
            update_word_count();
        });
    }
});