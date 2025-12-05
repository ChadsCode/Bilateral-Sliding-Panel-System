<?php
// footer.php - Footer component
?>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-left">
            © <a href="https://www.linkedin.com/in/chadwigington/" target="_blank">Chad Wigington</a>
        </div>
        
        <div class="footer-center">
            <svg class="trust-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            No User Data Stored
        </div>
        
        <div class="footer-right">
            <a href="#" onclick="showSheet('warning')">Disclaimer</a>
            <a href="#" onclick="showSheet('privacy')">Privacy</a>
            <a href="#" onclick="showSheet('terms')">Terms</a>
            <a href="#" onclick="showSheet('about')">About</a>
            <a href="#" onclick="showSheet('contact')">Contact</a>
            <a href="#" onclick="showSheet('sitemap')">Sitemap</a>
        </div>
    </div>
</footer>

<div class="bottom-sheet" id="bottomSheet">
    <div class="sheet-header">
        <h2 class="sheet-title" id="sheetTitle">Title</h2>
        <button class="sheet-close" onclick="closeSheet()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    <div class="sheet-content" id="sheetContent"></div>
</div>