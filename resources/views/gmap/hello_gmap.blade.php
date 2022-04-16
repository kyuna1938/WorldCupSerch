@extends('common.layout')
@section('addTitle')
<title>Hello Google Map!!</title>
@stop
@section('addMeta')
<meta name="csrf-token" content="{{csrf_token()}}">
@stop
@section('addCSS')
@stop
@section('addScript')
<!-- Google Map JavaScript Library -->
@stop
@include('common.header')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha512-VGxuOMLdTe8EmBucQ5vYNoYDTGijqUsStF6eM7P3vA/cM1pqOwSBv/uxw94PhhJJn795NlOeKBkECQZ1gIzp6A==" crossorigin="anonymous"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyD1kEwZrEl7kEbYUyelohaGA0qqsulLi04&language=ja"></script>
<div class="container">
    <div id="hello_gmap">
        <div class="title">Hello Google Map!!</div>
        <span>If your configuration is succeeded, you can see a world map in the following space.</span>
        <div id="gmap">
            <div id="mapinfo"></div>
            <div id="map" class="z-depth-1" style="height: 500px"></div>
        </div>
        <button type="submit" @click="addMarkerJapan" :disabled="false" class="btn btn-primary">Add Marker at Japan</button>
        <button type="submit" @click="addMarkerUSA" :disabled="false" class="btn btn-primary">Add Marker at U.S.A.</button>
        <button type="submit" @click="clearMarkers" :disabled="false" class="btn btn-primary">Clear Markers</button>
    </div>
</div>

<script type="text/javascript">
    const app = new Vue({
        el: '#hello_gmap',
        data: {
            gmap: null,
            markers: []
        },
        mounted: async function () {
            await this.sleep(1000);   // wait until loading google map javascript
            this.map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 0, lng: 0 },
                zoom: 1
            });
        },
        methods: {
            sleep: function (msec) {
                return new Promise((resolve) => {
                    setTimeout(() => { resolve() }, msec);
                })
            },
            addMarkerJapan: function () {
                let location = { lat: 36.2048, lng: 138.25 };
                let marker = this.addMarker("Japan", location);
                this.markers.push(marker);
            },
            addMarkerUSA: function () {
                let location = { lat: 37.0902, lng: -95.7129 };
                let marker = this.addMarker("Japan", location);
                this.markers.push(marker);
            },
            clearMarkers: function () {
                this.markers.forEach((marker) => {
                    marker.setMap(null);
                })
                this.markers = [];
            },
            addMarker(title, location, callback) {
                let marker = new google.maps.Marker(
                    {
                        position: location,
                        map: this.map,
                        title: title
                    }
                );
                return marker;
            },
        }
    });
</script>

@stop
@include('common.footer')