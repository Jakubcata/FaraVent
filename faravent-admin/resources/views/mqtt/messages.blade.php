
        <h5 class="card-title">Posledných 30 správ</h5>
        <script>
        $(function(){
                setInterval(function () {
                    if(vis()){
                        $.ajax({
                            type: "get",
                            url: "{{$messagesUrl}}",
                            cache: false,
                            data:{
                                api_token:"{{$currentUser->api_token}}"
                            },
                            success: function (html) {
                                $("#last-messages-table").html(html);
                            },
                            error: function(data){
                                showToast("toast-error","Failed refresh messages<br/>"+data.responseText);
                            }
                        });
                    } else{
                        console.log("Skipping");
                    }
                }, 2000);
        });
        </script>
        @include('mqtt.messages_table')
