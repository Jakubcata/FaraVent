<h5 class="card-title">Zariadenia</h5>
<table class="mb-0 table">
    <thead>
        <tr><th>Nazov zariadenia</th><th>Topicy na ktorom zariadenie prijima spravy</th><th>Topic do ktoreho zariadenie posiela spravy</th></tr>
    </thead>
    <tbody>
        @foreach($devices as $device)
          <tr>
              <th scope="row"><a href="{{route('showDevice',['id'=>$device->id])}}">{{ $device->verbose_name }}</a></th>
              <td>
                  <ul>
                      <li>{{$device->in_topic}}</li>
                      <li> {{$device->update_topic}} (firmware update)</li>
                  </ul>
              </td>
              <td>{{$device->out_topic}}</td>
              <td>
                  <a class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"
                        href="{{route('removeDevice',['id'=>$device->id])}}"
                        onclick="return confirm('Naozaj chceš zmazať {{$device->name}} ?')"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Remove">
                        <i class="pe-7s-trash btn-icon-wrapper"> </i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<form action="{{route('addDevice')}}">
    <div class="input-group">
        <input name="name" placeholder="Názov zariadenia bez medzier" type="text" class="form-control">
        <input name="verboseName" placeholder="Celý názov zariadenia" type="text" class="form-control">
        <button class="btn btn-primary">Add</button>
    </div>
</form>
