@extends('layouts.main')
@section('title', 'Editando ' . $event->title)

@section('content')
<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editando {{$event->title}}</h1>
    <form action="/events/update/{{$event->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="" class="title">Imagem: </label>
            <input type="file" class="form-control-file" id="image" name="image" placeholder="Imagem do evento">
            <img src="/img/events/{{$event->image}}" alt="{{$event->title}}" class="img-preview">
        </div>
        <div class="form-group">
            <label for="" class="title">Evento: </label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Título do evento" value="{{$event->title}}">
        </div>
        <div class="form-group">
            <label for="" class="title">Data do evento: </label>
            <input type="date" class="form-control" id="date" name="date" value="{{$event->date->format('Y-m-d')}}">
        </div>
        {{$event->date}}
        <div class="form-group">
            <label for="" class="title">Cidade: </label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Cidade do evento" value="{{$event->city}}">
        </div>

        <div class="form-group">
            <label for="" class="title">O evento é privado?: </label>
            <select name="private" id="private" class="form-control">
                <option value="0">Não</option>
                <option value="1" {{$event->private == 1 ? "selected='selected'" : ''}}>Sim</option>
            </select>
        </div>

        <div class="form-group">
            <label for="" class="title">Descrição: </label>
            <textarea name="description" id="description" cols="30" rows="10" placeholder="O que vai acontecer no evento?" class="form-control">{{$event->description}}</textarea>
        </div>

        <div class="form-group">
            <label for="" class="title">Adicione itens de infraestrutura: </label>
            <div class="form-group">
                <input type="checkbox" name="items[]" value="Cadeiras"> Cadeiras
            </div>
            <div class="form-group">
                <input type="checkbox" name="items[]" value="Palco"> Palco
            </div>
            <div class="form-group">
                <input type="checkbox" name="items[]" value="Cerveja Grátis"> Cerveja Grátis
            </div>
            <div class="form-group">
                <input type="checkbox" name="items[]" value="Open Food"> Open Food
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Editar Evento">
    </form>
</div>
@endsection