<?php
// toolbox.php - Updated toolbox panel component
$current_tool = $_SESSION['current_tool'] ?? 'tone'; // Default to tone (now "Analyze Message")

// Reordered tools array with "Analyze Message" first
$tools = [
    'tone' => [
        'title' => 'Analyze Message',
        'placeholder' => 'Paste your message to analyze tone, sentiment, and strategic insights...',
        'button_text' => 'ANALYZE COMMUNICATION',
        'icon' => '<circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/>',
        'description' => 'Premium executive analysis'
    ],
    'grammar' => [
        'title' => 'Grammar & Spelling',
        'placeholder' => 'Paste your text here for instant improvement...',
        'button_text' => 'ANALYZE',
        'icon' => '<path d="M4 7V4a2 2 0 012-2h8l2 2h4a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V7z"/><path d="M2 7h20"/>',
        'description' => 'Fix errors & polish text'
    ],
    'chain' => [
        'title' => 'Email Chain Analysis',
        'placeholder' => 'Paste email conversation here to analyze emotional dynamics...',
        'button_text' => 'ANALYZE CHAIN',
        'icon' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
        'description' => 'Multi-person conversation insights'
    ],
    'write' => [
        'title' => 'AI Email Writer',
        'placeholder' => 'Describe the email you need: "Professional follow-up to client about project delay"',
        'button_text' => 'GENERATE EMAIL',
        'icon' => '<path d="M12 20h9M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4z"/>',
        'description' => 'Create professional emails'
    ],
    'reply' => [
        'title' => 'Smart Reply Generator',
        'placeholder' => 'Paste the email you need to reply to...',
        'button_text' => 'GENERATE REPLY',
        'icon' => '<path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>',
        'description' => 'Contextual response drafts'
    ]
];
?>
<div class="toolbox-tab" onclick="togglePanel('toolbox')">TOOLS</div>

<div class="toolbox-panel" id="toolboxPanel">
    <div class="panel-header">
        <h2 class="panel-title">Communication Tools</h2>
        <button class="panel-close" onclick="togglePanel('toolbox')">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    
    <div class="tools-list">
        <?php foreach ($tools as $key => $tool): ?>
        <div class="tool-item <?php echo $current_tool === $key ? 'active' : ''; ?>" 
             data-tool="<?php echo htmlspecialchars($key); ?>" 
             onclick="selectTool('<?php echo htmlspecialchars($key); ?>')">
            <div class="tool-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <?php echo $tool['icon']; ?>
                </svg>
            </div>
            <div class="tool-info">
                <h3><?php echo htmlspecialchars($tool['title']); ?></h3>
                <p><?php echo htmlspecialchars($tool['description']); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<button class="voice-button" id="voiceButton" onclick="toggleVoice()">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 1a3 3 0 00-3 3v8a3 3 0 106 0V4a3 3 0 00-3-3z"/>
        <path d="M19 10v2a7 7 0 01-14 0v-2"/>
    </svg>
</button>