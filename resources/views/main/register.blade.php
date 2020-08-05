@extends('layouts.site')

@section('content')
    <form autocomplete="off" method="post" action="{{ route('company.store') }}">
        @csrf
        <div class="form-group">
            <div class="">
                <label class="label" for="name">Nome da sua loja</label>
                <input class="form-control" type="text" id="name" name="name" required>
            </div>
        </div>
        <div class="form-group">
            <div class="">
                <label class="label" for="slug">Endereço</label>
                <input class="form-control" type="text" id="slug" name="slug" required>
            </div>
        </div>
        <div class="form-group">
            <div class="">
                <label class="label" for="slug">Documento</label>
                <input class="form-control" type="text" id="document" name="document" required>
            </div>
        </div>
        <button class="btn btn-primary">
            Registrar minha loja
        </button>
    </form>
@endsection
