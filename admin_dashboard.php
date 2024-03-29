<?php
session_start();
include 'db_connection.php';


// Query to get the number of likes received
$sqlLikes = "SELECT COUNT(*) AS like_count FROM likes";
$resultLikes = mysqli_query($conn, $sqlLikes);
$rowLikes = mysqli_fetch_assoc($resultLikes);
$likeCount = $rowLikes['like_count'];

// Query to get the number of images uploaded
$sqlImages = "SELECT COUNT(*) AS image_count FROM images";
$resultImages = mysqli_query($conn, $sqlImages);
$rowImages = mysqli_fetch_assoc($resultImages);
$imageCount = $rowImages['image_count'];

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <!-- Include Font Awesome icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="/Icon/flower-pot.png">
       <!-- Custom styles -->
       <style>
        /* Blur filter for images */
        .image-container:hover .image-blur {
            filter: blur(1px);
            /* Reduced blur when hovering */
        }

        /* Increase size of images */
        .image-container:hover img {
            transform: scale(1.1);
            /* Increase size when hovering */
        }

        body {
            background-color: rgb(15 23 42);
        }
</style>
</head>

<body class="bg-slate-900">

    <!-- Navbar (You can include your existing navbar here) -->
    <!-- Navbar code goes here -->
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
                <a href="logout.php"class="hover:no-underline hover:shadow-md inline-block px-4 py-2 mr-2 rounded-md bg-gray-600 hover:bg-gray-700">Logout</a>
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


      <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Likes Card -->
            <div class="bg-white rounded-lg p-6 flex items-center shadow-md hover:shadow-lg transition duration-300 shadow-lg shadow-blue-500/50">
                <div class="mr-4 flex-shrink-0">
                    <i class="fas fa-thumbs-up text-blue-500 text-4xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Likes Received</h2>
                    <p class="text-gray-600 mt-1"><?php echo $likeCount; ?> Likes</p>
                </div>
            </div>

            <!-- Images Card -->
            <div class="bg-white rounded-lg p-6 flex items-center shadow-md hover:shadow-lg transition duration-300 shadow-lg shadow-blue-500/50">
                <div class="mr-4 flex-shrink-0">
                    <i class="fas fa-image text-green-500 text-4xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Images Uploaded</h2>
                    <p class="text-gray-600 mt-1"><?php echo $imageCount; ?> Images</p>
                </div>
            </div>

            <!-- Add more cards as needed for additional statistics -->
        </div>
    </div>

    <!-- Footer (You can include your existing footer here) -->
    <!-- Footer code goes here -->

</body>

</html>
