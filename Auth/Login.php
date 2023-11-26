<?php
include('-- Database/db-connection.php');

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {

        echo "<script>window.alert('Please fill in both email and password.')</script>";
    } else {
        // Use prepared statements to prevent SQL injection
        $query = "SELECT * FROM user WHERE username = ? AND password = ?";
        $stmt = $cnx->prepare($query);

        // Bind parameters
        $stmt->bind_param('ss', $username, $password);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {

            if ($user['role'] === 'admin') {
                echo "Login successful! You are an admin.";
                header('Location: Admin/index.php');
                // Add admin-specific actions if needed
            } else {
                echo "Login successful! You are a regular user.";
                header('Location: User/Data.php');
                // Add user-specific actions if needed
            }



        } else {
            echo "<script>window.alert('Invalid email or password.')</script>";
        }

        // Close the statement
        $stmt->close();
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Login Page</title>
</head>
<body>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <form action="" method="post" class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

            <input id="email" name="username" type="text" placeholder="Email Address" class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <div class="errorMessage px-4 mt-2 bg-red-600 text-white rounded mb-4"></div>
            
            <input id="password" name="password" type="password" placeholder="Password" class="px-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <div class="errorMessage px-4 mt-2 bg-red-600 text-white rounded  mb-8"></div>

            <button type="submit" name="login" class="flex w-full justify-center rounded-md bg-gray-800 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
        </form>
    </div>


    <!-- SCRIPT -->
    <script>
        
    </script>

</body>
</html>