@extends('layouts.app')

@section('auth')

    @if(\Request::is('static-sign-up') || \Request::is('static-sign-in')) 
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')

    @elseif(\Request::is('rtl'))  
        @include('layouts.navbars.auth.sidebar-rtl')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
            @include('layouts.navbars.auth.nav-rtl')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>

    @elseif(\Request::is('profile'))
        @include('layouts.navbars.auth.sidebar')
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            @include('layouts.navbars.auth.nav')
            @yield('content')
        </div>

    @elseif(\Request::is('virtual-reality')) 
        @include('layouts.navbars.auth.nav')
        <div class="border-radius-xl mt-3 mx-3 position-relative" style="background-image: url('../assets/img/vr-bg.jpg') ; background-size: cover;">
            @include('layouts.navbars.auth.sidebar')
            <main class="main-content mt-1 border-radius-lg">
                @yield('content')
            </main>
        </div>
        @include('layouts.footers.auth.footer')

    {{-- Role-based Dashboards --}}
    @elseif(Request::is('admin/dashboard*'))
        @include('layouts.navbars.auth.sidebar-admin')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav-admin')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>

    @elseif(Request::is('student/dashboard*'))
        @include('layouts.navbars.auth.sidebar-student')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav-student')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>

    @elseif(Request::is('lecturer/dashboard*'))
        @include('layouts.navbars.auth.sidebar-lecturer')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav-lecturer')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>

    @elseif(Request::is('technician/dashboard*'))
        @include('layouts.navbars.auth.sidebar-technician')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav-technician')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>

    @elseif(Request::is('staff/dashboard*'))
        @include('layouts.navbars.auth.sidebar-staff')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav-staff')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>

    @else
        {{-- Default Auth Layout --}}
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>
    @endif

    @include('components.fixed-plugin')

@endsection
