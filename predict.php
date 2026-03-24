<?php
// Initialize variables to avoid warnings
$result = "";
$output = "No data received from Python.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sonar_data'])) {
        $sonar_data = $_POST['sonar_data'];

        // Use absolute path for python if needed, and wrap data in quotes
        // Redirecting error output (2>&1) helps see why it fails
        $command = "python model_bridge.py \"$sonar_data\" 2>&1";
        $output = shell_exec($command);
        
        $result = trim($output);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-3xl shadow-2xl text-center max-w-sm w-full border-t-8 <?php echo ($result == 'Fish') ? 'border-green-500' : 'border-red-500'; ?>">
        <h2 class="text-2xl font-bold mb-4">Detection Result</h2>
        
        <?php if ($result == "Fish"): ?>
            <div class="bg-green-100 text-green-700 p-6 rounded-2xl mb-4">
                <span class="text-6xl">🐟</span>
                <p class="text-2xl font-black mt-2">FISH DETECTED</p>
            </div>
            <p class="text-gray-600 text-sm">High probability of a biological target. Cast your nets!</p>
        <?php elseif ($result == "Rock"): ?>
            <div class="bg-red-100 text-red-700 p-6 rounded-2xl mb-4">
                <span class="text-6xl">🪨</span>
                <p class="text-2xl font-black mt-2">ROCK DETECTED</p>
            </div>
            <p class="text-gray-600 text-sm">Obstacle detected. Change course to save fuel.</p>
        <?php else: ?>
            <div class="bg-yellow-100 p-4 rounded-xl text-xs text-left mb-4 overflow-auto max-h-40">
                <p class="font-bold">System Error / Debug Info:</p>
                <pre><?php echo htmlspecialchars($output); ?></pre>
            </div>
        <?php endif; ?>

        <a href="fish.html" class="mt-6 inline-block bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-xl transition-all">← Back</a>
    </div>
</body>
</html>