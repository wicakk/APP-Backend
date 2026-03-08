import jsVectorMap from 'jsvectormap';
import 'jsvectormap/dist/maps/world';
import 'jsvectormap/dist/jsvectormap.min.css';

export const initMap = () => {
    const mapSelectorOne = document.querySelectorAll('#mapOne');

    if (mapSelectorOne.length) {
        const defaultMarkers = [
            {
                name: "Lokasi Anda",
                coords: [-6.2088, 106.8456], // Default: Jakarta
            },
        ];

        const mapOne = new jsVectorMap({
            selector: "#mapOne",
            map: "world",
            zoomButtons: false,
            regionStyle: {
                initial: {
                    fontFamily: "Outfit",
                    fill: "#D9D9D9",
                },
                hover: {
                    fillOpacity: 1,
                    fill: "#465fff",
                },
            },
            markers: defaultMarkers,
            markerStyle: {
                initial: {
                    strokeWidth: 1,
                    fill: "#465fff",
                    fillOpacity: 1,
                    r: 6,
                },
                hover: {
                    fill: "#465fff",
                    fillOpacity: 1,
                },
                selected: {},
                selectedHover: {},
            },
        });

        // Deteksi lokasi user via Geolocation API
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // Hapus map lama dan buat ulang dengan lokasi user
                    document.querySelector('#mapOne').innerHTML = '';
                    new jsVectorMap({
                        selector: "#mapOne",
                        map: "world",
                        zoomButtons: false,
                        regionStyle: {
                            initial: {
                                fontFamily: "Outfit",
                                fill: "#D9D9D9",
                            },
                            hover: {
                                fillOpacity: 1,
                                fill: "#465fff",
                            },
                        },
                        markers: [
                            {
                                name: "Lokasi Anda",
                                coords: [lat, lng],
                            },
                        ],
                        markerStyle: {
                            initial: {
                                strokeWidth: 1,
                                fill: "#ef4444",
                                fillOpacity: 1,
                                r: 6,
                            },
                            hover: {
                                fill: "#ef4444",
                                fillOpacity: 1,
                            },
                            selected: {},
                            selectedHover: {},
                        },
                    });
                },
                () => {
                    // Jika user menolak, tetap pakai default Jakarta
                    console.log('Geolocation ditolak, menggunakan lokasi default.');
                }
            );
        }
    }
};

export default initMap;
