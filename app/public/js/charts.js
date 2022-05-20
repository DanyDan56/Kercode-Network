// Affichage du graphique pour le nombre de compte
function displayChartUsers(data) {
    labels = [];
    values = [];
    value = 0;
    for (let key in data) {
        labels.push(key);
        values.push(data[key] + value);
        value += data[key];
    }

    let chartUsers = new CanvasJS.Chart("chartUsers", {
        animationEnabled: true,
        theme: 'light2',
        title: {
            text: "Nombre de comptes"
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

// Affichage du graphique pour le nombre d'articles
function displayChartArticles(data) {
    labels = [];
    values = [];
    value = 0;
    for (let key in data) {
        labels.push(key);
        values.push(data[key] + value);
        value += data[key];
    }

    let chartArticles = new CanvasJS.Chart("chartArticles", {
        animationEnabled: true,
        theme: 'light2',
        title: {
            text: "Nombre d'articles"
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

    chartArticles.render();
}

// Affichage du graphique pour le nombre d'images
function displayChartImages(data) {
    labels = [];
    values = [];
    value = 0;
    for (let key in data) {
        labels.push(key);
        values.push(data[key] + value);
        value += data[key];
    }

    let chartImages = new CanvasJS.Chart("chartImages", {
        animationEnabled: true,
        theme: 'light2',
        title: {
            text: "Nombre d'images"
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

    chartImages.render();
}

// window.load = displayChartUsers;
// window.load = displayChartArticles;