<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize input
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $total_quantity = (int)$_POST['total_quantity'];
    $available_quantity = (int)$_POST['available_quantity'];
    $category = $conn->real_escape_string($_POST['category']);
    $date_added = $conn->real_escape_string($_POST['date_added']);

    // Handle image upload
    if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
        $target_dir = "img/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $filename = basename($_FILES["upload_file"]["name"]);
        $target_file = $target_dir . time() . '_' . $filename;

        // Move uploaded file
        if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
            $image_path = $conn->real_escape_string($target_file);
        } else {
            $image_path = '';
        }
    } else {
        $image_path = '';
    }

    // Insert query
    $sql = "INSERT INTO bookscollection (books_id, title, author, total_quantity, available_quantity, category, date_added, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissss", $book_id, $title, $author, $total_quantity, $available_quantity, $category, $date_added, $image_path);

    if ($stmt->execute()) {
        // Success - redirect or show success message
        header("Location: resources.php?success=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
      <link rel="shortcut icon" type="x-icon" href="img/library-managment.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-blue-50 font-sans text-blue-900">
  <!-- Mobile Header -->
    <header class="md:hidden bg-white p-4 flex items-center justify-between border-b">
        <h1 class="text-xl font-semibold">DEF Library</h1>
        <button id="menuToggle" class="w-8 h-8  rounded">
            <a href="#"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bxs-book-reader text-4xl'></i>
            </a>
        </button>
    </header>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar"
        class="fixed top-0 right-0 h-full w-20 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden overflow-y-auto ">

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="p-2 flex flex-col items-center space-y-6 mt-10">
            <a href="welcome.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx  bx-book-bookmark text-4xl'></i> 
                <span class="text-sm font-medium">Library</span>
            </a>

            <a href="my_dashboard.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                 <i class='bx bx-share-alt text-4xl'></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <a href="resources.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bx-book-open text-4xl'></i>
                <span class="text-sm font-medium">Resources</span>
            </a>
             <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>

            <a href="bookscollection.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bxs-book text-4xl'></i>
                <span class="text-sm font-medium">Books</span>
            </a>

            <a href="members.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bx-group text-4xl'></i>
                <span class="text-sm font-medium">Member</span>
            </a>

            <?php endif; ?>

            <a href="settings.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bx-cog text-4xl'></i>
                <span class="text-sm font-medium">Settings</span>
            </a>

            <a href="logout.php" class="flex flex-col items-center text-center space-y-1 hover:text-red-600 transition">
                <i class='bx bx-log-out text-4xl'></i>
                <span class="text-sm font-medium">Logout</span>
            </a>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden"></div>

    
<div class="flex">
    <!-- Sidebar (Desktop - Fixed) -->
    <div class="hidden md:fixed sm:fixed md:flex w-20 h-screen bg-white border-r flex-col items-center py-4 space-y-10">
        <div class="w-8 h-8 rounded flex flex-col items-center justify-center mt-6">
            <a href="" class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bxs-book-reader text-4xl'></i>
            </a>
        </div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <!-- Admin-visible links -->
            <div class="w-8 h-8 rounded flex flex-col items-center justify-center mt-6">
            <a href="welcome.php" class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx  bx-book-bookmark text-4xl'></i> 
                 <span class="text-sm font-medium">Library</span>
            </a>
        </div>

            <a href="my_dashboard.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-share-alt text-4xl'></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <a href="resources.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-book-open text-4xl'></i>
                <span class="text-sm font-medium">Resources</span>
            </a>

        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
            <!-- User-visible links -->
            <a href="members.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-group text-4xl'></i>
                <span class="text-sm font-medium">Member</span>
            </a>

            <a href="bookscollection.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bxs-book text-4xl'></i>
                <span class="text-sm font-medium">Books</span>
            </a>

            <a href="user_store.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-store text-4xl'></i>
                <span class="text-sm font-medium">Store</span>
            </a>
        <?php endif; ?>

        <!-- Common to both roles -->
        <a href="settings.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
            <i class='bx bx-cog text-4xl'></i>
            <span class="text-sm font-medium">Settings</span>
        </a>

        <a href="logout.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-red-600 transition">
            <i class='bx bx-log-out text-4xl'></i>
            <span class="text-sm font-medium">Logout</span>
        </a>
    </div>
</div>
        <!-- main containt -->
        <main class="w-full md:ml-20 pt-20 md:pt-6 px-4">
          <h1 class="text-3xl font-bold mb-6">Overview</h1>

            <div class="bg-white rounded-xl shadow p-8 max-w-4xl mx-auto space-y-6">

              
                




                <!-- Navigation Arrows -->
                <div class="flex justify-end space-x-2">
                    <button class="bg-[#1e2a56] text-white px-3 py-1 rounded">&lt;</button>
                    <button class="bg-[#1e2a56] text-white px-3 py-1 rounded">&gt;</button>
                </div>

                <!-- Form Fields -->
                <form class="space-y-4" method="POST" action="resources.php" enctype="multipart/form-data">
                  <!-- Image Upload -->
                <div
                    class="relative w-[200px] h-[300px] border-dashed border-2 border-gray-300 rounded-lg flex items-center justify-center text-center mx-auto mb-6 overflow-hidden">

                    <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden" alt="Preview" />

                    
                        <input type="file" name="upload_file" accept="image/*"
                         class="absolute inset-0 opacity-0 cursor-pointer z-10" required onchange="previewImage(event)">


                    <p id="placeholder" class="text-gray-500 text-sm pointer-events-none z-0">
                        Drop files to upload<br><span class="text-blue-500 underline">or browse</span>
                    </p>
                </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Book ID -->
                        <div>
                            <label class="block text-[#1e2a56] font-medium mb-1">Book ID</label>
                            <input type="text" name="book_id" class="w-full border rounded px-3 py-2" />
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-[#1e2a56] font-medium mb-1">Title</label>
                            <input type="text" name="title" class="w-full border rounded px-3 py-2" />
                        </div>

                        <!-- Author -->
                        <div>
                            <label class="block text-[#1e2a56] font-medium mb-1">Author</label>
                            <input type="text" name="author" class="w-full border rounded px-3 py-2" />
                        </div>

                        <!-- Total Quantity -->
                        <div>
                            <label class="block text-[#1e2a56] font-medium mb-1">Total Quantity</label>
                            <input type="number" name="total_quantity" class="w-full border rounded px-3 py-2" />
                        </div>

                        <!-- Available Quantity -->
                        <div>
                            <label class="block text-[#1e2a56] font-medium mb-1">Available Quantity</label>
                            <input type="number" name="available_quantity" class="w-full border rounded px-3 py-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-[#1e2a56] font-medium mb-1">Category</label>
                            <input type="text" name="category" class="w-full border rounded px-3 py-2" />
                        </div>

                        <!-- Date Added -->
                        <div>
                            <label class="block text-[#1e2a56] font-medium mb-1">Date Added</label>
                            <input type="date" name="date_added" class="w-full border rounded px-3 py-2" />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-4 mt-4">
                        <button type="submit" class="bg-[#1e2a56] text-white px-6 py-2 rounded">Save</button>
                        <button type="reset" class="bg-[#1e2a56] text-white px-6 py-2 rounded">Cancel</button>
                    </div>
                </form>

            </div>
        </main>
    </div>

 <script>
    

    // Mobile Sidebar Toggle

    const menuBtn = document.getElementById("menuToggle");
    const sidebar = document.getElementById("mobileSidebar");
    const overlay = document.getElementById("overlay");

    menuBtn.addEventListener("click", () => {
        sidebar.classList.toggle("translate-x-full");
        overlay.classList.toggle("hidden");
    });

    overlay.addEventListener("click", () => {
        sidebar.classList.add("translate-x-full");
        overlay.classList.add("hidden");
    });
    //for upload image

function previewImage(event) {
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('placeholder');
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}


    
    </script>
</body>

</html>

