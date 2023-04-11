<body style="background-image: url('<?= URL ?>/public/Assets/images/backgroundimage.jpg')">
    <img src="<?= URL ?>/public/Assets/images/allmovies.png" width="200px" alt="logo">
        <div class="container">

            <section>
                <div id="login-body">
                    <h1>S'inscrire</h1>

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


                    <form method="POST" action="validation_creerCompte">
                        <input type="text" name="login" placeholder="Votre login" required />
                        <input type="password" name="password" placeholder="Mot de passe" required />
                        <input type="email" name="mail" placeholder="Votre adresse email" required />
                        <button type="submit">S'inscrire</button>
                    </form>

                    <p class="grey">Déjà sur ALL MOVIES ? <a href="<?= URL ?>login">Connectez-vous</a>.</p>
                </div>
            </section>

        </div>
</body>
</html>