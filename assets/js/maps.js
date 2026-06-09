let mapa;
let marcador;
let autocomplete;

const ubicacionInicial = {
    lat: -9.29532,
    lng: -75.9974
};

function iniciarMapaPublicidad() {
    const mapaElemento = document.getElementById("mapaNegocio");
    const direccionInput = document.getElementById("direccion");
    const latitudInput = document.getElementById("latitud");
    const longitudInput = document.getElementById("longitud");
    const googleMapsInput = document.getElementById("google_maps_url");
    const btnUbicacion = document.getElementById("btnUsarUbicacion");
    const btnBuscar = document.getElementById("btnActualizarMapa");

    if (!mapaElemento || !direccionInput || !latitudInput || !longitudInput) {
        return;
    }

    mapa = new google.maps.Map(mapaElemento, {
        center: ubicacionInicial,
        zoom: 15,
        mapTypeControl: false,
        streetViewControl: false
    });

    marcador = new google.maps.Marker({
        position: ubicacionInicial,
        map: mapa,
        draggable: true
    });

    actualizarInputsUbicacion(ubicacionInicial.lat, ubicacionInicial.lng);

    autocomplete = new google.maps.places.Autocomplete(direccionInput, {
        componentRestrictions: { country: "pe" },
        fields: ["geometry", "formatted_address", "name"]
    });

    autocomplete.addListener("place_changed", function () {
        const place = autocomplete.getPlace();

        if (!place.geometry || !place.geometry.location) {
            return;
        }

        const lat = place.geometry.location.lat();
        const lng = place.geometry.location.lng();

        mapa.setCenter({ lat, lng });
        mapa.setZoom(17);
        marcador.setPosition({ lat, lng });

        if (place.formatted_address) {
            direccionInput.value = place.formatted_address;
        }

        actualizarInputsUbicacion(lat, lng);
    });

    marcador.addListener("dragend", function () {
        const position = marcador.getPosition();

        if (!position) {
            return;
        }

        const lat = position.lat();
        const lng = position.lng();

        actualizarInputsUbicacion(lat, lng);
    });

    if (btnUbicacion) {
        btnUbicacion.addEventListener("click", function () {
            if (!navigator.geolocation) {
                alert("Tu navegador no permite obtener la ubicación actual.");
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    mapa.setCenter({ lat, lng });
                    mapa.setZoom(17);
                    marcador.setPosition({ lat, lng });

                    actualizarInputsUbicacion(lat, lng);
                },
                function () {
                    alert("No se pudo obtener tu ubicación. Puedes buscar la dirección manualmente.");
                }
            );
        });
    }

    if (btnBuscar) {
        btnBuscar.addEventListener("click", function () {
            buscarDireccionManual();
        });
    }

    setTimeout(function () {
        google.maps.event.trigger(mapa, "resize");
        mapa.setCenter(marcador.getPosition());
    }, 500);
}

function buscarDireccionManual() {
    const direccionInput = document.getElementById("direccion");

    if (!direccionInput || direccionInput.value.trim() === "") {
        alert("Primero escribe una dirección.");
        return;
    }

    const geocoder = new google.maps.Geocoder();

    geocoder.geocode(
        {
            address: direccionInput.value + ", Tingo María, Perú"
        },
        function (results, status) {
            if (status === "OK" && results[0]) {
                const location = results[0].geometry.location;
                const lat = location.lat();
                const lng = location.lng();

                mapa.setCenter({ lat, lng });
                mapa.setZoom(17);
                marcador.setPosition({ lat, lng });

                actualizarInputsUbicacion(lat, lng);
            } else {
                alert("No se pudo encontrar la dirección. Intenta escribir una referencia más clara.");
            }
        }
    );
}

function actualizarInputsUbicacion(lat, lng) {
    const latitudInput = document.getElementById("latitud");
    const longitudInput = document.getElementById("longitud");
    const googleMapsInput = document.getElementById("google_maps_url");

    if (latitudInput) {
        latitudInput.value = lat;
    }

    if (longitudInput) {
        longitudInput.value = lng;
    }

    if (googleMapsInput) {
        googleMapsInput.value = `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const categoriaSelect = document.getElementById("categoria_id");
    const emprendimientoFields = document.getElementById("emprendimiento-fields");

    if (categoriaSelect && emprendimientoFields) {
        categoriaSelect.addEventListener("change", function () {
            setTimeout(function () {
                if (mapa && marcador) {
                    google.maps.event.trigger(mapa, "resize");
                    mapa.setCenter(marcador.getPosition());
                }
            }, 400);
        });
    }
});
