@extends('layouts.master')
@section('title', 'No Flights Available')
@section('body')

    {{--<x-search-bar />--}}
    <script defer src="{{url('assets/js/sorting.js')}}"></script>
    
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
     {{--<link rel="stylesheet" type="text/css" src="{{url('assets/css/jQuery.UI.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css">
    
    <div class="searchCardBanner">
        @include('layouts.searchcard')
    </div>

    <div class="loaderr" >
  <div class="loading">
    <img src="assets/images/loader.gif" alt="" srcset="" loading="lazy">
   <h4>Please have patience,<br>Your flight will be searched soon</h4>
  </div>
</div>
    <!-- DESKTOP VIEW END -->
        <div class="container pt-20">
            <div class="boxunder text-center">
                <div class="row">
                    <div class="col-sm-12">
                        <img src="{{ asset('assets/images/flights/no_flit.png') }}" alt="" width="300">
                        <div class="fnt20"> NO FLIGHTS FOUND</div>
                        <p class="searchtitle">Our systems seem to be experiencing an issue.<br> We are working
                            on resolving it asap.<br> Please refresh the page or go back to the earlier page</p>
                        <a href="/" class="btn btn-info" role="button"> GO BACK | TRY ANOTHER FLIGHTS | <i
                                class="fa fa-plane"></i> </a>
                        <div class="pb-20"></div>
                    </div>
                </div>
            </div>
        </div>

    <!-- MOBILE VIEW START -->
    <div id="MOBILEVIEWONETRIP">
        <header class="stickyheader">
            <div class="row">
                <div class="col-sm-6">
                    ddd
                </div>
                <div class="col-sm-6">
                    ddd
                </div>
            </div>
        </header>
        

    </div>
    <!-- MOBILE VIEW END -->

@section('css')
    <style>
    .loaderr {
         z-index: 1000;
      display: none;
      position: fixed;
      top: 100%;
      left: 50%;
      height:100%;
      width:100%;
      text-align: center;
      transform: translate(-50%, -50%);
        background-color:#ffffff7d;
    }
    
    .loading img {
      width: 200px;
    }        
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/range.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sliderstyle/custom.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
@endsection

@section('script')
    <script src="{{ asset('assets/js/range.js') }}"></script>
    <script src="{{ asset('assets/sliderstyle/multislider.js') }}"></script>
    <script src="{{ asset('assets/sliderstyle/multislider.min.js') }}"></script>
    <script>
        $('#exampleSlider').multislider({
            interval: 0,
            slideAll: false,
            duration: 100
        });
   </script>
<script type="text/javascript">
    function spinnerr(loading) {
        document.getElementsByClassName("loaderr")[0].style.display = "block";
        $("#main-form").submit();
    }
</script>   
   {{-- <x-footer /> --}}
@endsection



