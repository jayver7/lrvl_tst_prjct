@extends('layouts.app')

@section('content')

@role(['division_chief', 'admin'])
<div class="card">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-mm" id="ipcr_form_table">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> First Name </th>
                        <th> Last Name </th>
                        <th> MI </th>
                        <th> Position </th>
                        <th> Office </th>
                        <th> Status </th>
                        <th> Covered Period </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ipcr_form as $ipcrform)
                    <tr>
                        <td> {{$ipcrform["id"]}} </td>
                        <td> {{$ipcrform["first_name"]}} </td>
                        <td> {{$ipcrform["last_name"]}} </td>
                        <td> {{$ipcrform["mi"]}} </td>
                        <td> {{$ipcrform["position"]}} </td>
                        <td> {{$ipcrform["office"]}} </td>
                        <td> {{$ipcrform["status"]}} </td>
                        <td> {{$ipcrform["covered_period"]}} </td>
                        <td>
                            <a href="/approvedc/{{$ipcrform['id']}}/edit" class="btn btn-primary"> View </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('#ipcr_form_table').DataTable({
        width: '100%',
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true
    });
</script>
@endrole

@endsection