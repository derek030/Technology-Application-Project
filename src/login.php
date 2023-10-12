<?php
// Initialize the session
session_start();

include 'databaseConfig.php';

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === 1) {
    header("location: mypets.php");
    exit;
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
}

if (isset($_POST['email']) && isset($_POST['password'])) {

    // Check if username is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {

        $sql = "SELECT * FROM customer WHERE email='$email' AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['email'] === $email && $row['password'] === $password) {

                $_SESSION['email'] = $row['email'];

                $_SESSION['name'] = $row['first_name'] . ' ' . $row['last_name'];

                $_SESSION['id'] = $row['id'];

                $_SESSION['loggedin'] = 1;

                header("Location: mypets.php");

                exit();

            } else {

                header("Location: login.php?error=Incorect Email or Password");

                exit();

            }
        } else {

            header("Location: login.php?error=Incorect Email or Password");

            exit();

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Login</title>
</head>

<body>
    <!-- Main nav bar -->
    <nav>
        <!-- Main nav bar - Desktop -->
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">

                <div class="flex space-x-4">
                    <!-- logo -->
                    <div>
                        <a href="#" class="flex items-center py-5 px-2 text-gray-70">
                            <span class="font-bold font-poppins">Logo</span>
                        </a>
                    </div>

                    <!-- Left nav -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="index.php" class="py-5 px-3 text-darkblue-primary font-poppins font-medium">Home</a>
                        <a href="#" class="py-5 px-3 text-darkblue-primary font-poppins font-medium">Services</a>
                        <a href="#" class="py-5 px-3 text-darkblue-primary font-poppins font-medium">About</a>
                        <a href="#" class="py-5 px-3 text-darkblue-primary font-poppins font-medium">Contact</a>
                    </div>
                </div>

                <!-- Right nav -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="login.php"
                        class="py-2.5 px-6 bg-transparent text-darkblue-primary border border-darkblue-primary font-medium rounded-full font-poppins">Login</a>
                    <a href="register.php"
                        class="py-2.5 px-6 bg-darkblue-primary text-white rounded-full font-poppins font-medium">Register</a>
                </div>

                <!-- Mobile Hamburger Icon -->
                <div class="md:hidden flex items-center">
                    <button class="mobile-menu-button">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Main nav bar - Mobile -->
        <div class="mobile-menu hidden md:hidden">
            <a href="index.php" class="block py-2 px-6 text-darkblue-primary font-poppins">Home</a>
            <a href="#" class="block py-2 px-6 text-darkblue-primary font-poppins">Services</a>
            <a href="#" class="block py-2 px-6  text-darkblue-primary font-poppins">About</a>
            <a href="#" class="block py-2 px-6  text-darkblue-primary font-poppins">Contact</a>
            <a href="login.php" class="block py-2 px-6  text-darkblue-primary font-poppins">Login</a>
            <a href="register.php" class="block py-2 px-6  text-darkblue-primary font-poppins">Register</a>
        </div>
    </nav>

    <!-- Body Container -->
    <div class="flex flex-col h-screen justify-between">
        <!-- Main Content -->
        <div class="justify-center">
            <div class="sm:mx-auto sm:w-full md:max-w-xl">
                <h2
                    class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-darkblue-primary font-poppins">
                    Login</h2>
                <p class="mt-2.5 text-center text-sm text-darkblue-primary font-poppins">
                    Don't have an account?
                    <a href="register.php" class="font-semibold leading-6 text-state-blue">Register</a>
                </p>
            </div>
            <div class="my-12 mx-auto md:w-full md:max-w-xl px-4">
                <form class="space-y-6" action="" method="POST">
                    <div>
                        <label for="email"
                            class="block text-sm font-medium leading-6 text-darkblue-primary font-poppins">Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full rounded-md border-0 px-4 py-3.5 text-darkblue-primary shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-state-blue sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password"
                                class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        </div>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required
                                class="block w-full rounded-md border-0 px-4 py-3.5 text-darkblue-primary shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-state-blue sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                            class="flex justify-center rounded-full bg-darkblue-primary px-8 py-2.5 leading-6 text-white shadow-sm mx-auto font-poppins font-medium">Login</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Desktop -->
        <footer class="hidden md:block bg-darkblue-primary text-white rounded-t-3xl py-10">
            <!-- Footer Top -->
            <div class="mx-auto max-w-6xl">
                <div class="container flex flex-col md:flex-row justify-between items-center mx-auto">
                    <div class="space-x-6">
                        <a href="index.php" class="py-2 text-white font-poppins">Home</a>
                        <a href="#" class=" py-2 text-white font-poppins">Services</a>
                        <a href="#" class="py-2 text-white font-poppins">About</a>
                        <a href="#" class="py-2 hover\:text-white font-poppins">Contact</a>
                    </div>
                    <div class="social w-1/5 my-5 flex justify-end">
                        <!-- Facebook -->
                        <a class="block flex items-center text-gray-300 hover:text-white mr-6 no-underline" href="#">
                            <svg viewBox="0 0 24 24" class="fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23.998 12c0-6.628-5.372-12-11.999-12C5.372 0 0 5.372 0 12c0 5.988 4.388 10.952 10.124 11.852v-8.384H7.078v-3.469h3.046V9.356c0-3.008 1.792-4.669 4.532-4.669 1.313 0 2.686.234 2.686.234v2.953H15.83c-1.49 0-1.955.925-1.955 1.874V12h3.328l-.532 3.469h-2.796v8.384c5.736-.9 10.124-5.864 10.124-11.853z" />
                            </svg>
                        </a>
                        <!-- Twitter -->
                        <a class="block flex items-center text-gray-300 hover:text-white no-underline" href="#">
                            <svg viewBox="0 0 24 24" class="fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23.954 4.569a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.061a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="mx-auto max-w-6xl">
                <div
                    class="border-t border-white container flex flex-col md:flex-row justify-between items-center mx-auto">
                    <div class="my-5 font-poppins">
                        © 2023. All right reserved
                    </div>
                    <div class="space-x-6">
                        <a href="#" class="py-2 text-white font-poppins">Terms of Service</a>
                        <a href="#" class="py-2 text-white font-poppins">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Footer Mobile -->
        <footer class="md:hidden bg-darkblue-primary text-white rounded-t-3xl">
            <!-- Footer Top -->
            <div class="container overflow-hidden flex flex-col lg:flex-row mx-auto px-4 py-8">
                <div class="w-full mx-auto p-2">
                    <!-- Links -->
                    <ul class="w-full flex flex-col text-gray-700 list-none text-left">
                        <li class="py-2"><a href="index.php" class=text-white font-poppins">Home</a>
                        </li>
                        <li class="py-2"><a href="#" class="text-white font-poppins">Services</a>
                        </li>
                        <li class="py-2"><a href="#" class=" text-white font-poppins">About</a>
                        </li>
                        <li class="py-2"><a href="#" class="text-white font-poppins">Contact</a>
                        </li>
                        <li class="py-2"><a href="#" class="text-white font-poppins">Terms of Service</a>
                        </li>
                        <li class="py-2"><a href="#" class="text-white font-poppins">Privacy Policy</a>
                        </li>
                    </ul>
                    <!-- Socials -->
                    <ul class="mt-8 flex justify-start gap-6 space-x-4 mt-4 sm:justify-end">
                        <!-- Facebook -->
                        <li>
                            <a href="/" rel="noreferrer" target="_blank" class="text-white">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>

                        <!-- Instagram -->
                        <li>
                            <a href="/" rel="noreferrer" target="_blank" class="text-white">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>

                        <!-- Twitter -->
                        <li>
                            <a href="/" rel="noreferrer" target="_blank" class="text-white">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div
                class="border-t border-white flex flex-col md:flex-row justify-center items-center p-6 mt-4 text-white">
                <div>© 2023. All rights reserved.</div>
            </div>
        </footer>
    </div>

    <!-- Javascript -->
    <script>
        $(document).ready(function () {
            const btn = document.querySelector("button.mobile-menu-button");
            const menu = document.querySelector(".mobile-menu");

            // add event listeners
            btn.addEventListener("click", () => {
                menu.classList.toggle("hidden");
            });


        });
    </script>
</body>

</html>