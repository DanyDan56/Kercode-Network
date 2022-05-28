/**
 * Créé un graphique simple de valeur de données
 * 
 * @param {*} data Tableau de données associatifs (date => valeur)
 * @param {*} title Le nom du graphique
 * @param {*} containerName Le nom de l'id du containeur dans lequelle le graphique sera rendu
 */
function displayChart(data, title, containerName)
{
    dataPoints = [];
    value = 0;

    for (let key in data) {
        dataPoints.push({ label: new Date(key).toLocaleDateString(), y: data[key] + value });
        value += data[key];
    }

    let chartUsers = new CanvasJS.Chart(containerName, {
        animationEnabled: true,
        theme: 'light2',
        title: {
            text: title
        },
        axisX: {
            // title: "7 derniers jours"
            valueFormatString: "DD MMM"
        },
        axisY: {
            // title: "Nombres",
            includeZero: false
        },
        data: [{
            type: "line",
            dataPoints: dataPoints
        }]
    });

    chartUsers.render();
}

// window.load = displayChartUsers;
// window.load = displayChartArticles;