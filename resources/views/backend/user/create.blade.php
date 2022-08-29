@extends('backend.layouts.main')

@section('content')
    <section class="content-header">
        <h1>
            Thêm Thành Viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">Thêm Thành Viên</li>
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
                    <div class="box-header with-border">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-info pull-right"><i class="fa fa-list" aria-hidden="true"></i> Danh Sách</a>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên</label>
                                <input id="name" name="name" type="text" class="form-control" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Avatar</label>
                                <input type="file" name="avatar" id="avatar">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Mật khẩu</label>
                                <input type="text" class="form-control" id="password" name="password" placeholder="">
                            </div>

                            <div class="form-group">
                                <label>Vai trò</label>
                                <select class="form-control" name="role_id" id="role_id">
                                    <option value="">-- chọn --</option>
                                    <option value="1">Administrator</option>
                                    <option value="2">Member</option>
                                </select>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input value="1" type="checkbox" name="is_active" id="is_active"> Kích hoạt
                                </label>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btnCreate">Thêm</button>
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

            });
        });
    </script>
@endsection


