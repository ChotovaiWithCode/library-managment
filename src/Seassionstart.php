<?php
session_start();
$login = false;
$showError = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
        include 'database.php';
    $email = $_POST['email'];
    $password = $_POST['password']; 
    
     
//     $sql = "Select * from users where username='$username' AND password='$password'";
    $sql = "SELECT* FROM `users`WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      
      // Verify the password
      if (password_verify($password, $row['password'])) {
          // Password matches
          $_SESSION['loggedin'] = true;
          $_SESSION['email'] = $email;
          header("Location:librarypage.php");
          echo'hello';
          exit();
      } else {
          $showError="Invalid password!";
      }
  } else {
     $showError="No user found with this email!";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
          <button class="text-xl mx-[15px]"
          onclick="window.location.href='contactus.php'";>
          Contact</button>
          <button class="text-xl mx-[15px] h-[40px] md:h-full w-full md:w-[200px] bg-black rounded-full text-white disabled:">
              Start Session
          </button>
          <button class="text-xl mx-[15px] h-[40px] md:h-full w-full md:w-[200px] bg-black rounded-full text-white"
          onclick="window.location.href='registrationform.php'";>
              Register yourself
          </button>
      </div>
  </div>
</div>

  <!-- Form Section -->
  <div class="h-auto md:h-[825px] w-full flex items-center justify-center px-4 py-8 md:py-0">
    <div class="h-auto md:h-[420px] w-full md:w-[460px] bg-white p-8 rounded-lg shadow-2xl max-w-md">
      <h1 class="text-3xl font-bold mb-6 text-center">Session Start</h1>
      <form action="Seassionstart.php" method="POST">
        <!-- Email Field -->
        <div class="mb-[30px]">
          <input type="email" id="email" name="email" placeholder="Email" required
            class="mt-1 block h-[50px] w-full px-4 py-3 bg-cyan-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
            
        </div>

        <!-- Password Field -->
        <div class="mb-[30px]">
          <input type="password" id="password" name="password" placeholder="Password" required
            class="mt-1 block h-[50px] w-full px-4 py-3 bg-cyan-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
            <span style="color:red;"><?php echo $showError?></span>
        </div>

        <!-- Checkbox -->
        <div class="cheak h-[35px] w-full mb-[10px]">
          <input type="checkbox" id="cheakbox" name="cheakbox" value="Bike">
          <label for="remember" class="text-lg">Remember me</label>
        </div>

        <!-- Submit Button -->
        <div class="flex w-full justify-center mb-4">
          <button type="submit"
            class="px-4 py-2 h-[46px] w-full bg-cyan-600 text-white rounded-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
            Sign Up
          </button>
        </div>

        <!-- Login Link -->
        <div class="text-center">
          <p class="text-sm text-gray-600">
            Already have an account?
            <a href="registrationform.php" class="text-cyan-600 hover:text-cyan-700">Login here</a>
          </p>
        </div>
      </form>
    </div>
  </div>
</body>

</html>