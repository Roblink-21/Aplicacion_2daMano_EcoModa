<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{

    public function index()
    {
        return Product::where('status', 1)->latest('id')->get()->toArray();
    }

    public function getImage($id){
        $product = Product::find($id);

        return $product -> image -> getUrl();
    }

    public function show($id)
    {
        $product = Product::find($id);

        $similares = Product::where('category_id', $product->category_id)
            ->where('status', 1)
            ->where('id', '!=', $product->id)
            ->latest('id')
            ->get()
            ->toArray();

        return response([
            'Product' => $product,
            'Similar products' => $similares
        ], 201);
    }

    public function category($id)
    {
        $category = Category::find($id);

        $posts = Product::where('category_id', $category->id)
            ->where('status', 1)
            ->latest('id')
            ->get()
            ->toArray();
        //dd($posts);

        return response([
            'Category' => $category,
            'Products' => $posts
        ], 201);
    }

    public function tag($id)
    {
        $tag = Tag::find($id);

        $posts = $tag->products()->where('status', 1)->latest('id')->get()->toArray();

        return response([
            'Tag' => $tag,
            'Products' => $posts
        ], 201);
    }

    // Mi carrito de compras

    public function my_car()
    {

        $products = Product::all();
        $user = Auth::user();

        $user_list = $user->listProd;
        $separator = ";";
        $listLik = explode($separator, $user_list);

        $separator = ",";
        $listLik2 = explode($separator, $listLik[0]);

        $separator = ":0";
        $list2 = array();

        foreach ($listLik2 as $item) {
            $listlik3 = explode($separator, $item);
            $list2[] = $listlik3[0];
        }

        unset($list2[sizeof($list2) - 1]);

        $products = Product::find($list2);

        return $products;
    }

    //Descartar elemento del carrito de compras

    public function discard($id)
    {

        $value = $id;

        $user = Auth::user();

        $user_list = $user->listProd;
        $separator = ";";
        $listLik = explode($separator, $user_list);

        $separator = ",";
        $listLik2 = explode($separator, $listLik[0]);

        $separator = ":0";
        $list2 = array();

        foreach ($listLik2 as $item) {
            $listlik3 = explode($separator, $item);
            $list2[] = $listlik3[0];
        }

        unset($list2[sizeof($list2) - 1]);

        if (($clave = array_search($value, $list2)) !== false) {
            unset($list2[$clave]);
        }

        if (empty($list2)) {

            if (count($listLik) == 3) {
                $user->listProd = ";" . $listLik[1] . ";" . $listLik[2];
                $user->save();
            } else {
                $user->listProd = ";" . $listLik[1] . ";";
                $user->save();
            }
        } else {

            $list3 = array();

            foreach ($list2 as $val) {
                array_push($list3, $val . ":0,");
            }

            array_push($list3, ";");

            $list4 = "";

            foreach ($list3 as $val) {
                $list4 = $list4 . $val;
            }

            if (count($listLik) == 3) {
                $user->listProd = $list4 . $listLik[1] . ";" . $listLik[2];
                $user->save();
            } else {
                $user->listProd = $list4 . $listLik[1] . ";";
                $user->save();
            }
        }


        return [
            'message' => 'Product delete successfully of the car shopping!'
        ];
    }

    // comprar el producto del carrito de compras

    public function addReserve($id)
    {

        $value = $id;

        $user = Auth::user();

        $user_list = $user->listProd;
        $separator = ";";
        $listLik = explode($separator, $user_list);

        $separator = ":0,";
        $listLik2 = explode($separator, $listLik[0]);

        unset($listLik2[sizeof($listLik2) - 1]);

        if (($clave = array_search($value, $listLik2)) !== false) {
            unset($listLik2[$clave]);
        }

        $list3 = array();

        foreach ($listLik2 as $val) {
            array_push($list3, $val . ":0,");
        }

        array_push($list3, ";");

        //dd($list2);

        $listLik3 = "";

        foreach ($list3 as $val) {
            $listLik3 = $listLik3 . $val;
        }


        if (empty($listLik[1]) || is_null($user->listProd)) {
            $list4 = $listLik[1] . $value . ":1,;";
        } else {
            $list4 = $value . ":1," . $listLik[1] . ";";
        }

        if (count($listLik) == 3) {
            $user->listProd = $listLik3 . $list4 . $listLik[2];
        } else {
            $user->listProd = $listLik3 . $list4;
        }

        $user->save();

        Product::where('id', $value)->update(['status' => '1']);
        Product::where('id', $value)->update(['idClient' => Auth::user()->id]);

        return [
            'message' => 'Product reserve successfully of the car shopping!'
        ];
    }

    //Añadir el producto al carrito de compras

    public function addProduct($id)
    {

        $user = Auth::user();
        $value = $id;

        $user_list = $user->listProd;
        $separator = ";";
        $listLik = explode($separator, $user_list);

        $separator = ",";
        $listfav = explode($separator, $listLik[0]);

        $separator = ":0";
        $list2 = array();

        foreach ($listfav as $item) {
            $listlik2 = explode($separator, $item);
            $list2[] = $listlik2[0];
        }

        unset($list2[sizeof($list2) - 1]);

        $posts = Product::where('user_id', auth()->user()->id)->get();
        foreach ($posts as $item) {
            $products_id[] = $item->id;
        }


        if (in_array($value, $list2)) {

            return [
                'message' => 'Product is already added!'
            ];
        } else if (in_array($value, $products_id)) {
            return [
                'message' => 'It is your publication'
            ];
        } else if (empty($user->listProd)) {
            $user->listProd = $value . ":0,;";
            $user->save();
            return [
                'message' => 'Product add successfully!'
            ];
        } else {
            $userlist = $user->listProd;
            $user->listProd = $value . ":0," . $userlist;

            $user->save();

            return [
                'message' => 'Product add successfully!'
            ];
        }
    }

    //Reservar el producto desde la publicacion

    public function buyProduct($id)
    {

        $value = $id;

        $user = Auth::user();

        $userA = auth()->user()->id;

        $userP = Product::find($id)->user_id;

        if ($userA == $userP) {
            return [
                'message' => 'It is your product'
            ];
        } else {

            $user_list = $user->listProd;

            if (empty($user_list)) {

                $list2 = ";" . $value .  ":1,;";

                $user->listProd = $list2;


                $user->save();

            } else {
                $separator = ";";
                $listLik = explode($separator, $user_list);

                if (empty($listLik[1])) {
                    if (count($listLik) === 3) {
                        $list2 = $listLik[1] . $value . ":1,;" . $listLik[2];
                    } else {
                        $list2 = $listLik[1] . $value . ":1,;";
                    }
                } else {

                    if (count($listLik) === 3) {
                        $list2 = $listLik[1] . $value . ":1,;" . $listLik[2];
                    } else {
                        $list2 = $value . ":1," . $listLik[1] . ";";
                    }
                }

                $user->listProd = $listLik[0] . ";" . $list2;

                $user->save();
            }


            Product::where('id', $value)->update(['status' => '1']);
            Product::where('id', $value)->update(['idClient' => Auth::user()->id]);

            return [
                'message' => 'Product reserve successfully'
            ];
        }
    }

    //Comprar el producto y calificar al usuario
    public function finPurchase($id)
    {

        $value = $id;

        $user = Auth::user();

        $user_list = $user->listProd;
        $separator = ";";
        $listLik = explode($separator, $user_list);

        $separator = ":1,";
        $listLik2 = explode($separator, $listLik[1]);

        unset($listLik2[sizeof($listLik2) - 1]);

        if (($clave = array_search($value, $listLik2)) !== false) {
            unset($listLik2[$clave]);
        }

        $list3 = array();

        foreach ($listLik2 as $val) {
            array_push($list3, $val . ":1,");
        }

        array_push($list3, ";");

        //dd($list2);

        $listLik3 = "";

        foreach ($list3 as $val) {
            $listLik3 = $listLik3 . $val;
        }


        if (empty($listLik[2])) {
            $list4 = $listLik[2] . $value . ":2,";
        } else {
            $list4 = $value . ":2," . $listLik[2];
        }

        //dd($listLik[0] . ";" . $listLik3 . $list4);

        $product_vendor = Product::where('id', $value)->first();
        $index = $product_vendor->user_id;
        $vendor = User::where('id', $index)->first();
        $indexsum = $vendor->score;
        $indexsum = $indexsum + 1;

        //$score_plus = User::where('id', $vendor)->get('score');


        $user->listProd = $listLik[0] . ";" . $listLik3 . $list4;

        $user->save();

        Product::where('id', $value)->update(['status' => '2']);
        User::where('id', $index)->update(['score' => $indexsum]);

        return [
            'message' => 'Purchased product successfully'
        ];
    }


    public function historyProduct()
    {
        $user = Auth::user();

        $user_list = $user->listProd;
        $separator = ";";
        $listLik = explode($separator, $user_list);


        if (!empty($listLik[1]) || !is_null($user->listProd) && sizeof($listLik) == 3) {

            $separator2 = ":1,";
            $list_reserve = explode($separator2, $listLik[1]);
            unset($list_reserve[sizeof($list_reserve) - 1]);

            $products_reserve = Product::find($list_reserve);

            if (empty($listLik[2])) {
                $products_history = Product::find($listLik[2]);
            } else {

                $separator3 = ":2,";
                $list_history = explode($separator3, $listLik[2]);

                unset($list_history[sizeof($list_history) - 1]);
                $products_history = Product::find($list_history);
            }
        } else {

            $products_reserve = array();

            $products_history = array();
        }

        return response([
            'Reserve' => $products_reserve,
            'Purchased Products' => $products_history
        ], 201);
    }



}
