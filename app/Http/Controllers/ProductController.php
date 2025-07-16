<?php

namespace App\Http\Controllers;

use App\Actions\Product\ProductCreate;
use App\Actions\Product\ProductUpdate;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function records(): LengthAwarePaginator
    {
        return Product::latest()->paginate(15);
    }

    public function index(): View
    {
        return view('product_form', ['products' => self::records()]);
    }

    public function create()
    {
    }

    public function store(ProductRequest $request, ProductCreate $productCreate): Response
    {
        $productCreate->handle($request->validated());

        return response()->json(['success' => true, 'message' => 'Product Added Successfully', 'data' => self::records()], Response::HTTP_CREATED);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(ProductRequest $request, $id, ProductUpdate $productUpdate): Response
    {
        $productUpdate->handle($id, $request->validated());

        return response()->json(['success' => true, 'message' => 'Product Updated Successfully', 'data' => self::records()], Response::HTTP_OK);
    }

    public function destroy($id)
    {
    }
}