<?php
// process.php - Handles AJAX requests with enhanced context support
session_start();
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$tool = $_POST['tool'] ?? $_SESSION['current_tool'] ?? 'tone';
$content = $_POST['content'] ?? '';

switch ($action) {
    case 'analyze_premium':
        $context = $_POST['context'] ?? [];
        echo json_encode(analyze_premium_content($content, $context));
        break;
        
    case 'generate_response':
        $original = $_POST['original'] ?? '';
        $context = $_POST['context'] ?? [];
        echo json_encode(generate_response($original, $context));
        break;
        
    case 'refine_response':
        $response = $_POST['response'] ?? '';
        $feedback = $_POST['feedback'] ?? '';
        echo json_encode(refine_response($response, $feedback));
        break;
        
    case 'save_context':
        $context = $_POST;
        unset($context['action']);
        $_SESSION['user_context'] = $context;
        echo json_encode(['success' => true]);
        break;
        
    case 'process':
        echo json_encode(process_content($tool, $content));
        break;
        
    case 'analyze':
        echo json_encode(analyze_content($content));
        break;
        
    case 'select_tool':
        $_SESSION['current_tool'] = $tool;
        echo json_encode(['success' => true, 'tool' => $tool]);
        break;
        
    case 'get_sheet':
        $type = $_POST['type'] ?? '';
        echo json_encode(['content' => get_sheet_content($type)]);
        break;
        
    default:
        echo json_encode(['error' => 'Invalid action']);
}

function analyze_premium_content($content, $context) {
    // In production, this would call Claude API with full context
    // For now, return structured mock data that demonstrates context awareness
    
    $analysis = [
        'success' => true,
        'analysis' => [
            'sentiment' => determine_sentiment($content, $context),
            'dominant_emotion' => determine_emotion($content, $context),
            'power_position' => analyze_power_dynamics($content, $context),
            'deal_temperature' => analyze_deal_temperature($content, $context),
            'executive_summary' => generate_executive_summary($content, $context),
            'emotions' => analyze_emotions($content, $context),
            'strategic' => analyze_strategic_insights($content, $context),
            'language' => analyze_language($content, $context)
        ]
    ];
    
    return $analysis;
}

function determine_sentiment($content, $context) {
    // Context-aware sentiment analysis
    if ($context['last_interaction'] === 'conflict') {
        return 'Cautious';
    }
    if ($context['current_stakes'] === 'critical') {
        return 'High-Stakes';
    }
    if (preg_match('/pleased|happy|excited|great/i', $content)) {
        return 'Positive';
    }
    if (preg_match('/concerned|worried|disappointed/i', $content)) {
        return 'Negative';
    }
    return 'Professional';
}

function determine_emotion($content, $context) {
    if ($context['situation'] === 'crisis') {
        return 'Urgent';
    }
    if ($context['message_channel'] === 'text-whatsapp' && strlen($content) < 50) {
        return 'Brief';
    }
    if (preg_match('/urgent|asap|immediately/i', $content)) {
        return 'Pressing';
    }
    return 'Measured';
}

function analyze_power_dynamics($content, $context) {
    // Analyze based on role relationships
    if ($context['person_role'] === 'ceo' && $context['direction'] === 'from') {
        return 'Subordinate';
    }
    if ($context['person_role'] === 'report' && $context['direction'] === 'to') {
        return 'Authoritative';
    }
    if ($context['negotiation_authority'] === 'full' && $context['their_company_size'] === 'startup') {
        return 'Advantaged';
    }
    return 'Balanced';
}

function analyze_deal_temperature($content, $context) {
    if ($context['situation'] === 'closing') {
        if (preg_match('/agree|yes|confirmed|deal/i', $content)) {
            return 'Hot';
        }
        return 'Warm';
    }
    if ($context['current_stakes'] === 'critical') {
        return 'Critical';
    }
    return 'Moderate';
}

function generate_executive_summary($content, $context) {
    $summary = [
        'overview' => 'Analysis of ' . $context['message_channel'] . ' communication ' . 
                      $context['direction'] . ' ' . $context['person_role'] . '.',
        'key_findings' => [],
        'recommendations' => []
    ];
    
    // Add findings based on context
    if ($context['their_timezone'] && strpos($context['their_timezone'], '7-12') !== false) {
        $summary['key_findings'][] = 'Significant timezone difference may affect response expectations';
    }
    
    if ($context['last_interaction'] === 'conflict') {
        $summary['key_findings'][] = 'Previous tensions detected - proceed with diplomatic approach';
    }
    
    if ($context['legal_context'] === 'true') {
        $summary['key_findings'][] = 'Legal/compliance context active - ensure precise documentation';
    }
    
    // Add recommendations based on analysis
    if ($context['conflict_approach'] === 'avoidant' && preg_match('/disagree|concern|issue/i', $content)) {
        $summary['recommendations'][] = [
            'priority' => 'High',
            'action' => 'Address concerns directly but diplomatically given your conflict-avoidant style'
        ];
    }
    
    if ($context['decision_style'] === 'analytical' && $context['situation'] === 'negotiation') {
        $summary['recommendations'][] = [
            'priority' => 'Medium',
            'action' => 'Prepare detailed data to support your position'
        ];
    }
    
    return $summary;
}

function analyze_emotions($content, $context) {
    $emotions = [];
    
    // Context-aware emotion detection
    if (preg_match('/frustrated|annoyed|disappointed/i', $content)) {
        $emotions[] = [
            'name' => 'Frustration',
            'intensity' => $context['current_stakes'] === 'critical' ? 'high' : 'moderate',
            'evidence' => 'Language indicates dissatisfaction'
        ];
    }
    
    if ($context['situation'] === 'closing' && preg_match('/excited|pleased|looking forward/i', $content)) {
        $emotions[] = [
            'name' => 'Optimism',
            'intensity' => 'high',
            'evidence' => 'Positive language in deal context'
        ];
    }
    
    if ($context['message_channel'] === 'formal-letter') {
        $emotions[] = [
            'name' => 'Formality',
            'intensity' => 'high',
            'evidence' => 'Channel requires professional distance'
        ];
    }
    
    return $emotions;
}

function analyze_strategic_insights($content, $context) {
    $insights = [];
    
    // Determine intent based on context
    if ($context['situation'] === 'negotiation') {
        $insights['intent'] = 'Testing negotiation boundaries and seeking concessions';
    } else {
        $insights['intent'] = 'Information exchange and relationship maintenance';
    }
    
    // Check for hidden agendas
    if ($context['last_interaction'] === 'conflict' && preg_match('/appreciate|understand/i', $content)) {
        $insights['hidden_agenda'] = 'Possible attempt to smooth over unresolved issues without direct confrontation';
    }
    
    // Power dynamics
    if ($context['their_company_size'] === 'fortune500' && $context['negotiation_authority'] === 'limited') {
        $insights['power_dynamics'] = 'Significant power imbalance - they have structural advantages';
    }
    
    // Gender dynamics if provided
    if ($context['user_gender'] && $context['user_gender'] !== 'prefer-not-to-say') {
        $insights['gender_dynamics'] = 'Consider potential gender communication patterns in ' . 
                                       $context['industry'] . ' industry context';
    }
    
    // Cultural considerations based on timezone
    if ($context['their_timezone'] && strpos($context['their_timezone'], 'ahead') !== false) {
        $insights['cultural_considerations'] = 'Eastern timezone suggests potential cultural differences in directness and hierarchy';
    }
    
    return $insights;
}

function analyze_language($content, $context) {
    $language = [
        'formality' => 'Moderate',
        'assertiveness' => 'Balanced',
        'clarity' => 'Clear',
        'power_words' => [],
        'red_flags' => []
    ];
    
    // Adjust formality based on channel
    if ($context['message_channel'] === 'formal-letter') {
        $language['formality'] = 'High';
    } elseif ($context['message_channel'] === 'text-whatsapp') {
        $language['formality'] = 'Low';
    }
    
    // Channel appropriateness
    if ($context['message_channel']) {
        $language['channel_appropriateness'] = assess_channel_appropriateness($content, $context['message_channel']);
    }
    
    // Detect power words
    if (preg_match_all('/\b(must|require|expect|demand|insist)\b/i', $content, $matches)) {
        $language['power_words'] = array_unique($matches[1]);
    }
    
    // Red flags based on context
    if ($context['legal_context'] === 'true' && preg_match('/guarantee|promise|commit/i', $content)) {
        $language['red_flags'][] = 'binding language';
    }
    
    if ($context['current_stakes'] === 'critical' && preg_match('/maybe|perhaps|might/i', $content)) {
        $language['red_flags'][] = 'uncertainty in high-stakes';
    }
    
    // Urgency detection
    if (preg_match('/asap|urgent|immediately|today/i', $content)) {
        $language['urgency'] = 'High';
    } elseif (preg_match('/soon|shortly|next week/i', $content)) {
        $language['urgency'] = 'Moderate';
    } else {
        $language['urgency'] = 'Low';
    }
    
    return $language;
}

function assess_channel_appropriateness($content, $channel) {
    $word_count = str_word_count($content);
    
    switch($channel) {
        case 'text-whatsapp':
            if ($word_count > 100) return 'Too long for channel';
            if (preg_match('/Dear|Sincerely|Regards/i', $content)) return 'Too formal for channel';
            return 'Appropriate';
            
        case 'email':
            if ($word_count < 20) return 'Too brief for email';
            return 'Appropriate';
            
        case 'formal-letter':
            if (!preg_match('/Dear|Sincerely|Regards/i', $content)) return 'Lacks formal structure';
            return 'Appropriate';
            
        default:
            return 'Appropriate';
    }
}

function generate_response($original, $context) {
    // Generate response based on tone and full context
    $tone = $context['tone'] ?? 'professional';
    $response = "Thank you for your message.\n\n";
    
    // Adjust based on context
    if ($context['last_interaction'] === 'conflict') {
        $response = "I appreciate you reaching out.\n\n";
    }
    
    if ($context['legal_context']) {
        $response .= "For clarity and documentation purposes, ";
    }
    
    // Add tone-specific elements
    switch($tone) {
        case 'assertive':
            $response .= "I want to be direct about our position. ";
            break;
        case 'diplomatic':
            $response .= "I understand your perspective and would like to explore a mutually beneficial approach. ";
            break;
        case 'collaborative':
            $response .= "Let's work together to find the best solution. ";
            break;
        case 'firm':
            $response .= "While I respect your position, I must be clear about our requirements. ";
            break;
    }
    
    // Channel-specific formatting
    if ($context['message_channel'] === 'text-whatsapp') {
        $response = str_replace("\n\n", "\n", $response); // More compact
    }
    
    return [
        'success' => true,
        'suggested_response' => $response . "\n\n[Specific response points based on original message]\n\nBest regards,\n[Your name]"
    ];
}

function refine_response($response, $feedback) {
    // Simple refinement simulation
    $refined = $response;
    
    if (strpos($feedback, 'polished') !== false) {
        $refined = str_replace('Thanks', 'Thank you', $refined);
        $refined = str_replace('Hi', 'Hello', $refined);
    }
    
    return [
        'success' => true,
        'refined_response' => $refined
    ];
}

// Existing functions remain the same...
function process_content($tool, $content) {
    // ... existing implementation
}

function analyze_content($content) {
    // ... existing implementation
}

function get_sheet_content($type) {
    // ... existing implementation
}
?>