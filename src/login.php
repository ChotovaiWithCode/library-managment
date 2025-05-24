<?php
session_start();


   

$showError = $nameErr = $emailErr = $passwordErr = "";

// DB connection
include 'database.php';

// Set default values for form persistence
$name = $email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = $_POST['role'] ?? '';

    // Validate role
    if (!in_array($role, ['admin', 'user'])) {
        $showError = "Invalid role selected.";
    }

    // SIGNUP
    if ($action === "signup") {
        $name = trim($_POST['name'] ?? '');

        // Field validation
        if (empty($name)) $nameErr = "Name is required.";
        if (empty($email)) $emailErr = "Email is required.";
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $emailErr = "Invalid email format.";
        if (empty($password)) $passwordErr = "Password is required.";
        elseif (strlen($password) < 6) $passwordErr = "Password must be at least 6 characters.";

        // If no errors
        if (empty($nameErr) && empty($emailErr) && empty($passwordErr)) {
            // Check for existing email
            $checkStmt = $conn->prepare("SELECT id FROM logininfo WHERE email = ?");
            $checkStmt->bind_param("s", $email);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $emailErr = "Email already exists.";
            } else {
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO logininfo (name, email, password, loginrole) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

                if ($stmt->execute()) {
                    if ($role === "admin") {
                    header("Location: login.php");
                } else {
                    header("Location: login.php");
                }
                exit;
                } else {
                    $showError = "Something went wrong. Try again later.";
                }
            }
        }
    }

    // SIGNIN
    elseif ($action === "signin") {
        if (empty($email)) {
            $showError = "Email is required.";
        } elseif (empty($password)) {
            $showError = "Password is required.";
        } else {
            
            $stmt = $conn->prepare("SELECT * FROM logininfo WHERE email = ? AND loginrole = ?");
            $stmt->bind_param("ss", $email, $role);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['loginrole'];
                 $_SESSION['username'] = $user['username']; 
                $_SESSION['id'] = $user['id'];
                
                header("Location: members.php");
                



                if ($role === "admin") {
                    header("Location: my_dashboard.php");
                } else {
                    header("Location: members.php");
                }
                exit;
            } else {
                $showError = "Invalid email or password.";
            }
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f4f6fb] min-h-screen flex items-center justify-center">

    <div class="flex flex-col md:flex-row bg-white rounded-lg shadow-lg overflow-hidden max-w-4xl w-full">

        <!-- Illustration Side -->
        <div class="hidden md:flex flex-col items-center justify-center bg-indigo-50 w-1/2 p-8">
            <div class="flex items-center space-x-6 mb-4">
                <button type="button" id="Admin" name="role"
                    class="text-lg font-bold text-indigo-900 border-b-2 border-indigo-900 pb-1">Admin</button>
                <button type="button" id="Users" name="role"
                    class="text-lg font-semibold text-gray-400 hover:text-indigo-600">Users</button>
            </div>
            <img src="img/lb1.1.jpg" alt="Illustration" class="w-6/6 rounded-xl">
        </div>

        <!-- Form Side -->
        <div class="w-full md:w-1/2 p-8 relative">
            <!-- Background shapes -->
            <div class="absolute inset-0 z-0">
                <div class="w-60 h-60 bg-indigo-100 rounded-full absolute -top-20 -right-20"></div>
                <div class="w-40 h-40 bg-indigo-200 rounded-full absolute -bottom-20 -left-10"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10">
                <!-- Tabs -->
                <div class="flex items-center space-x-6 mb-6">
                    <button id="signin-tab"
                        class="text-xl font-bold text-indigo-900 border-b-2 border-indigo-900 pb-1">Sign in</button>
                    <button id="signup-tab" class="text-xl font-semibold text-gray-400 hover:text-indigo-600">Sign
                        up</button>
                </div>

                <!-- Sign In Form -->
                <form id="signin-form" class="space-y-4" action="" method="POST">


                    <div>
                        <label class="block text-gray-700 font-semibold">Email</label>
                        <input type="email" name="email" placeholder="Enter your email"
                            value="<?php echo htmlspecialchars($email ?? '') ?>"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            required>
                        <span style="color:red;"><?php echo $showError?></span>

                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold">Password</label>
                        <input type="password" name="password" placeholder="Enter your password"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            required>
                        <span style="color:red;"><?php echo $showError?></span>

                    </div>

                    <!-- Add these in signup form -->
                    <input type="hidden" name="role" id="user-role" value="user">
                    <input type="hidden" name="action" value="signin">





                    <div class="text-sm text-right text-indigo-500 cursor-pointer hover:underline">Forget password?
                    </div>
                    <button type="submit"
                        class="w-full bg-indigo-900 text-white py-2 rounded-lg hover:bg-indigo-800 transition duration-200">
                        Sign in
                    </button>
                    <p class="text-sm text-center mt-4 text-gray-500">
                        Don’t have an account? <a href="#" id="goto-signup" class="text-indigo-600 hover:underline">Sign
                            up</a>
                    </p>


                </form>

                <!-- Sign Up Form -->
                <form id="signup-form" class="space-y-4 hidden" action="login.php" method="POST">


                    <!-- Role Selector -->


                    <div>
                        <label class="block text-gray-700 font-semibold">Name</label>
                        <input type="text" name="name" placeholder="Your full name"
                            value="<?php echo htmlspecialchars($email ?? '') ?>"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            required>
                        <span style="color:red;"><?php echo $nameErr?> </span>

                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold">Email</label>
                        <input type="email" name="email" placeholder="Your email address"
                            value="<?php echo htmlspecialchars($email ?? '') ?>"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            required>
                        <span style="color:red;"><?php echo $emailErr?> </span>

                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold">Password</label>
                        <input type="password" name="password" placeholder="Create a password"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            required>
                        <span style="color:red;"><?php echo $passwordErr?> </span>

                    </div>

                    <!-- Hidden Role Input -->
                    <!-- Add these in signin form -->
                    <input type="hidden" name="role" id="login-role" value="user">
                    <input type="hidden" name="action" value="signup">




                    <button type="submit"
                        class="w-full bg-indigo-900 text-white py-2 rounded-lg hover:bg-indigo-800 transition duration-200">
                        Sign up
                    </button>
                    <p class="text-sm text-center mt-4 text-gray-500">
                        Already have an account? <a href="#" id="goto-signin"
                            class="text-indigo-600 hover:underline">Sign in</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script src="login.js"></script>

</body>

</html>