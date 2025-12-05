// premium.js - Premium dashboard functionality with enhanced context

// Process content with full context
function processContent() {
    const input = get_element('thoughtInput');
    const content = input.value.trim();
    
    if (!content) {
        show_notification('Please enter a message to analyze', 'warning');
        return;
    }
    
    // Gather all context from all bars and settings
    const context = {
        // Communication Context Bar
        direction: get_element('messageDirection').value,
        message_channel: get_element('messageChannel').value,
        person_role: get_element('personRole').value,
        situation: get_element('currentSituation').value,
        
        // Relationship Context Bar
        relationship_duration: get_element('relationshipDuration').value,
        last_interaction: get_element('lastInteraction').value,
        their_timezone: get_element('theirTimezone').value,
        
        // Message Context Bar
        current_stakes: get_element('currentStakes').value,
        their_company_size: get_element('theirCompanySize').value,
        their_communication_style: get_element('theirCommunicationStyle').value,
        
        // From settings (stored in localStorage)
        communication_style: localStorage.getItem('communicationStyle') || '',
        industry: localStorage.getItem('industry') || '',
        role_level: localStorage.getItem('roleLevel') || '',
        department: localStorage.getItem('department') || '',
        conflict_approach: localStorage.getItem('conflictApproach') || '',
        decision_style: localStorage.getItem('decisionStyle') || '',
        negotiation_authority: localStorage.getItem('negotiationAuthority') || '',
        user_gender: localStorage.getItem('userGender') || '',
        user_gender_other: localStorage.getItem('userGenderOther') || '',
        legal_context: localStorage.getItem('legalContext') === 'true'
    };
    
    // Show loading state - FIXED: Find the button properly
    const btn = document.querySelector('.btn-executive.primary');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="btn-text">Analyzing...</span>';
    }
    
    // Hide placeholder, show results
    const placeholder = get_element('resultsPlaceholder');
    const resultsContent = get_element('resultsContent');
    if (placeholder) placeholder.style.display = 'none';
    if (resultsContent) resultsContent.style.display = 'block';
    
    // Call API with context
    ajax_post('analyze_premium', {
        content: content,
        context: context
    }, function(response) {
        // Re-enable button
        const btn = document.querySelector('.btn-executive.primary');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<span class="btn-text">Analyze</span>';
        }
        
        if (response.success) {
            displayResults(response.analysis);
            
            // Smooth scroll to results
            setTimeout(function() {
                get_element('resultsSection').scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }, 100);
        } else {
            show_notification('Analysis failed. Please try again.', 'error');
            // Re-show placeholder on failure
            if (placeholder) placeholder.style.display = 'block';
            if (resultsContent) resultsContent.style.display = 'none';
        }
    });
}

// Display comprehensive results
function displayResults(analysis) {
    // Quick stats
    get_element('sentimentValue').textContent = analysis.sentiment || 'Neutral';
    get_element('emotionValue').textContent = analysis.dominant_emotion || 'Professional';
    get_element('powerValue').textContent = analysis.power_position || 'Balanced';
    get_element('dealValue').textContent = analysis.deal_temperature || 'Moderate';
    
    // Executive summary
    get_element('executiveSummary').innerHTML = formatExecutiveSummary(analysis.executive_summary);
    
    // Emotion grid
    displayEmotionGrid(analysis.emotions);
    
    // Strategic insights
    get_element('strategicInsights').innerHTML = formatStrategicInsights(analysis.strategic);
    
    // Language analysis
    get_element('languageAnalysis').innerHTML = formatLanguageAnalysis(analysis.language);
    
    // Show suggested response section
    const suggestedResponse = get_element('suggestedResponse');
    if (suggestedResponse) {
        suggestedResponse.style.display = 'block';
    }
}

// Format executive summary with highlighting
function formatExecutiveSummary(summary) {
    let html = '<div class="summary-section">';
    
    if (!summary) {
        html += '<p class="summary-text">Analysis complete. Review the detailed insights below.</p>';
    } else {
        html += '<p class="summary-text">' + (summary.overview || 'Analysis complete.') + '</p>';
        
        if (summary.key_findings && summary.key_findings.length > 0) {
            html += '<h4 class="summary-subtitle">Key Findings</h4>';
            html += '<ul class="findings-list">';
            summary.key_findings.forEach(finding => {
                html += '<li>' + finding + '</li>';
            });
            html += '</ul>';
        }
        
        if (summary.recommendations && summary.recommendations.length > 0) {
            html += '<h4 class="summary-subtitle">Recommended Actions</h4>';
            html += '<div class="recommendations">';
            summary.recommendations.forEach(rec => {
                html += '<div class="recommendation-item">';
                html += '<span class="rec-priority">' + (rec.priority || 'Action') + '</span>';
                html += '<span class="rec-text">' + (rec.action || rec) + '</span>';
                html += '</div>';
            });
            html += '</div>';
        }
        
        // Add timezone warning if significant difference
        const timezone = get_element('theirTimezone').value;
        if (timezone && timezone.includes('7-12')) {
            html += '<div class="alert alert-warning" style="margin-top: 16px;">';
            html += '<strong>Timezone Notice:</strong> Significant time difference detected. ';
            html += 'Consider timing sensitivity when responding.';
            html += '</div>';
        }
        
        // Add legal context warning if enabled
        if (localStorage.getItem('legalContext') === 'true') {
            html += '<div class="alert alert-warning" style="margin-top: 16px;">';
            html += '<strong>Legal Context Active:</strong> This communication may be subject to ';
            html += 'discovery or regulatory review. Ensure precise, factual language.';
            html += '</div>';
        }
    }
    
    html += '</div>';
    return html;
}

// Display emotion grid with intensity
function displayEmotionGrid(emotions) {
    let html = '';
    
    if (emotions && emotions.length > 0) {
        emotions.forEach(emotion => {
            const intensity = emotion.intensity === 'high' ? 100 : 
                             emotion.intensity === 'moderate' ? 66 : 33;
            
            html += '<div class="emotion-card">';
            html += '<div class="emotion-name">' + emotion.name + '</div>';
            html += '<div class="emotion-intensity">' + emotion.intensity + '</div>';
            html += '<div class="intensity-bar">';
            html += '<div class="intensity-fill" style="width: ' + intensity + '%"></div>';
            html += '</div>';
            if (emotion.evidence) {
                html += '<div class="emotion-evidence">"' + emotion.evidence + '"</div>';
            }
            html += '</div>';
        });
    } else {
        html = '<p style="color: var(--text-muted); text-align: center;">No strong emotions detected</p>';
    }
    
    get_element('emotionGrid').innerHTML = html;
}

// Format strategic insights
function formatStrategicInsights(strategic) {
    let html = '<div class="insights-container">';
    
    if (strategic) {
        if (strategic.intent) {
            html += '<div class="insight-section">';
            html += '<h5 class="insight-title">Core Intent</h5>';
            html += '<p class="insight-text">' + strategic.intent + '</p>';
            html += '</div>';
        }
        
        if (strategic.hidden_agenda) {
            html += '<div class="insight-section alert">';
            html += '<h5 class="insight-title">Potential Hidden Agenda</h5>';
            html += '<p class="insight-text">' + strategic.hidden_agenda + '</p>';
            html += '</div>';
        }
        
        if (strategic.negotiation_position) {
            html += '<div class="insight-section">';
            html += '<h5 class="insight-title">Negotiation Position</h5>';
            html += '<p class="insight-text">' + strategic.negotiation_position + '</p>';
            html += '</div>';
        }
        
        if (strategic.power_dynamics) {
            html += '<div class="insight-section">';
            html += '<h5 class="insight-title">Power Dynamics</h5>';
            html += '<p class="insight-text">' + strategic.power_dynamics + '</p>';
            html += '</div>';
        }
        
        if (strategic.cultural_considerations) {
            html += '<div class="insight-section">';
            html += '<h5 class="insight-title">Cultural Considerations</h5>';
            html += '<p class="insight-text">' + strategic.cultural_considerations + '</p>';
            html += '</div>';
        }
        
        if (strategic.gender_dynamics && localStorage.getItem('userGender')) {
            html += '<div class="insight-section">';
            html += '<h5 class="insight-title">Gender Communication Patterns</h5>';
            html += '<p class="insight-text">' + strategic.gender_dynamics + '</p>';
            html += '</div>';
        }
    }
    
    if (!strategic || Object.keys(strategic).length === 0) {
        html += '<p style="color: var(--text-muted);">No strategic insights detected</p>';
    }
    
    html += '</div>';
    return html;
}

// Format language analysis
function formatLanguageAnalysis(language) {
    let html = '<div class="language-container">';
    
    if (language) {
        html += '<div class="language-metric">';
        html += '<span class="metric-label">Formality:</span>';
        html += '<span class="metric-value">' + (language.formality || 'Moderate') + '</span>';
        html += '</div>';
        
        html += '<div class="language-metric">';
        html += '<span class="metric-label">Assertiveness:</span>';
        html += '<span class="metric-value">' + (language.assertiveness || 'Balanced') + '</span>';
        html += '</div>';
        
        html += '<div class="language-metric">';
        html += '<span class="metric-label">Clarity:</span>';
        html += '<span class="metric-value">' + (language.clarity || 'Clear') + '</span>';
        html += '</div>';
        
        if (language.urgency) {
            html += '<div class="language-metric">';
            html += '<span class="metric-label">Urgency:</span>';
            html += '<span class="metric-value">' + language.urgency + '</span>';
            html += '</div>';
        }
        
        if (language.power_words && language.power_words.length > 0) {
            html += '<div class="power-words">';
            html += '<h5>Power Language Detected</h5>';
            html += '<div class="word-chips">';
            language.power_words.forEach(word => {
                html += '<span class="word-chip">' + word + '</span>';
            });
            html += '</div></div>';
        }
        
        if (language.red_flags && language.red_flags.length > 0) {
            html += '<div class="power-words" style="margin-top: 16px;">';
            html += '<h5 style="color: var(--danger);">Red Flag Language</h5>';
            html += '<div class="word-chips">';
            language.red_flags.forEach(flag => {
                html += '<span class="word-chip" style="background: var(--danger);">' + flag + '</span>';
            });
            html += '</div></div>';
        }
        
        // Channel-specific insights
        const channel = get_element('messageChannel').value;
        if (channel && language.channel_appropriateness) {
            html += '<div class="language-metric" style="margin-top: 16px;">';
            html += '<span class="metric-label">Channel Appropriateness:</span>';
            html += '<span class="metric-value">' + language.channel_appropriateness + '</span>';
            html += '</div>';
        }
    } else {
        html += '<p style="color: var(--text-muted);">Standard professional language</p>';
    }
    
    html += '</div>';
    return html;
}

// Switch analysis tabs
function switchTab(tabName) {
    // Update buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Find the clicked button by the tabName
    document.querySelectorAll('.tab-btn').forEach(btn => {
        if (btn.textContent.toLowerCase().includes(tabName.toLowerCase()) || 
            btn.onclick.toString().includes(tabName)) {
            btn.classList.add('active');
        }
    });
    
    // Update panels
    document.querySelectorAll('.tab-panel').forEach(panel => {
        panel.classList.remove('active');
    });
    get_element(tabName + '-tab').classList.add('active');
}

// Generate response with tone
function generateResponse(tone) {
    const originalMessage = get_element('thoughtInput').value;
    const context = {
        tone: tone,
        direction: get_element('messageDirection').value,
        message_channel: get_element('messageChannel').value,
        person_role: get_element('personRole').value,
        situation: get_element('currentSituation').value,
        relationship_duration: get_element('relationshipDuration').value,
        last_interaction: get_element('lastInteraction').value,
        their_timezone: get_element('theirTimezone').value,
        current_stakes: get_element('currentStakes').value,
        their_company_size: get_element('theirCompanySize').value,
        their_communication_style: get_element('theirCommunicationStyle').value,
        legal_context: localStorage.getItem('legalContext') === 'true'
    };
    
    // Mark active tone - Fixed to find the button properly
    document.querySelectorAll('.tone-option').forEach(btn => {
        btn.classList.remove('active');
        if (btn.textContent.toLowerCase() === tone.toLowerCase() || 
            btn.onclick.toString().includes(tone)) {
            btn.classList.add('active');
        }
    });
    
    // Show loading state in response editor
    const responseEditor = get_element('responseEditor');
    responseEditor.value = 'Generating ' + tone + ' response...';
    responseEditor.disabled = true;
    
    ajax_post('generate_response', {
        original: originalMessage,
        context: context
    }, function(response) {
        responseEditor.disabled = false;
        if (response.success) {
            responseEditor.value = response.suggested_response;
            show_notification('Response generated', 'success');
        } else {
            responseEditor.value = '';
            show_notification('Failed to generate response', 'error');
        }
    });
}

// Copy response to clipboard
function copyResponse() {
    const text = get_element('responseEditor').value;
    if (!text || text.includes('Generating')) {
        show_notification('No response to copy', 'warning');
        return;
    }
    
    navigator.clipboard.writeText(text).then(function() {
        show_notification('Response copied to clipboard', 'success');
    });
}

// Refine response further
function refineResponse() {
    const currentResponse = get_element('responseEditor').value;
    
    if (!currentResponse || currentResponse.includes('Generating')) {
        show_notification('Generate a response first', 'warning');
        return;
    }
    
    const responseEditor = get_element('responseEditor');
    responseEditor.disabled = true;
    
    ajax_post('refine_response', {
        response: currentResponse,
        feedback: 'make it more polished and professional'
    }, function(response) {
        responseEditor.disabled = false;
        if (response.success) {
            responseEditor.value = response.refined_response;
            show_notification('Response refined', 'success');
        }
    });
}

// Copy results to clipboard
function copyResults() {
    const results = document.querySelector('.results-content').innerText;
    navigator.clipboard.writeText(results).then(function() {
        show_notification('Analysis copied to clipboard', 'success');
    });
}

// Clear content - updated for new layout
function clearContent() {
    if (confirm('Clear all content and analysis?')) {
        get_element('thoughtInput').value = '';
        get_element('wordCount').textContent = '0';
        
        // Reset results to placeholder state
        const placeholder = get_element('resultsPlaceholder');
        const resultsContent = get_element('resultsContent');
        if (placeholder) placeholder.style.display = 'block';
        if (resultsContent) resultsContent.style.display = 'none';
        
        // Clear all analysis data
        get_element('sentimentValue').textContent = '-';
        get_element('emotionValue').textContent = '-';
        get_element('powerValue').textContent = '-';
        get_element('dealValue').textContent = '-';
        
        // Clear dynamic content
        get_element('executiveSummary').innerHTML = '';
        get_element('emotionGrid').innerHTML = '';
        get_element('strategicInsights').innerHTML = '';
        get_element('languageAnalysis').innerHTML = '';
        
        // Reset tabs to default state
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
        document.querySelector('.tab-btn').classList.add('active');
        document.querySelector('.tab-panel').classList.add('active');
        
        // Clear response editor
        get_element('responseEditor').value = '';
        get_element('suggestedResponse').style.display = 'none';
        
        // Reset tone options
        document.querySelectorAll('.tone-option').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Scroll back to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        show_notification('Content cleared', 'info');
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    // Load saved context from settings
    const savedContext = [
        'communicationStyle', 
        'industry', 
        'roleLevel', 
        'department',
        'conflictApproach',
        'decisionStyle',
        'negotiationAuthority',
        'userGender',
        'userGenderOther',
        'legalContext'
    ];
    
    savedContext.forEach(key => {
        const value = localStorage.getItem(key);
        if (value && value !== 'false') {
            const element = get_element(key);
            if (element) {
                if (element.type === 'checkbox' || element.classList.contains('toggle-switch')) {
                    if (value === 'true') {
                        element.classList.add('active');
                    }
                } else {
                    element.value = value;
                }
            }
        }
    });
    
    // Auto-save context bar changes to session (not localStorage)
    const contextSelects = [
        'messageDirection',
        'messageChannel',
        'personRole', 
        'currentSituation', 
        'relationshipDuration',
        'lastInteraction',
        'theirTimezone',
        'currentStakes',
        'theirCompanySize',
        'theirCommunicationStyle'
    ];
    
    contextSelects.forEach(id => {
        const element = get_element(id);
        if (element) {
            element.addEventListener('change', function() {
                // Could send to server session if needed
                console.log('Context changed:', id, '=', this.value);
            });
        }
    });
});