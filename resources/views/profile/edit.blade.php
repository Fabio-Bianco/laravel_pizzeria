@extends('layouts.app-modern')

@section('title', 'Profilo personale')

@section('header')
<div class="text-center py-4">
    <div class="mb-2" style="font-size:3rem;">👤</div>
    <h1 class="display-6 fw-bold text-dark mb-2">Profilo personale</h1>
    <p class="lead text-muted mb-4">Gestisci i dati del tuo profilo, la password e l'account</p>
</div>
@endsection

@section('content')
    <div class="row g-4 justify-content-center">
        <div class="col-12 col-lg-6">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="col-12 col-lg-6">
            @include('profile.partials.update-password-form')
        </div>
        <div class="col-12 col-lg-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
