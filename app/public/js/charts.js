/**
 * Créé un graphique simple de valeur de données
 * 
 * @param {*} data Tableau de données associatifs (date => valeur)
 * @param {*} title Le nom du graphique
 * @param {*} containerName Le nom de l'id du containeur dans lequelle le graphique sera rendu
 */
function displayChart(data, title, containerName)
{
    labels = [];
    values = [];
    value = 0;

    for (let key in data) {
        labels.push(key);
        values.push(data[key] + value);
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
            dataPoints: [
                { label: new Date(labels[0]).toLocaleDateString(), y: values[0] },
                { label: new Date(labels[1]).toLocaleDateString(), y: values[1] },
                { label: new Date(labels[2]).toLocaleDateString(), y: values[2] },
                { label: new Date(labels[3]).toLocaleDateString(), y: values[3] },
                { label: new Date(labels[4]).toLocaleDateString(), y: values[4] },
                { label: new Date(labels[5]).toLocaleDateString(), y: values[5] },
                { label: new Date(labels[6]).toLocaleDateString(), y: values[6] }
            ]
        }]
    });

    chartUsers.render();
}

// window.load = displayChartUsers;
// window.load = displayChartArticles;