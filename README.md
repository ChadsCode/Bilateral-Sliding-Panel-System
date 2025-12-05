# Bilateral Sliding Panel System

Dashboard UI/UX architecture with dual sliding panels. Mobile-first. Vanilla code. No frameworks.

Repository: https://github.com/ChadsCode/Bilateral-Sliding-Panel-System

## What This Is

A dashboard navigation pattern. Two panels slide from opposite edges—Workspace from the left, Analyze from the right—keeping user focus centered on results. Think pocket doors sliding into wall cavities.

The interface is a tone and sentiment analysis prototype built while at Indiana University. The navigation architecture is the contribution.

## Why It Matters

Traditional dashboards rely on navigation hierarchies. Drill downs, page changes, subfolders. Each transition breaks focus and adds cognitive load.

This keeps users on a single screen. Most interactions happen within the panels themselves. Could reduce employee fatigue in high-volume environments.

## Demo

Try it: https://www.toneanalysis.com/ui/index

Demo is a visual prototype only. The interface is fully interactive but not connected to any processing. Nothing you type is analyzed. This is to experience the navigation design concept.

Tested on Windows, Android, and Chrome.

## Quick Start

1. Clone this repository
2. Serve files via localhost 
3. Open index.php in browser

## Requirements

- PHP server environment (XAMPP or similar)
- Modern browser with CSS Grid/Flexbox support
- Tested on Chrome only

## Project Structure
```
project-files/
├── index.php                 
├── header.php                
├── footer.php               
├── process.php               
├── app.js                    
├── premium.js                
├── settings.js               
├── accordion.js              
├── context-nav.js            
├── reflection-ui.js          
├── reflection_handler.php    
├── base.css                  
├── premium-layout.css        
├── premium-components.css    
├── panels-ui.css             
├── interactive-ui.css       
├── results-ui.css            
├── settings.css              
├── reflection-loop.css      
├── analysis_panel.php       
├── toolbox.php              
├── settings_panel.php        
├── settings_account.php      
├── settings_billing.php      
├── settings_context.php      
├── settings_privacy.php      
├── settings_help.php         
├── context.php               
└── ToneAnalysis.com_Logo.png 
```

Vanilla JavaScript, PHP, and CSS. No framework dependencies. 

## Design Concepts

- **Bilateral Panels**: Workspace slides left, Analyze slides right
- **Central Focus**: Results stay centered, panels overlay from edges
- **Reduced Navigation**: Minimal drill downs, no page changes
- **Mobile-First**: PWA-like responsiveness without full PWA overhead
- **Scroll Lock**: Main content locks when panels open

## Use Cases

- Call centers at scale
- High-stakes communications (consulting, negotiations)
- Any dashboard where reducing navigation overhead matters

## Technical Details

- Framework: Vanilla JavaScript
- Backend: PHP
- Styling: CSS with custom properties
- Security: CSRF token protection included 

## Browser Compatibility

Tested with Google Chrome on Windows and Android. Other browsers have not been tested.

## License

MIT License - Free for commercial and personal use

**MIT LICENSE DOES NOT APPLY TO THE NAME TONE ANALYSIS, TONEANALYSIS.COM, TONE ANALYSIS LOGO OR TRADE DRESS LIKENESS.**

## Author

Chad Wigington  
LinkedIn: https://www.linkedin.com/in/chadwigington/  
GitHub: https://github.com/ChadsCode

## Disclosures

1. Independent research project created while at Indiana University.
2. Not associated with or endorsed by any employer.
3. Backend server-side logic not included. This is frontend UI/UX only.
4. Have all code professionally verified before use.
5. Views are my own.
6. Android is a trademark of Google LLC. Google Chrome is a trademark of Google LLC. Windows and GitHub are trademarks of Microsoft Corporation. This project is not affiliated with, endorsed by, or sponsored by these organizations.

---


Questions? Open an issue or reach out via LinkedIn: https://www.linkedin.com/in/chadwigington/
