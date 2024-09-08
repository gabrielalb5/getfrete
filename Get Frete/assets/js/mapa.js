function initMap(){
    var origem = document.getElementById("origem_mapa").innerHTML;
    var destino = document.getElementById("destino_mapa").innerHTML;
    console.log(origem);
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer();
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 7,
    });
    directionsRenderer.setMap(map);

    directionsService.route({
        origin: origem,
        destination: destino,
        language: 'pt_BR',
        travelMode: google.maps.TravelMode.DRIVING
    }).then(response => {
        console.log({response});
        directionsRenderer.setDirections(response);
    }).catch(err => {
        console.log({err});
    })
};
