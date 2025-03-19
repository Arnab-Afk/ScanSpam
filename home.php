<?php
session_start();
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);

// Handle form submission
$scanResults = null;
$scannedUrl = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['url'])) {
    $scannedUrl = $_POST['url'];
    // Here you would process the URL with your scanning logic
    // For now, just a placeholder
    // $scanResults = scanUrl($scannedUrl);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScanSpam - Protect Yourself from Malicious URLs</title>
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

    <!-- Hero Section -->
    <section class="container mx-auto px-4 flex flex-col items-center justify-center py-16 flex-grow">
        <h1 class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-4">
            Stay Safe Online with <span class="text-blue-600">ScanSpam</span>
        </h1>
        <p class="text-xl text-gray-600 text-center mb-10 max-w-2xl">
            Check if a URL is malicious or safe before visiting. Protect yourself from phishing attacks and harmful websites.
        </p>
        
        <!-- URL Scanner Input -->
        <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg p-8 mb-10">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">
                <label for="url" class="block text-lg font-medium text-gray-700 mb-2">Enter a URL to scan</label>
                <div class="flex">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-link text-gray-400"></i>
                        </div>
                        <input type="url" id="url" name="url" value="<?php echo htmlspecialchars($scannedUrl); ?>" 
                            class="pl-10 w-full py-3 px-4 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            placeholder="https://example.com" required>
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-r-lg hover:opacity-90 transition duration-300 flex items-center">
                        <span>Scan</span>
                        <i class="fas fa-search ml-2"></i>
                    </button>
                </div>
            </form>
            
            <?php if ($scanResults): ?>
                <!-- Display scan results here -->
                <div class="mt-6 p-4 border rounded-lg">
                    <h3 class="font-bold mb-2">Scan Results for <?php echo htmlspecialchars($scannedUrl); ?></h3>
                    <!-- Add your scan results display logic here -->
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Feature Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-4xl mb-10">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="rounded-full bg-blue-100 h-12 w-12 flex items-center justify-center mb-4">
                    <i class="fas fa-bolt text-blue-600"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Fast Analysis</h3>
                <p class="text-gray-600">Scan URLs in seconds and get immediate results about potential threats.</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="rounded-full bg-green-100 h-12 w-12 flex items-center justify-center mb-4">
                    <i class="fas fa-database text-green-600"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Comprehensive Database</h3>
                <p class="text-gray-600">We check against millions of known threats and utilize AI for detection.</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="rounded-full bg-purple-100 h-12 w-12 flex items-center justify-center mb-4">
                    <i class="fas fa-user-shield text-purple-600"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Privacy Focused</h3>
                <p class="text-gray-600">We don't store your browsing history or share your personal information.</p>
            </div>
        </div>
        
        <!-- How It Works Section -->
        <div class="w-full max-w-4xl text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">How It Works</h2>
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="p-4 flex flex-col items-center">
                    <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <span class="font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="font-bold mb-2">Enter URL</h3>
                    <p class="text-gray-600 text-sm">Paste the suspicious link in the scanner</p>
                </div>
                
                <div class="hidden md:block text-gray-400">
                    <i class="fas fa-chevron-right"></i>
                </div>
                
                <div class="p-4 flex flex-col items-center">
                    <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <span class="font-bold text-blue-600">2</span>
                    </div>
                    <h3 class="font-bold mb-2">Analyze</h3>
                    <p class="text-gray-600 text-sm">Our system checks against known threats</p>
                </div>
                
                <div class="hidden md:block text-gray-400">
                    <i class="fas fa-chevron-right"></i>
                </div>
                
                <div class="p-4 flex flex-col items-center">
                    <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <span class="font-bold text-blue-600">3</span>
                    </div>
                    <h3 class="font-bold mb-2">Get Results</h3>
                    <p class="text-gray-600 text-sm">View detailed safety report and recommendations</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
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