@extends('layouts.admin')

@section('title', 'Sửa danh mục')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="mb-0">Sửa danh mục</h2>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Danh mục cha</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- Không chọn --</option>
                        @php
                        function renderCategoryOptionsEdit($categories, $parentId = null, $prefix = '', $currentId = null, $selectedId = null) {
                            foreach($categories->where('parent_id', $parentId) as $cat) {
                                if($cat->id == $currentId) continue;
                                echo '<option value="'.$cat->id.'"'.(($selectedId == $cat->id) ? ' selected' : '').'>'.$prefix.$cat->name.'</option>';
                                renderCategoryOptionsEdit($categories, $cat->id, $prefix.'--- ', $currentId, $selectedId);
                            }
                        }
                        renderCategoryOptionsEdit($parents, null, '', $category->id, old('parent_id', $category->parent_id));
                        @endphp
                    </select>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 