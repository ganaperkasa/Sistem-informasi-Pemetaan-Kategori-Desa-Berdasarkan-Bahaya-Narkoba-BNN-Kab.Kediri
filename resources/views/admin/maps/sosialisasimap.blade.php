@extends('layouts.main.index')
@section('container')
    <div class="row">
        <div class="col-md-12 col-lg-12 order-0 mb-4">
            <div class="card h-1000">
                <div class="card-body">

                    <div id="map"></div>
                    <div id="floating-info" style="display: none;"></div>
                    <!-- Make sure you put this AFTER Leaflet's CSS -->
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

                </div>
            </div>
        </div>
        <script>
            var map = L.map('map').setView([-7.8015312, 111.9448052], 11);

            var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 22,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // console.log(@json($desas))
            const desas = @json($desas)
            // const villages= {!! json_encode($desas) !!};

            const desaData = desas
                .filter(desa => desa.polygon && desa.polygon !== 'null')
                .map(desa => ({
                    type: "Feature",
                    properties: {
                        name: desa.nama_desa,
                        id: desa.id,
                        sosialisasi: desa.sosialisasis.length,
                        detail: desa.sosialisasis.map(s => ({
                            judul: s.judul,
                            gambar: s.gambar,
                        }))
                    },
                    geometry: {
                        type: desa.type_polygon,
                        coordinates: JSON.parse(desa.polygon),
                    }
                }));

            const geoJson = {
                type: "FeatureCollection",
                features: desaData,
            };

            function getColor(d) {
                return d >= 1 ? '#0000FF' :
                    '#FF0000';
            }

            function style(feature) {
                return {
                    fillColor: getColor(feature.properties.sosialisasi),
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.7
                };
            }

            function highlightFeature(e) {
                var layer = e.target;

                layer.setStyle({
                    weight: 5,
                    color: '#666',
                    dashArray: '',
                    fillOpacity: 0.7
                });

                layer.bringToFront();
                info.update(layer.feature.properties);
                showFloatingInfo(layer.feature.properties);
            }

            function resetHighlight(e) {
                geojson.resetStyle(e.target);
                info.update();
                hideFloatingInfo();
            }

            function zoomToFeature(e) {
                map.fitBounds(e.target.getBounds());
            }

            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });
            }

            function showFloatingInfo(props) {
                const div = document.getElementById('floating-info');
                let html = `<h4>Sosialisasi Desa</h4><b>${props.name}</b><br />${props.sosialisasi} Sosialisasi`;

                if (props.detail.length > 0) {
                    html += `<ul style="list-style:none;padding:0;">`;
                    props.detail.forEach(s => {
                        html +=
                            `<li style="margin-bottom:10px;"><b>${s.judul}</b><br/><img src="/storage/${s.gambar}" width="100"/></li>`;
                    });
                    html += `</ul>`;
                }

                div.innerHTML = html;
                div.style.display = 'block';
            }

            function hideFloatingInfo() {
                const div = document.getElementById('floating-info');
                div.style.display = 'none';
            }


            geojson = L.geoJson(geoJson, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(map);

            var info = L.control();

            info.onAdd = function(map) {
                this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
                this.update();
                return this._div;
            };

            info.update = function(props) {
                if (!props) {
                    this._div.innerHTML = '<h4>Soialisasi Desa </h4>Arahkan kursor ke suatu Desa';
                    return;
                }

                let html = `<h4>Sosialisasi Desa</h4><b>${props.name}</b><br />${props.sosialisasi} Sosialisasi`;

                this._div.innerHTML = html;
            };

            info.addTo(map);

            var legend = L.control({
                position: 'bottomright'
            });

            legend.onAdd = function(map) {

                var div = L.DomUtil.create('div', 'info legend'),
                    grades = [0, 1],
                    labels = [];

                
                for (var i = 0; i < grades.length; i++) {
                    var from = grades[i];
                    var to = grades[i + 1];

                    div.innerHTML +=
                        '<i style="background:' + getColor(from) + '"></i> ' +
                        (to ? from + '&ndash;' + (to - 1) + '<br>' : from + '+');
                }

                return div;
            };

            legend.addTo(map);
        </script>
    @endsection
