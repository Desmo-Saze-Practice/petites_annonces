import L from 'Leaflet';

import '../../node_modules/leaflet/dist/leaflet.css';

const apiUrl = '/api/annonce/search-by-position';

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
  iconRetinaUrl: require("leaflet/dist/images/marker-icon-2x.png"),
  iconUrl: require("leaflet/dist/images/marker-icon.png"),
  shadowUrl: require("leaflet/dist/images/marker-shadow.png")
});

let map = L.map('map').setView([48.858384217485096, 2.294438384657103], 11);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors'
}).addTo(map);


// display map on page load
if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function (position) {
        map.setView([position.coords.latitude, position.coords.longitude], 13);
        let marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        marker.bindPopup("<b>Vous êtes ici</b><br>").openPopup();
    })
} 


// center map on user location
document.getElementById('geoValue').addEventListener('click', (e)=> {

    // console.log('my event is ', e);
    
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function (position) {
            
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            const promise = fetch(`${apiUrl}?lat=${lat}&lon=${lon}&radius=12`);

            promise
                .then(response => response.json())
                .then(json => {
                    console.log(json);
                    json.forEach(address => {
                        let html= '';
                        console.log(address);
                        address.annonce.forEach(annonce => {
                            html+=`<a href="/annonce/${annonce.id}">${annonce.title}</a><br><br>${annonce.price} €</br>`
                        });
                    L.marker([address.lat, address.lon]).addTo(map).bindPopup(html).openPopup();
                    });
                })

            map.setView([position.coords.latitude, position.coords.longitude], 13);
            // if (!newMarker) {
            //     newMarker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            // marker.bindPopup("<b>Vous êtes ici</b><br>").openPopup();
            // }
        })
    } 
})