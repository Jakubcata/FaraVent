<h5 class="card-title">Pošli správu</h5>

<form id="send-message-form">
  <div class="input-group">
    <input type="text" name="topic" placeholder="topic" class="form-control">
    <input type="text" name="message" placeholder="message" class="form-control">
    <button class="btn btn-primary">Send</button>
  </div>
</form>

<script>
$(function(){
    $("#send-message-form button").click(function(e){
        e.preventDefault();
        $.get({
            url:"{{route('sendMessage')}}",
            data:{
                api_token:"{{$currentUser->api_token}}",
                topic:$("#send-message-form input[name='topic']").val(),
                message:$("#send-message-form input[name='message']").val(),
            },
            success:function(data){
                $("#send-message-form input[name='topic']").val("");
                $("#send-message-form input[name='message']").val("");
                showToast("toast-success","Message sent");
            },
            error:function(data){
                showToast("toast-error","Message send error<br/>"+data.responseText, 5000);
            }
        });

    });
});

</script>
