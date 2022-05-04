<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categoria;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function shop()

    {

        $products = Product::paginate(8);
        $categorias = Categoria::all();
    

        return view('shop')->withTitle('BAHIA COMPUTACION')->with(['products' => $products , 'categorias' => $categorias]);

    }

    public function shopF()

    {

        $products = Product::all();
        $categorias = Categoria::all();
    

        return view('shopFiltro')->withTitle('BAHIA COMPUTACION')->with(['products' => $products , 'categorias' => $categorias]);

    }

    public function buscar(Request $request){

        $name = $request->get('name');
        $categorias = Categoria::all();
        $products = Product::select("*")
                            ->where('name', 'LIKE', '%'.$name.'%')
                            ->get();
                            

        return view('shopFiltro')->withTitle('BAHIA COMPUTACION')->with(['products' => $products , 'categorias' => $categorias]);

    }

    public function filtro(Request $request){

        $categorias = Categoria::all();

            if($request->category_id == 0){

                $products = Product::paginate(8);
                return view('shop')->withTitle('BAHIA COMPUTACION')->with(['products' => $products , 'categorias' => $categorias]);
            }
            elseif($request->category_id == 100000){


                $products = Product::all()->sortBy("name");

            }
            elseif($request->category_id == 100001){


                $products = Product::all()->sortByDesc("name");

            }
            else
             {

                $products = Product::select("*")
                ->whereIn('category_id', $request)
                ->get();

             }
                       
            return view('shopFiltro')->withTitle('BAHIA COMPUTACION')->with(['products' => $products , 'categorias' => $categorias]);
    
        }

    public function cart()  {

        $cartCollection = \Cart::getContent();


        return view('cart')->withTitle('BAHIA COMPUTACION')->with(['cartCollection' => $cartCollection]);

    }

    public function buy()  {

        $cartCollection = \Cart::getContent();


        return view('buy')->withTitle('BAHIA COMPUTACION')->with(['cartCollection' => $cartCollection]);

    }

    public function remove(Request $request){

        \Cart::remove($request->id);

        return redirect()->route('cart.index')->with('success_msg', ' El Producto ' . $request->name .' se elimino de tu carrito' );

    }


    public function add(Request $request){

        \Cart::add(array(

            'id' => $request->id,

            'name' => $request->name,

            'price' => $request->price,

            'quantity' => $request->quantity,

            'attributes' => array(

                'image' => $request->img,

                'stock' => $request->stock

            )

        ));

        return redirect()->route('cart.index')->with('success_msg', 'Producto Agregado a sú Carrito!');

    }


    public function update(Request $request){

        
        if(($request->quantity) > ($request->stock)){

            return redirect()->route('cart.index')->with('alert_msg', 'Cantidad no disponible en stock de '.$request->name);
            
        } 

        \Cart::update($request->id,

            array(

                'quantity' => array(

                    'relative' => false,

                    'value' => $request->quantity

                ),

        ));

        return redirect()->route('cart.index')->with('success_msg', 'Tu carrito se actualizo con exito!');

    }


    public function clear(){

        \Cart::clear();

        return redirect()->route('cart.index')->with('success_msg', 'Tu carrito se vacio con exito');

    }

    public function pagar(){
    
        $carrito = \Cart::getContent();
        $total = \Cart::getTotal();

        foreach($carrito as $producto){
   
            $id = $producto->id;
            $cantidad = ($producto->attributes->stock) - ($producto->quantity);
            $product = Product::find($id);
            $product->stock = $cantidad;
            $product->save();
        }    

        \Cart::clear();

            return view('resumenProducto')->withTitle('BAHIA COMPUTACION')->with(['carrito' => $carrito , 'total' => $total]);

    }

}
