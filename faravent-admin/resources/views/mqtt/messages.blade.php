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
        <h5 class="card-title">Posledných 30 správ</h5>Enable refresh <input type="checkbox" id="refresh_messages">
        <script>
        var timerId= 0;
        $(function(){
          $("#refresh_messages").click(function(){
            if($("#refresh_messages" ).is(":checked")) {
                timerId = setInterval(function () {
                  $.ajax({
                      type: "get",
                      url: "{{route('lastMessagesSnippet')}}",
                      cache: false,
                      success: function (html) {
                          $("#last-messages-table").html(html);
                      }
                  });
              }, 1000);
          } else{

            clearInterval(timerId);
          }
      })});
        </script>
        @include('mqtt.messages_table')
    </div>
</div>
