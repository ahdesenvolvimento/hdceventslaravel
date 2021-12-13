@extends('layouts.main')
@section('title', 'HDC Events')

@section('content')
<div id="search-container" class="col-md-12">
    <h1>Procure por um evento</h1>
    <form action="/" method="GET">
        <input type="text" id="search" name="search" class="form-control" placeholder="Procurar">
    </form>
</div>
<div id="events-container" class="col-md-12">
    @if ($busca)
    <h2>Eventos relacionados a: {{$busca}}</h2>
    @else
    <h2>Próximos eventos</h2>
    @endif
    <p class="subtitle">Veja os eventos nos próximos dias</p>

    <div id="card-container" class="row">
        @foreach($events as $event)
        <div class="card col-md-3">
            <img src="/img/events/{{$event->image}}" alt="{{$event->title}}">
            <div class="card-body">
                <p class="card-date">
                    {{date('d/m/Y', strtotime($event->date))}}
                </p>
                <h5 class="card-title">
                    {{$event->title}}
                </h5>
                <p class="card-participants">
                    {{count($event->users)}} participantes
                </p>
                <a href="/events/{{$event->id}}" class="btn btn-primary">saber mais</a>
            </div>
        </div>
        @endforeach
        @if (count($events))
         <p>Não há eventos disponíveis.</p>
        @endif
    </div>
</div>
@endsection