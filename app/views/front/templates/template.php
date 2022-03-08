<!DOCTYPE html>
<html lang="fr">

<head>
    <title><?= $title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <!-- Custom Theme -->
    <link rel="stylesheet" href="app/public/css/theme.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="app/public/css/style.css">
</head>

<body class="theme-l5">

    <!-- On affiche la barre de navigation si on en a besoin -->
    <?php if (isset($navbar)) { echo $navbar; } ?>

    <!-- Le contenu de la page -->
    <?= $content; ?>
    
</body>
    <!-- Custom Scripts -->
    <script src="app/public/js/custom.js"></script>

</html>