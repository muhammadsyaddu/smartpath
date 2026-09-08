/*
|--------------------------------------------------------------------------
| SMARTPATH ADMIN DASHBOARD
|--------------------------------------------------------------------------
| Fungsi:
| - Inisialisasi Leaflet
| - OpenStreetMap
| - Marker laporan
| - Filter kategori
| - Filter periode
| - Recenter Kota Depok
| - Secure popup rendering
|
| Tidak mengubah:
| - routes/web.php
| - controller
| - database
| - business logic Laravel
|--------------------------------------------------------------------------
*/

(() => {

    'use strict';


    /*
    |--------------------------------------------------------------------------
    | CONSTANT
    |--------------------------------------------------------------------------
    */

    const DEFAULT_CENTER = [
        -6.4025,
        106.7942
    ];

    const DEFAULT_ZOOM = 12;


    /*
    |--------------------------------------------------------------------------
    | HTML ESCAPE
    |--------------------------------------------------------------------------
    | Data laporan berasal dari database.
    | Sebelum dimasukkan ke popup Leaflet, data di-escape.
    |--------------------------------------------------------------------------
    */

    const escapeHtml = (value) => {

        return String(value ?? '').replace(
            /[&<>'"]/g,
            (character) => {

                const entities = {

                    '&': '&amp;',

                    '<': '&lt;',

                    '>': '&gt;',

                    "'": '&#039;',

                    '"': '&quot;'

                };

                return entities[character];

            }
        );

    };


    /*
    |--------------------------------------------------------------------------
    | PRIORITY
    |--------------------------------------------------------------------------
    */

    const getPriorityLevel = (score) => {

        const numericScore = Number(score);

        if (numericScore >= 70) {

            return {
                level: 'high',
                label: 'Tinggi',
                color: '#dc2626'
            };

        }

        if (numericScore >= 40) {

            return {
                level: 'medium',
                label: 'Sedang',
                color: '#d97706'
            };

        }

        return {

            level: 'low',

            label: 'Rendah',

            color: '#16a34a'

        };

    };


    /*
    |--------------------------------------------------------------------------
    | POPUP
    |--------------------------------------------------------------------------
    */

    const createPopup = (report) => {

        const score = Number(
            report.skor_prioritas ?? 0
        );

        const priority =
            getPriorityLevel(score);


        const title =
            escapeHtml(
                report.judul || 'Laporan'
            );


        const address =
            escapeHtml(
                report.alamat
                ||
                report.kategori
                ||
                'Lokasi tidak tersedia'
            );


        const category =
            escapeHtml(
                report.kategori
                ||
                'Kategori tidak tersedia'
            );


        const status =
            escapeHtml(
                report.status_label
                ||
                report.status
                ||
                'Status tidak tersedia'
            );


        return `
            <div class="sp-map-popup">

                <div class="sp-map-popup-title">
                    ${title}
                </div>

                <div class="sp-map-popup-address">
                    ${address}
                </div>

                <div class="sp-map-popup-meta">

                    <span
                        class="sp-map-popup-badge"
                        style="
                            color:${priority.color};
                            border-color:${priority.color}33;
                            background:${priority.color}10;
                        "
                    >
                        ${escapeHtml(priority.label)}
                    </span>

                    <span class="sp-map-popup-score">
                        Skor ${escapeHtml(score)}
                    </span>

                </div>

                <div class="sp-map-popup-detail">
                    ${category}
                </div>

                <div class="sp-map-popup-status">
                    ${status}
                </div>

            </div>
        `;

    };


    /*
    |--------------------------------------------------------------------------
    | INITIALIZE
    |--------------------------------------------------------------------------
    */

    const initializeMap = () => {

        const mapElement =
            document.getElementById(
                'admin-map'
            );


        if (!mapElement) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan Leaflet sudah tersedia
        |--------------------------------------------------------------------------
        */

        if (
            typeof window.L === 'undefined'
        ) {

            console.error(
                'SmartPath: Leaflet.js belum tersedia.'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Jangan initialise dua kali
        |--------------------------------------------------------------------------
        */

        if (
            mapElement.dataset.initialized === 'true'
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Baca data peta
        |--------------------------------------------------------------------------
        */

        const dataElement =
            document.getElementById(
                'smartpath-map-data'
            );


        let reports = [];


        if (dataElement) {

            try {

                const parsed =
                    JSON.parse(
                        dataElement.textContent || '[]'
                    );


                if (
                    Array.isArray(parsed)
                ) {

                    reports = parsed;

                }

            } catch (error) {

                console.error(
                    'SmartPath: data peta tidak dapat dibaca.',
                    error
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Create Map
        |--------------------------------------------------------------------------
        */

        const map =
            window.L
                .map(
                    mapElement,
                    {
                        zoomControl: true,

                        attributionControl: true,

                        scrollWheelZoom: true
                    }
                )
                .setView(
                    DEFAULT_CENTER,
                    DEFAULT_ZOOM
                );


        mapElement.dataset.initialized =
            'true';


        /*
        |--------------------------------------------------------------------------
        | OpenStreetMap
        |--------------------------------------------------------------------------
        */

        window.L
            .tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    maxZoom: 19,

                    attribution:
                        '&copy; OpenStreetMap contributors'
                }
            )
            .addTo(map);


        /*
        |--------------------------------------------------------------------------
        | Marker Layer
        |--------------------------------------------------------------------------
        */

        const markerLayer =
            window.L
                .layerGroup()
                .addTo(map);


        /*
        |--------------------------------------------------------------------------
        | Marker Renderer
        |--------------------------------------------------------------------------
        */

        const renderMarkers = () => {

            markerLayer.clearLayers();


            const categoryFilter =
                document.getElementById(
                    'map-category-filter'
                );


            const periodFilter =
                document.getElementById(
                    'map-period-filter'
                );


            const categoryId =
                categoryFilter?.value || '';


            const period =
                Number(
                    periodFilter?.value || 7
                );


            const cutoff =
                period > 0
                    ? Date.now()
                        -
                        (
                            period
                            *
                            24
                            *
                            60
                            *
                            60
                            *
                            1000
                        )
                    : 0;


            reports.forEach(
                (report) => {

                    const latitude =
                        Number(
                            report.latitude
                        );


                    const longitude =
                        Number(
                            report.longitude
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Validasi koordinat
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !Number.isFinite(latitude)
                        ||
                        !Number.isFinite(longitude)
                    ) {

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Filter kategori
                    |--------------------------------------------------------------------------
                    */

                    if (
                        categoryId
                        &&
                        String(
                            report.kategori_id
                        )
                        !==
                        String(
                            categoryId
                        )
                    ) {

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Filter periode
                    |--------------------------------------------------------------------------
                    */

                    if (
                        cutoff
                        &&
                        report.created_at
                        &&
                        Date.parse(
                            report.created_at
                        ) < cutoff
                    ) {

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Priority
                    |--------------------------------------------------------------------------
                    */

                    const score =
                        Number(
                            report.skor_prioritas ?? 0
                        );


                    const priority =
                        getPriorityLevel(
                            score
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Custom Marker
                    |--------------------------------------------------------------------------
                    */

                    const markerIcon =
                        window.L.divIcon({

                            className:
                                'smartpath-leaflet-marker',

                            html:
                                `
                                <span
                                    class="
                                        sp-marker
                                        ${priority.level}
                                    "
                                    role="img"
                                    aria-label="
                                        Prioritas
                                        ${escapeHtml(
                                            priority.label
                                        )}
                                    "
                                ></span>
                                `,

                            iconSize: [
                                15,
                                15
                            ],

                            iconAnchor: [
                                7.5,
                                7.5
                            ]

                        });


                    /*
                    |--------------------------------------------------------------------------
                    | Create Marker
                    |--------------------------------------------------------------------------
                    */

                    const marker =
                        window.L.marker(
                            [
                                latitude,
                                longitude
                            ],
                            {
                                icon:
                                    markerIcon
                            }
                        );


                    marker
                        .addTo(
                            markerLayer
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Popup
                    |--------------------------------------------------------------------------
                    */

                    marker.bindPopup(
                        createPopup(
                            report
                        ),
                        {
                            maxWidth: 280,

                            minWidth: 190,

                            closeButton: true
                        }
                    );

                }
            );

        };


        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'map-category-filter'
            )
            ?.addEventListener(
                'change',
                renderMarkers
            );


        document
            .getElementById(
                'map-period-filter'
            )
            ?.addEventListener(
                'change',
                renderMarkers
            );


        /*
        |--------------------------------------------------------------------------
        | Recenter
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'map-recenter'
            )
            ?.addEventListener(
                'click',
                () => {

                    map.flyTo(
                        DEFAULT_CENTER,
                        DEFAULT_ZOOM,
                        {
                            duration: 0.5
                        }
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | First Render
        |--------------------------------------------------------------------------
        */

        renderMarkers();


        /*
        |--------------------------------------------------------------------------
        | Leaflet resize fix
        |--------------------------------------------------------------------------
        */

        window.setTimeout(
            () => {

                map.invalidateSize();

            },
            150
        );


        /*
        |--------------------------------------------------------------------------
        | Window resize
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'resize',
            () => {

                map.invalidateSize();

            },
            {
                passive: true
            }
        );

    };


    /*
    |--------------------------------------------------------------------------
    | DOM READY
    |--------------------------------------------------------------------------
    */

    if (
        document.readyState === 'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initializeMap,
            {
                once: true
            }
        );

    } else {

        initializeMap();

    }

})();