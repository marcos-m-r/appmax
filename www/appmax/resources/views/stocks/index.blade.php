@extends('layouts.base')

@section('content')
<div class="row">
<div class="col-sm-12">
  <h1 class="display-3">Relatório de Estoque</h1>    

  <h2>Filtros</h2>
  <form class="col-sm-4" action="{{ route('stock.index')}}" method="POST" role="search">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="origin">Realizado Via:</label>
      <select class="form-control" name="origin">
        <option value="">Selecione</option>
        <option {{ ($filter['origin'] == "api") ? "selected" : "" }} value="api">API</option>
        <option {{ ($filter['origin'] == "site") ? "selected" : "" }} value="site">Site</option>
      </select>
    </div>
    
    <div class="form-group">
      <label for="created_at">Data de Realização</label>
      <datepicker :language="ptBR" name="created_at" :use-utc="false" :format="dateFormat" value="{{ $filter['created_at'] . "T00:00:00" }}"></datepicker>
    </div>
    
    <button type="submit" class="btn btn-primary">
      Enviar
    </button>
  </form>
</br>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>Produto</td>
          <td>Tipo</td>
          <td>Estq. Antes</td>
          <td>Estq. Depois</td>
          <td>Qntd. Alterada</td>
          <td>Estq. Atual</td>
          <td>Realizado via</td>
          <td>Realizado em</td>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $stock)
        <tr>
            <td>{{ $stock->product->name }}</td>
            <td>{{ ($stock->type == 'add') ? 'Adição' : 'Baixa' }}</td>
            <td>{{ $stock->before }}</td>
            <td>{{ $stock->after }}</td>
            <td>{{ ($stock->type == 'add') ? ($stock->after - $stock->before) : ($stock->before - $stock->after) }}</td>
            @if ($stock->product->in_stock < 100)
            <td>{{ $stock->product->in_stock }}
              <span class="badge badge-pill badge-warning">Estoque baixo</span>
            </td>
            @else
            <td>{{ $stock->product->in_stock }}</td>
            @endif
            <td>{{ ($stock->origin == 'api') ? 'API' : 'Site' }}</td>
            <td>{{ $stock->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
  </table>

</div>
@endsection
