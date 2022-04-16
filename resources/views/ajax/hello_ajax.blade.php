@extends('common.layout')
@section('addTitle')
<title>Hello AJAX!!</title>
@stop
@section('addMeta')
<meta name="csrf-token" content="{{csrf_token()}}">
@stop
@section('addCSS')

@stop
@include('common.header')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha512-VGxuOMLdTe8EmBucQ5vYNoYDTGijqUsStF6eM7P3vA/cM1pqOwSBv/uxw94PhhJJn795NlOeKBkECQZ1gIzp6A==" crossorigin="anonymous"></script>

<div class="container">
    <div id="hello_ajax">
        <div class="title">Hello AJAX!!</div>
        <div><span>Push button to get message from the server: </span></div>
        <button type="submit" @click="showMessage1" :disabled="false" class="btn btn-primary">Show Message1</button>
        <button type="submit" @click="showMessage2" :disabled="false" class="btn btn-primary">Show Message2</button>
        <div class="title">@{{ message }}</div>
    </div>
</div>

    <script>
        const app = new Vue({
            el: '#hello_ajax',
            data: {
                message: ""
            },
            methods: {
                showMessage1: function () {
                    let url = "/ajax/hello_ajax_message";
                    axios.get(url).then((res) => {
                        this.message = res.data.message1;
                    });
                },
                showMessage2: async function () {
                    let url = "/ajax/hello_ajax_message";
                    let res = await axios.get(url);
                    this.message = res.data.message2;
                }
            }
        });
    </script>

@stop
@include('common.footer')