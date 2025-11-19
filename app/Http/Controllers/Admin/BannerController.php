<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->paginate(20);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $data = [];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_banner_'.uniqid().'.'.$file->getClientOriginalExtension();
                
            // Sửa đường dẫn cho Vinahost
            $uploadPath = 'images/banners';
            $fullPath = public_path($uploadPath);
            
            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            $file->move($fullPath, $filename);
            $data['image_path'] = $uploadPath . '/' . $filename;
            
            // Debug log
            \Log::info('Banner upload', [
                'filename' => $filename,
                'upload_path' => $uploadPath,
                'full_path' => $fullPath,
                'final_path' => $data['image_path'],
                'file_exists' => file_exists($fullPath . '/' . $filename)
            ]);
        }

        // Các giá trị mặc định để đơn giản hoá nhập liệu
        $data['title'] = null;
        $data['link_url'] = null;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['sort_order'] = (int) (Banner::max('sort_order') + 1);

        Banner::create($data);
        return redirect()->route('admin.banners.index')->with('success', 'Thêm banner thành công!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $data = [];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_banner_'.uniqid().'.'.$file->getClientOriginalExtension();
            
            // Sửa đường dẫn cho Vinahost
            $uploadPath = 'images/banners';
            $fullPath = public_path($uploadPath);
            
            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            $file->move($fullPath, $filename);
            $data['image_path'] = $uploadPath . '/' . $filename;
            
            // Debug log
            \Log::info('Banner update', [
                'filename' => $filename,
                'upload_path' => $uploadPath,
                'full_path' => $fullPath,
                'final_path' => $data['image_path'],
                'file_exists' => file_exists($fullPath . '/' . $filename)
            ]);
        }

        $data['title'] = $request->input('title');
        $data['link_url'] = $request->input('link_url');
        if ($request->filled('sort_order')) {
            $data['sort_order'] = (int) $request->input('sort_order');
        }
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $banner->update($data);
        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật banner thành công!');
    }

    public function destroy(Banner $banner)
    {
        // Xóa file ảnh nếu tồn tại
        if ($banner->image_path) {
            $path = public_path($banner->image_path);
            if (file_exists($path)) @unlink($path);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Đã xóa banner!');
    }
}


