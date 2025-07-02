@extends('layouts.main.index')
@section('container')
<div class="row">
    <div class="col-md-12 col-lg-12 order-0 mb-4">
      <div class="card h-1000">
        <div class="card-body">

            <div id="map"></div>
            <!-- Make sure you put this AFTER Leaflet's CSS -->
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        </div>
      </div>
    </div>
    <script>
        var map = L.map('map').setView([-7.8028918,112.0526085], 11);

        var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);


        @foreach($desas as $desa)
        @if($desa->latitude && $desa->longitude)
            var marker = L.marker([{{ $desa->latitude }}, {{ $desa->longitude }}], {
                alt: '{{ $desa->nama_desa }}'
            }).addTo(map).bindPopup(
                '<strong>Desa:</strong>{{ $desa->nama_desa }}<br><strong>Kecamatan:</strong> {{ $desa->kecamatan->nama_kecamatan }}<br><strong>Golongan Narkoba:</strong> {{ $desa->golongan_positif }}').openPopup();
            marker.bindTooltip(
                    "{{ $desa->nama_desa ?: 'Lokasi Tanpa Nama' }}", {
                        permanent: true,
                        direction: 'top',
                        className: 'my-labels' // Optional: untuk custom styling
                    }
                );
        @endif
    @endforeach






    </script>

@endsection