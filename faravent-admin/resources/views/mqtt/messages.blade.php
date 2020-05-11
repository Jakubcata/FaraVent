<div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title">Pošli správu</h5>

        <form action="{{route('publish')}}">
          <div class="input-group">
            <input type="text" name="topic" placeholder="topic" class="form-control">
            <input type="text" name="message" placeholder="message" class="form-control">
            <button class="btn btn-primary">Send</button>
          </div>
        </form>
    </div>
</div>

<div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title">Posledných 30 správ</h5>
        <table class="mb-0 table">
            <thead>
            <tr>
                <th>Type</th>
                <th>Topic</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
              <tr><td>{{$message->type}}</td><td>{{$message->topic}}</td><td>{{$message->message}}</td><td>{{Helper::time_elapsed_string($message->created)}}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
