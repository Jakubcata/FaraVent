<div class="main-card mb-3 card">
    <div class="card-body"><h5 class="card-title">Subscribed topics</h5>
        <table class="mb-0 table">
            <tbody>
            @foreach($topics as $topic)
              <tr><th scope="row">{{ $topic }}</th><td><a  class="mr-2 btn-icon btn-icon-only btn btn-outline-danger" href="{{route('deleteTopic', ['topic' => $topic])}}" onclick="return confirm('Naozaj chceš zmazať {{$topic}} ?')" data-toggle="tooltip" data-placement="top" title="Unsubscribe"><i class="pe-7s-trash btn-icon-wrapper"> </i></a></td></tr>
            @endforeach
            </tbody>
        </table>
        <form class="form-inline" action="{{route('addTopic')}}">
            <div class="mb-0 mr-sm-2 mb-sm-0 position-relative form-group">
                <input name="topic" placeholder="Nový topic" type="text" class="form-control">
            </div>
            <button class="btn btn-primary">Add</button>
        </form>
    </div>
</div>
