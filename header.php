<header class="fixed right-0 left-0 z-50 shadow-lg flex justify-between h-16 justify-end px-12">
    <a class="text-5xl mt-1 text-green-500 font-semibold" href="home.php">AquaLeak</a>
    <nav class="items-center flex space-x-10 justify-end text-black">
        <ul class="flex aligned-centre space-x-16">
            <li><b><a href="home.php" class="hover:underline hover:text-blue-500">Home</a></b></li>
            <li><b><a href="about_us.php" class="hover:underline hover:text-blue-500">About</a></b></li>
            <li><b><a href="contact_us.php" class="hover:underline hover:text-blue-500">Contact</a></b></li>
        </ul>
        <a href="report.php" class="rounded-[12px] py-2 px-5 bg-red-500 hover:underline hover:bg-red-700 text-black"><b>Report</b></a>
        <div class="relative group">
            <button class="rounded-[12px] bg-blue-500 text-black py-2 px-4">
                <b><?php echo $fetch_info['name'];?></b>
                <i class="fas fa-user ml-2"></i>
            </button>
            <ul class="rounded-[12px] font-bold w-full absolute hidden bg-blue-400 text-white py-2 px-4 top-full group-hover:block">
                <li><a href="user_complaint_list.php">List</a></li>
                <li><a href="logout-user.php">Logout</a></li>
                <li><a href="admin.html">Admin</a></li>
            </ul>
        </div>
    </nav>
</header>