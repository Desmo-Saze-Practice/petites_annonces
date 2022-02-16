const apiUrl = 'https://api-adresse.data.gouv.fr/search/?q=';

const formTextSelector = document.getElementById('annonce_address_autocomplete');
const autocompleteResult = document.querySelector('.autocompleteResult');

// hiden form elements
const longitude = document.getElementById('annonce_address_lon');

const latitude = document.getElementById('annonce_address_lat');

const street = document.getElementById('annonce_address_street');

const streetNumber = document.getElementById('annonce_address_streetNumber');

const zipcode = document.getElementById('annonce_address_zipcode');

const city = document.getElementById('annonce_address_city');

formTextSelector.addEventListener('keyup', (e) => {
    autocompleteResult.innerHTML = '';
    // let userImput = e.target.value;

    // console.log(userImput);

    const promise = fetch(apiUrl + e.target.value);

    promise
        .then(response => response.json())
        .then(json => {
            json.features.forEach(element => {
                let prop = element.properties.label;
                const li = document.createElement('li');
                li.addEventListener('click', e => {
                    formTextSelector.value = e.target.textContent;
                    autocompleteResult.innerHTML = '';

                    if (element.properties.housenumber) {
                        streetNumber.value = element.properties.housenumber;                        
                        street.value = element.properties.street;
                    } else {
                        street.value = element.properties.name;
                        streetNumber.value = "";

                    }

                    city.value = element.properties.city;
                    zipcode.value = element.properties.citycode;
                    longitude.value = element.geometry.coordinates[0];
                    latitude.value = element.geometry.coordinates[1];

                    console.log('you are my lon ', longitude);
                    console.log('you are my city ', city);
                    console.log('you are my zipcode ', zipcode);
                    console.log('you are my street number ', streetNumber);
                    console.log('you are my street ', street);
                    console.log('you are my latitude ', latitude);
                });
                li.innerText = prop;
                autocompleteResult.append(li);
            });
        });
});