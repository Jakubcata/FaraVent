<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">
    <title>FaraVent Admin</title>
    <base href="{{url('/')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
</head>
<body>

    <div class="container main">
        <div class="row">
          <div class="col-md-6">
            <h5>Sledované topics</h5>

            <table class="table">
              <tbody>
              @foreach($topics as $topic)
                <tr><th scope="row">{{ $topic }}</th><td><a href="{{route('deleteTopic', ['topic' => $topic])}}" onclick="return confirm('Naozaj chceš zmazať {{$topic}} ?')">Delete</a></td></tr>
              @endforeach
            </tbody>
            </table>
            <form action="{{route('addTopic')}}">
              <div  class="input-group">
                <input type="text" name="topic" placeholder="Nový topic" class="form-control">
                <input type="submit" value="Add">
              </div>
            </form>
            <br/>
            <h5>Zariadenia</h5>
            <table class="table">
            <thead>
                <tr><th>Nazov zariadenia</th><th>Topicy na ktorom zariadenie prijima spravy</th><th>Topic do ktoreho zariadenie posiela spravy</th></tr>
            </thead>
            <tbody>
              @foreach($devices as $device)
                <tr><th scope="row">{{ $device->name }}</th><td><ul><li>{{$device->in_topic}}</li><li> {{$device->name}}_update (firmware update)</li></ul></td><td>{{$device->out_topic}}</td><td><a href="{{route('removeDevice',['id'=>$device->id])}}">Remove</a></td></tr>
              @endforeach
            </tbody>
            </table>
            <form action="{{route('addDevice')}}">
              <div  class="input-group">
                <input type="text" name="name" placeholder="Názov zariadenia bez medzier" class="form-control">
                <input type="submit" value="Add">
              </div>
            </form>
            <br/>
            <h5>Binárky</h5>
            <table class="table">
              <tbody>
              @foreach($binaries as $binary)
                <tr><th scope="row">{{ $binary->name }}</th>
                  <td>{{$binary->created_at}}</td>
                  <td><a href="{{route('deployBinary',['id'=>$binary->id])}}" onclick="return confirm('Naozaj chceš deploynuť {{$binary->name}} ?')">Deploy</a></td>
                  <td><a href="{{route('deleteBinary',['id'=>$binary->id])}}" onclick="return confirm('Naozaj chceš zmazať {{$binary->name}} ?')">Delete</a></td>
                </tr>
              @endforeach
            </tbody>
            </table>

            <form action="{{route('uploadBinary')}}" method="post" enctype="multipart/form-data">
              @csrf
              Select binary to upload:
              <input type="file" name="binary">
              <input type="submit" value="Upload Binary" name="submit">
            </form>

          </div>


          <div class="col-md-6">
            <h5>Pošli správu</h5>
            <form action="{{route('publish')}}">
              <div  class="input-group">
                <input type="text" name="topic" placeholder="topic" class="form-control">
                <input type="text" name="message" placeholder="message" class="form-control">
                <input type="submit" value="Send">
              </div>
            </form><br/>
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
              <tr><td>{{$message->type}}</td><td>{{$message->topic}}</td><td>{{$message->message}}</td><td>{{Helper::time_elapsed_string($message->created)}}</td></tr>
            @endforeach
          </tbody>
          </table>

          </div>
        </div>
    </div>
</body>
</html>
