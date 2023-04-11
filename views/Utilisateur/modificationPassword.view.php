<h2>Modification du mot de passe de <?= $_SESSION['profil']['login'] ?></h2>
<body style="background-image: url('<?= URL ?>/public/Assets/images/backgroundimage.jpg')">
    <img src="<?= URL ?>/public/Assets/images/allmovies.png" width="200px" alt="logo">
        <div class="container">

            <section>
                <div id="login-body">
                    <h1>Modifier Mot de passe</h1>

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

                    <form method="POST" action="<?= URL ?>compte/validation_modificationPassword">
                        <input id="oldpassword" type="password" name="ancienpassword" placeholder="Ancien Mot de passe"  />
                        <input id="newpassword" type="password" name="nouveaupassword" placeholder="Nouveau Mot de passe"  />
                        <input id="confirmpassword" type="password" name="confirmpassword" placeholder="Confirmation nouveau Mot de passe"  />
                        <button id="btnModifier" type="submit" disabled >Valider</button>
                        <div id="erreur" class="alert-danger cacher-element">
                            Les passwords ne correspondent pas
                        </div>
                    </form>

                    <p class="grey">Pour annuler cliquer ! <a href="<?= URL ?>compte/profil">Ici</a>.</p>
                    <button id="btnSupCompte">Supprimer compte</button>
                    <div id="suppressionCompte" class="cacher-element">
                        <div class="alert-danger">
                            Veuillez confirmer la suppression du compte en cliquant ci-dessous !
                            <br>
                            <a href="<?= URL ?>compte/suppressionCompte" class="alert-danger">je souhaite supprimer mon compte définitivement Cliquer : ici</a>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <script src="<?= URL ?>/public/Javascript/script.js"></script>
        
</body>