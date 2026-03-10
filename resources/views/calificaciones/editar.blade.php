@extends('layouts.app')


@section('contenido')

<h1>Vista Editar Calificaciones</h1>

@isset($id)
<p>Editando la calificacion con ID: {{ $id }}</p>
@endisset

@endsection
