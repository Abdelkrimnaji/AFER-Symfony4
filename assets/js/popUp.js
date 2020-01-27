const close = document.querySelector('.close');
const close2 = document.querySelector('.close2');
const close3 = document.querySelector('.close3');
const close4 = document.querySelector('.close4');
const close5 = document.querySelector('.close5');
const close6 = document.querySelector('.close6');
const closeTribunal = document.querySelector('.closeTribunal');
const closePrefecture = document.querySelector('.closePrefecture');
const closeStagiaire = document.querySelector('.closeStagiaire');
const closeAnimateur = document.querySelector('.closeAnimateur');
const closeLieuStage = document.querySelector('.closeLieuStage');
const closeLicence = document.querySelector('.closeLicence');
const closeInfraction = document.querySelector('.closeInfraction');
// pop-up ajout service/autorité/statut/fonction dans entité tribunal/préfécture/animateur
loadFormAutoriteTribunal();
loadFormTribunalService();
loadFormPrefectureService();
loadFormPrefectureAutorite();
loadFormAnimateurFonction();
loadFormAnimateurStatut();
loadFormTribunal();
loadFormPrefecture();
loadFormStagiaire();
loadFormLieuStage();
loadFormAnimateur();
loadFormLicence();
loadFormInfraction();

function loadFormAutoriteTribunal() {
    let autorite = document.querySelector('#addAutoriteTribunal');
    if (autorite != null) {
        fetch("/admin/tribunal/autorite/loadFormAutoriteTribunal", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {

                if (reponse.length > 0) {
                    document.querySelector('#modalCart .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCart .modal-body button');

                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();

                            if (document.querySelector('form[name="tribunal_autorite"] #tribunal_autorite_nom').value.length != 0) {

                                let autorite = document.querySelector('form[name="tribunal_autorite"] #tribunal_autorite_nom');
                                let token = document.querySelector('form[name="tribunal_autorite"] #tribunal_autorite__token');
                                let data = new FormData();
                                data.append("tribunal_autorite_nom", autorite.value);
                                data.append("tribunal_autorite__token", token.value);

                                fetch("/admin/tribunal/autorite/loadFormAutoriteTribunal", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })

                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                    .then((resultat) => {
                                        if (resultat.error != null) {
                                            document.querySelector('#errorAutoriteTribunal').innerHTML = "L'autorité existe déjà";
                                        } else if (resultat.value != null) {
                                            const selectTribunalAutorite = document.querySelector('#tribunal_tribunal_autorite');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id)
                                            option.text = resultat.value;
                                            selectTribunalAutorite.add(option);
                                            selectTribunalAutorite.selectedIndex = selectTribunalAutorite.length - 1;
                                            close.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('form[name="tribunal_autorite"] #tribunal_autorite_nom').classList.add('error')
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormTribunalService() {
    let service = document.querySelector('#addServiceTribunal');

    if (service != null) {
        fetch("/admin/tribunal/service/loadFormServiceTribunal", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalCart2 .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCart2 .modal-body button');

                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();

                            if (document.querySelector('form[name="tribunal_service"] #tribunal_service_nom').value.length != 0) {

                                let service = document.querySelector('form[name="tribunal_service"] #tribunal_service_nom');
                                let token = document.querySelector('form[name="tribunal_service"] #tribunal_service__token');
                                let data = new FormData();
                                data.append("tribunal_service_nom", service.value);
                                data.append("tribunal_service_token", token.value);

                                fetch("/admin/tribunal/service/loadFormServiceTribunal", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })
                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                    .then((resultat) => {
                                        if (resultat.error != null) {
                                            document.querySelector('#error2').innerHTML = "Le service existe déjà";

                                        } else if (resultat.value != null) {
                                            const selectTribunalService = document.querySelector('#tribunal_tribunal_service');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id)
                                            option.text = resultat.value;
                                            selectTribunalService.add(option);
                                            selectTribunalService.selectedIndex = selectTribunalService.length - 1;
                                            close2.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('form[name="tribunal_service"] #tribunal_service_nom').classList.add('error')
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormPrefectureService() {
    let service = document.querySelector('#addServicePrefecture');

    if (service != null) {
        fetch("/admin/prefecture/service/loadFormServicePrefecture", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalCartServicePrefecture .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCartServicePrefecture .modal-body button');

                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();

                            if (document.querySelector('form[name="prefecture_service"] #prefecture_service_nom').value.length != 0) {

                                let service = document.querySelector('form[name="prefecture_service"] #prefecture_service_nom');
                                let token = document.querySelector('form[name="prefecture_service"] #prefecture_service__token');
                                let data = new FormData();
                                data.append("prefecture_service_nom", service.value);
                                data.append("prefecture_service__token", token.value);

                                fetch("/admin/prefecture/service/loadFormServicePrefecture", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })
                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                    .then((resultat) => {

                                        if (resultat.error != null) {
                                            document.querySelector('#errorServicePrefecture').innerHTML = "Le service existe déjà";

                                        } else if (resultat.value != null) {
                                            const selectPrefectureService = document.querySelector('#prefecture_prefectureService');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id)
                                            option.text = resultat.value;
                                            selectPrefectureService.add(option);
                                            selectPrefectureService.selectedIndex = selectPrefectureService.length - 1;
                                            close3.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('form[name="prefecture_service"] #prefecture_service_nom').classList.add('error')
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormPrefectureAutorite() {
    let autorite = document.querySelector('#addAutoritePrefecture');

    if (autorite != null) {
        fetch("/admin/prefecture/autorite/loadFormAutoritePrefecture", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalCartAutoritePrefecture .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCartAutoritePrefecture .modal-body button');

                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();

                            if (document.querySelector('form[name="prefecture_autorite"] #prefecture_autorite_nom').value.length != 0) {

                                let autorite = document.querySelector('form[name="prefecture_autorite"] #prefecture_autorite_nom');
                                let token = document.querySelector('form[name="prefecture_autorite"] #prefecture_autorite__token');
                                let data = new FormData();
                                data.append("prefecture_autorite_nom", autorite.value);
                                data.append("prefecture_autorite__token", token.value);

                                fetch("/admin/prefecture/autorite/loadFormAutoritePrefecture", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })
                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                    .then((resultat) => {

                                        if (resultat.error != null) {
                                            document.querySelector('#errorAutoritePrefecture').innerHTML = "L'autorité existe déjà";

                                        } else if (resultat.value != null) {
                                            const selectPrefectureAutorite = document.querySelector('#prefecture_prefectureAutorite');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id)
                                            option.text = resultat.value;
                                            selectPrefectureAutorite.add(option);
                                            selectPrefectureAutorite.selectedIndex = selectPrefectureAutorite.length - 1;
                                            close4.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('form[name="prefecture_autorite"] #prefecture_autorite_nom').classList.add('error')
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormAnimateurFonction() {
    let fonction = document.querySelector('#addFonctionAnimateur');

    if (fonction != null) {
        fetch("/admin/animateur/fonction/loadFormAnimateurFonction", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalCart5 .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCart5 .modal-body button');

                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();

                            if (document.querySelector('form[name="animateur_fonction"] #animateur_fonction_nom').value.length != 0) {

                                let fonction = document.querySelector('form[name="animateur_fonction"] #animateur_fonction_nom');
                                let token = document.querySelector('form[name="animateur_fonction"] #animateur_fonction__token');
                                let data = new FormData();

                                data.append("animateur_fonction_nom", fonction.value);
                                data.append("animateur_fonction__token", token.value);

                                fetch("/admin/animateur/fonction/loadFormAnimateurFonction", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })
                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                    .then((resultat) => {

                                        if (resultat.error != null) {
                                            document.querySelector('#error5').innerHTML = "La fonction existe déjà";

                                        } else if (resultat.value != null) {
                                            const selectAnimateurFonction = document.querySelector('#animateur_animateurFonction');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id);
                                            option.text = resultat.value;
                                            selectAnimateurFonction.add(option);
                                            selectAnimateurFonction.selectedIndex = selectAnimateurFonction.length - 1;
                                            close5.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('form[name="animateur_fonction"] #animateur_fonction_nom').classList.add('error')
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormAnimateurStatut() {

    let statut = document.querySelector('#addStatutAnimateur');

    if (statut != null) {
        fetch("/admin/animateur/statut/loadFormAnimateurStatut", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalCart6 .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCart6 .modal-body button');

                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();
                            if (document.querySelector('form[name="animateur_statut"] #animateur_statut_nom').value.length != 0) {

                                let statut = document.querySelector('form[name="animateur_statut"] #animateur_statut_nom');
                                let token = document.querySelector('form[name="animateur_statut"] #animateur_statut__token');
                                let data = new FormData();

                                data.append("animateur_statut_nom", statut.value);
                                data.append("animateur_statut__token", token.value);
                                fetch("/admin/animateur/statut/loadFormAnimateurStatut", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })
                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                    .then((resultat) => {

                                        if (resultat.error != null) {
                                            document.querySelector('#error6').innerHTML = "Le statut existe déjà";

                                        } else if (resultat.value != null) {
                                            const selectAnimateurStatut = document.querySelector('#animateur_animateurStatut');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id)
                                            option.text = resultat.value;
                                            selectAnimateurStatut.add(option);
                                            selectAnimateurStatut.selectedIndex = selectAnimateurStatut.length - 1;
                                            close6.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('form[name="animateur_statut"] #animateur_statut_nom').classList.add('error')
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormTribunal() {
    let tribunal = document.querySelector('#addTribunal');

    if (tribunal != null) {
        fetch("/admin/stage/loadFormTribunal", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalCartTribunal .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCartTribunal .modal-body button');
                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();
                            if (document.querySelector('form[name="tribunal"] #tribunal_nom_tribunal').value.length != 0 &&
                                document.querySelector('form[name="tribunal"] #tribunal_adresse_tribunal').value.length != 0 &&
                                document.querySelector('form[name="tribunal"] #tribunal_numero_adresse_tribunal').value.length != 0 &&
                                document.querySelector('form[name="tribunal"] #tribunal_commune_tribunal').value.length != 0 &&
                                document.querySelector('form[name="tribunal"] #tribunal_tribunal_service').value != "" &&
                                document.querySelector('form[name="tribunal"] #tribunal_tribunal_autorite').value != "") {

                                let tribunalNom = document.querySelector('form[name="tribunal"] #tribunal_nom_tribunal');
                                let tribunalAdresse = document.querySelector('form[name="tribunal"] #tribunal_adresse_tribunal');
                                let tribunalNumeroAdresse = document.querySelector('form[name="tribunal"] #tribunal_numero_adresse_tribunal');
                                let tribunalCommune = document.querySelector('form[name="tribunal"] #tribunal_commune_tribunal');
                                let tribunalAutorite = document.querySelector('form[name="tribunal"] #tribunal_tribunal_autorite');
                                let tribunalService = document.querySelector('form[name="tribunal"] #tribunal_tribunal_service');
                                let token = document.querySelector('form[name="tribunal"] #tribunal__token');

                                let data = new FormData();
                                data.append("tribunal_nom_tribunal", tribunalNom.value);
                                data.append("tribunal_adresse_tribunal", tribunalAdresse.value);
                                data.append("tribunal_numero_adresse_tribunal", tribunalNumeroAdresse.value);
                                data.append("tribunal_commune_tribunal", tribunalCommune.value);
                                data.append("tribunal_tribunal_autorite", tribunalAutorite.value);
                                data.append("tribunal_tribunal_service", tribunalService.value);
                                data.append("tribunal__token", token.value);
                                fetch("/admin/stage/loadFormTribunal", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })
                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                    .then((resultat) => {

                                        if (resultat.error != null) {
                                            document.querySelector('#errorTribunal').innerHTML = "Le tribunal existe déjà";
                                        } else if (resultat.value != null) {
                                            const selectTribunal = document.querySelector('#stage_tribunal');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id);
                                            option.text = resultat.value;
                                            selectTribunal.add(option);
                                            selectTribunal.selectedIndex = selectTribunal.length - 1;
                                            closeTribunal.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('#errorTribunal').innerHTML = "Veuillez remplir tous les champs";
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormPrefecture() {
    let prefecture = document.querySelector('#addPrefecture');

    if (prefecture != null) {
        fetch("/admin/stage/loadFormPrefecture", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalCartPrefecture .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCartPrefecture .modal-body button');
                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();
                            if (document.querySelector('form[name="prefecture"] #prefecture_nomPrefecture').value.length != 0 &&
                                document.querySelector('form[name="prefecture"] #prefecture_adressePrefecture').value.length != 0 &&
                                document.querySelector('form[name="prefecture"] #prefecture_numeroAdressePrefecture').value.length != 0 &&
                                document.querySelector('form[name="prefecture"] #prefecture_communePrefecture').value.length != 0 &&
                                document.querySelector('form[name="prefecture"] #prefecture_prefectureService').value != "" &&
                                document.querySelector('form[name="prefecture"] #prefecture_prefectureAutorite').value != "") {

                                let prefectureNom = document.querySelector('form[name="prefecture"] #prefecture_nomPrefecture');
                                let prefectureAdresse = document.querySelector('form[name="prefecture"] #prefecture_adressePrefecture');
                                let prefectureNumeroAdresse = document.querySelector('form[name="prefecture"] #prefecture_numeroAdressePrefecture');
                                let prefectureCommune = document.querySelector('form[name="prefecture"] #prefecture_communePrefecture');
                                let prefectureAutorite = document.querySelector('form[name="prefecture"] #prefecture_prefectureAutorite');
                                let prefectureService = document.querySelector('form[name="prefecture"] #prefecture_prefectureService');
                                let token = document.querySelector('form[name="prefecture"] #prefecture__token');
                                let data = new FormData();

                                data.append("prefecture_nomPrefecture", prefectureNom.value);
                                data.append("prefecture_adressePrefecture", prefectureAdresse.value);
                                data.append("prefecture_numeroAdressePrefecture", prefectureNumeroAdresse.value);
                                data.append("prefecture_communePrefecture", prefectureCommune.value);
                                data.append("prefecture_prefectureAutorite", prefectureAutorite.value);
                                data.append("prefecture_prefectureService", prefectureService.value);
                                data.append("prefecture__token", token.value);

                                fetch("/admin/stage/loadFormPrefecture", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })
                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                    .then((resultat) => {

                                        if (resultat.error != null) {
                                            document.querySelector('#errorPrefecture').innerHTML = "La préfecture existe déjà";
                                        } else if (resultat.value != null) {
                                            const selectPrefecture = document.querySelector('#stage_prefecture');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id)
                                            option.text = resultat.value;
                                            selectPrefecture.add(option);
                                            selectPrefecture.selectedIndex = selectPrefecture.length - 1;
                                            closePrefecture.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormStagiaire() {
    let stagiaire = document.querySelector('#addStagiaire');

    if (stagiaire != null) {
        fetch("/admin/stage/loadFormStagiaire", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalCartStagiaire .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCartStagiaire .modal-body button');
                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();
                            if (document.querySelector('form[name="stagiaire"] #stagiaire_nomStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_prenomStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_communeStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_nomNaissanceStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_dateNaissanceStagiaire_day').value.length != "" &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_dateNaissanceStagiaire_month').value.length != "" &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_dateNaissanceStagiaire_year').value.length != "" &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_lieuNaissanceStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_adresseStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_nationaliteStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_numeroPortableStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_numeroFixeStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_emailStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_numeroAdresseStagiaire').value.length != 0 &&
                                document.querySelector('form[name="stagiaire"] #stagiaire_civilite').value.length != "") {



                                let stagiaireNom = document.querySelector('form[name="stagiaire"] #stagiaire_nomStagiaire');
                                let stagiairePrenom = document.querySelector('form[name="stagiaire"] #stagiaire_prenomStagiaire');
                                let stagiaireCommune = document.querySelector('form[name="stagiaire"] #stagiaire_communeStagiaire');
                                let stagiaireNomNaissance = document.querySelector('form[name="stagiaire"] #stagiaire_nomNaissanceStagiaire');
                                let stagiaireDateNaissance = document.querySelector('form[name="stagiaire"] #stagiaire_dateNaissanceStagiaire_year').value + "-" +
                                    document.querySelector('form[name="stagiaire"] #stagiaire_dateNaissanceStagiaire_month').value + "-" +
                                    document.querySelector('form[name="stagiaire"] #stagiaire_dateNaissanceStagiaire_day').value;
                                let stagiaireLieuNaissance = document.querySelector('form[name="stagiaire"] #stagiaire_lieuNaissanceStagiaire');
                                let stagiaireAdresse = document.querySelector('form[name="stagiaire"] #stagiaire_adresseStagiaire');
                                let stagiaireNationalite = document.querySelector('form[name="stagiaire"] #stagiaire_nationaliteStagiaire');
                                let stagiaireNumeroPortable = document.querySelector('form[name="stagiaire"] #stagiaire_numeroPortableStagiaire');
                                let stagiaireNumeroFixe = document.querySelector('form[name="stagiaire"] #stagiaire_numeroFixeStagiaire');
                                let stagiaireEmail = document.querySelector('form[name="stagiaire"] #stagiaire_emailStagiaire');
                                let stagiaireNumeroAdresse = document.querySelector('form[name="stagiaire"] #stagiaire_numeroAdresseStagiaire');
                                let stagiaireCivilite = document.querySelector('form[name="stagiaire"] #stagiaire_civilite');
                                let token = document.querySelector('form[name="stagiaire"] #stagiaire__token');
                                let data = new FormData();

                                data.append("stagiaire_nomStagiaire", stagiaireNom.value);
                                data.append("stagiaire_prenomStagiaire", stagiairePrenom.value);
                                data.append("stagiaire_communeStagiaire", stagiaireCommune.value);
                                data.append("stagiaire_nomNaissanceStagiaire", stagiaireNomNaissance.value);
                                data.append("stagiaire_dateNaissanceStagiaire", stagiaireDateNaissance);
                                data.append("stagiaire_lieuNaissanceStagiaire", stagiaireLieuNaissance.value);
                                data.append("stagiaire_adresseStagiaire", stagiaireAdresse.value);
                                data.append("stagiaire_nationaliteStagiaire", stagiaireNationalite.value);
                                data.append("stagiaire_numeroPortableStagiaire", stagiaireNumeroPortable.value);
                                data.append("stagiaire_numeroFixeStagiaire", stagiaireNumeroFixe.value);
                                data.append("stagiaire_emailStagiaire", stagiaireEmail.value);
                                data.append("stagiaire_numeroAdresseStagiaire", stagiaireNumeroAdresse.value);
                                data.append("stagiaire_civilite", stagiaireCivilite.value);
                                data.append("stagiaire", token.value);

                                fetch("/admin/stage/loadFormStagiaire", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })
                                    .then((resultat) => {
                                        return resultat.json();


                                    })

                                    .then((resultat) => {
                                        if (resultat.error != null) {
                                            document.querySelector('#errorStagiaire').innerHTML = "Le stagiaire existe déjà";
                                        } else if (resultat.value != null) {

                                            const selectStagiaire_list = document.querySelector('#stage_stagiaires');
                                            let option = document.createElement("option");
                                            option.setAttribute('value', resultat.id);
                                            option.text = resultat.value;
                                            selectStagiaire_list.add(option);
                                            $('#stage_stagiaires').trigger("chosen:updated");

                                            closeStagiaire.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('#errorStagiaire').innerHTML = "Veuillez remplir tous les champs";
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormAnimateur() {
    let animateur = document.querySelector('#addAnimateur');
    if (animateur != null) {
        fetch("/admin/stage/loadFormAnimateur", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {

                if (reponse.length > 0) {
                    document.querySelector('#modalCartAnimateur .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCartAnimateur .modal-body button');
                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();
                            if (document.querySelector('form[name="animateur"] #animateur_nom_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_civilite').value.length != "" &&
                                document.querySelector('form[name="animateur"] #animateur_prenom_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_rue_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_numero_rue_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_commune_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_region_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_email_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_numero_portable_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_numero_fixe_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_siret_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_urssaf_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_raison_sociale_animateur').value.length != 0 &&
                                document.querySelector('form[name="animateur"] #animateur_gta_animateur').value.length != "" &&
                                document.querySelector('form[name="animateur"] #animateur_animateurFonction').value.length != "" &&
                                document.querySelector('form[name="animateur"] #animateur_animateurStatut').value.length != "") {


                                let AnimateurNom = document.querySelector('form[name="animateur"] #animateur_nom_animateur');
                                let AnimateurCivilite = document.querySelector('form[name="animateur"] #animateur_civilite');
                                let AnimateurPrenom = document.querySelector('form[name="animateur"] #animateur_prenom_animateur');
                                let AnimateurRue = document.querySelector('form[name="animateur"] #animateur_rue_animateur');
                                let AnimateurNumeroRue = document.querySelector('form[name="animateur"] #animateur_numero_rue_animateur');
                                let AnimateurCommune = document.querySelector('form[name="animateur"] #animateur_commune_animateur');
                                let AnimateurRegion = document.querySelector('form[name="animateur"] #animateur_region_animateur');
                                let AnimateurEmail = document.querySelector('form[name="animateur"] #animateur_email_animateur');
                                let AnimateurNumeroPortable = document.querySelector('form[name="animateur"] #animateur_numero_portable_animateur');
                                let AnimateurNumeroFixe = document.querySelector('form[name="animateur"] #animateur_numero_fixe_animateur');
                                let AnimateurSiret = document.querySelector('form[name="animateur"] #animateur_siret_animateur');
                                let AnimateurUrssaf = document.querySelector('form[name="animateur"] #animateur_urssaf_animateur');
                                let AnimateurRaisonSociale = document.querySelector('form[name="animateur"] #animateur_raison_sociale_animateur');
                                let AnimateurGta = document.querySelector('form[name="animateur"] #animateur_gta_animateur');
                                let AnimateurFonction = document.querySelector('form[name="animateur"] #animateur_animateurFonction');
                                let AnimateurStatut = document.querySelector('form[name="animateur"] #animateur_animateurStatut');
                                let AnimateurObservations = document.querySelector('form[name="animateur"] #animateur_observations_animateur');
                                let token = document.querySelector('form[name="animateur"] #animateur__token');
                                let data = new FormData();

                                data.append("animateur_nom_animateur", AnimateurNom.value);
                                data.append("animateur_civilite", AnimateurCivilite.value);
                                data.append("animateur_prenom_animateur", AnimateurPrenom.value);
                                data.append("animateur_rue_animateur", AnimateurRue.value);
                                data.append("animateur_numero_rue_animateur", AnimateurNumeroRue.value);
                                data.append("animateur_commune_animateur", AnimateurCommune.value);
                                data.append("animateur_region_animateur", AnimateurRegion.value);
                                data.append("animateur_email_animateur", AnimateurEmail.value);
                                data.append("animateur_numero_portable_animateur", AnimateurNumeroPortable.value);
                                data.append("animateur_numero_fixe_animateur", AnimateurNumeroFixe.value);
                                data.append("animateur_siret_animateur", AnimateurSiret.value);
                                data.append("animateur_urssaf_animateur", AnimateurUrssaf.value);
                                data.append("animateur_raison_sociale_animateur", AnimateurRaisonSociale.value);
                                data.append("animateur_gta_animateur", AnimateurGta.value);
                                data.append("animateur_animateurFonction", AnimateurFonction.value);
                                data.append("animateur_animateurStatut", AnimateurStatut.value);
                                data.append("animateur_observations_animateur", AnimateurObservations.value);
                                data.append("animateur__token", token.value);

                                fetch("/admin/stage/loadFormAnimateur", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })

                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                console.log(resultat.json())
                                    .then((resultat) => {

                                        if (resultat.error != null) {
                                            document.querySelector('#errorAnimateur').innerHTML = "L'animateur existe déjà";
                                        } else if (resultat.value != null) {

                                            const selectAnimateur_list = document.querySelector('#stage_animateurs');
                                            let option = document.createElement("option");
                                            option.setAttribute('value', resultat.id);
                                            option.text = resultat.value;
                                            selectAnimateur_list.add(option);
                                            $('#stage_animateurs').trigger("chosen:updated");

                                            closeAnimateur.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('#errorAnimateur').innerHTML = "Veuillez remplir tous les champs";
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormLieuStage() {
    let lieuStage = document.querySelector('#addLieuStage');

    if (lieuStage != null) {
        fetch("/admin/stage/loadFormLieuStage", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })
            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalCartLieuStage .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalCartLieuStage .modal-body button');
                    inputCommuneLieuStage();
                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();

                            if (document.querySelector('form[name="lieu_stage"] #lieu_stage_nom_etablissement').value.length != 0 &&
                                document.querySelector('form[name="lieu_stage"] #lieu_stage_agrement').value.length != 0 &&
                                document.querySelector('form[name="lieu_stage"] #lieu_stage_numero_adresse_stage').value.length != 0 &&
                                document.querySelector('form[name="lieu_stage"] #lieu_stage_adresse_stage').value.length != 0 &&
                                document.querySelector('form[name="lieu_stage"] #lieu_stage_nom_commune').value.length != 0 &&
                                document.querySelector('form[name="lieu_stage"] #lieu_stage_latitude').value.length != 0 &&
                                document.querySelector('form[name="lieu_stage"] #lieu_stage_longitude').value.length != 0 &&
                                document.querySelector('form[name="lieu_stage"] #lieu_stage_dmsLatitude').value.length != 0 &&
                                document.querySelector('form[name="lieu_stage"] #lieu_stage_dmsLongitude').value.length != 0 &&
                                document.querySelector('form[name="lieu_stage"] #lieu_stage_telephone_stage').value.length != 0) {

                                let nom = document.querySelector('form[name="lieu_stage"] #lieu_stage_nom_etablissement');
                                let agrement = document.querySelector('form[name="lieu_stage"] #lieu_stage_agrement');
                                let numeroAdresse = document.querySelector('form[name="lieu_stage"] #lieu_stage_numero_adresse_stage');
                                let adresse = document.querySelector('form[name="lieu_stage"] #lieu_stage_adresse_stage');
                                let commune = document.querySelector('form[name="lieu_stage"] #lieu_stage_nom_commune');
                                let latitude = document.querySelector('form[name="lieu_stage"] #lieu_stage_latitude');
                                let longitude = document.querySelector('form[name="lieu_stage"] #lieu_stage_longitude');
                                let dmsLatitude = document.querySelector('form[name="lieu_stage"] #lieu_stage_dmsLatitude');
                                let dmsLongitude = document.querySelector('form[name="lieu_stage"] #lieu_stage_dmsLongitude');
                                let telephone = document.querySelector('form[name="lieu_stage"] #lieu_stage_telephone_stage');
                                let token = document.querySelector('form[name="lieu_stage"] #lieu_stage__token');
                               

                                let data = new FormData();
                                data.append("lieu_stage_nom_etablissement", nom.value);
                                data.append("lieu_stage_agrement", agrement.value);
                                data.append("lieu_stage_numero_adresse_stage", numeroAdresse.value);
                                data.append("lieu_stage_adresse_stage", adresse.value);
                                data.append("lieu_stage_nom_commune", commune.value);
                                data.append("lieu_stage_latitude", latitude.value);
                                data.append("lieu_stage_longitude", longitude.value);
                                data.append("lieu_stage_dms_latitude", dmsLatitude.value);
                                data.append("lieu_stage_dms_longitude", dmsLongitude.value);
                                data.append("lieu_stage_telephone_stage", telephone.value);
                                data.append("lieu_stage__token", token.value);

                                console.log(dmslongitude.value);
                                fetch("/admin/stage/loadFormLieuStage", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })

                                    .then((resultat) => {
                                        return resultat.json();
                                    })
                                    .then((resultat) => {
                                        if (resultat.error != null) {
                                            document.querySelector('#errorLieuStage').innerHTML = "Le lieu de stage existe déjà";
                                        } else if (resultat.value != null) {
                                            const selectLieuStage = document.querySelector('#stage_lieuStage');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id)
                                            option.text = resultat.value;
                                            selectLieuStage.add(option);
                                            selectLieuStage.selectedIndex = selectLieuStage.length - 1;
                                            closeLieuStage.click();
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

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
                                    //let longitude = document.getElementById('lieu_stage_longitude');
                                    //let latitude = document.getElementById('lieu_stage_latitude');


                                    for (let i = 0; i < p.length; i++) {
                                        const element = p[i];

                                        element.addEventListener('click', function (e) {
                                            commune.value = resultat[p[i].id]['nomCommune'] + " (" + resultat[p[i].id]['cp'] + ")";
                                            selection.classList.add('listeHidden');

                                            //longitude.value = resultat[p[i].id]['longitude'];
                                            //latitude.value = resultat[p[i].id]['latitude'];
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

function loadFormLicence() {
    let licence = document.querySelector('#addLicence');

    if (licence != null) {
        fetch("/admin/stagiaire/loadFormLicence", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();

            })

            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalLicence .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalLicence .modal-body button');
                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();

                            if (document.querySelector('form[name="licence"] #licence_licenceNumber').value.length != 0 &&
                                document.querySelector('form[name="licence"] #licence_licenceDate_day').value.length != "" &&
                                document.querySelector('form[name="licence"] #licence_licenceDate_month').value.length != "" &&
                                document.querySelector('form[name="licence"] #licence_licenceDate_year').value.length != "" &&
                                document.querySelector('form[name="licence"] #licence_prefecture').value.length != "")

                            {

                                let licenceNumber = document.querySelector('form[name="licence"] #licence_licenceNumber');
                                let licenceDate = document.querySelector('form[name="licence"] #licence_licenceDate_year').value + "-" +
                                    document.querySelector('form[name="licence"] #licence_licenceDate_month').value + "-" +
                                    document.querySelector('form[name="licence"] #licence_licenceDate_day').value;
                                let prefecture = document.querySelector('form[name="licence"] #licence_prefecture');

                                let data = new FormData();

                                data.append("licence_licenceNumber", licenceNumber.value);
                                data.append("licence_licenceDate", licenceDate);
                                data.append("licence_prefecture", prefecture.value);

                              

                                fetch("/admin/stagiaire/loadFormLicence", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })

                                    .then((resultat) => {
                                        return resultat.json();
                                    })

                                    .then((resultat) => {
                                        if (resultat.error != null) {
                                            document.querySelector('#errorLicence').innerHTML = "Le permis existe déjà";
                                        } else if (resultat.value != null) {

                                            const selectLicence = document.querySelector('#stagiaire_licence');
                                            let option = document.createElement("option");
                                            option.setAttribute('value', resultat.id)
                                            option.text = resultat.value;
                                            selectLicence.add(option);
                                            selectLicence.selectedIndex = selectLicence.length - 1;
                                            closeLicence.click();

                                        }
                                       
                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('#errorLicence').innerHTML = "Veuillez remplir tous les champs";
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
            });
    }
}

function loadFormInfraction() {
    let infraction = document.querySelector('#addInfraction');

    if (infraction != null) {
        fetch("/admin/stagiaire/loadFormInfraction", {
                credentials: 'include'
            })
            .then((reponse) => {
                return reponse.text();
            })

            .then((reponse) => {
                if (reponse.length > 0) {
                    document.querySelector('#modalInfraction .modal-body').innerHTML = reponse;
                    btn = document.querySelector('#modalInfraction .modal-body button');
                    inputCommuneInfraction();
                    if (btn != null) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();

                            if (document.querySelector('form[name="infraction"] #infraction_lieuInfraction').value.length != 0 &&
                                document.querySelector('form[name="infraction"] #infraction_dateInfraction_date_day').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_dateInfraction_date_month').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_dateInfraction_date_year').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_dateInfraction_time_hour').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_dateInfraction_time_minute').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_natureInfraction').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_dateCondamnation_day').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_dateCondamnation_month').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_dateCondamnation_year').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_numeroParquet').value.length != "" &&
                                document.querySelector('form[name="infraction"] #infraction_tribunal').value.length != 0)

                            {
                                let lieuInfraction = document.querySelector('form[name="infraction"] #infraction_lieuInfraction');
                                let dateInfraction = document.querySelector('form[name="infraction"] #infraction_dateInfraction_date_day').value + "-" +
                                    document.querySelector('form[name="infraction"] #infraction_dateInfraction_date_month').value + "-" +
                                    document.querySelector('form[name="infraction"] #infraction_dateInfraction_date_year').value + " " +
                                    document.querySelector('form[name="infraction"] #infraction_dateInfraction_time_hour').value + ":" +
                                    document.querySelector('form[name="infraction"] #infraction_dateInfraction_time_minute').value;
                                let natureInfraction = document.querySelector('form[name="infraction"] #infraction_natureInfraction');
                                let dateCondamnation = document.querySelector('form[name="infraction"] #infraction_dateCondamnation_day').value + "-" +
                                    document.querySelector('form[name="infraction"] #infraction_dateCondamnation_month').value + "-" +
                                    document.querySelector('form[name="infraction"] #infraction_dateCondamnation_year').value;                                
                                let numeroParquet = document.querySelector('form[name="infraction"] #infraction_numeroParquet');
                                let tribunal = document.querySelector('form[name="infraction"] #infraction_tribunal');
                                let data = new FormData();

                                data.append("infraction_lieuInfraction", lieuInfraction.value);
                                data.append("infraction_dateInfraction", dateInfraction);
                                data.append("infraction_natureInfraction", natureInfraction.value);
                                data.append("infraction_dateCondamnation", dateCondamnation);
                                data.append("infraction_numeroParquet", numeroParquet.value);
                                data.append("infraction_tribunal", tribunal.value);

                                console.log(dateInfraction);
                                
                                fetch("/admin/stagiaire/loadFormInfraction", {
                                        method: "POST",
                                        body: data,
                                        credentials: 'include'
                                    })

                                    .then((resultat) => {
                                        return resultat.json();

                                    })

                                    .then((resultat) => {
                                        if (resultat.error != null) {
                                            console.log(resultat.error);
                                            document.querySelector('#errorInfraction').innerHTML = "Cette infraction existe déjà";
                                        } else if (resultat.value != null) {

                                            const selectInfraction = document.querySelector('#stagiaire_infraction');
                                            const option = document.createElement("option");
                                            option.setAttribute('value', resultat.id)
                                            option.text = resultat.value;
                                            //selectInfraction.add(option);
                                            selectInfraction.selectedIndex = selectInfraction.length - 1;
                                            closeInfraction.click();

                                        }

                                    }).catch((error) => {
                                        console.log(error);
                                    });
                            } else {
                                document.querySelector('#errorInfraction').innerHTML = "Veuillez remplir tous les champs";
                            }
                        })
                    }
                }
            }).catch((error) => {
                console.log(error);
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