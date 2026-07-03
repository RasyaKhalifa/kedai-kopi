@extends('layouts.app')
@section('content')

<div class="container">
    <h2>Dashboard Coffee Corner</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h3>{{ $jumlahMenu }}</h3>
                    Total Menu
                </div>
            </div>
        </div>
        <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h3>{{ $jumlahMeja }}</h3>
                Total
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark">
            <div class="card-body">
            <h3>{{ $menuAktif }}</h3>
            Menu Aktif
        </div>
    </div>
</div>
</div>
</div>

@endsection
