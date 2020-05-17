<h5 class="card-title">Binárky</h5>
<table class="mb-0 table">
    <thead>
        <tr><th>Názov</th><th>branch</th><th>verzia</th><th>Dátum</th><th>Deploy</th><th>Delete</th></tr>
    </thead>
    <tbody>
        @foreach($binaries as $binary)
        <tr><th scope="row"><a href="{{url("/").'/binaries/'.$binary->real_name}}">{{ $binary->name }}</a></th>
            <td>{{$binary->version}}</td>
            <td>{{$binary->branch}}</td>
            <td>{{$binary->created_at}}</td>
            <td><a class="mr-2 btn-icon btn-icon-only btn btn-outline-success" href="{{route('deployBinary',['id'=>$binary->id])}}" onclick="return confirm('Naozaj chceš deploynuť {{$binary->name}} ?')" data-toggle="tooltip" data-placement="top" title="Deploy"><i class="pe-7s-play btn-icon-wrapper"> </i></a></td>
            <td><a class="mr-2 btn-icon btn-icon-only btn btn-outline-danger" href="{{route('deleteBinary',['id'=>$binary->id])}}" onclick="return confirm('Naozaj chceš zmazať {{$binary->name}} ?')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="pe-7s-trash btn-icon-wrapper"> </i></a></td>
          </tr>
        @endforeach
    </tbody>
</table>
<form class="form-inline" action="{{route('uploadBinary')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-0 mr-sm-2 mb-sm-0 position-relative form-group">
        <input type="text" name="version" placeholder="version" class="form-control">
        <input type="text" name="branch" placeholder="branch" class="form-control">
    </div>
    <input type="file" name="binary">
    <button class="btn btn-primary">Add</button>
</form>
