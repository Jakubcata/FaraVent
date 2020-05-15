<div id="last-messages-table">
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
        @foreach($lastMessages as $message)
          <tr><td>{{$message->type}}</td><td>{{$message->topic}}</td><td>{{$message->message}}</td><td>{{Helper::time_elapsed_string($message->created)}}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>
