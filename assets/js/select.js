inputCommuneLieuStage();
inputCommuneStagiaire();
inputCommuneTribunal();
inputCommuneAnimateur();
inputCommunePrefecture();
inputCommuneInfraction();

function inputCommuneLieuStage() {
    let commune = document.querySelector('#lieu_stage_nom_commune');

    if (commune != null) {
        commune.addEventListener('keyup', function (e) {
            if (commune.textLength > 2) {
                fetch("/admin/stage/lieucommune", {
                        credentials: 'include'
                    })
                    .then((reponse) => {
                        return reponse.text();
                    })
                    .then((reponse) => {
                        
                        if (reponse.length > 0) {
                            let data = new FormData();
                            data.append("lieu_stage_nom_commune", commune.value);

                            fetch("/admin/stage/lieucommune", {
                                    method: "POST",
                                    body: data,
                                    credentials: 'include'
                                })
                                .then((resultat) => {
                                    return resultat.json();
                                })
                                .then((resultat) => {

                                    let selection = document.getElementById('select');
                                    selection.style.top = (commune.offsetTop + commune.scrollHeight) + "px";
                                    selection.style.left = commune.offsetLeft + "px";
                                    selection.style.width = commune.offsetWidth + "px";
                                    let ville;

                                    for (let i = 0; i < resultat.length; i++) {
                                        ville = document.createElement("p");
                                        ville.textContent = resultat[i]['nomCommune'] + " (" + resultat[i]['cp'] + ")";
                                        ville.id = i;
                                        selection.appendChild(ville);
                                        selection.classList.remove('listeHidden');
                                    }

                                    let p = selection.getElementsByTagName('p');
                                    let longitude = document.getElementById('lieu_stage_longitude');
                                    let latitude = document.getElementById('lieu_stage_latitude');


                                    for (let i = 0; i < p.length; i++) {
                                        const element = p[i];

                                        element.addEventListener('click', function (e) {
                                            commune.value = resultat[p[i].id]['nomCommune'] + " (" + resultat[p[i].id]['cp'] + ")";
                                            selection.classList.add('listeHidden');

                                            longitude.value = resultat[p[i].id]['longitude'];
                                            latitude.value = resultat[p[i].id]['latitude'];
                                        })
                                    }
                                }).catch((error) => {
                                    console.log(error);
                                });
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
            }
        });
    }
}

function inputCommuneStagiaire() {
    let communeStagiaire = document.querySelector('#stagiaire_communeStagiaire');
    if (communeStagiaire != null) {
        communeStagiaire.addEventListener('keyup', function (e) {
            if (communeStagiaire.textLength > 2) {
                fetch("/admin/stagiaire/communeStagiaire", {
                        credentials: 'include'
                    })
                    .then((reponse) => {
                        return reponse.text();
                    })
                    .then((reponse) => {
                        console.log(reponse);
                        if (reponse.length > 0) {
                            let data = new FormData();
                            data.append("stagiaire_communeStagiaire", communeStagiaire.value);

                            fetch("/admin/stagiaire/communeStagiaire", {
                                    method: "POST",
                                    body: data,
                                    credentials: 'include'
                                })
                                .then((resultat) => {
                                    return resultat.json();
                                })
                                .then((resultat) => {

                                    let selectionStagiaire = document.getElementById('selectStagiaire');
                                    selectionStagiaire.style.top = (communeStagiaire.offsetTop + communeStagiaire.scrollHeight) + "px";
                                    selectionStagiaire.style.left = communeStagiaire.offsetLeft + "px";
                                    selectionStagiaire.style.width = communeStagiaire.offsetWidth + "px";

                                    let villeStagiaire;

                                    for (let i = 0; i < resultat.length; i++) {
                                        villeStagiaire = document.createElement("p");
                                        villeStagiaire.textContent = resultat[i]['nomCommune'] + " (" + resultat[i]['cp'] + ")";
                                        villeStagiaire.id = i;
                                        selectionStagiaire.appendChild(villeStagiaire);
                                        selectionStagiaire.classList.remove('listeHidden');
                                    }

                                    let p = selectionStagiaire.getElementsByTagName('p');

                                    for (let i = 0; i < p.length; i++) {
                                        const element = p[i];

                                        element.addEventListener('click', function (e) {
                                            communeStagiaire.value = resultat[p[i].id]['nomCommune'] + " (" + resultat[p[i].id]['cp'] + ")";
                                            selectionStagiaire.classList.add('listeHidden');
                                        })
                                    }
                                }).catch((error) => {
                                    console.log(error);
                                });
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
            }
        });
    }
}

function inputCommuneTribunal() {
    let communeTribunal = document.querySelector('#tribunal_commune_tribunal');
    if (communeTribunal != null) {
        communeTribunal.addEventListener('keyup', function (e) {
            if (communeTribunal.textLength > 2) {
                fetch("/admin/tribunal/commune", {
                        credentials: 'include'
                    })
                    .then((reponse) => {
                        return reponse.text();
                    })
                    .then((reponse) => {
                        if (reponse.length > 0) {
                            let data = new FormData();
                            data.append("tribunal_commune_tribunal", communeTribunal.value);

                            fetch("/admin/tribunal/commune", {
                                    method: "POST",
                                    body: data,
                                    credentials: 'include'
                                })
                                .then((resultat) => {
                                    return resultat.json();
                                })
                                .then((resultat) => {

                                    let selectionTribunal = document.getElementById('selectTribunal');
                                    selectionTribunal.style.top = (communeTribunal.offsetTop + communeTribunal.scrollHeight) + "px";
                                    selectionTribunal.style.left = communeTribunal.offsetLeft + "px";
                                    selectionTribunal.style.width = communeTribunal.offsetWidth + "px";

                                    let villeTribunal;

                                    for (let i = 0; i < resultat.length; i++) {
                                        villeTribunal = document.createElement("p");
                                        villeTribunal.textContent = resultat[i]['nomCommune'] + " (" + resultat[i]['cp'] + ")";
                                        villeTribunal.id = i;
                                        selectionTribunal.appendChild(villeTribunal);
                                        selectionTribunal.classList.remove('listeHidden');
                                    }

                                    let p = selectionTribunal.getElementsByTagName('p');

                                    for (let i = 0; i < p.length; i++) {
                                        const element = p[i];

                                        element.addEventListener('click', function (e) {
                                            communeTribunal.value = resultat[p[i].id]['nomCommune'] + " (" + resultat[p[i].id]['cp'] + ")";
                                            selectionTribunal.classList.add('listeHidden');
                                        })
                                    }
                                }).catch((error) => {
                                    console.log(error);
                                });
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
            }
        });
    }
}

function inputCommuneAnimateur() {
    let communeAnimateur = document.querySelector('#animateur_commune_animateur');
    if (communeAnimateur != null) {
        communeAnimateur.addEventListener('keyup', function (e) {
            if (communeAnimateur.textLength > 2) {
                fetch("/admin/animateur/commune", {
                        credentials: 'include'
                    })
                    .then((reponse) => {
                        return reponse.text();
                    })
                    .then((reponse) => {
                        if (reponse.length > 0) {
                            let data = new FormData();
                            data.append("animateur_commune_animateur", communeAnimateur.value);

                            fetch("/admin/animateur/commune", {
                                    method: "POST",
                                    body: data,
                                    credentials: 'include'
                                })
                                .then((resultat) => {
                                    return resultat.json();
                                })
                                .then((resultat) => {

                                    let selectionAnimateur = document.getElementById('selectAnimateur');
                                    selectionAnimateur.style.top = (communeAnimateur.offsetTop + communeAnimateur.scrollHeight) + "px";
                                    selectionAnimateur.style.left = communeAnimateur.offsetLeft + "px";
                                    selectionAnimateur.style.width = communeAnimateur.offsetWidth + "px";

                                    let villeAnimateur;

                                    for (let i = 0; i < resultat.length; i++) {
                                        villeAnimateur = document.createElement("p");
                                        villeAnimateur.textContent = resultat[i]['nomCommune'] + " (" + resultat[i]['cp'] + ")";
                                        villeAnimateur.id = i;
                                        selectionAnimateur.appendChild(villeAnimateur);
                                        selectionAnimateur.classList.remove('listeHidden');
                                    }

                                    let p = selectionAnimateur.getElementsByTagName('p');
                                    let region = document.getElementById('animateur_region_animateur');

                                    for (let i = 0; i < p.length; i++) {
                                        const element = p[i];

                                        element.addEventListener('click', function (e) {
                                            communeAnimateur.value = resultat[p[i].id]['nomCommune'] + " (" + resultat[p[i].id]['cp'] + ")";
                                            selectionAnimateur.classList.add('listeHidden');

                                            region.value = resultat[p[i].id]['region'];
                                        })
                                    }
                                }).catch((error) => {
                                    console.log(error);
                                });
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
            }
        });
    }
}

function inputCommunePrefecture() {
    let communePrefecture = document.querySelector('#prefecture_communePrefecture');
    if (communePrefecture != null) {
        communePrefecture.addEventListener('keyup', function (e) {
            if (communePrefecture.textLength > 2) {
                fetch("/admin/prefecture/commune", {
                        credentials: 'include'
                    })
                    .then((reponse) => {
                        return reponse.text();
                    })
                    .then((reponse) => {
                        if (reponse.length > 0) {
                            let data = new FormData();
                            data.append("prefecture_communePrefecture", communePrefecture.value);

                            fetch("/admin/prefecture/commune", {
                                    method: "POST",
                                    body: data,
                                    credentials: 'include'
                                })
                                .then((resultat) => {
                                    return resultat.json();
                                })
                                .then((resultat) => {

                                    let selectionPrefecture = document.getElementById('selectPrefecture');
                                    selectionPrefecture.style.top = (communePrefecture.offsetTop + communePrefecture.scrollHeight) + "px";
                                    selectionPrefecture.style.left = communePrefecture.offsetLeft + "px";
                                    selectionPrefecture.style.width = communePrefecture.offsetWidth + "px";

                                    let villePrefecture;

                                    for (let i = 0; i < resultat.length; i++) {
                                        
                                        villePrefecture = document.createElement("p");
                                        villePrefecture.textContent = resultat[i]['nomCommune'] + " (" + resultat[i]['cp'] + ")";
                                        villePrefecture.id = i;
                                        selectionPrefecture.appendChild(villePrefecture);
                                        selectionPrefecture.classList.remove('listeHidden');
                                    }

                                    let p = selectionPrefecture.getElementsByTagName('p');

                                    for (let i = 0; i < p.length; i++) {
                                        const element = p[i];

                                        element.addEventListener('click', function (e) {
                                            communePrefecture.value = resultat[p[i].id]['nomCommune'] + " (" + resultat[p[i].id]['cp'] + ")";
                                            selectionPrefecture.classList.add('listeHidden');
                                        })
                                    }
                                }).catch((error) => {
                                    console.log(error);
                                });
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
            }
        });
    }
}

function inputCommuneInfraction() {
    let communeInfraction = document.querySelector('#infraction_lieuInfraction');
    if (communeInfraction != null) {
        communeInfraction.addEventListener('keyup', function (e) {
            if (communeInfraction.textLength > 2) {
                fetch("/admin/stagiaire/infraction/lieucommune", {
                        credentials: 'include'
                    })
                    .then((reponse) => {
                        return reponse.text();
                    })
   
                    .then((reponse) => {
                       
                        if (reponse.length > 0) {
                            let data = new FormData();
                            data.append("infraction_lieuInfraction", communeInfraction.value);

                            fetch("/admin/stagiaire/infraction/lieucommune", {
                                    method: "POST",
                                    body: data,
                                    credentials: 'include'
                                })
                                .then((resultat) => {
                                    return resultat.json();
                                })
                                .then((resultat) => {

                                    let selectionInfraction = document.getElementById('selectInfraction');
                                    
                                    selectionInfraction.style.top = (communeInfraction.offsetTop + communeInfraction.scrollHeight) + "px";
                                    console.log(communeInfraction.scrollHeight);
                                    selectionInfraction.style.left = communeInfraction.offsetLeft + "px";
                                    selectionInfraction.style.width = communeInfraction.offsetWidth + "px";
                                    let villeInfraction;

                                    for (let i = 0; i < resultat.length; i++) {
                                        
                                        villeInfraction = document.createElement("p");
                                        villeInfraction.textContent = resultat[i]['nomCommune'] + " (" + resultat[i]['cp'] + ")";
                                        villeInfraction.id = i;
                                      
                                        selectionInfraction.appendChild(villeInfraction);
                                        selectionInfraction.classList.remove('listeHidden');
                                    }

                                    let p = selectionInfraction.getElementsByTagName('p');
                                    

                                    for (let i = 0; i < p.length; i++) {
                                        const element = p[i];

                                        element.addEventListener('click', function (e) {
                                            console.log(communeInfraction.value);
                                            communeInfraction.value = resultat[p[i].id]['nomCommune'] + " (" + resultat[p[i].id]['cp'] + ")";
                                            selectionInfraction.classList.add('listeHidden');
                                            
                                          
                                        })
                                    }
                                }).catch((error) => {
                                    console.log(error);
                                });
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
            }
        });
    }
}