@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">{{ $type == 'add' ? 'Adicionar a' : 'Baixa n'}}o Estoque</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br /> 
        @endif
        <form method="post" action="{{ route('products.updateStock', $product->id) }}">
            @method('PUT') 
            @csrf
            <input type="hidden" name="type" value={{ $type }} />
            
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" readonly class="form-control" name="name" value={{ $product->name }} />
            </div>

            <div class="form-group">
                <label for="sku">C&oacute;digo SKU:</label>
                <input type="text" readonly class="form-control" name="sku" value={{ $product->sku }} />
            </div>

            <div class="form-group">
                <label for="in_stock">Quantidade em estoque:</label>
                <input type="number" readonly min="0" class="form-control" name="in_stock" value={{ $product->in_stock }} />
            </div>

            <div class="form-group">
                @if ($type == "add")
                <label for="quantity">Quantidade de ser adicionada:</label>
                <input type="number" min="0" class="form-control" name="quantity" />
                @else
                <label for="quantity">Quantidade a ser baixada:</label>
                <input type="number" min="0" max="{{ $product->in_stock}}" class="form-control" name="quantity" />
                @endif 
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('products.index')}}" class="btn btn-danger float-right">Cancelar</a>
        </form>
    </div>
</div>
@endsection
