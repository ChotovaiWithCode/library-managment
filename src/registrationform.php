<?php
 // validation

 $firstnameErr=$lastnameErr=$emailErr=$passwordErr=$districtErr=$countryErr="";
 $firstname=$lastname=$email=$password=$district=$country="";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('database.php'); // Connect to userInfo DB
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password=$_POST['password'];
    $district = $_POST['district'];
    $country = $_POST['country'];

//cheak username exsist

$existSqlE="SELECT* FROM `users`WHERE Email='$email'";
$existSqlP="SELECT* FROM `users`WHERE Password='$password'";

$resultE=mysqli_query($conn,$existSqlE);
$resultP=mysqli_query($conn,$existSqlP);

$numberExistrowsE=mysqli_num_rows($resultE);

if($firstname==""){
                $firstnameErr='Firstname is requird*';
 }
 elseif($lastname==""){
                $lastnameErr='Lastname is requird*';
 }
       

else if($numberExistrowsE>0){
        $emailErr="Email already exist*";
        if($email==""){
                $emailErr='Email is requird*';
        }
      
      
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format*";
      }
else if($resultP==""){
        $passwordErr="Password is requird*";
       }
      
else{
      
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql="INSERT INTO `users` ( `firstname`, `lastname`, `email`, `password`, `district`, `country`, `registration_date`) VALUES ('$firstname', '$lastname', '$email', '$hash', '$district', '$country', current_timestamp());";
        $result=mysqli_query($conn,$sql);
        if($result){
                header("location:librarypage.php");
        }
 
       
      
}

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="./output.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <div class="nav h-auto md:h-[102px] w-full mx-auto flex items-center justify-center py-4 md:py-0">
        <div class="items h-auto md:h-[42px] w-full px-4 md:px-0 md:w-[1050px] flex flex-col md:flex-row items-center justify-between">
            <!-- Logo -->
            <div class="logo h-full w-auto md:w-[195px] flex items-center justify-center mb-4 md:mb-0">
                <h1 class="text-3xl font-bold cursor-pointer">LB-M</h1>
            </div>
            <!-- Nav Items -->
            <div class="items h-full w-full md:w-[855px] flex flex-col md:flex-row items-center justify-end space-y-2 md:space-y-0 md:space-x-4">
                <button class="text-xl mx-[15px]"
                onclick="window.location.href='contactus.php'";>
                Contact</button>
                <button class="text-xl mx-[15px] h-[40px] md:h-full w-full md:w-[200px] bg-black rounded-full text-white cursor-pointer"
                onclick="window.location.href='Seassionstart.php'";>
                    Start Session
                </button>
                <button class="text-xl mx-[15px] h-[40px] md:h-full w-full md:w-[200px] bg-black rounded-full text-white cursor-pointer disabled:">
                    Register yourself
                </button>
            </div>
        </div>
    </div>
    <div class="background flex flex-col items-center justify-center">
        <div class="heading h-auto w-full py-8 flex flex-col items-center justify-center text-center">
            <h1 class="text-4xl md:text-7xl font-bold mb-6">Registration Yourself</h1>
            <p class="text-lg md:text-2xl font-medium text-gray-500">O catálogo da sua biblioteca está disponível em qualquer lugar, a qualquer hora.</p>
        </div>
        <div class="bg-white p-4 md:p-8 rounded-lg shadow-md w-full md:w-[960px]">
            <!-- Heading -->
            <h1 class="text-3xl md:text-5xl font-bold mb-8 text-left">Registration Form</h1>

            <form action="registrationform.php" method="POST">
                <!-- First Name & Last Name -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input
                            type="text"
                            name="firstname"
                            id="firstName"
                            placeholder="First Name"
                            class="w-full p-3 border border-gray-300 rounded bg-cyan-50 focus:outline-none focus:border-cyan-500"
                            required
                        />
                        <span style="color:red;"><?php echo $firstnameErr?> </span>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input
                            type="text"
                            name="lastname"
                            id="lastName"
                            placeholder="Last Name"
                            class="w-full p-3 border border-gray-300 rounded bg-cyan-50 focus:outline-none focus:border-cyan-500"
                            required
                        />
                        <span style="color:red;"><?php echo $lastnameErr?> </span>
                    </div>
                </div>

                <!-- Email & District -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Email"
                            class="w-full p-3 border border-gray-300 rounded bg-cyan-50 focus:outline-none focus:border-cyan-500"
                            required
                        />
                        <span style="color:red;"><?php echo $emailErr?> </span>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Password"
                            class="w-full p-3 border border-gray-300 rounded bg-cyan-50 focus:outline-none focus:border-cyan-500"
                            required
                        />
                        <span style="color:red;"><?php echo $passwordErr?> </span>
                    </div>
                </div>

                <!-- Country -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-1">District</label>
                        <input
                            type="text"
                            name="district"
                            id="district"
                            placeholder="District"
                            class="w-full p-3 border border-gray-300 rounded bg-cyan-50 focus:outline-none focus:border-cyan-500"
                            required
                        />
                        <span style="color:red;"><?php echo $districtErr?> </span>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <input
                            type="text"
                            name="country"
                            id="country"
                            placeholder="Country"
                            class="w-full p-3 border border-gray-300 rounded bg-cyan-50 focus:outline-none focus:border-cyan-500"
                            required
                        />
                        <span style="color:red;"><?php echo $countryErr?> </span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-left">
                    <button
                        type="submit"
                        name="sub-btn"
                        class="px-6 py-3 bg-cyan-400 text-white rounded hover:bg-cyan-500 focus:outline-none cursor-pointer"
                        id="submit-btn"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>