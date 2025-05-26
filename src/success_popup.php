<?php
session_start();
require 'database.php'; // make sure this file defines $conn (mysqli connection)

$name = "User"; // default

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT name FROM member_info WHERE member_id = ?");
    if ($stmt) {
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $stmt->bind_result($fetchedName);

        if ($stmt->fetch()) {
            $name = htmlspecialchars($fetchedName);
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
      <link rel="shortcut icon" type="x-icon" href="img/library-managment.png">
    <meta charset="UTF-8">
    <title>Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <!-- Popup Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <!-- Popup Box -->
        <div class="bg-white rounded-xl shadow-2xl p-6 max-w-sm w-full mx-4 scale-100 opacity-100 transition-all">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Text -->
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-800 mb-2">Success!</h3>
                <p class="text-gray-600 mb-2">
                    Thanks, <?php echo $name; ?>.<br>
                    You are able to read this book.
                </p>


                <a href="bookscollection.php"
                    class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-6 rounded-lg inline-block">
                    Continue
                </a>
            </div>
        </div>
    </div>

</body>

</html>