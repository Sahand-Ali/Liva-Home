<?php
session_start();
include 'db_connection.php';

// Pagination
$limit = 10; // Number of images per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

// Calculate offset for the SQL query
$offset = ($page - 1) * $limit;

// Fetch images and their respective like counts from the database with pagination
$sql = "SELECT images.*, COUNT(likes.image_id) AS like_count
        FROM images
        LEFT JOIN likes ON images.id = likes.image_id
        GROUP BY images.id
        ORDER BY images.created_at DESC
        LIMIT $limit OFFSET $offset"; // Add LIMIT and OFFSET for pagination
$result = mysqli_query($conn, $sql);

// Count total number of images for pagination
$totalImages = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM images"));

// Calculate total number of pages
$totalPages = ceil($totalImages / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/Icon/flower-pot.png">
    <title>Liva Home</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    

    <!-- Custom styles -->
    <style>
        /* Blur filter for images */
        .image-container:hover .image-blur {
            filter: blur(0.5px);
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

    <div class="text-5xl font-extrabold text-center">
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-violet-500 ">
            Welcome to Liva Home
        </span>
    </div>

    <!-- Content -->
    <div class="container mx-auto py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="w-full p-2 image-container relative">
                <div class="bg-white rounded-lg bg-blue-500 shadow-lg shadow-blue-500/50 overflow-hidden">
                    <img src="images/<?php echo $row['image_name']; ?>" alt="Image"
                        class="w-full h-80 object-cover object-center image-blur transition duration-300">
                    <?php
                // Calculate time difference between current time and image's created_at timestamp
                $createdAt = strtotime($row['created_at']);
                $currentTime = time();
                $timeDifference = $currentTime - $createdAt;
                // If the image is added within the last 24 hours, display the "New" label
                if ($timeDifference <= 86400) { // 86400 seconds = 24 hours
                    echo '<div class="absolute top-2 right-3 flex items-center justify-center bg-yellow-600 text-white rounded-full w-14 h-12">
                            <img src="icon/flames.png" alt="Fire icon" class="h-6 w-6 mr-1">
                            <span class="text-xs">New!</span>
                        </div>';
                }
                ?>
                    <div class="p-4 flex justify-between items-center">
                        <span class="text-sm text-gray-600"><?php echo $row['like_count']; ?> likes</span>
                        <?php if (isset($_SESSION['username']) && ($_SESSION['username'] === 'sahand' || $_SESSION['username'] === 'latif')): ?>
                        <form action="delete.php?id=<?php echo $row['id']; ?>" method="post">
                            <button type="submit"
                                class="text-red-500 hover:text-red-700 px-3 py-1 bg-white rounded">Delete</button>
                        </form>
                        <?php else: ?>
                        <form action="like.php" method="post">
                            <input type="hidden" name="image_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="text-white px-3 py-1 bg-green-500 rounded">Like</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            <div class="flex bg-gray-800 rounded-md p-2">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>"
                    class="px-3 py-1 mx-1 <?php echo $page == $i ? 'bg-gray-300 text-gray-800' : 'bg-gray-600 text-white'; ?> rounded-md"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
        </div>

        <script>
            function toggleMobileMenu() {
                var mobileMenu = document.getElementById("mobile-menu");
                mobileMenu.classList.toggle("hidden");
            }
        </script>
        <script>
    // Check if success parameter is present in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');

    // If success parameter is present, show success alert
    if (success === '1') {
        showAlert('Image successfully added!', 'bg-green-500');
    }

    // Function to show alert
    function showAlert(message, bgColor) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `fixed top-0 right-0 m-4 p-4 rounded-md text-white ${bgColor}`;
        alertDiv.textContent = message;

        // Dismiss button
        const dismissButton = document.createElement('button');
        dismissButton.innerHTML = '&times;';
        dismissButton.className = 'float-right text-lg font-bold focus:outline-none';
        dismissButton.addEventListener('click', () => alertDiv.remove());
        alertDiv.appendChild(dismissButton);

        // Append alert to body
        document.body.appendChild(alertDiv);

        // Remove alert after 5 seconds
        setTimeout(() => alertDiv.remove(), 5000);
    }
</script>

    </div>
</body>

</html>

