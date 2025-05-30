<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="./output.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <div class="nav h-auto md:h-[102px] w-full mx-auto flex items-center justify-center py-4 md:py-0">
        <div class="items h-auto md:h-[42px] w-full px-4 md:px-0 md:w-[1050px] flex flex-col md:flex-row items-center justify-between">
            <!-- Logo -->
            <div class="logo h-full w-auto md:w-[195px] flex items-center justify-center mb-4 md:mb-0">
                <h1 class="text-3xl font-bold">LB-M</h1>
            </div>
            <!-- Nav Items -->
            <div class="items h-full w-full md:w-[855px] flex flex-col md:flex-row items-center justify-end space-y-2 md:space-y-0 md:space-x-4">
                <button class="text-xl mx-[15px] disabled:">Contact</button>
                <button class="text-xl mx-[15px] h-[40px] md:h-full w-full md:w-[200px] bg-black rounded-full text-white"
                onclick="window.location.href='Seassionstart.php'";>
                    Start Session
                </button>
                <button class="text-xl mx-[15px] h-[40px] md:h-full w-full md:w-[200px] bg-black rounded-full text-white"
                onclick="window.location.href='registrationform.php'";>
                    Register yourself
                </button>
            </div>
        </div>
    </div>

    <!-- Background Section -->
    <div class="background bg-[url('/src/img/contact-bg.png')] bg-cover bg-center h-auto md:h-[825px] w-full flex items-center justify-center py-8 md:py-0">
        <!-- Form Container -->
        <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg w-full md:w-[585px] max-w-md mx-4">
            <h1 class="text-3xl md:text-4xl font-bold mb-3 text-left">Contact Us</h1>
            <p class="text-lg md:text-xl mb-4 text-left">Our attendants are ready to help you!</p>
            <form>
                <!-- Name Field -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Name</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        required
                        class="mt-1 block w-full px-3 py-2 bg-cyan-100/50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        class="mt-1 block w-full px-3 py-2 bg-cyan-100/50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                </div>

                <!-- Description Field -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        required
                        class="mt-1 block w-full px-3 py-2 bg-cyan-100/50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                    ></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-start">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>