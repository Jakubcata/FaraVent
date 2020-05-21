<h5 class="card-title">Subscribed topics</h5>
<div id="topics-table">
@include('mqtt.topics_table')
</div>
<form id="add-topic-form" class="form-inline" action="{{route('addTopic')}}">
    <div class="mb-0 mr-sm-2 mb-sm-0 position-relative form-group">
        <input name="topic" placeholder="Nový topic" type="text" class="form-control">
    </div>
    <button class="btn btn-primary">Add</button>
</form>
<script>
$(function(){
    $("#add-topic-form button").click(function(e){
        e.preventDefault();
        $.get({
            url:"{{route('addTopic')}}",
            data:{
                api_token:"{{$currentUser->api_token}}",
                topic:$("#add-topic-form input[name='topic']").val(),
            },
            success:function(data){
                $("#add-topic-form input[name='topic']").val("");
                showToast("toast-success","Topic added");
                reloadTopics();
            },
            error:function(data){
                showToast("toast-error","Error while adding topic<br/>"+data.responseText, 5000);
            }
        });

    });
});

function reloadTopics(){
    $.ajax({
        type: "get",
        url: "{{route('topicsSnippet')}}",
        cache: false,
        data:{
            api_token:"{{$currentUser->api_token}}"
        },
        success: function (html) {
            $("#topics-table").fadeOut('fast', function() {
                $("#topics-table").html(html);
                $("#topics-table").fadeIn('fast');
            });
        },
        error: function(data){
            showToast("toast-error","Failed load topics<br/>"+data.responseText,5000);
        }
    });
}

function deleteTopic(topic){
    if(!confirm('Naozaj chceš zmazať '+topic+' ?'))
        return false;
    $.get({
        url:"{{route('deleteTopic')}}",
        data:{
            api_token:"{{$currentUser->api_token}}",
            topic:topic,
        },
        success:function(data){
            showToast("toast-success","Topic deleted");
            reloadTopics();
        },
        error:function(data){
            showToast("toast-error","Error while adding topic<br/>"+data.responseText, 5000);
        }
    });
    return false;
}

</script>
