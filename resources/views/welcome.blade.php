<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    </head>
    <body>
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->

                <!-- Icon -->
                <div class="fadeIn first py-5">
                    <img src="http://elixia.tech/wp-content/themes/elixia/img/logo.svg" id="icon" alt="User Icon" />
                </div>

                <!-- Login Form -->
                <form id="login-form">
                    <input type="text" id="login" class="fadeIn second" name="email" placeholder="email">
                    <input type="text" id="password" class="fadeIn third" name="password" placeholder="password">

                    <div>
                        <input type="submit" class="fadeIn fourth" value="Log In">
                    </div>
                </form>

                <!-- Remind Passowrd -->
                <div id="formFooter">
                    <a class="underlineHover" href="#">Forgot Password?</a>
                </div>

            </div>
        </div>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script>

        $(document).ready(function(){
            console.log('i am ready');

            var rule = {
                email: "required",
                password: "required",
            };

            var message = {
                email: "email is required",
                password: "password is required"
            }

            $("#login-form").validate({
                rules: rule,
                messages: message,
                submitHandler: function(form) {
                    var formData = new FormData($("#login-form")[0]);

                     $.ajax({
                        type        : 'POST',
                        url         : "{{ url('api/login') }}",
                        data        : formData,
                        cache       : false,
                        processData : false,
                        contentType : false,
                        success     : function( res ){
                            console.log(res);
                            localStorage.setItem("access_token", res.access_token);
                            location.href= "{{ url('api/auth/dashboard') }}/" + localStorage.getItem("access_token");
                        },
                        error       : function (xhr) {
                            if( xhr.status == "401" ){
                                location.href = "{{ url('/') }}";
                            }
                            else if( xhr.status == "422" ){
                                var response = JSON.parse(xhr.responseText);
                                $('#error-msg').html('<p class="error">'+xhr.responseText+'</p>');
                            }
                            else {
                                var response = JSON.parse(xhr.responseText);
                                $('#error-msg').html('<p class="error">Other Error: </p><p class="error">'+xhr.responseText+'</p>');
                            }
                        } 
                    });
                    
             }
            });
        })
        
        </script>
    </body>
</html>
