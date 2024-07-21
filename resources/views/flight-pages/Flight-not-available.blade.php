@extends('layouts.master')
@section('title', 'No Flights Available')
@section('body')

    {{-- <x-search-bar /> --}}
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
{{-- <h4>Oops, flight no longer available please <a href="https://flights.wagnistrip.com">Click here</a>click here<p></p> to search agen.</h4> --}}
    <!-- DESKTOP VIEW END -->
        <div class="container pt-20">
            <div class="boxunder text-center">
                <div class="row">
                    <div class="col-sm-12">
                        <img src="{{ asset('assets/images/flights/no_flit.png') }}" alt="" width="300">
                        <div class="fnt20"> FLIGHT NO LONGER AVAILABLE</div>
                        <p class="searchtitle">It seems, flight no longer available or canceled,<br> Please click here for search again or<br> go back to choose another flight </p>
                        <a href="/" class="btn btn-info" role="button"> SEARCH FLIGHTS <i
                                class="fa fa-plane"></i> </a>
                        <div class="pb-20"></div>
                    </div>
                </div>
            </div>
        </div>

<br>
<br>
<br>
<br>

    <!-- MOBILE VIEW START -->
    <div id="MOBILEVIEWONETRIP">
        <header class="stickyheader">
            <div class="row">
                <div class="col-sm-6">
                
                </div>
                <div class="col-sm-6">
            
                </div>
            </div>
        </header>

    </div>
    <!-- MOBILE VIEW END -->

<br>
<br>
<br>
@section('css')
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
@endsection

{{-- <x-footer />--}}
@endsection
