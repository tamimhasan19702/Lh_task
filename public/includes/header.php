<?php
use LH\Helpers\ImageHelper;

?>



<nav class="bg-white shadow">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <a href="<?= BASE_URL ?>index.php" class="text-xl font-bold text-gray-800">
            <?php
            $logoPath = ImageHelper::getImagePath('logo.png');
            if ($logoPath !== null) {
                echo "<img src='$logoPath' alt='Logo'>";
            } else {
                echo "<span class='text-red-500'>Logo not found</span>";
            }
            ?>
        </a>
        <?php if (!isset($_SESSION['authenticated'])) { ?>
        <a href="<?= BASE_URL ?>admin/login.php"
            class="bg-primary text-white rounded-md px-4 py-2 font-montserrat hover:bg-primary transition duration-300">
            Admin panel
        </a>
        <?php } else {?>

        <a href="<?= BASE_URL ?>admin/logout.php"
            class="bg-primary text-white rounded-md px-4 py-2 font-montserrat hover:bg-primary transition duration-300">
            Logout
        </a>
        <?php } ?>
    </div>
</nav>