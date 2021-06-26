<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleModel;
use Illuminate\Support\Facades\Auth;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    //
    /**
     * @OA\Post(
     *      path="/master/category",
     *      operationId="StoreCategoryProduct",
     *      tags={"Products Category"},
     *      summary="Store new Category",
     *      security={ {"bearer": {} }},
     *      description="Returns Category data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="nama_kategori", 
     *                  type="string", 
     *                  example="Electronic"
     *              ),
     *              @OA\Property(
     *                  property="deskripsi", 
     *                  type="string", 
     *                  example="Kelompok Elektronik"
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
     *                  example="Kategori berhasil ditambahkan"
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
     *                  example="nama Kategori Kosong"
     *              ),
     *          )    
     *      ),
     * )
     */
    public function create(Request $request) {
        $dat = $request->all();
        $user_id = Auth::id();
        $user_role=RoleModel::where('user_id',$user_id)->first(); 
        print_r($user_role->status);
        if($user_role->position=="admin") {
            $validator = Validator::make($request->all(), [
                'nama_kategori' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()
                ],422);
            } 
            
            $Category = new CategoryModel;
            $Category->nama_kategori=$dat["nama_kategori"];
            $Product->deskripsi=$dat["deskripsi"];
            $Product->save();
        
            return response()->json([
                "success" => true,
                "message" => "Kategori berhasil ditambahkan"
            ],200);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Maaf, anda tak bisa tambah kategori"
            ],401);
        }
    }

    /**
     * @OA\Put(
     *      path="/master/category/{id}",
     *      operationId="EditCategory",
     *      tags={"Products Category"},
     *      summary="Edit Category",
     *      security={ {"bearer": {} }},
     *      description="Returns Category data",
     *      @OA\Parameter(
     *          description="ID of Category",
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
     *                  property="nama_kategori", 
     *                  type="string", 
     *                  example="Perabotan Rumah Tangga"
     *              ),
     *              @OA\Property(
     *                  property="deskripsi", 
     *                  type="string", 
     *                  example="Peralatan rumah tanga"
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
     *                  example="Product berhasil diupdate"
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
     *                  example="nama kategori sudah kosong"
     *              ),
     *          )    
     *      ),
     * )
     */
    public function edit(Request $request,$id) {
        $dat = $request->all();
         $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ],422);
        } 
        
        $Category = $CategoryModel->find($id);
        $Category->nama_kategori=$dat["nama_kategori"];
        $Product->deskripsi=$dat["deskripsi"];
        $Product->save();
       
        return response()->json([
            "success" => true,
            "message" => "Product berhasil diupdate"
        ],200);
    }

    /**
     * @OA\Delete(
     *      path="/master/category",
     *      operationId="DeleteCategory",
     *      tags={"Products Category"},
     *      summary="Delete Category",
     *      security={ {"bearer": {} }},
     *      description="Returns Message",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="id", 
     *                  type="integer", 
     *                  example="1"
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
     *                  example="Kategori berhasil dihapus"
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
     *                  example="id tidak ditemukan"
     *              ),
     *          )    
     *      ),
     * )
     */
    public function delete(Request $request) {
        $dat = $request->all();
         $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ],422);
        } 
        
        $Category = $CategoryModel->find($id);
        $Category->delete();
       
        return response()->json([
            "success" => true,
            "message" => "Kategori berhasil dihapus"
        ],200);
    }

    /**
     * @OA\Get(
     *      path="/master/category",
     *      operationId="GetCategoryList",
     *      tags={"Products Category"},
     *      summary="Get Category List",
     *      description="Returns Category Data",
     *      security={ {"bearer": {} }},    
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
     *                       @OA\Property(
     *                          property="nama_kategori", 
     *                          type="string", 
     *                          example="Perabotan Rumah Tangga"
     *                      ),
     *                      @OA\Property(
     *                          property="deskripsi", 
     *                          type="string", 
     *                          example="Peralatan rumah tanga"
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
    public function get_category(Request $request) {
        $dat = $request->all();
        $Category = CategoryModel::all();
        if(!$Category->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Kategori ditemukan",
                "data" =>$Category 
            ],200);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Kategori tidak ditemukan"
            ],404);
        }    
    }

    /**
     * @OA\Get(
     *      path="/master/category/{id}",
     *      operationId="GetCategoryDetail",
     *      tags={"Products Category"},
     *      summary="Get Category Detail",
     *      description="Returns Category Data",
     *      security={ {"bearer": {} }},    
     *       @OA\Parameter(
     *          description="ID of Category",
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
     *                  example="Kategori ditemukan"
     *              ),
     *              @OA\Property(
     *                  property="data", 
     *                  type="object", 
     *                  @OA\Property(
     *                      property="nama_kategori", 
     *                      type="string", 
     *                      example="Perabotan Rumah Tangga"
     *                   ),
     *                   @OA\Property(
     *                      property="deskripsi", 
     *                      type="string", 
     *                      example="Peralatan rumah tanga"
     *                   ),
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
    public function get_category_detail(Request $request,$id) {
        // $dat = $request->all();
        // print_r($request);
        $Category = CategoryModel::find($id);
        //print_r($Category);
        if(!empty($Category)) {
            return response()->json([
                "success" => true,
                "message" => "Kategori ditemukan",
                "data" =>$Category
            ],200);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Kategori tidak ditemukan"
            ],404);
        }    
    }
}
