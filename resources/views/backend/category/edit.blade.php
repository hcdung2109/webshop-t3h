@extends('backend.layouts.main')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chỉnh sửa
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <a href="{{ route('admin.category.index') }}" class="btn btn-info pull-right"><i class="fa fa-list" aria-hidden="true"></i> Danh Sách</a>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{ route('admin.category.update', ['category' => $model->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên</label>
                                <input value="{{ $model->name }}" required id="name" name="name" type="text" class="form-control" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Chọn ảnh</label>
                                <input type="file" name="image" id="image">
                            </div>

                            @if($model->image && file_exists(public_path($model->image)))
                                <img src="{{ asset($model->image) }}" width="100" height="75" alt="">
                            @else
                                <img src="{{ asset('upload/404.png') }}" width="100" height="75" alt="">
                            @endif

                            <div class="form-group">
                                <label>Chọn Danh Mục Cha</label>
                                <select class="form-control" name="parent_id" id="parent_id">
                                    <option value="0">-- Chọn --</option>
                                    @foreach($data as $item)
                                        <option {{ $item->id == $model->parent_id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Vị trí</label>
                                <input value="{{ $model->position }}" min="0" type="number" class="form-control" id="position" name="position" placeholder="">
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input @if($model->is_active == 1) checked @endif value="1" type="checkbox" name="is_active" id="is_active"> Hiển thị
                                </label>
                            </div>

                            <div class="form-group">
                                <label>Loại Danh Mục</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="0">-- chọn --</option>
                                    <option @if($model->type == 1) checked @endif value="1">DM Sản Phẩm</option>
                                    <option @if($model->type == 2) checked @endif value="2">DM Tin Tức</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script type="text/javascript">
        $( document ).ready(function() {
            CKEDITOR.replace( 'description' );

            $('.btnCreate').click(function () {
                if ($('#name').val() === '') {
                    $('#name').notify('Bạn nhập chưa nhập tên,'error');
                    document.getElementById('title').scrollIntoView();
                    return false;
                }
            });
        });
    </script>
@endsection
