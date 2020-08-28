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
                <div class="col col-lg-4">
                    <input type="text" class="form-control mb-2 mr-sm-2" id="search" placeholder="Enter search text" name="search">
                    <span><small class="text-danger">please enter atleast 3 characters.</small></span>
                </div>
                
                <div class="col col-lg-3 p-2">
                    <label for="sortBy">Sort By :</label>

                    <select class="" id="sortBy" name="sortBy">
                        <option value="0">None</option>
                        <option value="1">Start Date</option>
                        <option value="2">End Date</option>
                        <option value="3">Source Name<</option>
                    </select>
                </div>

                <div class="col col-lg-2">
                    <button type="button" class="btn mb-2" onClick="addDispatch();">Add Dispatch</button>
                </div>

                <div class="col col-lg-2">
                    <button type="button" class="btn mb-2" onClick="exportDispatch();">Export Data</button>
                </div>
            </div>
        </div>

        <div class="container-fluid px-5 py-3">
            <div class="wrapper fadeInDown dispatchItems">
               
            </div>
        </div>

        <script>

            $(document).ready(function(){
                console.log('i am ready');
                getDispatchItems(0);

                $('#search').on('keyup', function(){

                    var search = $(this).val();

                    if( search.length >= 3) {

                        var token = localStorage.getItem("access_token");
    
                        $.ajaxSetup({
                            headers: {
                                'Authorization': 'Bearer '+ token,
                            }
                        });
    
                        $.ajax({
                            type        : 'GET',
                            url         : "{{ url('api/auth/searchDispatch') }}/"+search,
                            success     : function( res ){
                                var html = "";
                                res.items.forEach(el => {
                                    html += '<div class="row my-3 border border-secondary rounded">'+
                                        '<div class="col col-lg-12"><b>Dispatch ID: '+ el.id +'</b></div>'+
                                        '<div class="col col-lg-3 py-2"><b>Source Name:</b> <br />'+el.sourceName+'</div>'+
                                        '<div class="col col-lg-3"><b>Destination Name:</b> <br />'+el.destName+'</div>'+
                                        '<div class="col col-lg-3"><b>Transporter Code:</b> <br />'+el.transName+'</div>'+
                                        '<div class="col col-lg-3"><b>Vehicle Number:</b> <br />'+el.vehicle_no+'</div>'+
                                        '<div class="col col-lg-6"><b>Start Date:</b> <br />'+el.start_date+'</div>'+
                                        '<div class="col col-lg-6"><b>End Date:</b> <br />'+el.end_date+'</div>'+
                                    '</div>';
                                });
                                
                                localStorage.removeItem("limitValue");
                                $(".dispatchItems").html(html);
                            } 
                        });
                    } else {
                        getDispatchItems(0);
                    }
                });

                $('#sortBy').on('change', function(){

                    var sortBy = $(this).val();

                    if( sortBy) {

                        var token = localStorage.getItem("access_token");
    
                        $.ajaxSetup({
                            headers: {
                                'Authorization': 'Bearer '+ token,
                            }
                        });
    
                        $.ajax({
                            type        : 'GET',
                            url         : "{{ url('api/auth/sortDispatch') }}/"+sortBy,
                            success     : function( res ){
                                var html = "";
                                res.items.forEach(el => {
                                    html += '<div class="row my-3 border border-secondary rounded">'+
                                        '<div class="col col-lg-12"><b>Dispatch ID: '+ el.id +'</b></div>'+
                                        '<div class="col col-lg-3 py-2"><b>Source Name:</b> <br />'+el.sourceName+'</div>'+
                                        '<div class="col col-lg-3"><b>Destination Name:</b> <br />'+el.destName+'</div>'+
                                        '<div class="col col-lg-3"><b>Transporter Code:</b> <br />'+el.transName+'</div>'+
                                        '<div class="col col-lg-3"><b>Vehicle Number:</b> <br />'+el.vehicle_no+'</div>'+
                                        '<div class="col col-lg-6"><b>Start Date:</b> <br />'+el.start_date+'</div>'+
                                        '<div class="col col-lg-6"><b>End Date:</b> <br />'+el.end_date+'</div>'+
                                    '</div>';
                                });
                                
                                localStorage.removeItem("limitValue");
                                $(".dispatchItems").html(html);
                            } 
                        });
                    }
                });
            })
            
            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() == $(document).height()) {
                    var x = localStorage.getItem("limitValue");
                    if(x){
                        getDispatchItems(x);
                    }
                }
            });

            function getDispatchItems(limit) {

                var token = localStorage.getItem("access_token");

                $.ajaxSetup({
                    headers: {
                        'Authorization': 'Bearer '+ token,
                    }
                });

                $.ajax({
                    type        : 'GET',
                    url         : "{{ url('api/auth/getDispatchItems') }}/"+limit,
                    success     : function( res ){

                        var html = "";
                        res.items.forEach(el => {
                            html += '<div class="row my-3 border border-secondary rounded">'+
                                '<div class="col col-lg-12"><b>Dispatch ID: '+ el.id +'</b></div>'+
                                '<div class="col col-lg-3 py-2"><b>Source Name:</b> <br />'+el.sourceName+'</div>'+
                                '<div class="col col-lg-3"><b>Destination Name:</b> <br />'+el.destName+'</div>'+
                                '<div class="col col-lg-3"><b>Transporter Code:</b> <br />'+el.transName+'</div>'+
                                '<div class="col col-lg-3"><b>Vehicle Number:</b> <br />'+el.vehicle_no+'</div>'+
                                '<div class="col col-lg-6"><b>Start Date:</b> <br />'+el.start_date+'</div>'+
                                '<div class="col col-lg-6"><b>End Date:</b> <br />'+el.end_date+'</div>'+
                            '</div>';
                        });
                        
                        localStorage.setItem("limitValue", res.limit);
                        if( limit == 0 ) {
                            $(".dispatchItems").html(html);
                        } else {
                            $(".dispatchItems").append(html);
                        }
                    } 
                });
            }

            function logout() {
                $.ajaxSetup({
                    headers: {
                        'Authorization': 'Bearer '+ localStorage.getItem("access_token"),
                    }
                });

                $.ajax({
                    type        : 'POST',
                    url         : "{{ url('api/auth/logout') }}",
                    success     : function( res ){
                        console.log(res); 
                        location.href = "{{ url('/') }}";
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

            function addDispatch() {
                location.href= "{{ url('api/auth/addDispatchPage') }}/" + localStorage.getItem("access_token");
            }

            function exportDispatch() {
                location.href= "{{ url('api/auth/file-export') }}/" + localStorage.getItem("access_token");
            }
        </script>
    </body>
</html>
