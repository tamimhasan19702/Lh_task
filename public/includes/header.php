<?php
use LH\Helpers\ImageHelper;

?>

<nav class="bg-white shadow">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <a href="/" class="text-xl font-bold text-gray-800">
            <?php
            $logoPath = ImageHelper::getImagePath('logo.png');
            if ($logoPath !== null) {
                echo "<img src='$logoPath' alt='Logo'>";
            } else {
                echo "<span class='text-red-500'>Logo not found</span>";
            }
            ?>
        </a>
        <ul class="flex space-x-4">
            <li><a href="/index.php" class="text-gray-600 hover:text-gray-800">Home</a></li>
            <li><a href="/admin/login.php" class="text-gray-600 hover:text-gray-800">Admin</a></li>
        </ul>
    </div>
</nav>