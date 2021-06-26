<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductModel;

class ProductController extends Controller
{
    //
    /**
     * @OA\Post(
     *      path="/master/product",
     *      operationId="StoreProduct",
     *      tags={"Products"},
     *      summary="Store new product",
     *       security={ {"bearer": {} }},
     *      description="Returns product data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="kode_barang", 
     *                  type="string", 
     *                  example="K001"
     *              ),
     *              @OA\Property(
     *                  property="nama_barang", 
     *                  type="string", 
     *                  example="Pensil"
     *              ),
     *              @OA\Property(
     *                  property="merk", 
     *                  type="string", 
     *                  example="LG"
     *              ),
     *              @OA\Property(
     *                  property="serialnumber", 
     *                  type="string", 
     *                  example="LG-webos-0xB010100"
     *              ),
     *              @OA\Property(
     *                  property="stok", 
     *                  type="integer", 
     *                  example="10"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success Operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="true"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="Product berhasil ditambahkan"
     *              ),
     *          )    
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocess",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="kode unik sudah terpakai"
     *              ),
     *          )    
     *      ),
     * )
     */
    public function create(Request $request) {
        $dat = $request->all();
         $validator = Validator::make($request->all(), [
            'kode_barang' => 'required|unique:products',
            'category_id' => 'required|integer',
            'nama_barang' => 'required',
            'merk' => 'required',
            'serialnumber' => 'required',
            'stok' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ],422);
        } 
        
        $Product = new ProductModel;
        $Product->kode_barang=$dat["kode_barang"];
        $Product->nama_barang=$dat["nama_barang"];
        $Product->merk=$dat["merk"];
        $Product->serialnumber=$dat["serialnumber"];
        $Product->stok=$dat["stok"];
        $Product->save();
       
        return response()->json([
            "success" => true,
            "message" => "Product berhasil ditambahkan"
        ],200);
    }

    /**
     * @OA\Put(
     *      path="/master/product/{id}",
     *      operationId="EditProduct",
     *      tags={"Products"},
     *      security={ {"bearer": {} }},
     *      summary="Edit product",
     *      description="Returns product data",
     *      @OA\Parameter(
     *          description="ID of Product",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *             type="integer",
     *          )
     *      ),    
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="kode_barang", 
     *                  type="string", 
     *                  example="K001"
     *              ),
     *              @OA\Property(
     *                  property="nama_barang", 
     *                  type="string", 
     *                  example="Pensil"
     *              ),
     *              @OA\Property(
     *                  property="merk", 
     *                  type="string", 
     *                  example="LG"
     *              ),
     *              @OA\Property(
     *                  property="serialnumber", 
     *                  type="string", 
     *                  example="LG-webos-0xB010100"
     *              ),
     *              @OA\Property(
     *                  property="stok", 
     *                  type="integer", 
     *                  example="10"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success Operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="true"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="Product berhasil ditambahkan"
     *              ),
     *          )    
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocess",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="kode unik sudah terpakai"
     *              ),
     *          )    
     *      ),
     * )
     */
    public function edit(Request $request,$id) {
        $dat = $request->all();
         $validator = Validator::make($request->all(), [
            'kode_barang' => 'required|unique:products',
            'category_id' => 'required|integer',
            'nama_barang' => 'required',
            'merk' => 'required',
            'serialnumber' => 'required',
            'stok' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ],422);
        } 
        
        $Product = $ProductModel->find($id);
        $Product->kode_barang=$dat["kode_barang"];
        $Product->nama_barang=$dat["nama_barang"];
        $Product->merk=$dat["merk"];
        $Product->serialnumber=$dat["serialnumber"];
        $Product->stok=$dat["stok"];
        $Product->save();
       
        return response()->json([
            "success" => true,
            "message" => "Product berhasil diupdate"
        ],200);
    }

    /**
     * @OA\Delete(
     *      path="/master/product",
     *      operationId="DeleteProduct",
     *      tags={"Products"},
     *      security={ {"bearer": {} }},
     *      summary="Delete product",
     *      description="Returns Message",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="kode_barang", 
     *                  type="string", 
     *                  example="K001"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success Operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="true"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="Product berhasil dihapus"
     *              ),
     *          )    
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocess",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="kode unik sudah terpakai"
     *              ),
     *          )    
     *      ),
     * )
     */
    public function delete(Request $request) {
        $dat = $request->all();
         $validator = Validator::make($request->all(), [
            'kode_barang' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ],422);
        } 
        
        $Product = $ProductModel->find($id);
        $Product->delete();
       
        return response()->json([
            "success" => true,
            "message" => "Product berhasil dihapus"
        ],200);
    }

    /**
     * @OA\Get(
     *      path="/master/product",
     *      operationId="GetProductList",
     *      tags={"Products"},
     *      security={ {"bearer": {} }},
     *      summary="Get Product List",
     *      description="Returns Product Data",
     *      @OA\Response(
     *          response=200,
     *          description="Success Operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="true"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="Kategori ditemukan"
     *              ),
     *              @OA\Property(
     *                  property="data", 
     *                  type="array", 
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="kode_barang", 
     *                          type="string", 
     *                          example="K001"
     *                      ),
     *                      @OA\Property(
     *                          property="nama_barang", 
     *                          type="string", 
     *                          example="Pensil"
     *                      ),
     *                      @OA\Property(
     *                          property="merk", 
     *                          type="string", 
     *                          example="LG"
     *                      ),
     *                      @OA\Property(
     *                          property="serialnumber", 
     *                          type="string", 
     *                          example="LG-webos-0xB010100"
     *                      ),
     *                      @OA\Property(
     *                          property="stok", 
     *                          type="integer", 
     *                          example="10"
     *                      ),
     *                  )
     *              ),
     *          )    
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="id tidak ditemukan"
     *              ),
     *          )    
     *      ),
     * )
     */
    public function get_product(Request $request) {
        $dat = $request->all();
        $Product = ProductModel::all();
        if(!$Product->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Product ditemukan",
                "data" => $Product 
            ],200);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Product tidak ditemukan"
            ],404);
        }    
    }

    /**
     * @OA\Get(
     *      path="/master/product/{id}",
     *      operationId="GetProductDetail",
     *      tags={"Products"},
     *      security={ {"bearer": {} }},
     *      summary="Get Product Detail",
     *      description="Returns Product Data",
     *       @OA\Parameter(
     *          description="ID of Product",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *             type="integer",
     *          )
     *      ),    
     *      @OA\Response(
     *          response=200,
     *          description="Success Operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="true"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="Product ditemukan"
     *              ),
     *              @OA\Property(
     *                  property="data", 
     *                  type="object", 
     *                  @OA\Property(
     *                       property="kode_barang", 
     *                       type="string", 
     *                       example="K001"
     *                  ),
     *                  @OA\Property(
     *                       property="nama_barang", 
     *                       type="string", 
     *                       example="Pensil"
     *                  ),
     *                  @OA\Property(
     *                        property="merk", 
     *                        type="string", 
     *                        example="LG"
     *                  ),
     *                  @OA\Property(
     *                        property="serialnumber", 
     *                        type="string", 
     *                        example="LG-webos-0xB010100"
     *                  ),
     *                  @OA\Property(
     *                        property="stok", 
     *                        type="integer", 
     *                        example="10"
     *                  ),
     *                  
     *              ),
     *          )    
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="id tidak ditemukan"
     *              ),
     *          )    
     *      ),
     * )
     */     
    public function get_product_detail(Request $request) {
        $dat = $request->all();
        $Product = ProductModel::find($dat["id"]);
        if(!empty($Product)) {
            return response()->json([
                "success" => true,
                "message" => "Product ditemukan",
                "data" =>$Product
            ],200);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Product tidak ditemukan"
            ],404);
        }    
    }

}
