<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/Icon/flower-pot.png">
    <title>Login</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
</head>
<style>
     body {
            background-color: rgb(15 23 42);
        }
</style>
<body class="bg-slate-900">
    <!-- Navbar -->
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button id="menu-toggle" onclick="toggleMobileMenu()" type="button"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed -->
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!-- Icon when menu is open -->
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <img class="h-8 w-auto" src="Icon/flower.png" alt="Your Company">
                    </div>
                    <div class="hidden sm:ml-6 sm:block ">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="index.php"
                                class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700 ">Home</a>
                            <a href="upload.php"
                                class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Upload
                                Image</a>
                            <?php if (!isset($_SESSION['username'])): ?>
                            <a href="login.php"
                                class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Login</a>
                            <?php else: ?>
                            <a href="logout.php"
                                class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Logout</a>
                            <?php endif; ?>
                            <a href="contact.html" class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Contact Us</a>
                            <a href="admin_dashboard.php" class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Admin Dashboard</a>
                        </div>
                    </div>
                </div>
                <?php if (isset($_SESSION['username'])): ?>
                <div class="mr-4 text-white">
                    Welcome, <?php echo $_SESSION['username']; ?>!
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
            <div class="flex flex-col space-y-1 px-2 pb-3 pt-2 items-center">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <a href="index.php"
                    class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Home</a>
                <a href="upload.php"
                    class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Upload Image</a>
                <?php if (!isset($_SESSION['username'])): ?>
                <a href="login.php"
                    class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Login</a>
                <?php else: ?>
                <a href="logout.php"
                    class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Logout</a>
                <?php endif; ?>
                <a href="contact.html"
                    class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Contact Us</a>
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="admin_dashboard.php" class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Admin Dashboard</a>
                <div class="mr-4 text-white">
                    Welcome, <?php echo $_SESSION['username']; ?>!
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="text-5xl font-extrabold text-center mt-2">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-violet-500">
                Login Form
            </span>
        </div>

    <div class="container mx-auto flex items-center justify-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-4">Login Form</h1>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required class="mb-4 p-2 border border-gray-300 rounded-lg block w-full">
                <input type="password" name="password" placeholder="Password" required class="mb-4 p-2 border border-gray-300 rounded-lg block w-full">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-lg w-full">Login</button>
            </form>
            <?php if(isset($error)) echo "<p class='text-red-500 mt-2'>$error</p>"; ?>
        </div>
    </div>
    <script>
                function toggleMobileMenu() {
                    var mobileMenu = document.getElementById("mobile-menu");
                    mobileMenu.classList.toggle("hidden");
                }
            </script>
</body>
</html>
