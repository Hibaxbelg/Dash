@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Profil :</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        {{ $errors->first() }}
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nom : </label>
                                                <input class="form-control" value="{{ Auth::user()->name }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label>Email : </label>
                                                <input name="email" type="email" class="form-control"
                                                    value="{{ Auth::user()->email }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Mot de passe : </label>
                                                <input name="password" type="password" class="form-control">
                                                <small>Laissez-le vide si vous ne voulez pas changer le mot de passe</small>
                                            </div>
                                            <div class="form-group">
                                                <label>Confirmtion de mot de passe : </label>
                                                <input name="password_confirmation" type="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <img class="rounded-circle" width="150" height="150"
                                                src="{{ Auth::user()->avatar }}">
                                            <div class="form-group">
                                                <label>Photo de profil : </label>
                                                <input type="file" name="avatar" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary">Enregister</button>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
