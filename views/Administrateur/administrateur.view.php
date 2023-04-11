<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= URL ?>/public/CSS/main.css">
    <title>Document</title>
</head>
<body>
    <h1>Page administrateur</h1>
    <header class="header-profil">
        <div class="logo">
            <img class="logo-allmovie" src="<?= URL ?>/public/Assets/images/allmovies.png" alt="logo">

        </div>
                <!-- ***** CONTAINER CACHER ***** -->
        <div id="modificationMail" class="cacher-element">
            <form method="POST" action="<?= URL ?>compte/validation_modificationMail">
                <div class="container-modifMail">
                    <label for="mail">Modifier email</label>
                    <input type="email" name="mail" id="mail" value="<?= $utilisateur['mail'] ?>">
                </div>
                <div>
                    <button id="btnValidModifMail">Valider</button>
                </div>
            </form>
        </div>
                <!-- ******** FIN DU CONTAINER CACHER ****** -->

            <?php 
            if(!empty($_SESSION['alert'])) {
                    foreach($_SESSION['alert'] as $alert){
                        echo "<p class='alert ".$alert['type'] ."'role='alert'>
                            ".$alert['message']."
                        </p>";
                    }
                    unset($_SESSION['alert']);
                }
            ?>

        <form action="#" id="form">
            <input type="text" name="search" id="search" class="search" placeholder="Rechercher un utilisateur">
        </form>

        <?php if(empty($_SESSION['profil'])) : ?>
            <div id="container-infoProfil">
                <a href="<?= URL ?>login">Se connecter</a>
        <?php else : ?>
                <div class="header-right">
                    <a title="Modifier Mot de passe" href="<?= URL ?>compte/modificationPassword"><?= $utilisateur['login'] ?><ion-icon name="person-outline"></ion-icon></a>
                    <span>Mail:<?= $utilisateur['mail'] ?></span>
                    <button title="Modifier Mail" class="btn-modifMail"><ion-icon name="pencil-outline"></ion-icon></button>
                    <a href="<?= URL ?>compte/deconnexion"> Déconnexion</a>
                </div>
            </div>
        <?php endif ?>
    </header>

     <table class="table-admin">
        <thead>
            <tr>
                <th class="th">LOGIN</th>
                <th class="th">COMPTE VALIDE</th>
                <th class="th">ROLE</th>
                <th class="th">EMAIL</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $utilisateur) : ?>
                <tr class="tr">
                    <td class="td"><?= $utilisateur['login'] ?></td>
                    <td class="td"><?= (int)$utilisateur['est_valide'] === 0 ? "non validé" : "validé" ?></td>
                    <td class="td"><?= $utilisateur['role'] ?></td>
                    <td class="td"><?= $utilisateur['mail'] ?></td>
                </tr>
            <?php endforeach ?>
            
        </tbody>
     </table>


<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="<?= URL ?>/public/Javascript/script.js"></script>
<script src="<?= URL ?>/public/Javascript/main.js"></script>
</body>
</html>

</body>
</html>