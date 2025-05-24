<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Library Borrow Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-10 font-sans">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col md:flex-row">

        <!-- Left: Image Section -->
        <div class="md:w-1/2 w-full bg-indigo-100 flex items-center justify-center p-6">
            <img src="img/lb1.1.jpg" alt="Library Illustration"
                class="rounded-xl w-full max-w-sm md:max-w-full object-cover">
        </div>

        <!-- Right: Form Section -->
        <div class="md:w-1/2 w-full relative bg-white px-6 py-10 sm:px-8">

            <!-- Decorative background blobs -->
            <div class="absolute inset-0 z-0">
                <div class="w-40 h-40 bg-indigo-100 rounded-full absolute -top-10 -right-10"></div>
                <div class="w-24 h-24 bg-indigo-200 rounded-full absolute -bottom-10 -left-10"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 leading-snug">
                    Ready<br><span class="text-indigo-900">to borrow?</span>
                </h2>

                <form action="borrow_check.php" method="POST" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm text-gray-600 mb-1">Email</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900"
                            placeholder="Enter your email" />
                    </div>

                    <div>
                        <label for="member_id" class="block text-sm text-gray-600 mb-1">Member ID</label>
                        <input type="text" name="member_id" id="member_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900"
                            placeholder="Enter your ID" />
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-900 hover:bg-indigo-800 text-white py-2 rounded-lg transition duration-200">
                        Explore books
                    </button>
                </form>



                <p class="mt-4 text-sm text-gray-600">
                    Not a member? <a href="#" class="text-indigo-900 hover:underline">Create an account</a>
                </p>
            </div>
        </div>

    </div>

</body>

</html>