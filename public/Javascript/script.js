


let oldPassword = document.getElementById('oldpassword');

let newPassword = document.getElementById('newpassword');

let confirmPassword = document.getElementById('confirmpassword');

let erreur = document.getElementById('erreur')

let btnModifier = document.getElementById('btnModifier');
console.log(btnModifier);

function verificationPassword() {
    if (newPassword.value === confirmPassword.value) {
        console.log("mot de passe correct");
        btnModifier.disabled = false;
        erreur.classList.add('cacher-element');
    } else {
        console.log("mot de passe incorrect");
        btnModifier.disabled = true;
        erreur.classList.remove('cacher-element');
    }
}

newPassword.addEventListener('keyup', function(){
    verificationPassword();
})
confirmPassword.addEventListener('keyup', function(){
    verificationPassword();
})

let btnSupCompte = document.getElementById('btnSupCompte');
let suppressionCompte = document.getElementById('suppressionCompte');

btnSupCompte.addEventListener('click',function(){
    suppressionCompte.classList.remove("cacher-element");
})

let btnModifMail = document.querySelector('.btn-modifMail');
let divModificationMail = document.querySelector('#modificationMail');
let btnValidModifMail = document.querySelector('#btnValidModifMail')

btnModifMail.addEventListener('click', function(){
    divModificationMail.classList.toggle('montrer-element');
});

btnValidModifMail.addEventListener('click', function(){
    divModificationMail.classList.toggle('cacher-element');
});

