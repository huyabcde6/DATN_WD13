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
    public function index()
    {
        $comments = productComment::with('user', 'product')
            ->latest()
            
            ->paginate(7);

        return view('admin.comments.index', compact('comments'));
    }
    public function store(Request $request, $slug)
    {
        $product = products::where('slug', $slug)->firstOrFail();

        // $hasPurchased = Order::where('user_id', auth()->id())
        // ->whereHas('orderDetail', function($query) use ($product) {
        //     $query->where('product_detail_id', $product->id);
        //     })
        //     ->where('payment_status', 'pending')
        //     ->exists();

        // if (!$hasPurchased) {
        //     return back()->with('error', 'Bạn cần mua sản phẩm này trước khi đánh giá');
        // }

        $comment = productComment::query()->create([
            'user_id'       => auth()->id(),
            'products_id'   => $product->id,
            'description'   => $request->description,
            'is_hidden'     => false,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    public function hide($commentId)
    {
        $comment = productComment::findOrFail($commentId);
        
        $comment->is_hidden = !$comment->is_hidden;

        $comment->save();
    
        return back()->with('success', 'Đã cập nhật trạng thái bình luận!');
    }

}
