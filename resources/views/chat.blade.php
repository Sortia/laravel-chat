<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="{{asset('/js/jquery.js')}}"></script>
{{--    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js" integrity="sha256-yr4fRk/GU1ehYJPAs8P4JlTgu0Hdsp4ZKrx8bDEDC3I=" crossorigin="anonymous"></script>

    <title>Chat</title>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">Chat</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-12" id="chat">

                    @foreach($messages as $message)
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="btn btn-outline-primary @if($message->user_id === 1) float-left @else float-right @endif mb-2">{{$message->text}}</button>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <input type="text" class="form-control mb-3" id="input-chat">
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-success btn-block" id="btn-chat">Send</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>

    $(function () {
        $('#btn-chat').on('click', function () {
            let message = $('#input-chat').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/addMessage",
                data: {
                    message: message
                },
                success: function () {
                    $('#input-chat').val('');
                }
            });
        });

        let socket = io(':6001');

        socket.on('chat:message', function (data) {

            console.log(data);

            $('#chat').append(
                ' <div class="row">\n' +
                '<div class="col-lg-12">\n' +
                '<button class="btn btn-outline-primary float-right mb-2">' + data.text + '</button>\n' +
                '</div>\n' +
                '</div>'
            );
        })
    });

</script>

</body>
</html>
