@extends('layouts.tenant')

@section('search-placeholder','Profil Saya')

@section('content')

@include('tenant.profile.partials.header')

@include('tenant.profile.partials.profile-card')

@include('tenant.profile.partials.personal')

@include('tenant.profile.partials.security')

@include('tenant.profile.partials.action')

@endsection