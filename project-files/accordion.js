// accordion.js - Context accordion functionality with scroll lock and auto-focus fixes

// Store the original scroll position
let mainScrollPosition = 0;

// Fix: Prevent main page scrolling when panels are open
function lockMainScroll() {
    // Save current scroll position
    mainScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
    
    // Add class to body to prevent scrolling
    document.body.style.overflow = 'hidden';
    document.body.style.position = 'fixed';
    document.body.style.top = `-${mainScrollPosition}px`;
    document.body.style.width = '100%';
}

function unlockMainScroll() {
    // Remove the locks
    document.body.style.overflow = '';
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.width = '';
    
    // Restore scroll position
    window.scrollTo(0, mainScrollPosition);
}

// Toggle context accordion sections with auto-focus and scroll
function toggleContext(contextName) {
    const contextItem = document.querySelector(`#${contextName}-context`).parentElement;
    const allContextItems = document.querySelectorAll('.context-item');
    
    // Close all other contexts
    allContextItems.forEach(item => {
        if (item !== contextItem) {
            item.classList.remove('active');
        }
    });
    
    // Toggle current context
    const wasActive = contextItem.classList.contains('active');
    contextItem.classList.toggle('active');
    
    // If opening, scroll it into view and focus first input
    if (!wasActive && contextItem.classList.contains('active')) {
        // Small delay to ensure animation completes
        setTimeout(() => {
            // Scroll the context item into view within the panel
            const panel = document.querySelector('.analysis-panel-content');
            const contextContent = contextItem.querySelector('.context-content');
            
            if (panel && contextContent) {
                // Calculate position
                const panelRect = panel.getBoundingClientRect();
                const itemRect = contextItem.getBoundingClientRect();
                const contextRect = contextContent.getBoundingClientRect();
                
                // Check if the context content is below the visible area
                if (contextRect.bottom > panelRect.bottom) {
                    // Scroll to show the entire context section
                    const scrollAmount = contextRect.bottom - panelRect.bottom + 20; // 20px padding
                    panel.scrollTop += scrollAmount;
                } else if (itemRect.top < panelRect.top) {
                    // If it's above, scroll up
                    const scrollAmount = itemRect.top - panelRect.top - 20;
                    panel.scrollTop += scrollAmount;
                }
                
                // Focus the first select element
                const firstSelect = contextContent.querySelector('.premium-select');
                if (firstSelect) {
                    firstSelect.focus();
                }
            }
        }, 350); // Wait for accordion animation
    }
}

// Toggle workspace panel (combined tools/settings) with scroll lock
function togglePanel(panelName) {
    const panel = get_element(panelName + 'Panel');
    const tab = document.querySelector('.' + panelName + '-tab');
    
    if (panel) {
        const isOpening = !panel.classList.contains('active');
        panel.classList.toggle('active');
        
        // Handle scroll locking
        if (isOpening) {
            lockMainScroll();
        }
        
        // Hide/show tab when panel is active
        if (panel.classList.contains('active')) {
            if (tab) tab.style.display = 'none';
            
            // If workspace panel, ensure it scrolls to top
            if (panelName === 'workspace') {
                const workspaceContent = panel.querySelector('.workspace-content');
                if (workspaceContent) {
                    workspaceContent.scrollTop = 0;
                }
            }
            
            // Close other panels when opening one
            const otherPanel = panelName === 'workspace' ? 'analysisPanel' : 'workspacePanel';
            const other = get_element(otherPanel);
            const otherTab = document.querySelector('.' + (panelName === 'workspace' ? 'analysis' : 'workspace') + '-tab');
            
            if (other && other.classList.contains('active')) {
                other.classList.remove('active');
                if (otherTab) otherTab.style.display = 'block';
            }
        } else {
            // Show tab when panel closes
            if (tab) tab.style.display = 'block';
            
            // Check if all panels are closed
            const workspacePanel = get_element('workspacePanel');
            const analysisPanel = get_element('analysisPanel');
            
            if (!workspacePanel?.classList.contains('active') && 
                !analysisPanel?.classList.contains('active')) {
                unlockMainScroll();
            }
        }
    }
}

// Select tool function - updated for new layout
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
            
            // Update placeholder text based on tool
            const placeholders = {
                'tone': 'Paste the message you want to analyze for tone, sentiment, and strategic insights...',
                'write': 'Describe the email you need: "Professional follow-up to client about project delay"',
                'reply': 'Paste the email you need to reply to...'
            };
            
            const input = get_element('thoughtInput');
            if (input && placeholders[toolName]) {
                input.placeholder = placeholders[toolName];
            }
            
            show_notification('Tool selected: ' + toolName, 'info');
        }
    });
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    // Set first context active by default
    const firstContext = document.querySelector('.context-item');
    if (firstContext) {
        firstContext.classList.add('active');
    }
    
    // Ensure workspace panel scrolls to top when opened
    const workspacePanel = get_element('workspacePanel');
    if (workspacePanel) {
        const workspaceContent = workspacePanel.querySelector('.workspace-content');
        if (workspaceContent) {
            workspaceContent.scrollTop = 0;
        }
    }
    
    // Ensure scroll is unlocked when page loads
    unlockMainScroll();
    
    // Auto-close panels when clicking outside
    document.addEventListener('click', function(e) {
        const workspacePanel = get_element('workspacePanel');
        const analysisPanel = get_element('analysisPanel');
        const workspaceTab = document.querySelector('.workspace-tab');
        const analysisTab = document.querySelector('.analysis-tab');
        
        let panelsClosed = false;
        
        // Check if click is outside panels and tabs
        if (workspacePanel && workspacePanel.classList.contains('active')) {
            if (!workspacePanel.contains(e.target) && !workspaceTab.contains(e.target)) {
                workspacePanel.classList.remove('active');
                if (workspaceTab) workspaceTab.style.display = 'block';
                panelsClosed = true;
            }
        }
        
        if (analysisPanel && analysisPanel.classList.contains('active')) {
            if (!analysisPanel.contains(e.target) && !analysisTab.contains(e.target)) {
                analysisPanel.classList.remove('active');
                if (analysisTab) analysisTab.style.display = 'block';
                panelsClosed = true;
            }
        }
        
        // If panels were closed and no panels remain open, unlock scroll
        if (panelsClosed) {
            const anyPanelOpen = (workspacePanel?.classList.contains('active') || 
                                 analysisPanel?.classList.contains('active'));
            if (!anyPanelOpen) {
                unlockMainScroll();
            }
        }
    });
    
    // Handle escape key to close panels and unlock scroll
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const workspacePanel = get_element('workspacePanel');
            const analysisPanel = get_element('analysisPanel');
            let anyPanelWasOpen = false;
            
            if (workspacePanel?.classList.contains('active')) {
                workspacePanel.classList.remove('active');
                document.querySelector('.workspace-tab').style.display = 'block';
                anyPanelWasOpen = true;
            }
            
            if (analysisPanel?.classList.contains('active')) {
                analysisPanel.classList.remove('active');
                document.querySelector('.analysis-tab').style.display = 'block';
                anyPanelWasOpen = true;
            }
            
            if (anyPanelWasOpen) {
                unlockMainScroll();
            }
        }
    });
});