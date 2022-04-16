@extends('common.layout')
@section('addTitle')
<title>Search Win Matches: Results</title>
@stop
@include('common.header')
@section('content')
<div class="container">
    <div class="title">Search Win Matches: Results</div>
    <div class="title">Search: <?php echo $name[0]->country; ?></div>
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
            <tr>
                <td scope="row"><?php echo $val->name1; ?></td>
                <td scope="row"><?php echo $val->name2; ?></td>
                <td scope="row"><?php echo $val->name3; ?></td>
                <td scope="row"><?php echo $val->start_date; ?></td>
                <td scope="row"><?php echo $name[0]->country; ?></td>
                <td scope="row"><?php echo $val->plus.' - '.$val->mina; ?></td>
                <td scope="row"><?php echo $val->country; ?></td>
            </tr>
        <?php } ?>
        <?php foreach ($data2 as $val) { ?>
            <tr>
                <td scope="row"><?php echo $val->name1; ?></td>
                <td scope="row"><?php echo $val->name2; ?></td>
                <td scope="row"><?php echo $val->name3; ?></td>
                <td scope="row"><?php echo $val->start_date; ?></td>
                <td scope="row"><?php echo $name[0]->country; ?></td>
                <td scope="row"><?php echo $val->plus.' - '.$val->mina; ?></td>
                <td scope="row"><?php echo $val->country; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
@stop
@include('common.footer')