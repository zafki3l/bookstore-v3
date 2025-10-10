<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/<?= PROJECT_NAME ?>/public/css/layouts/homepage/header.css">
    <link rel="stylesheet" href="/<?= PROJECT_NAME ?>/public/css/layouts/homepage/footer.css">
    <link rel="stylesheet" href="/<?= PROJECT_NAME ?>/public/css/rule.css">
    <title><?= $data['title'] ?></title>
</head>
<body>
    <!-- HEADER -->
     <?php include_once VIEW_PATH . '/layouts/parts/homepage/header.homepage.php' ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?= $data['content']; ?>
    </div>

    <!-- FOOTER -->
    <?php include_once VIEW_PATH . '/layouts/parts/homepage/footer.homepage.php' ?>
</body>
</html>