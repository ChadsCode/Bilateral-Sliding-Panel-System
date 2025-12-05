<?php
// index.php - Premium Dashboard for ToneAnalysis
session_start();

// Generate CSRF token for security
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Store current tool in session
$_SESSION['current_tool'] = 'tone';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- CSRF Token for security -->
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
    <title>ToneAnalysis - Executive Intelligence Platform</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="panels-ui.css">
    <link rel="stylesheet" href="interactive-ui.css">
    <link rel="stylesheet" href="results-ui.css">
    <link rel="stylesheet" href="premium-layout.css">
    <link rel="stylesheet" href="premium-components.css">
    <link rel="stylesheet" href="settings.css">
    <!-- Reflection Loop CSS -->
    <link rel="stylesheet" href="reflection-loop.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="executive-container">
        <!-- Main Analysis Results Area - Always Visible -->
        <div class="analysis-workspace">
            <!-- Results Section - Now primary content -->
            <div class="results-section" id="resultsSection">
                <div class="results-placeholder" id="resultsPlaceholder">
                    <h4>Analysis Results Will Appear Here</h4>
                    <p>Enter a message in the analysis panel and click Analyze to see comprehensive insights</p>
                </div>
                
                <div class="results-content" id="resultsContent" style="display: none;">
                    <div class="results-header">
                        <h3 class="results-title">Strategic Analysis</h3>
                        <button class="btn-icon" onclick="copyResults()">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Quick Read Panel -->
                    <div class="quick-read-panel">
                        <div class="quick-stat">
                            <span class="stat-label">Sentiment</span>
                            <span class="stat-value" id="sentimentValue">-</span>
                        </div>
                        <div class="quick-stat">
                            <span class="stat-label">Dominant Emotion</span>
                            <span class="stat-value" id="emotionValue">-</span>
                        </div>
                        <div class="quick-stat">
                            <span class="stat-label">Power Position</span>
                            <span class="stat-value" id="powerValue">-</span>
                        </div>
                        <div class="quick-stat">
                            <span class="stat-label">Deal Temperature</span>
                            <span class="stat-value" id="dealValue">-</span>
                        </div>
                    </div>
                    
                    <!-- Detailed Analysis Tabs -->
                    <div class="analysis-tabs">
                        <div class="tab-nav">
                            <button class="tab-btn active" onclick="switchTab('executive')">Executive Summary</button>
                            <button class="tab-btn" onclick="switchTab('emotional')">Emotional Profile</button>
                            <button class="tab-btn" onclick="switchTab('strategic')">Strategic Insights</button>
                            <button class="tab-btn" onclick="switchTab('language')">Language Analysis</button>
                        </div>
                        
                        <div class="tab-content">
                            <div class="tab-panel active" id="executive-tab">
                                <div class="analysis-content" id="executiveSummary">
                                    <!-- Dynamic content -->
                                </div>
                            </div>
                            
                            <div class="tab-panel" id="emotional-tab">
                                <div class="emotion-grid" id="emotionGrid">
                                    <!-- Dynamic emotion cards -->
                                </div>
                            </div>
                            
                            <div class="tab-panel" id="strategic-tab">
                                <div class="strategic-insights" id="strategicInsights">
                                    <!-- Dynamic insights -->
                                </div>
                            </div>
                            
                            <div class="tab-panel" id="language-tab">
                                <div class="language-analysis" id="languageAnalysis">
                                    <!-- Dynamic language analysis -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rewrite Section -->
                    <div class="rewrite-section">
                        <h4 class="rewrite-title">Suggested Response Strategy</h4>
                        <div class="tone-options">
                            <button class="tone-option" onclick="generateResponse('assertive')">Assertive</button>
                            <button class="tone-option" onclick="generateResponse('diplomatic')">Diplomatic</button>
                            <button class="tone-option" onclick="generateResponse('collaborative')">Collaborative</button>
                            <button class="tone-option" onclick="generateResponse('firm')">Firm but Fair</button>
                        </div>
                        <div class="suggested-response" id="suggestedResponse" style="display: none;">
                            <textarea class="response-editor" id="responseEditor"></textarea>
                            <div class="response-actions">
                                <button class="btn-executive primary" onclick="copyResponse()">Copy Response</button>
                                <button class="btn-executive ghost" onclick="refineResponse()">Refine Further</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Left Panel - Tools & Settings Combined -->
    <div class="workspace-tab" onclick="togglePanel('workspace')">WORKSPACE</div>
    
    <div class="workspace-panel" id="workspacePanel">
        <div class="panel-header">
            <h2 class="panel-title">Workspace</h2>
            <button class="panel-close" onclick="togglePanel('workspace')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        
        <div class="workspace-content">
            <!-- Tools Section -->
            <div class="workspace-section">
                <h3 class="workspace-section-title">Communication Tools</h3>
                <div class="tools-list">
                    <div class="tool-item active" data-tool="tone" onclick="selectTool('tone')">
                        <div class="tool-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/>
                            </svg>
                        </div>
                        <div class="tool-info">
                            <h3>Analyze Message</h3>
                            <p>executive analysis</p>
                        </div>
                    </div>
                    
                    <div class="tool-item" data-tool="write" onclick="selectTool('write')">
                        <div class="tool-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </div>
                        <div class="tool-info">
                            <h3>Tool #2</h3>
                            <p>In development.. Coming soon!</p>
                        </div>
                    </div>
                    
                    <div class="tool-item" data-tool="reply" onclick="selectTool('reply')">
                        <div class="tool-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
                            </svg>
                        </div>
                        <div class="tool-info">
                            <h3>Tool #3</h3>
                            <p>In development.. Coming soon!</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Settings Section -->
            <div class="workspace-section">
                <h3 class="workspace-section-title">Settings</h3>
                <div class="settings-nav">
                    <div class="settings-nav-item" onclick="switchSection('privacy')">Privacy</div>
                    <div class="settings-nav-item" onclick="switchSection('account')">Account</div>
                    <div class="settings-nav-item" onclick="switchSection('billing')">Billing</div>
                    <div class="settings-nav-item" onclick="switchSection('context')">Context</div>
                    <div class="settings-nav-item active" onclick="switchSection('help')">Help</div>
                </div>
                
                <div class="settings-content-inline">
                    <?php 
                    include 'settings_privacy.php';
                    include 'settings_account.php';
                    include 'settings_billing.php';
                    include 'settings_context.php';
                    include 'settings_help.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Panel - Analysis Input -->
    <div class="analysis-tab" onclick="togglePanel('analysis')">ANALYZE</div>
    
    <div class="analysis-panel" id="analysisPanel">
        <div class="panel-header">
            <h2 class="panel-title">Message Analysis</h2>
            <button class="panel-close" onclick="togglePanel('analysis')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        
        <div class="analysis-panel-content">
            <!-- Message Input Section -->
            <div class="message-input-section">
                <textarea 
                    class="executive-input" 
                    id="thoughtInput"
                    placeholder="Paste the message you want to analyze for tone, sentiment, and strategic insights..."
                    spellcheck="false"
                ></textarea>
                
                <div class="input-footer">
                    <div class="word-counter">
                        <span id="wordCount">0</span> words
                    </div>
                    <div class="action-buttons">
                        <button class="btn-executive primary" onclick="processContent()">
                            <span class="btn-text">Analyze</span>
                        </button>
                        <button class="btn-executive ghost" onclick="clearContent()">Clear</button>
                    </div>
                </div>
            </div>
            
            <!-- Context Accordion Section -->
            <div class="context-accordion">
                <!-- Communication Context -->
                <div class="context-item">
                    <button class="context-header" onclick="toggleContext('communication')">
                        <span>Communication Context</span>
                        <svg class="context-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="context-content" id="communication-context">
                        <div class="context-selectors">
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="messageDirection">
                                    <option value="from">Analyzing Message FROM</option>
                                    <option value="to">Crafting Message TO</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                            
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="messageChannel">
                                    <option value="">Channel..</option>
                                    <option value="email">Email</option>
                                    <option value="slack-teams">Slack/Teams</option>
                                    <option value="text-whatsapp">Text/WhatsApp</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="formal-letter">Formal Letter</option>
                                    <option value="video-transcript">Video Call Transcript</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                            
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="personRole">
                                    <option value="">Their Role..</option>
                                    <option value="auditor">Auditor</option>
                                    <option value="board">Board Member</option>
                                    <option value="ceo">CEO / President</option>
                                    <option value="cfo">CFO / Finance Head</option>
                                    <option value="client">Client</option>
                                    <option value="consultant">Consultant</option>
                                    <option value="peer">Peer / Colleague</option>
                                    <option value="report">Report (Direct)</option>
                                    <option value="superior">Superior</option>
                                    <option value="vendor">Vendor / Supplier</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                            
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="currentSituation">
                                    <option value="">Situation..</option>
                                    <option value="normal">Business as Usual</option>
                                    <option value="closing">Closing a Deal</option>
                                    <option value="conflict">Conflict Resolution</option>
                                    <option value="crisis">Crisis Management</option>
                                    <option value="negotiation">Negotiation</option>
                                    <option value="review">Performance Review</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Relationship Context -->
                <div class="context-item">
                    <button class="context-header" onclick="toggleContext('relationship')">
                        <span>Relationship Context</span>
                        <svg class="context-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="context-content" id="relationship-context">
                        <div class="context-selectors">
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="relationshipDuration">
                                    <option value="">How long known..</option>
                                    <option value="first-contact">First Contact</option>
                                    <option value="new">New (< 3 months)</option>
                                    <option value="developing">Developing (3-12 months)</option>
                                    <option value="established">Established (1-3 years)</option>
                                    <option value="long-term">Long-term (3+ years)</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                            
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="lastInteraction">
                                    <option value="">Last interaction..</option>
                                    <option value="positive">Ended positively</option>
                                    <option value="neutral">Neutral/Professional</option>
                                    <option value="tense">Some tension</option>
                                    <option value="conflict">Unresolved conflict</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                            
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="theirTimezone">
                                    <option value="">Their Time Zone..</option>
                                    <option value="same">Same as mine</option>
                                    <option value="1-3-ahead">1-3 hours ahead</option>
                                    <option value="4-6-ahead">4-6 hours ahead</option>
                                    <option value="7-12-ahead">7-12 hours ahead</option>
                                    <option value="1-3-behind">1-3 hours behind</option>
                                    <option value="4-6-behind">4-6 hours behind</option>
                                    <option value="7-12-behind">7-12 hours behind</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Message Context -->
                <div class="context-item">
                    <button class="context-header" onclick="toggleContext('message')">
                        <span>Message Context</span>
                        <svg class="context-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="context-content" id="message-context">
                        <div class="context-selectors">
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="currentStakes">
                                    <option value="">What's at Risk..</option>
                                    <option value="low">Low Stakes (< $10K)</option>
                                    <option value="moderate">Moderate ($10K-$100K)</option>
                                    <option value="high">High ($100K-$1M)</option>
                                    <option value="critical">Critical ($1M+)</option>
                                    <option value="career">Career/Reputation Defining</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                            
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="theirCompanySize">
                                    <option value="">Their Company Size..</option>
                                    <option value="startup">Startup (1-50)</option>
                                    <option value="small">Small (51-200)</option>
                                    <option value="midsize">Midsize (201-1000)</option>
                                    <option value="enterprise">Enterprise (1000-10000)</option>
                                    <option value="fortune500">Fortune 500 (10000+)</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                            
                            <div class="premium-select-wrapper">
                                <select class="premium-select" id="theirCommunicationStyle">
                                    <option value="">Their Style (if known)..</option>
                                    <option value="data-driven">Data & Facts Focused</option>
                                    <option value="relationship">Relationship Focused</option>
                                    <option value="action-oriented">Action/Results Oriented</option>
                                    <option value="process-oriented">Process/Details Oriented</option>
                                    <option value="big-picture">Vision/Strategy Focused</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 5L6 8L9 5" stroke="currentColor" fill="none" stroke-width="1.5"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="app.js"></script>
    <script src="premium.js"></script>
    <script src="settings.js"></script>
    <script src="accordion.js"></script>
    <!-- Reflection Loop JavaScript -->
    <script src="reflection-ui.js"></script>
</body>
</html>