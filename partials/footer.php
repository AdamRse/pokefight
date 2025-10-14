<footer>

</footer>
<script src="./js/default.js"></script>
<?php
if(file_exists("js/".PAGE_NO_EXT.".js")){
    ?>
    <script src='./js/<?= PAGE_NO_EXT ?>.js'></script>
    <?php
}
?>
</body>
</html>
<?php
ob_end_flush();