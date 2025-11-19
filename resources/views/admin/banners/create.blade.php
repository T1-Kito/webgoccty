@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Thêm banner</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Ảnh banner (kéo thả hoặc chọn ảnh)</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                    <label class="form-check-label" for="is_active">Hiển thị</label>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
            <button class="btn btn-primary" type="submit">Lưu</button>
        </div>
    </form>
</div>
@endsection


