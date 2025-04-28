<style>
    .banner {
        margin-bottom: 2.5rem;
    }

    .banner .content {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        background: transparent linear-gradient(90deg, #005f94 33%, #ffffff00 100%) 0% 0% no-repeat padding-box;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-left: 5%;
        padding-right: 51%;
    }

    .banner .content .heading {
        color: #fff;
        font-size: 3rem;
        line-height: normal;
    }

    .banner .content .heading+p {
        color: #fff;
    }

    @media (min-width: 142.5rem) and (max-width: 1919px) {

        .banner .content {
            padding-right: 50%;
        }
    }

    @media (min-width: 992px) {
        .banner img {
            height: 85vh;
            object-fit: cover;
        }
    }

    @media (max-width: 991px) {
        .banner .content {
            padding-right: 29%;
            background-color: #00000075;
        }
    }

    @media (max-width: 767px) {
        .banner .content {
            padding-right: 20%;
        }

        .banner .content .heading {
            font-size: 2rem;
            line-height: normal;
        }
    }

    @media (max-width: 575px) {
        .banner .content {
            padding-right: 5%;
        }
    }
</style>

{{--
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')

{{-- @section('search') --}}
{{--	<!-- @parent --> --}}
{{--	@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.form', 'search.inc.form']) --}}
{{-- @endsection --}}



@section('content')



    <div class="main-container" id="homepage">
        <div class="position-relative banner">
            <img src="{{ asset('public/assets/images/banner-img.png') }}" class="w-100" />
            <div class="content">
                <h1 class="heading">FIND RESEARCHERS, CONNECT, COLLABORATE</h1>
                <div class="mx-0 search-row">
                    @includeFirst([
                        config('larapen.core.customizedViewPath') . 'search.inc.header-search',
                        'search.inc.header-search',
                    ])
                </div>
                <p class="mb-0"><span class="orange-text">Create Your Profile</span> on MENA Medical Research and discover
                    networking opportunities </p>
            </div>
        </div>

        @if (Session::has('flash_notification'))
            @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])

            <?php $paddingTopExists = true; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        @include('flash::message')

                        {{-- <div class="alert
                        alert-success
            " role="alert"> --}}

                        {{-- Your profile has been created --}}
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
            <?php Session::forget('flash_notification.message'); ?>
        @endif

        @if (isset($sections) and $sections->count() > 0)
            @foreach ($sections as $section)
                @if (view()->exists($section->view))
                    @includeFirst(
                        [config('larapen.core.customizedViewPath') . $section->view, $section->view],
                        ['firstSection' => $loop->first]
                    )
                @endif
            @endforeach
        @endif

    </div>

@endsection

@section('after_scripts')
    <script>
        @if (config('settings.optimization.lazy_loading_activation') == 1)
            $(document).ready(function() {
                $('#postsList').each(function() {
                    var $masonry = $(this);
                    var update = function() {
                        $.fn.matchHeight._update();
                    };
                    $('.item-list', $masonry).matchHeight();
                    this.addEventListener('load', update, true);
                });


            });
        @endif
        $(document).ready(function() {
            $("#cross").click(function() {
                location.reload(true);
            });
        });
    </script>
@endsection
