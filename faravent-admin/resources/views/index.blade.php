<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">
    <title>FaraVent Admin</title>
    <base href="http://admin.faravent.jakubcata.eu/">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
</head>
<body>

    <div class="container main">
        <div class="row">
          <div class="col-md-3">
            <h5>Sledované topics</h5>

            <table class="table">
              <tbody>
              @foreach($topics as $topic)
                <tr><th scope="row">{{ $topic }}</th><td><a href={{route('deleteTopic', ['topic' => $topic])}} onclick="return confirm('Naozaj chceš zmazať {{$topic}} ?')">Delete</a></td></tr>
              @endforeach
            </tbody>
            </table>
            <form action="{{route('addTopic')}}">
              <div  class="input-group">
                <input type="text" id="fname" name="topic" placeholder="Nový topic" class="form-control">
                <input type="submit" value="Add">
              </div>
            </form>
          </div>


          <div class="col-md-6">
                      <div class="float-left"><h5>Posledných 30 správ</h5></div>

                      <div class="float-right"><a class="btn btn-info" href="{{route('index')}}">Refresh</a></div>
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Message</th>
                            <th scope="col">Date</th>
                          </tr>
                        </thead>
                        <tbody>
            @foreach($messages as $message)
              <tr><td>{{$message->type}}</td><td>{{$message->topic}}</td><td>{{$message->message}}</td><td>{{$message->created}}</td></tr>
            @endforeach
          </tbody>
          </table>
          <h5>Pošli správu</h5>
          <form action="{{route('publish')}}">
            <div  class="input-group">
              <input type="text" name="topic" placeholder="topic" class="form-control">
              <input type="text" name="message" placeholder="message" class="form-control">
              <input type="submit" value="Send">
            </div>
          </form>
          </div>
        </div>
    </div>
</body>
</html>
