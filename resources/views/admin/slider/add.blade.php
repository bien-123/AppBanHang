@extends('admin.main')

@section('content')
    <form action="" method="POST">
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <label for="menu">Tiêu Đề</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nhập tên sản phẩm">
                </div>

                <div class="col-md-6">
                    <label for="menu">Đường Dẫn</label>
                    <input type="text" name="url" value="{{ old('url') }}" class="form-control" placeholder="Nhập tên sản phẩm">
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Sản Phẩm</label>
                <input type="file" id="upload" class="form-control">
                <div id="image_show">
                    <a href="{{ old('thumb') }}" target="_blank">
                        <img src="{{ old('thumb') }}" width="100px">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{ old('thumb') }}">
            </div>

                <div class="form-group">
                    <label for="menu">Sắp Xếp</label>
                    <input type="number" name="sort_by" value="{{ old('sort_by') }}" class="form-control">
                </div>

            <div class ="form-group">
                <label>Kích Hoạt</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active" checked="">
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active">
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Thêm Slider</button>
            </div>
        @csrf
    </form>
@endsection

<!-- Mô tả định dạng văn bản -->
@section('footer')
    <script>
        CKEDITOR.replace('content');//gọi đến mô tả chi tiết có id là content
    </script>
@endsection
