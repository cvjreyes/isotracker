@if (Auth::guest())

@else
    <table class="table table-bordered">
        <tr>
            <th>Area</th>
            <th>Type of civilpments</th>
            <th>Code</th>
            <th>Hours</th>
            <th>Estimated quantity</th>
            <th>Estimated Hours</th>
            <th width="280px">Action</th>
        </tr>
    @foreach ($ecivils as $key => $item)
    <tr>
        <td>{{ $item->area }}</td>
        <td>{{ $item->type }}</td>
        <td>{{ $item->code }}</td>
        <td>{{ $item->hours }}</td>
        <td>{{ $item->est_quantity }}</td>
        <td>{{ $item->est_hours }}</td>

    </tr>
    @endforeach
    </table>

@endif