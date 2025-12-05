// context-nav.js - Updated with 3 contexts, fixed initial load

let currentContext = 0; // Start with first context (Communication)

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    // Small delay to ensure DOM is fully ready
    setTimeout(function() {
        // Start with first context active
        switchContext(0);
    }, 100);
    
    // Ensure context bar has consistent height from the start
    const contextBar = get_element('contextBar');
    if (contextBar) {
        // Remove any inline styles that might affect height
        contextBar.style.removeProperty('height');
        contextBar.style.removeProperty('min-height');
    }
});

// Switch between context views
function switchContext(index) {
    // Ensure index is within bounds (0-2 for 3 contexts)
    if (index < 0) index = 2;
    if (index > 2) index = 0;
    
    // Don't switch to same context unless it's the initial load
    if (index === currentContext && currentContext !== 0) return;
    
    const contextBar = get_element('contextBar');
    const contextControls = get_element('contextControls');
    const contextLabel = get_element('contextLabel');
    
    // Add transition class
    contextBar.classList.add('transitioning');
    
    // Fade out current content
    contextControls.style.opacity = '0';
    contextLabel.style.opacity = '0';
    
    setTimeout(() => {
        // Get new context template
        const template = get_element('context-' + index);
        if (template) {
            // Update label
            const newLabel = template.querySelector('.context-label');
            if (newLabel) {
                contextLabel.textContent = newLabel.textContent;
                // Reset any inline styles
                contextLabel.style.removeProperty('position');
                contextLabel.style.removeProperty('left');
                contextLabel.style.removeProperty('top');
                contextLabel.style.removeProperty('transform');
            }
            
            // Update controls
            const newControls = template.querySelector('.context-controls');
            if (newControls) {
                contextControls.innerHTML = newControls.innerHTML;
                // Ensure controls are visible
                contextControls.style.display = 'flex';
            }
            
            // Update active square
            document.querySelectorAll('.context-square').forEach((square, idx) => {
                if (idx === index) {
                    square.classList.add('active');
                } else {
                    square.classList.remove('active');
                }
            });
        }
        
        // Fade in new content
        contextControls.style.opacity = '1';
        contextLabel.style.opacity = '1';
        
        // Remove transition class
        setTimeout(() => {
            contextBar.classList.remove('transitioning');
        }, 150);
        
        currentContext = index;
    }, 150);
}

// Navigate to previous context - using squares
function prevContext(squareIndex) {
    if (typeof squareIndex === 'number') {
        switchContext(squareIndex);
    } else {
        switchContext(currentContext - 1);
    }
}

// Navigate to next context - using squares
function nextContext(squareIndex) {
    if (typeof squareIndex === 'number') {
        switchContext(squareIndex);
    } else {
        switchContext(currentContext + 1);
    }
}

// Ensure squares stay in position during transitions
function maintainSquarePosition() {
    const contextNav = document.querySelector('.context-nav');
    if (contextNav) {
        // Force recalculation of position
        contextNav.style.bottom = '20px';
        contextNav.style.position = 'absolute';
    }
}

// Call maintainSquarePosition after any context switch
window.addEventListener('resize', maintainSquarePosition);

// Make squares pulse on first load to draw attention
window.addEventListener('load', function() {
    // Ensure initial context is loaded
    if (currentContext === 0) {
        const contextControls = get_element('contextControls');
        if (contextControls && contextControls.innerHTML.trim() === '') {
            // Force load first context if empty
            switchContext(0);
        }
    }
    
    setTimeout(() => {
        const squares = document.querySelectorAll('.context-square');
        squares.forEach((square, index) => {
            setTimeout(() => {
                square.classList.add('pulse');
                setTimeout(() => {
                    square.classList.remove('pulse');
                }, 600);
            }, index * 200);
        });
    }, 500);
    
    // Ensure proper positioning on load
    maintainSquarePosition();
});