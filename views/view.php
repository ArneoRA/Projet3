<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="../css/projet3.css" rel="stylesheet" />
    <title>Projet 3 - Home</title>
</head>
<body>
    <header>
        <h1>Blog Jean Forteroche</h1>
    </header>

    <?php foreach ($episodes as $episode): ?>
            <article>
                <h2><?php echo $episode['titre'] ?></h2>
                <p><?php echo $episode['contenu'] ?></p>
            </article>
    <?php endforeach ?>


    <footer class="footer">
        <a href="https://github.com/ArneoRA/Projet3">Projet 3 - GitHub</a> Blog Personnalisé utilisant : PHP - MVC - POO - MiniFramework Silex - BootStrap - Twig.
    </footer>
</body>
</html>
