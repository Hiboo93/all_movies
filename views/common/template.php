<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $page_description ?>">
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="<?= URL ?>public/CSS/style.css">
    <link rel="stylesheet" href="<?= URL ?>public/CSS/main.css">

    <?php if(!empty($page_css)) : ?>
            <link rel="stylesheet" href="<?= URL ?>public/CSS/<?= $fichier_css ?>">
    <?php endif ?>

</head>
<body>
    

    <?php 
        if(!empty($_SESSION['alert'])) {
            foreach($_SESSION['alert'] as $alert){
                echo "<div class='alert ".$alert['type'] ."'role='alert'>
                    ".$alert['message']."
                </div>";
            }
            unset($_SESSION['alert']);
        }
    ?> 
    

    <?= $page_content ?>

    

   
    <script src="/public/Javascript/script.js"></script>
    <?php if(!empty($page_javascript)) : ?>
            <script src="<?= URL ?>/public/Javascript/main.js"></script>
    <?php endif ?>
    
    
</body>
</html>