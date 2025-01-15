<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\Order;
use App\Models\OrderAction;
use App\Models\productComment;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Xem bình luận', ['only' => ['index']]);
        $this->middleware('permission:Ẩn bình luận', ['only' => ['hide']]);
    }
    public function index()
    {
        $comments = productComment::with('user', 'product')
            ->latest()

            ->paginate(7);

        return view('admin.comments.index', compact('comments'));
    }
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu gửi lên
        $request->validate([
            'product_name' => 'required|string|max:255',
            'comment' => 'required|string|max:500',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        // Kiểm tra số lượng file
        if ($request->hasFile('images') && count($request->file('images')) > 3) {
            return redirect()->back()->withErrors(['images' => 'Bạn chỉ được gửi tối đa 3 hình ảnh.']);
        }

        // Truy vấn để lấy product_id từ product_name
        $product = Product::where('name', $request->product_name)->first();

        if (!$product) {
            return redirect()->back()->withErrors(['product_name' => 'Sản phẩm không tồn tại.']);
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('comments', 'public'); // Lưu ảnh vào thư mục storage/app/public/comments
                $imagePaths[] = $path; // Thêm đường dẫn vào mảng
            }
        }

        // Lưu bình luận vào cơ sở dữ liệu
        productComment::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'description' => $request->comment,
            'images' => $imagePaths, // Lưu mảng đường dẫn hình ảnh dưới dạng JSON
        ]);
        // OrderAction::create([
        //     'user_id' => auth()->id(),
        //     'product_id' => $product->id,
        //     'action' => 'comment', // Hành động là bình luận
        //     'comment' => $request->comment,
        // ]);

        return redirect()->back()->with('success', 'Bình luận đã được gửi thành công!');
    }



    public function hide($commentId)
    {
        $comment = productComment::findOrFail($commentId);

        $comment->is_hidden = !$comment->is_hidden;

        $comment->save();

        return back()->with('success', 'Đã cập nhật trạng thái bình luận!');
    }

    public function fetchComments(Product $product, Request $request)
    {
        $comments = $product->productComments()
            ->where('is_hidden', 0)
            ->orderByDesc('created_at')
            ->paginate(3);

        return response()->json([
            'comments' => view('user.sanpham.partials.comment_list', compact('comments'))->render(),
            'next_page' => $comments->nextPageUrl(),
        ]);
    }
}
