@extends('layouts.base')

@section('content')
<div class="row">
<div class="col-sm-12">
  <h1 class="display-3">Produtos</h1>    
  <div>
      <a style="margin: 19px;" href="{{ route('products.create')}}" class="btn btn-primary">Novo Produto</a>
  </div>  
    
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Nome</td>
          <td>C&oacute;digo SKU</td>
          <td>Qtd. Estoque</td>
          <td colspan="2">Estoque</td>
          <td colspan="2">A&ccedil;&otilde;es</td>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->sku}}</td>
            <td>{{$product->in_stock}}</td>
            <td colspan="2">
                <a href="{{ route('products.addStock', $product)}}" class="btn btn-info">Adicionar</a>
                <a href="{{ route('products.removeStock', $product)}}" class="btn btn-warning">Dar Baixa</a>
            </td>
            <td>
                <a href="{{ route('products.edit', $product)}}" class="btn btn-primary">Editar</a>
            </td>
            <td>
                <form action="{{ route('products.destroy', $product->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>

</div>
@endsection
