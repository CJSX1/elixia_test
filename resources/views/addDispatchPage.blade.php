<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Elixia Test</title>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <style>
        .error {
            color: red;
        }
        </style>
    </head>
    <body>
       
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="javascript:void(0);">ELixia Test</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="javascript:void(0);">Welcome, {{ auth()->user()->name }}<span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" onClick="logout();">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid px-5 pt-3">
            <div class="row">
                
                <button href="button" class="btn mb-5" onClick="backBtn();"> << Back</button>
                <form id="addDispatch-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="delivery_no">Delivery Number</label>
                            <input type="text" class="form-control" id="delivery_no" name="delivery_no" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ship_no">Shipment Number</label>
                            <input type="text" class="form-control" id="ship_no" name="ship_no" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="source_code">Source Code</label>
                            <select id="source_code" name="source_code" class="form-control">
                                <option disabled selected>Choose...</option>
                                @if(isset($sourceCodes) && count($sourceCodes) > 0 )
                                @foreach($sourceCodes as $sc)
                                    <option value="{{ $sc->id }}">{{ $sc->sourceName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dest_code">Destination Code</label>
                            <select id="dest_code" name="dest_code" class="form-control">
                                <option disabled selected>Choose...</option>
                                @if(isset($destinationCodes) && count($destinationCodes) > 0 )
                                @foreach($destinationCodes as $dc)
                                    <option value="{{ $dc->id }}">{{ $dc->destName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="form-group col-md-4">
                            <label for="trans_code">Transporter Code</label>
                            <select id="trans_code" name="trans_code" class="form-control">
                                <option disabled selected>Choose...</option>
                                @if(isset($transporterCodes) && count($transporterCodes) > 0 )
                                @foreach($transporterCodes as $tc)
                                    <option value="{{ $tc->id }}">{{ $tc->transName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="start_date">Start Date</label>
                            <input type="text" class="form-control" id="start_date" name="start_date" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="end_date">End Date</label>
                            <input type="text" class="form-control" id="end_date" name="end_date" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="veh_no">Vehicle Number</label>
                            <input type="text" class="form-control" id="veh_no" name="veh_no" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="driver_nm">Driver Name</label>
                            <input type="text" class="form-control" id="driver_nm" name="driver_nm" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="driver_ph">Driver Phone</label>
                            <input type="text" class="form-control" id="driver_ph" name="driver_ph" autocomplete="off">
                        </div>
                    </div>
                    <input type="submit" class="btn mb-2" value="Save Dispatch">
                </form>
                <div id="error-msg">

                </div>
            </div>
        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(document).ready(function(){
                console.log('i am ready');

                $( "#start_date" ).datepicker({
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(selected) {
                        $("#end_date").datepicker("option","minDate", selected)
                    }
                });
                $( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});

                var rule = {
                    delivery_no: {
                        required: true,
                        number: true
                    },

                    source_code: "required",
                    dest_code: "required",
                    trans_code: "required",
                    
                    start_date: "required",
                    end_date: "required",
                    
                    veh_no: "required",
                };

                var message = {
                    
                    source_code: " is required",
                    dest_code: " is required",
                    trans_code: " is required",
                    
                    start_date: " is required",
                    end_date: " is required",
                    
                    veh_no: " is required",
                };
                
                $("#addDispatch-form").validate({
                    rules: rule,
                    messages: message,
                    errorPlacement: function(error, element) {
                        console.log(element);
                        if (element.is('select')) {
                            error.insertBefore(element);
                        }  else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        var formData = new FormData($("#addDispatch-form")[0]);

                        var token = localStorage.getItem("access_token");

                        //regex for phone number
                        if( $('#driver_ph').val() != "" ){
                            var check = /^([0-9]{10})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})/.test($('#driver_ph').val());
                            if(!check){
                                $('#error-msg').html('<p class="error">Invalid phone number.</p>');
                                return false;
                            } else {
                                $('#error-msg').html('<p>Valid phone number.</p>');
                            } 
                        }

                        //validation for name character count
                        if( $('#driver_nm').val() != "" && $('#driver_nm').val().lenth < 50){
                            $('#error-msg').html('<p class="error">Driver name is greater than 50 characters.</p>');
                            return false;
                        }

                        $.ajaxSetup({
                            headers: {
                                'Authorization': 'Bearer '+ token,
                            }
                        });

                        $.ajax({
                            type        : 'POST',
                            url         : "{{ url('api/auth/saveDispatch') }}",
                            data        : formData,
                            cache       : false,
                            processData : false,
                            contentType : false,
                            success     : function( res ){
                                if(res.status == '200'){
                                    location.href= "{{ url('api/auth/dashboard') }}/" + localStorage.getItem("access_token");
                                }
                            },
                            error       : function (xhr) {
                                if( xhr.status == 401 ){
                                    location.href = "{{ url('/') }}";
                                }
                                else if( xhr.status == 422 ){
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

            function backBtn() {
                location.href= "{{ url('api/auth/dashboard') }}/" + localStorage.getItem("access_token");
            }
        </script>
    </body>
</html>
