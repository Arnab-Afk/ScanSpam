<?php
session_start();
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);

// Get the URL from query string
$scannedUrl = isset($_GET['url']) ? $_GET['url'] : '';

// In a real implementation, you would call your scanning APIs here
// For this template, we'll use placeholder data
$scanDate = date("F j, Y, g:i a");
$safetyScore = 85; // Example score out of 100
$isSafe = $safetyScore > 70; // Just an example threshold

// Example scan results (in a real app, this would come from API calls)
$scanResults = [
    'status' => $isSafe ? 'safe' : 'suspicious',
    'virusTotal' => [
        'positives' => 2,
        'total' => 68,
        'scanDate' => $scanDate,
        'permalink' => '#'
    ],
    'googleSafeBrowsing' => [
        'status' => 'clean',
        'threats' => []
    ],
    'phishingDetection' => [
        'score' => 12, // 0-100 (higher means more likely phishing)
        'status' => 'clean'
    ],
    'malwareDetection' => [
        'detected' => false,
        'threats' => []
    ],
    'domainInfo' => [
        'registrar' => 'Example Registrar, LLC',
        'creationDate' => '2020-01-15',
        'expiryDate' => '2025-01-15',
        'age' => '3 years'
    ],
    'sslInfo' => [
        'valid' => true,
        'issuer' => 'Let\'s Encrypt Authority X3',
        'expiryDate' => '2023-12-25'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Scan Report - ScanSpam</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-shield-alt text-2xl text-blue-600"></i>
                <span class="text-xl font-bold text-gray-800">ScanSpam</span>
            </div>
            <div>
                <?php if ($isLoggedIn): ?>
                    <a href="dashboard.php" class="text-gray-600 hover:text-blue-600 mr-4">Dashboard</a>
                    <a href="logout.php" class="text-gray-600 hover:text-blue-600">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-gray-600 hover:text-blue-600 mr-4">Login</a>
                    <a href="signup.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Back to Scanner Link -->
        <div class="mb-6">
            <a href="home.php" class="text-blue-600 hover:underline flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Scanner
            </a>
        </div>
        
        <!-- URL and Summary Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">URL Scan Report</h1>
            
            <div class="border-b pb-4 mb-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="break-all">
                        <span class="text-gray-600 text-sm">Scanned URL:</span>
                        <h2 class="text-lg font-medium"><?php echo htmlspecialchars($scannedUrl); ?></h2>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <span class="text-gray-600 text-sm">Scan date: <?php echo $scanDate; ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Safety Score -->
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <div class="flex-shrink-0">
                    <?php if ($isSafe): ?>
                        <div class="bg-green-100 text-green-800 font-bold rounded-full p-6 inline-flex items-center justify-center w-24 h-24">
                            <div class="text-center">
                                <div class="text-2xl"><?php echo $safetyScore; ?></div>
                                <div class="text-xs uppercase">Safe</div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-red-100 text-red-800 font-bold rounded-full p-6 inline-flex items-center justify-center w-24 h-24">
                            <div class="text-center">
                                <div class="text-2xl"><?php echo $safetyScore; ?></div>
                                <div class="text-xs uppercase">Unsafe</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-2">
                        <?php if ($isSafe): ?>
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> This URL appears to be safe
                        <?php else: ?>
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> This URL may be dangerous
                        <?php endif; ?>
                    </h3>
                    <p class="text-gray-600">
                        <?php if ($isSafe): ?>
                            Our scan did not detect any significant security issues with this website.
                            Always exercise caution when providing personal information online.
                        <?php else: ?>
                            Our scan detected potential security risks with this website.
                            We recommend against visiting this URL or providing any personal information.
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="mt-6 flex flex-wrap gap-2">
                <a href="home.php?url=<?php echo urlencode($scannedUrl); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center">
                    <i class="fas fa-redo mr-2"></i> Rescan
                </a>
                <?php if ($isLoggedIn): ?>
                    <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 inline-flex items-center">
                        <i class="fas fa-bookmark mr-2"></i> Save Report
                    </button>
                <?php endif; ?>
                <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 inline-flex items-center">
                    <i class="fas fa-share-alt mr-2"></i> Share Report
                </button>
            </div>
        </div>
        
        <!-- Detailed Scan Results -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- VirusTotal Results -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">VirusTotal Scan</h3>
                    <a href="#" class="text-blue-600 hover:underline text-sm">View on VirusTotal</a>
                </div>
                
                <div class="flex items-center mb-4">
                    <div class="mr-4">
                        <?php if ($scanResults['virusTotal']['positives'] > 0): ?>
                            <div class="bg-yellow-100 text-yellow-800 rounded-full p-3 inline-flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        <?php else: ?>
                            <div class="bg-green-100 text-green-800 rounded-full p-3 inline-flex items-center justify-center">
                                <i class="fas fa-check"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <p class="font-medium">
                            <?php echo $scanResults['virusTotal']['positives']; ?> of <?php echo $scanResults['virusTotal']['total']; ?> engines detected issues
                        </p>
                        <p class="text-gray-600 text-sm">Last scanned: <?php echo $scanResults['virusTotal']['scanDate']; ?></p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="mb-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <?php 
                            $percentage = ($scanResults['virusTotal']['total'] - $scanResults['virusTotal']['positives']) 
                                        / $scanResults['virusTotal']['total'] * 100;
                            ?>
                            <div class="bg-green-600 h-2.5 rounded-full" style="width: <?php echo $percentage; ?>%"></div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 flex justify-between">
                        <span><?php echo $scanResults['virusTotal']['positives']; ?> detections</span>
                        <span><?php echo $scanResults['virusTotal']['total'] - $scanResults['virusTotal']['positives']; ?> clean</span>
                    </div>
                </div>
            </div>
            
            <!-- Google Safe Browsing Results -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4">Google Safe Browsing</h3>
                
                <div class="flex items-center mb-4">
                    <div class="mr-4">
                        <?php if ($scanResults['googleSafeBrowsing']['status'] == 'clean'): ?>
                            <div class="bg-green-100 text-green-800 rounded-full p-3 inline-flex items-center justify-center">
                                <i class="fas fa-check"></i>
                            </div>
                        <?php else: ?>
                            <div class="bg-red-100 text-red-800 rounded-full p-3 inline-flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <p class="font-medium">
                            <?php if ($scanResults['googleSafeBrowsing']['status'] == 'clean'): ?>
                                No threats detected by Google Safe Browsing
                            <?php else: ?>
                                Threats detected by Google Safe Browsing
                            <?php endif; ?>
                        </p>
                        <p class="text-gray-600 text-sm">Protection against phishing and malware</p>
                    </div>
                </div>
                
                <?php if ($scanResults['googleSafeBrowsing']['status'] != 'clean'): ?>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <h4 class="font-medium text-red-700 mb-2">Detected Threats:</h4>
                        <ul class="list-disc pl-5 text-red-700">
                            <?php foreach ($scanResults['googleSafeBrowsing']['threats'] as $threat): ?>
                                <li><?php echo $threat; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Phishing Detection -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4">Phishing Detection</h3>
                
                <div class="flex items-center mb-4">
                    <div class="mr-4">
                        <?php if ($scanResults['phishingDetection']['score'] < 30): ?>
                            <div class="bg-green-100 text-green-800 rounded-full p-3 inline-flex items-center justify-center">
                                <i class="fas fa-check"></i>
                            </div>
                        <?php elseif ($scanResults['phishingDetection']['score'] < 70): ?>
                            <div class="bg-yellow-100 text-yellow-800 rounded-full p-3 inline-flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        <?php else: ?>
                            <div class="bg-red-100 text-red-800 rounded-full p-3 inline-flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <p class="font-medium">
                            Phishing probability: 
                            <?php if ($scanResults['phishingDetection']['score'] < 30): ?>
                                <span class="text-green-600">Low</span>
                            <?php elseif ($scanResults['phishingDetection']['score'] < 70): ?>
                                <span class="text-yellow-600">Medium</span>
                            <?php else: ?>
                                <span class="text-red-600">High</span>
                            <?php endif; ?>
                        </p>
                        <p class="text-gray-600 text-sm">AI-based analysis of URL characteristics</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="mb-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="
                                <?php if ($scanResults['phishingDetection']['score'] < 30): ?>
                                    bg-green-600
                                <?php elseif ($scanResults['phishingDetection']['score'] < 70): ?>
                                    bg-yellow-500
                                <?php else: ?>
                                    bg-red-600
                                <?php endif; ?>
                                h-2.5 rounded-full" 
                                style="width: <?php echo $scanResults['phishingDetection']['score']; ?>%">
                            </div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 flex justify-between">
                        <span>Safe</span>
                        <span>Suspicious</span>
                        <span>Dangerous</span>
                    </div>
                </div>
            </div>
            
            <!-- Domain Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4">Domain Information</h3>
                
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-600">Registrar:</div>
                        <div class="col-span-2"><?php echo $scanResults['domainInfo']['registrar']; ?></div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-600">Creation Date:</div>
                        <div class="col-span-2"><?php echo $scanResults['domainInfo']['creationDate']; ?></div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-600">Expiry Date:</div>
                        <div class="col-span-2"><?php echo $scanResults['domainInfo']['expiryDate']; ?></div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-600">Domain Age:</div>
                        <div class="col-span-2"><?php echo $scanResults['domainInfo']['age']; ?></div>
                    </div>
                </div>
                
                <div class="mt-4 p-4 bg-blue-50 text-blue-800 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-0.5">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">
                                Newly registered domains (less than 1 year old) are more commonly associated with malicious activities. 
                                This domain has been registered for <?php echo $scanResults['domainInfo']['age']; ?>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- SSL Certificate Information -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-lg font-bold mb-4">SSL Certificate Details</h3>
            
            <div class="flex items-center mb-4">
                <div class="mr-4">
                    <?php if ($scanResults['sslInfo']['valid']): ?>
                        <div class="bg-green-100 text-green-800 rounded-full p-3 inline-flex items-center justify-center">
                            <i class="fas fa-lock"></i>
                        </div>
                    <?php else: ?>
                        <div class="bg-red-100 text-red-800 rounded-full p-3 inline-flex items-center justify-center">
                            <i class="fas fa-lock-open"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div>
                    <p class="font-medium">
                        <?php if ($scanResults['sslInfo']['valid']): ?>
                            Valid SSL Certificate
                        <?php else: ?>
                            Invalid or Missing SSL Certificate
                        <?php endif; ?>
                    </p>
                    <p class="text-gray-600 text-sm">
                        <?php if ($scanResults['sslInfo']['valid']): ?>
                            The connection to this website is encrypted and verified
                        <?php else: ?>
                            The connection to this website may not be secure
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-3 mt-4 bg-gray-50 p-4 rounded-lg">
                <?php if ($scanResults['sslInfo']['valid']): ?>
                    <div>
                        <div class="text-gray-600 text-sm">Issued By</div>
                        <div class="font-medium"><?php echo $scanResults['sslInfo']['issuer']; ?></div>
                    </div>
                    <div>
                        <div class="text-gray-600 text-sm">Expires On</div>
                        <div class="font-medium"><?php echo $scanResults['sslInfo']['expiryDate']; ?></div>
                    </div>
                    <div>
                        <div class="text-gray-600 text-sm">Status</div>
                        <div class="font-medium text-green-600">Valid</div>
                    </div>
                <?php else: ?>
                    <div class="col-span-3 text-center text-red-600">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        This website does not have a valid SSL certificate. Connection may not be secure.
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="mt-4 p-4 bg-yellow-50 text-yellow-800 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">
                            SSL certificates help secure data transmitted between your browser and the website. 
                            Websites without valid certificates may expose your information to third parties.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Malware Analysis -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-lg font-bold mb-4">Malware Analysis</h3>
            
            <div class="flex items-center mb-4">
                <div class="mr-4">
                    <?php if (!$scanResults['malwareDetection']['detected']): ?>
                        <div class="bg-green-100 text-green-800 rounded-full p-3 inline-flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                    <?php else: ?>
                        <div class="bg-red-100 text-red-800 rounded-full p-3 inline-flex items-center justify-center">
                            <i class="fas fa-virus"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div>
                    <p class="font-medium">
                        <?php if (!$scanResults['malwareDetection']['detected']): ?>
                            No malware detected
                        <?php else: ?>
                            Malware detected on this website
                        <?php endif; ?>
                    </p>
                    <p class="text-gray-600 text-sm">Analysis of website content and behavior</p>
                </div>
            </div>
            
            <?php if ($scanResults['malwareDetection']['detected']): ?>
            <div class="bg-red-50 p-4 rounded-lg">
                <h4 class="font-medium text-red-700 mb-2">Detected Threats:</h4>
                <ul class="list-disc pl-5 text-red-700">
                    <?php foreach ($scanResults['malwareDetection']['threats'] as $threat): ?>
                        <li><?php echo $threat; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php else: ?>
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <i class="fas fa-shield-alt text-green-700"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            Our scan didn't detect any malicious code or suspicious behavior on this website.
                        </p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Summary and Recommendations -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-lg font-bold mb-4">Summary and Recommendations</h3>
            
            <div class="mb-4">
                <h4 class="font-medium text-gray-800 mb-2">Overall Assessment:</h4>
                <p>
                    <?php if ($isSafe): ?>
                        Based on our comprehensive analysis, this URL appears to be <strong class="text-green-600">safe to visit</strong>.
                        The website doesn't contain any known malware, phishing attempts, or other significant security threats.
                    <?php else: ?>
                        Based on our comprehensive analysis, this URL appears to be <strong class="text-red-600">potentially dangerous</strong>.
                        We've detected several security concerns that suggest this website might be harmful.
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="mt-4">
                <h4 class="font-medium text-gray-800 mb-2">Recommendations:</h4>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <?php if ($isSafe): ?>
                        <li>You can proceed to visit this website with standard caution.</li>
                        <li>As with any website, avoid sharing sensitive information unless necessary.</li>
                        <li>Consider using ScanSpam's browser extension for real-time protection while browsing.</li>
                    <?php else: ?>
                        <li class="text-red-600 font-medium">We strongly recommend against visiting this website.</li>
                        <li>If you've already visited it, consider scanning your device for malware.</li>
                        <li>If you entered any credentials on this site, change those passwords immediately on legitimate sites.</li>
                        <li>Report this URL to our database to help protect others.</li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <?php if ($isLoggedIn): ?>
            <div class="mt-6">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center">
                    <i class="fas fa-history mr-2"></i> Add to History
                </button>
            </div>
            <?php else: ?>
            <div class="mt-6 p-4 bg-blue-50 text-blue-700 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium mb-1">Create a free account for more features</p>
                        <p class="text-sm mb-2">
                            Sign up to save your scan history, receive alerts, and access advanced scanning features.
                        </p>
                        <a href="signup.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center text-sm">
                            <i class="fas fa-user-plus mr-2"></i> Sign Up Free
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-shield-alt"></i>
                        <span class="font-bold">ScanSpam</span>
                    </div>
                    <p class="text-gray-400 text-sm mt-2">© 2025 ScanSpam. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition">About</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Privacy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Terms</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>