@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-3 p-2">
            <h2 class="text-center font-weight-bold">Secciones</h2>         
                <ul class="list-group list-group-flush">          
                    @foreach($seccion_cantidad as $seccion => $cantidad)
                        @if($seccion == $productos_detalles[0]->seccion)
                        <a href="{{route('seccion', $seccion)}}" class="list-group-item list-group-item-action active disabled mb-3">- {{$seccion}} ({{$cantidad}})</a>
                        @else
                        <a href="{{route('seccion', $seccion)}}" class="list-group-item list-group-item-action mb-3">- {{$seccion}} ({{$cantidad}})</a>
                        @endif
                    @endforeach
                        <a href="/productos" class="list-group-item list-group-item-action mb-3">- Ver todos</a>
                </ul>
                <a href="/productos/create"><button type = "button" class="btn btn-success">Crear nuevo producto</button></a> 
        </div>
        <div class="col-12 col-lg-9">
            <div class="row">
                @foreach($productos_detalles as $item)
                    <div class="col-sm-4">                       
                        <div class="card" style="width: 18rem;">
                            <img src="{{asset($item->imagen)}}" class="card-img-top" alt="..." height="200">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->nombre}}</h5>
                                <p class="card-text">{{$item->descripcion}}</p>
                                <p class="card-text font-weight-bold">${{$item->precio}}</p>
                                <a href="/productos/{{$item->id}}"><button type="button" class="btn btn-success">Detalles</button></a>
                            </div>
                        </div>
                    </div>                   
                @endforeach               
            </div>                           
        </div>       
    </div>   
</div>
@endsection