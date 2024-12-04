<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\Order;
use App\Models\productComment;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $slug)
    {
        $product = products::where('slug', $slug)->firstOrFail();

       

        $comment = productComment::query()->create([
            'user_id' => auth()->id(),
            'products_id' => $product->id,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

}
