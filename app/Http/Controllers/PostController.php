<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class PostController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->latest('id')->paginate(8);

        //dd($products);
        if (request('search')) {
            $products = $products->where('name', 'like', '%' . request('search') . '%');
        }


        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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


        return view('products.history', compact('products_reserve', 'products_history'));
    }

    public function buyProduct(Request $request)
    {

        $value = $request->server('QUERY_STRING');

        $user = Auth::user();

        $user_list = $user->listProd;

        if (empty($user_list)) {

            $list2 = ";" . $value .  ":1,;";

            $user->listProd = $list2;


            $user->save();
        } else {
            $separator = ";";
            $listLik = explode($separator, $user_list);

            if (empty($listLik[1])) {
                if(count($listLik) === 3){
                    $list2 = $listLik[1] . $value . ":1,;" . $listLik[2];
                }else{
                    $list2 = $listLik[1] . $value . ":1,;";
                }
                
            } else {

                if(count($listLik) === 3){
                    $list2 = $listLik[1] . $value . ":1,;" . $listLik[2];
                }else{
                    $list2 = $value . ":1," . $listLik[1] . ";";
                }
            }

            $user->listProd = $listLik[0] . ";" . $list2;

            $user->save();
        }


        Product::where('id', $value)->update(['status' => '1']);
        Product::where('id', $value)->update(['idClient' => Auth::user()->id]);

        return back()->with('status', 'Product reserve successfully!');
    }

    public function addProduct(Request $request)
    {

        //$productlist = $product -> id;
        //dd($request);
        $user = Auth::user();
        //$value = $request ->query();
        $value = $request->server('QUERY_STRING');
        //dd($value);

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
            return back()->with('status', 'Product is already added!');
        } else if (in_array($value, $products_id)) {
            return back()->with('status', 'It is your publication');
        } else if (empty($user->listProd)) {
            $user->listProd = $value . ":0,;";
            $user->save();
            return back()->with('status', 'Product add successfully!');
        } else {
            $userlist = $user->listProd;
            $user->listProd = $value . ":0," . $userlist;

            $user->save();

            return back()->with('status', 'Product add successfully!');
        }
    }

    public function mi_car()
    {

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

        return view('products.shopping', compact('products'));
    }


    public function show(Product $product)
    {
        //$this->authorize('published', $product);

        $similares = Product::where('category_id', $product->category_id)
            ->where('status', 1)
            ->where('id', '!=', $product->id)
            ->latest('id')
            ->take(4)
            ->get();
        return view('products.show', compact('product', 'similares'));
    }

    public function category(Category $category)
    {

        $posts = Product::where('category_id', $category->id)
            ->where('status', 1)
            ->latest('id')
            ->paginate(6);
        //dd($posts);

        return view('products.category', compact('posts', 'category'));
    }

    public function tag(Tag $tag)
    {
        $posts = $tag->products()->where('status', 1)->latest('id')->paginate(4);

        return view('products.tag', compact('posts', 'tag'));
    }

    public function discard(Request $request)
    {

        $value = $request->server('QUERY_STRING');

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

            if(count($listLik) == 3){
                $user->listProd = ";" . $listLik[1] . ";" . $listLik[2];
                $user->save();
            }else{
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

            if(count($listLik) == 3){
                $user->listProd = $list4 . $listLik[1] . ";" . $listLik[2];
                $user->save();
            }else{
                $user->listProd = $list4 . $listLik[1] . ";";
                $user->save();
            }
        }

        return back()->with('status', 'Product delete successfully of the car shopping!');
    }

    public function addReserve(Request $request)
    {

        $value = $request->server('QUERY_STRING');

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

        if(count($listLik) == 3){
            $user->listProd = $listLik3 . $list4 . $listLik[2];
        }else{
            $user->listProd = $listLik3 . $list4;
        }

        $user->save();

        Product::where('id', $value)->update(['status' => '1']);
        Product::where('id', $value)->update(['idClient' => Auth::user()->id]);

        return back()->with('status', 'Product reserve successfully!');
    }

    public function addBought(Request $request)
    {

        $value = $request->server('QUERY_STRING');

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

        return back()->with('status', 'Thanks for your purchase!');
    }
}
