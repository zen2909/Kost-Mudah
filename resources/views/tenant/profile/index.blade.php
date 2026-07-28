@extends('layouts.tenant')

@section('search-placeholder','Profil Saya')

@section('content')

@include('tenant.profile.partials.header')

<form
    action="{{ route('tenant.profile.update') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf
    @method('PUT')

    @include('tenant.profile.partials.profile-card')

    @include('tenant.profile.partials.personal')

    @include('tenant.profile.partials.security')

    @include('tenant.profile.partials.action')

</form>

@endsection

@push('scripts')
<script>

function choosePhoto(){
    document.getElementById('photo').click();
}

function previewPhoto(event){

    const reader = new FileReader();

    reader.onload = function(e){

        document.getElementById('preview').src = e.target.result;

    }

    reader.readAsDataURL(event.target.files[0]);

}

</script>
@endpush