<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php $settings = settings(); ?>
    <title>{{ $page->page_title or config('app.name') }}</title>
    {!! $settings->google_verification !!}
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $page->page_description }}"/>
    <meta name="keywords" content="{{ $page->page_keyword }}">

    <link rel="icon" type="image/x-icon" href="{{ asset($settings->favicon) }}" sizes="16x16"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('assets/cgfront/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/cgfront/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/cgfront/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/default.min.css"/>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('style')
    <script src="{{ asset('assets/frontend/js/sweetalert/dist/sweetalert.min.js') }}"></script>
    @php $settings = logo_with_title(); @endphp

</head>
<body>
@php $websettings = web_settings(); @endphp
{{--@php $notification = notification(); @endphp--}}
@php $img_path = image_path(); @endphp
@php $pages = \App\Pages::where('show_in_menu', 1)->orderBy('sequence')->get(); @endphp

<header class="fadeInDown wow">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">
            @if(file_exists(public_path($settings->logo)) &&  $settings->logo!='')
                <img src="{{URL::asset($settings->logo)}}" alt="{{ $settings->site_title != '' ? $settings->site_title : 'bigfrog.io' }}" style=" height: 50px; width: 200px; ">
            @else
                bigfrog<span>.io</span>
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mainNavBar">
                @foreach($pages as $key=>$page)
                    <li class="nav-item {{ setActive($page->slug, 'active') }}">
                        <a class="nav-link" href="@if($page->slug == 'home'){{ url('/') }}@else{{ url('/') .'/'.$page->slug }}@endif">{{ $page->title }} @if($key == 0) <span class="sr-only">(current)</span>@endif</a>
                    </li>
                @endforeach
            </ul>
            <ul class="searchBar">
                <form class="searchForm" action="{{ url('search') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="search" placeholder="Search for coupon codes" class="form-control" id="form-input" required>
                        <button type="submit" class="btn searchBtn"><img src="{{ config('constants.img_path') }}/searchIcon.png"></button>
                    </div>
                </form>
            </ul>
        </div>
    </nav>
</header>

@yield('content')

{{-- Footer --}}
<footer class="fadeInUp wow">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">


                @php $footer_menu = footer_menu(); @endphp
                <div class="footerNav" style="text-align: center;">
                    <div class="footerSocial" style="margin-bottom: 10px;">
                        <ul>
                            @if($websettings->facebook_url != '')<li><a href="{{ $websettings->facebook_url }}" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>@endif
                            @if($websettings->twitter_url != '')<li><a href="{{ $websettings->twitter_url }}" class="fb"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>@endif
                            @if($websettings->linkedin_url != '')<li><a href="{{ $websettings->linkedin_url }}" class="fb"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>@endif
                            @if($websettings->instagram_url != '')<li><a href="{{ $websettings->instagram_url }}" class="insta"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>@endif
                            @if($websettings->google_plus_url != '')<li><a href="{{ $websettings->google_plus_url }}" class="google"><i class="fa fa-google" aria-hidden="true"></i></a></li>@endif
                            @if($websettings->youtube_url != '')<li><a href="{{ $websettings->youtube_url }}" class="youTube"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>@endif
                        </ul>
                    </div>
                    @if(!empty($footer_menu))
                        <ul>
                            @foreach($footer_menu as $key=>$menu)
                                <li class="{{ setActive($menu->slug, 'footerNavActive') }}">
                                    <a href="@if($menu->slug == 'home'){{ url('/') }}@else{{ url('/') .'/'.$menu->slug }}@endif">
                                        {{ $menu->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                        <p>Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} <a href="{{ url('/') }}">bigfrog.io</a> , Designed and Developed by
                            <a href="https://www.deaninfotech.com/" target="_blank">Dean Infotech</a></p>

                    <div class="footerNav disclaimer_div">
                        <h5> <strong>Disclaimer : </strong></h5>
                        <p>The display of third-party trademarks and trade names on this site does not necessarily indicate any affiliation or endorsement of BigFrog.io. If you click a merchant link and buy a product or service on their website, we may be paid a fee by the merchant.</p>
                    </div>


                </div>
            </div>
        </div>
    </div>
</footer>



<script src="{{ asset('assets/cgfront/js/jquery-1.11.3.min.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/cgfront/js/wow.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- <script src="js/bootsnav.js"></script> -->
<!-- <script src="js/modernizr.min.js"></script> -->
<script>(new WOW).init()</script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/alertify.min.js"></script>
<script src="{{ asset('assets/cgfront/js/slick.js') }}"></script>
<script>
    var base_url = "{{ URL::to('/') }}";
</script>
<script type="text/javascript">
    window.scrollTo(0,0);
    $(document).ready(function(){
        var url = $(location).attr('href'),
        parts = url.split("/"),
        last_part = parts[parts.length-1];
        last_part = last_part.substr(last_part.indexOf("#"))

        if(last_part.length > 1){
            // console.log($(last_part));
            // console.log(last_part.substr(last_part.indexOf("#")));
            $(last_part).modal('toggle');
        }
        let searchForm = $(".searchForm");
        searchForm.removeAttr('target');
        $("#form-input").removeAttr('value');
    });
    function openStore(event, link_to_redirect, search){
        var modal = event.target;
        console.log(modal.getAttribute('data-target'));
        var modalId = modal.getAttribute('data-target');
        if(search != ''){
            let searchForm = $(".searchForm");
            searchForm.attr('target', '_blank');
            $("#form-input").attr('value', search);
            searchForm.attr('action', '{{ url('search') }}' + modalId);
            searchForm.submit();
            window.location = link_to_redirect;
        }else{
            if(window.location.href.indexOf('#') >= 0){
                let currentBaseUrl = window.location.href.substr(0, window.location.href.indexOf('#'));
                window.open(currentBaseUrl + modalId, '_blank');
                window.location = link_to_redirect;
            }else{
                window.open(window.location.href + modalId, '_blank');
                window.location = link_to_redirect;
            }
        }
    }
</script>
<script>
    // Copy Coupon Code and redirect URL
    $(document).on('click', '.copyBtn', function(){

        var par = $(this).parent('div').children('h6').attr('id');
        var link_to_go = $(this).parent('div').children('input').val();

        var range = document.createRange();
        range.selectNode(document.getElementById(par));
        window.getSelection().removeAllRanges(); // clear current selection
        window.getSelection().addRange(range); // to select text
        document.execCommand("copy");
        window.getSelection().removeAllRanges();// to deselect
        $("button.copyBtn").html('<i class="fa fa-check" aria-hidden="true"></i> Copied');
        $("button.copyBtn").attr('disabled', 'true');
        $.ajax({
            url: base_url+'/coupon/count/'+par,
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                console.log(data);
            }
        });
        /*window.open(link_to_go, '_blank').focus();*/

        $('.modal').on('hidden.bs.modal', function () {
            $("button.copyBtn").html('<i class="fa fa-clone" aria-hidden="true"></i> Copy');
            $("button.copyBtn").removeAttr('disabled');
        })
    });

    // footer Newsletter
    $(document).ready(function () {
        var form = $('#newsletter');
        form.submit(function(e) {
            e.preventDefault();
            // $('div.page-loader').show();
            $('button.subscribeBtn').html('Subscribing...');
            $.ajax({
                url     : base_url + '/ajax/newsletter-subscription',
                type    : 'POST',
                data    : form.serialize(),
                dataType: 'json',
                success : function ( data )
                {
                    $('div.page-loader').hide();
                    $('button.subscribeBtn').html('Subscribe');
                    if(data.errors) {
                        $.each(data.errors, function (key, value) {
                            // $('.'+key+'-error').html(value);
                            swal('', value[0], "error");
                            $('input[name="'+key+'"]').closest('div.form-group').addClass('has-error');
                            $('input[name="'+key+'"]').focus();
                        });
                    }
                    if(data.success == 1){
                        alertify.success('Success : '+data.msg);
                        form[0].reset();
                    }
                    if(data.warning == 2){
                        alertify.error('Error : '+data.msg);
                        form[0].reset();
                    }
                },
                error: function( json )
                {
                    if(json.status === 422) {
                        $.each(json.responseJSON, function (key, value) {
                            //$('.'+key+'-error').html(value);
                            $('input[name="'+key+'"]').closest('div.form-group').addClass('has-error');
                        });
                    } else {
                        // Error
                        // alert('Incorrect credentials. Please try again.')
                    }
                }
            });
        });
    });
    // Related coupon section modal popup newsletter
    $(document).on('click', '.relatedCouponSubmit', function (e) {
        e.preventDefault();
        var formId = $(this).parent('div').parent('form').attr('id');
        var email = $(this).parent('div').children('input').val();
        var relform = $('#' + formId);
        // console.log(email);
        // $('div.page-loader').show();
        $('button.relatedCouponSubmit').html('Subscribing...');
        $.ajax({
            url: base_url + '/ajax/newsletter-subscription',
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'newsletter_email': email
            },
            dataType: 'json',
            success: function (data) {
                $('div.page-loader').hide();
                $('button.relatedCouponSubmit').html('Subscribe');
                if (data.errors) {
                    $.each(data.errors, function (key, value) {
                        // $('.'+key+'-error').html(value);
                        swal('', value[0], "error");
                        $('input[name="' + key + '"]').closest('div.form-group').addClass('has-error');
                        $('input[name="' + key + '"]').focus();
                    });
                }
                if (data.success == 1) {
                    alertify.success('Success : ' + data.msg);
                    relform[0].reset();
                    return false;
                }
                if (data.warning == 2) {
                    alertify.error('Error : ' + data.msg);
                    relform[0].reset();
                    return false;
                }
            },
            error: function (json) {
                if (json.status === 422) {
                    $.each(json.responseJSON, function (key, value) {
                        //$('.'+key+'-error').html(value);
                        $('input[name="' + key + '"]').closest('div.form-group').addClass('has-error');
                    });
                    return false;
                } else {
                    return false;
                    // Error
                    // alert('Incorrect credentials. Please try again.')
                }
            }
        });
    });
    // Store detail page modal popup newsletter
    $(document).on('click', '.modalPopUpForm', function (e) {
        e.preventDefault();
        var formId = $(this).parent('div').parent('form').attr('id');
        var email = $(this).parent('div').children('input').val();
        var relform = $('#' + formId);
        // console.log(email);
        // $('div.page-loader').show();
        $('button.modalPopUpForm').html('Subscribing...');
        $.ajax({
            url: base_url + '/ajax/newsletter-subscription',
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'newsletter_email': email
            },
            dataType: 'json',
            success: function (data) {
                $('div.page-loader').hide();
                $('button.modalPopUpForm').html('Subscribe');
                if (data.errors) {
                    $.each(data.errors, function (key, value) {
                        // $('.'+key+'-error').html(value);
                        swal('', value[0], "error");
                        $('input[name="' + key + '"]').closest('div.form-group').addClass('has-error');
                        $('input[name="' + key + '"]').focus();
                    });
                }
                if (data.success == 1) {
                    alertify.success('Success : ' + data.msg);
                    relform[0].reset();
                    return false;
                }
                if (data.warning == 2) {
                    alertify.error('Error : ' + data.msg);
                    relform[0].reset();
                    return false;
                }
            },
            error: function (json) {
                if (json.status === 422) {
                    $.each(json.responseJSON, function (key, value) {
                        //$('.'+key+'-error').html(value);
                        $('input[name="' + key + '"]').closest('div.form-group').addClass('has-error');
                    });
                    return false;
                } else {
                    return false;
                    // Error
                    // alert('Incorrect credentials. Please try again.')
                }
            }
        });
    });

    // Rating Modal PopUp Functionality
    $(document).ready(function () {
        var ratingForm = $('#ratingModalPopUp');

        $('input[type=submit]').on('click', function(e){
            e.preventDefault();

            var rate = $(this).val();
            var storeId = $('#store_id').val();

            $.ajax({
                url     : base_url+'/stores/reviews/save',
                type    : 'POST',
                data    : {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'store_id': storeId,
                    'review_star': rate
                },
                dataType: 'json',
                success : function ( data ) {
                    if(data.status == 'failed'){
                        $.each(data.data, function (key, value) {
                            alertify.error(value);
                        });
                    }
                    else if(data.status == 'success'){
                        alertify.success('Your Rating has been submitted');
                        ratingForm[0].reset();
                        $('#rateModal').modal('hide');
                    }
                    else if(data.status == 'duplicate'){
                        alertify.error(data.data);
                        ratingForm[0].reset();
                        $('#rateModal').modal('hide');
                    }
                }
            });
        });
    });
</script>
@yield('scripts')

<!-- Modal -->
@if(isset($_SESSION['error']))
    @php unset($_SESSION['error']) @endphp
@endif
</body>
</html>


