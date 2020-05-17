@extends('crudbooster::admin_template')

@section('content')

<div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
        <h3>{{DB::table('orders')->where('deleted_at', null)->count()}}</h3>

          <p>Pedidos</p>
        </div>
        <div class="icon">
          <i class="fa fa-shopping-cart"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{DB::table('clients')->where('deleted_at', null)->count()}}</h3>

          <p>Clientes</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{DB::table('vehicles')->where('deleted_at', null)->count()}}</h3>
  
            <p>Veículos</p>
          </div>
          <div class="icon">
            <i class="fa fa-car"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{DB::table('cms_users')->where('deleted_at', null)->count()}}</h3>

          <p>Funcionários</p>
        </div>
        <div class="icon">
          <i class="fa fa-user"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-black">
        <div class="inner">
          <h3>{{DB::table('providers')->where('deleted_at', null)->count()}}</h3>

          <p>Fornecedores</p>
        </div>
        <div class="icon text-light-blue">
          <i class="fa fa-truck"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-fuchsia">
          <div class="inner">
            <h3>{{DB::table('products')->where('deleted_at', null)->count()}}</h3>
  
            <p>Produtos</p>
          </div>
          <div class="icon">
            <i class="fa fa-cubes"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-lime">
          <div class="inner">
            <h3>{{DB::table('services')->where('deleted_at', null)->count()}}</h3>
  
            <p>Serviços</p>
          </div>
          <div class="icon">
            <i class="fa fa-sliders"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <h3>{{DB::table('services')->where('deleted_at', null)->count()}}</h3>
    
              <p>Privilégios</p>
            </div>
            <div class="icon">
              <i class="fa fa-key"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
  </div>

@endsection