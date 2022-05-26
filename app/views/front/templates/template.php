<!DOCTYPE html>
<html lang="fr">

<head>
    <title><?= $title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom Style -->
    <link rel="stylesheet" href="app/public/css/style.css">
    <!-- Custom Theme -->
    <link rel="stylesheet" href="app/public/css/theme.css">
</head>

<body class="theme-l5">

    <!-- On affiche la barre de navigation si on en a besoin -->
    <?php if (isset($navbar)) { echo $navbar; } ?>

    <!-- Le contenu de la page -->
    <?= $content; ?>

    <!-- Custom Scripts -->
    <script src="app/public/js/scripts.js"></script>
    
</body>

</html>