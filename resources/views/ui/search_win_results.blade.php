@extends('common.layout')
@section('addTitle')
<title>Search Win Matches: Results</title>
@stop
@include('common.header')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha512-VGxuOMLdTe8EmBucQ5vYNoYDTGijqUsStF6eM7P3vA/cM1pqOwSBv/uxw94PhhJJn795NlOeKBkECQZ1gIzp6A==" crossorigin="anonymous"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyD1kEwZrEl7kEbYUyelohaGA0qqsulLi04&language=ja"></script>
<div class="container" id="gmap">
    <div class="title">Search Win Matches: Results</div>
    <div>
            <div id="mapinfo"></div>
                <div id="map" class="z-depth-1" style="height: 500px"></div>
            </div>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">TOURNAMENT</th>
                <th scope="col">ROUND</th>
                <th scope="col">GROUP</th>
                <th scope="col">DATE</th>
                <th scope="col">TEAM</th>
                <th scope="col">RESULT</th>
                <th scope="col">TEAM</th>
            </tr>
        </thead>
        <?php foreach ($data1 as $val) { ?>
            <tr @click='drowColor(<?php echo $val->id1; ?>,<?php echo $val->id2; ?>)'>
                <td scope="row"><?php echo $val->name1; ?></td>
                <td scope="row"><?php echo $val->name2; ?></td>
                <td scope="row"><?php echo $val->name3; ?></td>
                <td scope="row"><?php echo $val->start_date; ?></td>
                <td scope="row"><?php echo $val->country1; ?></td>
                <td scope="row"><?php echo $val->plus.' - '.$val->mina; ?></td>
                <td scope="row"><?php echo $val->country2; ?></td>
            </tr>
        <?php } ?>
        
        
    </table>
</div>
<script type="text/javascript">
    const app = new Vue({
        el: '#gmap',
        data: {
            gmap: null,
            markers: [],
            countriesmark:[
                <?php foreach ($latlng as $val):?>
                    {id:<?=$val->id?>,lat:<?=$val->lat?>,lng:<?=$val->lng?>},
                <?php endforeach; ?>
            ]
        },
        mounted: async function () {
            await this.sleep(1000);   // wait until loading google map javascript
            this.map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 0, lng: 0 },
                zoom: 1
            });
            
            this.drowMarkers();
        },
        methods: {
            sleep: function (msec) {
                return new Promise((resolve) => {
                    setTimeout(() => { resolve() }, msec);
                })
            },

            clearMarkers: function () {
                this.markers.forEach((marker) => {
                    marker.setMap(null);
                })
                this.markers = [];
            },

            addMarker(title, location, icon, callback) {
                let marker = new google.maps.Marker(
                    {
                        position: location,
                        map: this.map,
                        icon: icon
                    }
                );
                return marker;
            },

            drowMarkers: function(){
                let icon = 'https://maps.google.com/mapfiles/ms/icons/red-dot.png';
                for(let i = 0;i < this.countriesmark.length;i++){
                    let location = { lat: this.countriesmark[i].lat, lng: this.countriesmark[i].lng };
                    this.addMarker("Japan", location, icon)
                }
            },

            drowColor: function(id1,id2){
                
                for(let i = 0;i < this.countriesmark.length;i++){
                    let icon = 'https://maps.google.com/mapfiles/ms/icons/red-dot.png';
                    if(id1 == this.countriesmark[i].id || id2 == this.countriesmark[i].id){
                        icon = 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png';
                        console.log(id1);
                    }
                    let location = { lat: this.countriesmark[i].lat, lng: this.countriesmark[i].lng };
                    this.addMarker("Japan", location,icon)
                }
            },



        }
    });
</script>
@stop
@include('common.footer')