<?php
// analysis_panel.php - Analysis panel component
?>

<div class="analysis-tab" onclick="togglePanel('analysis')">INSIGHTS</div>

<div class="analysis-panel" id="analysisPanel">
    <div class="panel-header">
        <h2 class="panel-title">Real-time Analysis</h2>
        <button class="panel-close" onclick="togglePanel('analysis')">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    
    <div class="analysis-content">
        <div class="analysis-actions">
            <button class="analysis-btn" onclick="pullContent()">PULL</button>
            <button class="analysis-btn" onclick="pushContent()">PUSH</button>
        </div>
        
        <div class="analysis-input-wrapper">
            <textarea 
                class="analysis-input" 
                id="analysisInput"
                placeholder="Edit content here for analysis..."
            ></textarea>
        </div>
        
        <button class="analysis-btn primary" onclick="runAnalysis()">ANALYZE</button>
        
        <div class="analysis-results">
            <div class="analysis-item">
                <div class="analysis-label">Tone</div>
                <div class="analysis-value" id="toneValue">-</div>
            </div>
            
            <div class="analysis-item">
                <div class="analysis-label">Sentiment</div>
                <div class="analysis-value">
                    <span class="sentiment-indicator" id="sentimentIndicator"></span>
                    <span id="sentimentValue">-</span>
                </div>
            </div>
            
            <div class="analysis-item">
                <div class="analysis-label">Readability</div>
                <div class="analysis-value" id="readabilityValue">-</div>
            </div>
            
            <div class="analysis-item">
                <div class="analysis-label">Word Count</div>
                <div class="analysis-value" id="wordCount">0</div>
            </div>
        </div>
        
        <button class="analysis-btn report" onclick="generateReport()">GENERATE REPORT</button>
    </div>
</div>