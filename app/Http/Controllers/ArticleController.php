<?php

namespace App\Http\Controllers;

use App\Models\CloudFile;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index(){
        $articles = Products::where('vendor_id',auth('vendor')->user()->id)-> latest()->get();
        return view ('dashboard.vendors.articles.index', compact
        ('articles'));
    }

    public function create(){

     return view ('dashboard.vendors.articles.create');
    }

    public function handleCreate(Request $request){
        try {
            $request->validate([
                'name' => 'required',
                'description' =>'required',
                'price' => 'required|integer'
            ],[
                'name.required'=> 'Le nom du produit est requis',
                'description.required' => 'La description du produit est requise',
                'price.required'=>'Le prix du produit est requis'
            ]);

            $imagePath = '';

            if ($request->hasFile('image')) {
                $imagePath .= $request->file('image')->store('images', 'public');
                # code...
            }


            $produit = new Products();
            $produit->image =$imagePath;
            $produit->name = $request->name;
            $produit->description = $request->description;
            $produit->price = $request->price;
            $produit->vendor_id = auth('vendor')->user()->id;


            if ($produit->save()) {
                return redirect()->back()->with('success', 'Enregistré avec succès');
            }
            

            // dd($produit);

        } catch (Exception $e) {
            dd($e);
        }


      


        // try{
        //     DB::beginTransaction();

    //         $productData = [
    //             'image'=>$request->image,
    //             'name'=>$request->name,
    //             'price'=>$request->price,
    //             'description'=>$request->description,
    //             'vendor_id'=>auth('vendor')->user()->id,

    //         ];

    
    //  $product = Products::create($productData);



//  $this->handleImageUpload($product, $request,'image', 'cloud_files/articles','cloud_file_id');
//     //Gérer ici l'upload des images 

//             DB::commit();
//             return redirect()->route('articles.index')->
//             with('success',' Produit enregistré');
//         }catch(Exception $e){

//             DB::rollback();
//             return redirect()->back()->with('error',
//             $e->getMessage());
//         }
    // }

    


//     public function handleImageUpload($data, $request, 
//     $inputKey, $destination, $attributeName)
//     {
// if($request->hasFile('$inputKey')){
// $filePath = $request->file($inputKey)->
// store("destination", 'public');

// $cloudFile = CloudFile::create([
//     'path' => $filePath
// ]);

// $data->{$attributeName} = $cloudFile->id;
// $data->update();
//    }
 
//   }
}

}
