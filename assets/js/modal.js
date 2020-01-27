verifAutoriteTribunal();
myBoxAutoriteTribunal = $('#autoriteTribunalDelete');
verifServiceTribunal();
myBoxServiceTribunal = $('#tribunalServiceDelete');
verifAutoritePrefecture();
myBoxAutoritePrefecture = $('#prefectureAutoriteDelete');
verifServicePrefecture();
myBoxServicePrefecture = $('#prefectureServiceDelete');
verifFonctionAnimateur();
myBoxFonctionAnimateur = $('#animateurFonctionDelete');
verifStatutAnimateur();
myBoxStatutAnimateur = $('#animateurStatutDelete');
verifLieuStage();
myBoxLieuStage = $('#lieuStageDelete');
//Fonction vérification si l'autorité existe ou non pour les tribunaux
function verifAutoriteTribunal(){
    let btnDelete = document.querySelectorAll('.tribunalAutoriteDelete');
    [].forEach.call( btnDelete, (btnElement) => {
        btnElement.addEventListener('click', (e)=>{

            e.preventDefault();
            let id = btnElement.getAttribute('data-id');
            data = new FormData();
            data.append('id',id);

            fetch("/admin/tribunal/autorite/supprAlertFormAutoriteTribunal", { method: "POST", body: data, credentials: 'include'
            })
            .then((reponse) => {
                return reponse.json();
            })
            .then((reponse) => {

                if (reponse.error != null) {

                    console.log('erreur');

                } else {

                    if(reponse.nb === 0) {
                        document.querySelector('.modal-body').innerHTML = "Vous êtes sur le point de supprimer une autorité";
                        myBoxAutoriteTribunal.modal('show');
                        document.querySelector('.btn-danger').href = "/admin/tribunal/autorite/"+id+"/supprimer";
                        document.querySelector('.btn-danger').style.display = 'block';
                    } else {
                        document.querySelector('.modal-body').innerHTML = "Vous ne pouvez pas supprimer cette autorité car elle est utilisée pour un tribunal";
                        document.querySelector('.btn-danger').style.display = 'none';
                        myBoxAutoriteTribunal.modal('show');
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
        })
    })  
}

//Fonction vérification si le service existe ou non pour les tribunaux
function verifServiceTribunal(){
    let btnDelete = document.querySelectorAll('.tribunalServiceDelete');
    [].forEach.call( btnDelete, (btnElement) => {
        btnElement.addEventListener('click', (e)=>{

            e.preventDefault();
            let id = btnElement.getAttribute('data-id');
            data = new FormData();
            data.append('id',id);

            fetch("/admin/tribunal/autorite/supprAlertFormServiceTribunal", { method: "POST", body: data, credentials: 'include'
            })
            .then((reponse) => {
                return reponse.json();
            })
            .then((reponse) => {

                if (reponse.error != null) {

                    console.log('erreur');

                } else {

                    if(reponse.nb === 0) {
                        document.querySelector('.modal-body').innerHTML = "Vous êtes sur le point de supprimer un service";
                        myBoxServiceTribunal.modal('show');
                        document.querySelector('.btn-danger').href = "/admin/tribunal/service/"+id+"/supprimer";
                        document.querySelector('.btn-danger').style.display = 'block';
                    } else {
                        document.querySelector('.modal-body').innerHTML = "Vous ne pouvez pas supprimer ce service car il est utilisé pour un tribunal";
                        document.querySelector('.btn-danger').style.display = 'none';
                        myBoxServiceTribunal.modal('show');
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
        })
    })  
}

//Fonction vérification si l'autorité existe ou non pour les préfectures
function verifAutoritePrefecture(){
    let btnDelete = document.querySelectorAll('.prefectureAutoriteDelete');
    [].forEach.call( btnDelete, (btnElement) => {
        btnElement.addEventListener('click', (e)=>{

            e.preventDefault();
            let id = btnElement.getAttribute('data-id');
            data = new FormData();
            data.append('id',id);

            fetch("/admin/prefecture/autorite/supprAlertFormAutoritePrefecture", { method: "POST", body: data, credentials: 'include'
            })
            .then((reponse) => {
                return reponse.json();
            })
            .then((reponse) => {

                if (reponse.error != null) {

                    console.log('erreur');

                } else {

                    if(reponse.nb === 0) {
                        document.querySelector('.modal-body').innerHTML = "Vous êtes sur le point de supprimer une autorité";
                        myBoxAutoritePrefecture.modal('show');
                        document.querySelector('.btn-danger').href = "/admin/prefecture/autorite/"+id+"/supprimer";
                        document.querySelector('.btn-danger').style.display = 'block';
                    } else {
                        document.querySelector('.modal-body').innerHTML = "Vous ne pouvez pas supprimer cette autorité car elle est utilisée pour une préfecture";
                        document.querySelector('.btn-danger').style.display = 'none';
                        myBoxAutoritePrefecture.modal('show');
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
        })
    })  
}

//Fonction vérification si le service existe ou non pour les préfectures
function verifServicePrefecture(){
    let btnDelete = document.querySelectorAll('.prefectureServiceDelete');
    [].forEach.call( btnDelete, (btnElement) => {
        btnElement.addEventListener('click', (e)=>{

            e.preventDefault();
            let id = btnElement.getAttribute('data-id');
            data = new FormData();
            data.append('id',id);

            fetch("/admin/prefecture/service/supprAlertFormServicePrefecture", { method: "POST", body: data, credentials: 'include'
            })
            .then((reponse) => {
                return reponse.json();
            })
            .then((reponse) => {

                if (reponse.error != null) {

                    console.log('erreur');

                } else {

                    if(reponse.nb === 0) {
                        document.querySelector('.modal-body').innerHTML = "Vous êtes sur le point de supprimer un service";
                        myBoxServicePrefecture.modal('show');
                        document.querySelector('.btn-danger').href = "/admin/prefecture/service/"+id+"/supprimer";
                        document.querySelector('.btn-danger').style.display = 'block';
                    } else {
                        document.querySelector('.modal-body').innerHTML = "Vous ne pouvez pas supprimer ce service car il est utilisé pour une préfecture";
                        document.querySelector('.btn-danger').style.display = 'none';
                        myBoxServicePrefecture.modal('show');
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
        })
    })  
}

//Fonction vérification si la fonction existe ou non pour les animateurs
function verifFonctionAnimateur(){
    let btnDelete = document.querySelectorAll('.animateurFonctionDelete');
    [].forEach.call( btnDelete, (btnElement) => {
        btnElement.addEventListener('click', (e)=>{

            e.preventDefault();
            let id = btnElement.getAttribute('data-id');
            data = new FormData();
            data.append('id',id);

            fetch("/admin/animateur/fonction/supprAlertFormFonctionAnimateur", { method: "POST", body: data, credentials: 'include'
            })
            .then((reponse) => {
                return reponse.json();
            })
            .then((reponse) => {

                if (reponse.error != null) {

                    console.log('erreur');

                } else {

                    if(reponse.nb === 0) {
                        document.querySelector('.modal-body').innerHTML = "Vous êtes sur le point de supprimer une fonction";
                        myBoxFonctionAnimateur.modal('show');
                        document.querySelector('.btn-danger').href = "/admin/animateur/fonction/"+id+"/supprimer";
                        document.querySelector('.btn-danger').style.display = 'block';
                    } else {
                        document.querySelector('.modal-body').innerHTML = "Vous ne pouvez pas supprimer cette fonction car elle est utilisée pour un animateur";
                        document.querySelector('.btn-danger').style.display = 'none';
                        myBoxFonctionAnimateur.modal('show');
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
        })
    })  
}

//Fonction vérification si le statut existe ou non pour les animateurs
function verifStatutAnimateur(){
    let btnDelete = document.querySelectorAll('.animateurStatutDelete');
    [].forEach.call( btnDelete, (btnElement) => {
        btnElement.addEventListener('click', (e)=>{

            e.preventDefault();
            let id = btnElement.getAttribute('data-id');
            data = new FormData();
            data.append('id',id);

            fetch("/admin/animateur/statut/supprAlertFormFonctionAnimateur", { method: "POST", body: data, credentials: 'include'
            })
            .then((reponse) => {
                return reponse.json();
            })
            .then((reponse) => {

                if (reponse.error != null) {

                    console.log('erreur');

                } else {

                    if(reponse.nb === 0) {
                        document.querySelector('.modal-body').innerHTML = "Vous êtes sur le point de supprimer un statut";
                        myBoxStatutAnimateur.modal('show');
                        document.querySelector('.btn-danger').href = "/admin/animateur/statut/"+id+"/supprimer";
                        document.querySelector('.btn-danger').style.display = 'block';
                    } else {
                        document.querySelector('.modal-body').innerHTML = "Vous ne pouvez pas supprimer ce statut car il est utilisé pour un animateur";
                        document.querySelector('.btn-danger').style.display = 'none';
                        myBoxStatutAnimateur.modal('show');
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
        })
    })  
}

//Fonction vérification si le lieu de stage existe ou non pour les stages
function verifLieuStage(){
    let btnDelete = document.querySelectorAll('.lieuStageDelete');
    [].forEach.call( btnDelete, (btnElement) => {
        btnElement.addEventListener('click', (e)=>{

            e.preventDefault();
            let id = btnElement.getAttribute('data-id');
            data = new FormData();
            data.append('id',id);

            fetch("/admin/stage/lieuStage/supprAlertFormLieuStage", { method: "POST", body: data, credentials: 'include'
            })
            .then((reponse) => {
                return reponse.json();
            })
            .then((reponse) => {

                if (reponse.error != null) {

                    console.log('erreur');

                } else {

                    if(reponse.nb === 0) {
                        document.querySelector('.modal-body').innerHTML = "Vous êtes sur le point de supprimer un lieu de stage";
                        myBoxLieuStage.modal('show');
                        document.querySelector('.btn-danger').href = "/admin/stage/lieuStage/"+id+"/supprimer";
                        document.querySelector('.btn-danger').style.display = 'block';
                    } else {
                        document.querySelector('.modal-body').innerHTML = "Vous ne pouvez pas supprimer ce lieu de stage car il est utilisé pour un stage";
                        document.querySelector('.btn-danger').style.display = 'none';
                        myBoxLieuStage.modal('show');
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
        })
    })  
}