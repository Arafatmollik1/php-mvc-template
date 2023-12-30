<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <!-- Bootstrap css and bootstrap icons -->
    <link rel="stylesheet" href="<?= $config->baseUrlEnd; ?>/assets/css/bootstrap-css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- local stylesheet -->
    <link rel="stylesheet" href="<?= $config->baseUrlEnd; ?>/assets/css/common.css<?= $actionHandler->isCacheEnabled(); ?>">
    <?php if($actionHandler->isCssDefined()): ?>
    <link rel="stylesheet" href="<?= $config->baseUrlEnd; ?>/assets/css/<?= $actionHandler->getController(); ?>.css<?= $actionHandler->isCacheEnabled(); ?>">   
    <?php endif; ?>
    <!--local js-->
    <script src="<?= $config->baseUrlEnd; ?>/assets/js/common.js<?= $actionHandler->isCacheEnabled(); ?>" defer></script>
    <?php if($actionHandler->isJsDefined()): ?>
    <script src="<?= $config->baseUrlEnd; ?>/assets/js/<?= $actionHandler->getController(); ?>.js<?= $actionHandler->isCacheEnabled(); ?>" defer></script>
    <?php endif; ?>
    <!-- Bootstrap's JS and jquery-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="<?= $config->baseUrlEnd; ?>/assets/js/bootstrap-js/bootstrap.bundle.min.js" defer></script>
</head>