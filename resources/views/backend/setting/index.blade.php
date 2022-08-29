@extends('backend.layouts.main')

@section('content')
    <section class="content-header">
        <h1>
            Thông tin Website
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Thông tin Website</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{ route('admin.setting.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên Công Ty</label>
                                <input value="{{ $model->company }}" id="company" name="company" type="text" class="form-control" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Logo</label>
                                <input type="file" name="image" id="image">
                            </div>

                            @if($model->image && file_exists(public_path($model->image)))
                                <img src="{{ asset($model->image) }}" width="100" height="75" alt="">
                            @else
                                <img src="{{ asset('upload/404.png') }}" width="100" height="75" alt="">
                            @endif

                            <div class="form-group">
                                <label for="exampleInputPassword1">Địa chỉ 1</label>
                                <input value="{{ $model->address }}" type="text" class="form-control" id="address" name="address" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Địa chỉ 2</label>
                                <input value="{{ $model->address2 }}" type="text" class="form-control" id="address2" name="address2" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">SĐT</label>
                                <input value="{{ $model->phone }}" type="text" class="form-control" id="phone" name="phone" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Email</label>
                                <input value="{{ $model->email }}" type="email" class="form-control" id="email" name="email" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Mã Số Thuế</label>
                                <input value="{{ $model->tax }}" type="text" class="form-control" id="tax" name="tax" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Facebook</label>
                                <input value="{{ $model->facebook }}" type="text" class="form-control" id="facebook" name="facebook" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Thời gian mở cửa</label>
                                <input value="{{ $model->open_time }}" type="text" class="form-control" id="open_time" name="open_time" placeholder="">
                            </div>

                            <div class="form-group">
                                <label id="label-description">Giới thiệu</label>
                                <textarea id="content" name="content" class="form-control" rows="3" placeholder="Enter ...">{{ $model->content }}</textarea>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btnCreate">Cập nhật</button>
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
            CKEDITOR.replace( 'content' );

            $('.btnCreate').click(function () {
                if ($('#company').val() === '') {
                    $('#company').notify('Bạn nhập chưa nhập tiêu đề','error');
                    document.getElementById('company').scrollIntoView();
                    return false;
                }
            });
        });
    </script>
@endsection


