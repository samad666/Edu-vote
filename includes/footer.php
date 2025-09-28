    <script src="assets/js/admin.js"></script>
    
    <!-- Additional page-specific scripts can be added here -->
    <?php if (isset($additional_scripts)): ?>
        <?php foreach ($additional_scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Inline scripts can be added here -->
    <?php if (isset($inline_scripts)): ?>
        <script>
            <?php echo $inline_scripts; ?>
        </script>
    <?php endif; ?>
    
</body>
</html>
