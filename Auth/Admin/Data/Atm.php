
<?php


    session_start();
    if (!isset($_SESSION['name']) || $_SESSION['user_type'] != "Admin") {
        header("Location: ../../Login.php");
        exit;
    }
    
    include('../../-- DATABASE/db-connection.php');

    if (isset($_POST['add_atm'])) {
        
        $agenceId = $_POST['agenceId'];
        $longitude = $_POST['longitude'];
        $laltitude = $_POST['laltitude'];

        $getBankId = "SELECT bank_id FROM agence WHERE id = $agenceId";
        // $bankId = mysqli_fetch_assoc($cnx->query($getBankId));
        $result = mysqli_query($cnx, $getBankId);

        $row = mysqli_fetch_assoc($result);
        $bankId = $row['bank_id'];


        if (empty($agenceId) || empty($longitude) || empty($laltitude)) {
            echo "<script>window.alert('Inputs should not be empty');</script>";
        } else {

            $query = "
                INSERT INTO distributeur (bank_id, longitude, latitude, agence_id)
                VALUES ('$bankId', $longitude, $laltitude, $agenceId);
            ";

            $run_query = mysqli_query($cnx, $query);
            echo "<script>window.alert('distrubuteur Added succesfully');</script>";
        }
    }

    $fetchAtm = "SELECT * FROM distributeur";
    $AtmData = $cnx->query($fetchAtm);

    $fetchAgencies = "SELECT * FROM agence";
    $AgenciesData = $cnx->query($fetchAgencies);

    if (isset($_GET['rm'])) {

        $Atm_to_remove = $_GET['rm'];

        $delete_Atm = "DELETE FROM distributeur WHERE id = $Atm_to_remove";

        $run_delete = mysqli_query($cnx, $delete_Atm);
        echo "<script>window.alert('distrubuteur Deleted succesfully');</script>";
        header("Location: Atm.php");
    }

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../../Login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
</head>
<body>

<div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="">

                <div class="hidden md:block">
                    <div class=" flex items-baseline space-x-4">
                    <a href="../index.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium" >Home</a>
                    <a href="bank.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Bank's</a>
                    <a href="Agencies.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Agency's</a>
                    <a href="Atm.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">Distrubuteur's</a>
                    <a href="Roles.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Role's</a>
                    <a href="Users.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">User's</a>
                    <a href="Addresses.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Address's</a>
                    <a href="Accounts.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Account's</a>
                    <a href="Transactions.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
                    </div>
                </div>
                </div>
                <div class="hidden md:block">

                <div class="ml-4 flex items-center md:ml-6">
                    <!-- <button >Log Out</button> -->
                    <form method="post" style="display: flex; align-items: center;">
                        <?php
                        echo "<h3 style='color: white; margin-right: 30px;'> ( User Name : " . $_SESSION['name']. " )</h3>";
                        ?>
                        <button style="color: red;" name="logout" type="submit">Log Out</button>
                    </form>
                </div>
                
                </div>
            </div>
            </div>

            
        </nav>


        <!-- PAGE CONTENT ===================== -->
        <section class="mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" >
            <form method="post" placeholder class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <!-- <select name="type" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <option value="" selected>Choose bank</option>
                    <option value="credit">CIH BANK</option>
                </select>  -->
                <select name="agenceId" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <option value="">Choose Agency </option>
                    <?php
                        foreach($AgenciesData as $agency) {
                            echo "<option value='" . $agency['id'] . "'>" . $agency['bank_name']. " </option>";
                        }
                    ?>  
                </select> 
                <input name="longitude" type="text" placeholder="Longitude" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="laltitude" type="text" placeholder="Laltitude" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">

                <button name="add_atm" type="submit" class="bg-gray-600 text-white text-xl rounded">Add ATM</button>
            </form>
        </section>


        <!-- PAGE CONTENT ===================== -->
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Longitude</th>
                                <th scope="col" class="px-6 py-4">Latitude</th>
                                <th scope="col" class="px-6 py-4">Bank ID</th>
                                <th scope="col" class="px-6 py-4">Agency ID</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($AtmData as $Atm) {
                                    echo "<tr class='border-b dark:border-neutral-500'>";

                                    echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $Atm['id'] . "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" . $Atm['longitude'] . "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" . $Atm['latitude'] . "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" . $Atm['bank_id'] . "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" . $Atm['agence_id'] . "</td>";

                                    echo "<td class='whitespace-nowrap px-6 py-4'>";
                                    echo "<button class='bg-blue-600 mr-4 py-2 px-8 text-white font-bold'>Edit</button>";
                                    echo "<a href='Atm.php?rm=" . $Atm['id'] . "' class='bg-red-600 py-2 px-8 text-white font-bold'>Remove</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </main>
    </div>


</body>
</html>





    
