@extends('layouts.app')

@section('content')
<style>
    .card {
        display: inline-block; /* Permite que la tarjeta se ajuste automáticamente al contenido */
        border: 1px solid black; /* Borde de la tarjeta */
        padding: 10px; /* Espaciado interno de la tarjeta */

    
    }
   
</style>
<div class="container">
    <div class="row justify-content-center">
       <div class="card" style="width: 400px; height: 170px;">
       <form action="{{ route('scores_search') }}" method="GET">
                    <div class="form-group">
                        <br>
                        <label for="documento">Buscar por número de documento:</label>
                        <input type="text" name="documento" id="documento" class="form-control" value="{{ $documentsearch ?? ''}}">
                    </div>  
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>

            @if (isset($resultados))
                <div class="card">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="row">Documento</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Curso</th>
                                <th scope="col">Materia</th>
                                <th scope="col">Definitiva</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultados as $nota)
                                <tr>
                                    @foreach ($apprentices as $apprentice)
                                        @if ($nota->apprentice_id == $apprentice->id)
                                            @foreach ($users as $user)
                                                @if ($apprentice->user_id == $user->id)
                                                    <th>{{ $user->document_number }}</th>
                                                    <th>{{ $user->name }}</th>
                                                    @break
                                                @endif
                                            @endforeach
                                            @foreach ($cursos as $curso)
                                                @if ($apprentice->curso_id == $curso->id)
                                                    <th>{{ $curso->name }}</th>
                                                @endif
                                            @endforeach
                                            @break
                                        @endif
                                    @endforeach
                                    @foreach ($subjects as $subject)
                                        @if ($nota->subject_id == $subject->id)
                                            <th>{{ $subject->nombre }}</th>
                                            @break
                                        @endif
                                    @endforeach
                                    <th scope="row">{{ $nota->average }}</th>
                                    <th><form action="{{ route('scores_download_pdf') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="documento" value="{{ $documentsearch ?? '' }}">
                                    <button type="submit" class="btn btn-primary">Descargar PDF</button>
                                </form></th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
       </div>
                
    </div>
</div>
@endsection
