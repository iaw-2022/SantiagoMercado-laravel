@extends('Plantillas.appAdmin')

<br></br>

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Editar Producto</span>
                    </div>               
                    <div class="card-body">
                        <form  action="{{ route('product.actualizar')}}" method="POST">
                          {{ csrf_field() }}
                            
                          <div class="form-group row">

                                        <input type="hidden" value="{{ $product->id}}" id="id" name="id">

                                        <label><strong>Nombre:</strong></label>
                                        <input class="form-control" type="text" value="{{ $product->name}}" id="name" name="name">

                                        <label><strong>Descripcion:</strong></label>
                                        <input class="form-control" type="text" value="{{ $product->details}}" id="details" name="details">

                                        <label><strong>Precio:</strong></label>
                                        <input class="form-control" type="number" value="{{ $product->price }}" id="price" name="price">

                                        <label><strong>Stock:</strong></label>
                                        <input class="form-control" type="number" value="{{ $product->stock }}" id="stock" name="stock">

                                        <label><strong>Categoria:</strong></label>
                                        <input class="form-control" type="number" value="{{ $product->category_id }}" id="category_id" name="category_id">

                                        <label><strong>Imagen:</strong></label>
                                        <input class="form-control-file" type="file" id="image_path" name="image_path">

                                        <br></br><button type="btn btn-success" class="btn btn-primary">Confirmar</button>

                                    </div>
                        </form>
                                                
                    </div>
                    
                </div>

                <br></br>
                <br></br>

                <div class="float-right">
                            <a class="btn btn-success" href="{{ route('products.index') }}"> Volver</a>
                        </div>

            </div>
        </div>
    </section>
@endsection
