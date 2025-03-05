@extends('layouts.app')

@section('content')
    <h1>Editar Reporte</h1>
    <form action="{{ route('reports.update', $report) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $report->title }}" required>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
@endsection