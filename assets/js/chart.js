require('../../node_modules/chart.js/dist/Chart.js');

let civiliteGraph = new Array();
let stageMonthGraph = new Array();
let titulaireGraph = new Array();
let currentYear = new Date().getFullYear();

countCivilite();
countStage();
countTitulaire();

function countCivilite() {
    fetch("/admin/countCivilite", {
            method: "POST",
            credentials: 'include'
        })
        .then((reponse) => {
            return reponse.json();
        })
        .then((reponse) => {
            civiliteGraph[0] = reponse.nbHomme[0][1];
            civiliteGraph[1] = reponse.nbFemme[0][1];
            myChartCivilite.update();

        }).catch((error) => {
            console.log(error);
        });
}

function countStage() {
    fetch("/admin/countStage", {
            method: "POST",
            credentials: 'include'
        })
        .then((reponse) => {
            return reponse.json();
        })
        .then((reponse) => {
            stageMonthGraph[0] = reponse.janvier[0]['count(id)'];
            stageMonthGraph[1] = reponse.fevrier[0]['count(id)'];
            stageMonthGraph[2] = reponse.mars[0]['count(id)'];
            stageMonthGraph[3] = reponse.avril[0]['count(id)'];
            stageMonthGraph[4] = reponse.mai[0]['count(id)'];
            stageMonthGraph[5] = reponse.juin[0]['count(id)'];
            stageMonthGraph[6] = reponse.juillet[0]['count(id)'];
            stageMonthGraph[7] = reponse.aout[0]['count(id)'];
            stageMonthGraph[8] = reponse.septembre[0]['count(id)'];
            stageMonthGraph[9] = reponse.octobre[0]['count(id)'];
            stageMonthGraph[10] = reponse.novembre[0]['count(id)'];
            stageMonthGraph[11] = reponse.decembre[0]['count(id)'];
            myChartStageMois.update();
        }).catch((error) => {
            console.log(error);
        });
}

function countTitulaire() {
    fetch("/admin/countTitulaire", {
            method: "POST",
            credentials: 'include'
        })
        .then((reponse) => {
            return reponse.json();
        })
        .then((reponse) => {
            titulaireGraph[0] = reponse.titulaire[0]['cartejeune'];
            titulaireGraph[1] = reponse.titulaire[0]['partenaire'];
            titulaireGraph[2] = reponse.titulaire[0]['adherent'];
            myChartTitulaire.update();
        }).catch((error) => {
            console.log(error);
        });
}

var graphCivilite = document.getElementById("myChartCivilite");
var graphStageMois = document.getElementById("myChartStageMois");
var graphTitulaire = document.getElementById("myChartTitulaire");

var myChartCivilite = new Chart(graphCivilite, {
    type: 'pie',
    data: {
        labels: ["Homme", "Femme"],
        datasets: [{
            label: 'Nombre de stagiaires Homme et Femme',
            data: civiliteGraph,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 99, 132, 0.5)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        title: {
            display: true,
            text: 'Nombre de stagiaires Homme et Femme'
        }
    }
});

var myChartStageMois = new Chart(graphStageMois, {
    type: 'bar',
    data: {
        labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        datasets: [{
            data: stageMonthGraph,
            backgroundColor: [
                'rgba(0, 178, 20, 0.5)',
                'rgba(178, 168, 0, 0.5)',
                'rgba(164, 78, 178, 0.5)',
                'rgba(0, 124, 178, 0.5)',
                'rgba(255, 193, 204, 0.5)',
                'rgba(90, 255, 28, 0.5)',
                'rgba(255, 88, 0, 0.5)',
                'rgba(128, 232, 255, 0.5)',
                'rgba(233, 174, 255, 0.5)',
                'rgba(255, 191, 5, 0.5)',
                'rgba(0, 39, 178, 0.5)',
                'rgba(178, 88, 154, 0.5)',
            ],
            borderColor: [
                'rgba(0, 178, 20, 1)',
                'rgba(178, 168, 0, 1)',
                'rgba(164, 78, 178, 1)',
                'rgba(0, 124, 178, 1)',
                'rgba(255, 193, 204, 1)',
                'rgba(90, 255, 28, 1)',
                'rgba(255, 88, 0, 1)',
                'rgba(128, 232, 255, 1)',
                'rgba(233, 174, 255, 1)',
                'rgba(255, 191, 5, 1)',
                'rgba(0, 39, 178, 1)',
                'rgba(178, 88, 154, 1)',



            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem) {
                    return tooltipItem.yLabel;
                }
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        title: {
            display: true,
            text: "Nombre de stages par mois pour l'année " + currentYear
        }
    }
});

var myChartTitulaire = new Chart(graphTitulaire, {
    type: 'doughnut',
    data: {
        labels: ["Carte jeune", "Partenaire", "Adhérent"],
        datasets: [{
            label: 'Nombre de stagiaires titulaire',
            data: titulaireGraph,
            backgroundColor: [
                'rgba(255, 143, 30, 0.5)',
                'rgba(255, 206, 24, 0.5)',
                'rgba(0, 255, 167, 0.5)'
            ],
            borderColor: [
                'rgba(255, 143, 30, 1)',
                'rgba(255, 206, 24, 1)',
                'rgba(0, 255, 167, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        title: {
            display: true,
            text: 'Nombre de stagiaires titulaire'
        }
    }
});
