@extends('common.layout')
@section('addTitle')
<title>Search World Cup Database</title>
@stop
@include('common.header')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha512-VGxuOMLdTe8EmBucQ5vYNoYDTGijqUsStF6eM7P3vA/cM1pqOwSBv/uxw94PhhJJn795NlOeKBkECQZ1gIzp6A==" crossorigin="anonymous"></script>
<style>
    #search_form_area {
        padding: 0.5em 1em;
        margin: 2em 0;
        background: #f0f7ff;
        border: dashed 2px #5b8bd0;
    }
</style>

<div class="container">
    <div class="title">Search World Cup Database</div>

    <form action="./search_results" method="POST">
        {{ csrf_field() }}

        <div id="search_form_area">
            <div class="title">Search Form</div>
            <div class="form-group">

                <label for="Tournament">Tournament</label>
                <select class="form-control" id="tournament" name="tournament" v-model="selected" @Change="getTeam">
                    <option value="" selected></option>
                    <?php foreach ($tournaments as $v) { ?>
                        <option value=<?php echo $v->id; ?>><?php echo $v->name; ?></option>
                    <?php } ?>
                    
                </select>

                <label for="Round">Round</label>
                <select class="form-control" id="round" v-model="selected1" @Change="getRound">
                    <option value="" selected></option>
                    <option value="group" >Group</option>
                    <option value="knock" >Knockout</option>              
                </select>

                <div style="display: block;" id="gdiv">
                    <label for="Group">Group</label>
                    <select class="form-control" id="group" name="group">
                        <option value="" selected></option>
                        <option v-for="d in groups" v-bind:value="d.id">@{{d.name}}</option>
                    </select>
                     
                </div>
                
                <label for="Team">Team</label>
                <select class="form-control" id="team" name="team" onChange="kakunin2()">
                    <option value="" selected></option>
                    <option v-for="d in datas" v-bind:value="d.id">@{{d.name}}</option>
                </select>

                <div style="display: none;" id="odiv">
                    <label for="Outcome">Outcome(for the team you set)</label>
                    <p>
                        <input type="checkbox" name = "win" value="1">win
                        <input type="checkbox" name = "lose" value="2">lose 
                        <input type="checkbox" name = "drow" value="4">drow  
                    </p>
                </div>
                
            </div>
            
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <li>
        <a href="{{ url('/importcsv/select_csv') }}"> データの追加はこちら </a>
    </li>
        <a hr>
</div>
<script type="text/javascript">
    function kakunin1(){
        $val = $("select[id='round']").val();
        if($val == 'knock'){
            document.getElementById("gdiv").style.display="none";
        } else {
            document.getElementById("gdiv").style.display="block";
        }
    }
    function kakunin2(){
        $val = $("select[id='team']").val();
        console.log($val)
        if($val){
            document.getElementById("odiv").style.display="block";
        } else {
            document.getElementById("odiv").style.display="none";
        }
    }
    const app = new Vue({
        el: '#search_form_area',
        data: {
            selected : '',
            selected1 : '',
            datas : [],
            groups : [],
            array : []
        },
        methods: {
            getTeam: async function () {
                if(this.selected1 == 'group'){

                }
                this.array = await axios.get( '/ui/search_team?id=' + this.selected);
                this.datas = this.array.data;
                
            },
            getRound: async function () {
                /*if(this.selected1 == 'knock'){
                    document.getElementById("gdiv").style.display="none";
                    return;
                } else {
                    document.getElementById("gdiv").style.display="block";
                }*/
                console.log( '/ui/search_group?id=' + this.selected + '&round_name=' + this.selected1);
                this.array = await axios.get( '/ui/search_group?id=' + this.selected + '&round_name=' + this.selected1);
                this.groups = this.array.data;
                console.log(this.groups);
            },
        }
    });
</script>
@stop
@include('common.footer')
