@extends('backend.layouts.main')

@section('content')
    <section class="content-header">
        <h1>
            Thêm Sản Phẩm
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Thêm Sản Phẩm</li>
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
                        <a href="{{ route('admin.product.index') }}" class="btn btn-info pull-right"><i class="fa fa-list" aria-hidden="true"></i> Danh Sách</a>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên</label>
                                <input value="{{ old('name') }}" id="name" name="name" type="text" class="form-control" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Chọn ảnh</label>
                                <input type="file" name="image" id="image">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng</label>
                                <input id="stock" name="stock" type="number" class="form-control" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Gía bán</label>
                                <input value="{{ old('price') }}" id="price" name="price" type="text" class="form-control" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Gía khuyến mại</label>
                                <input value="{{ old('sale') }}" id="sale" name="sale" type="text" class="form-control" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Liên kết</label>
                                <input value="{{ old('url') }}" type="text" class="form-control" id="url" name="url" placeholder="">
                            </div>

                            <div class="form-group">
                                <label>Chọn Danh Mục</label>
                                <select class="form-control" name="category_id" id="category_id">
                                    <option value="0">-- Chọn --</option>
                                    @foreach($data as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Vị trí</label>
                                <input value="{{ old('position') }}" min="0" type="number" class="form-control" id="position" name="position" placeholder="">
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input value="1" type="checkbox" name="is_active" id="is_active"> Hiển thị
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input value="1" type="checkbox" name="is_active" id="is_active"> Sản phẩm hot / Flash sale
                                </label>
                            </div>

                            <div class="form-group">
                                <label id="label-summary">Tóm tắt</label>
                                <textarea id="summary" name="summary" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>

                            <div class="form-group">
                                <label id="label-description">Mô tả</label>
                                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>

                            <div class="form-group">
                                <label id="label-description">Meta Title</label>
                                <textarea id="meta_title" name="meta_title" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>

                            <div class="form-group">
                                <label id="label-description">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" class="form-control" rows="3" placeholder="Enter ..."></textarea>
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
            CKEDITOR.replace( 'summary' );
            CKEDITOR.replace( 'description' );

            $('#price').on('keyup',function (e) {
                var price = $(this).val().replace(/[^0-9]/g,'');
                if (price > 0) {
                    price = parseInt(price.replaceAll(',',''));
                    price = new Intl.NumberFormat('ja-JP').format(price);
                }
                $(this).val(price);
            });

            $('#sale').on('keyup',function (e) {
                var price = $(this).val().replace(/[^0-9]/g,'');
                if (price > 0) {
                    price = parseInt(price.replaceAll(',',''));
                    price = new Intl.NumberFormat('ja-JP').format(price);
                }
                $(this).val(price);
            });

            if($('#sale').val !== '') {
                var price = $('#sale').val().replace(/[^0-9]/g,'');
                if (price > 0) {
                    price = parseInt(price.replaceAll(',',''));
                    price = new Intl.NumberFormat('ja-JP').format(price);
                }
                $('#sale').val(price);
            }

            if($('#price').val !== '') {
                var price = $('#price').val().replace(/[^0-9]/g,'');
                if (price > 0) {
                    price = parseInt(price.replaceAll(',',''));
                    price = new Intl.NumberFormat('ja-JP').format(price);
                }
                $('#price').val(price);
            }

            $('.btnCreate').click(function () {
                if ($('#title').val() === '') {
                    $('#title').notify('Bạn nhập chưa nhập tiêu đề','error');
                    document.getElementById('title').scrollIntoView();
                    return false;
                }

                if ($('#category_id').val() === 0 || $('#category_id').val() === '') {
                    $('#category_id').notify('Bạn chưa chọn danh mục','error');
                    document.getElementById('category_id').scrollIntoView();
                    return false;
                }

                var summary = CKEDITOR.instances["summary"].getData();

                if (summary === '') {
                    $('#label-summary').notify('Bạn nhập chưa nhập tóm tắt','error');
                    document.getElementById('label-summary').scrollIntoView();
                    return false;
                }

                var description = CKEDITOR.instances["description"].getData();

                if (description === '') {
                    $('#label-description').notify('Bạn nhập chưa nhập mô tả','error');
                    document.getElementById('label-description').scrollIntoView();
                    return false;
                }

                if ($('#meta_title').val() === '') {
                    $('#meta_title').notify('Bạn chưa chọn danh mục','error');
                    document.getElementById('meta_title').scrollIntoView();
                    return false;
                }

                if ($('#meta_description').val() === '') {
                    $('#meta_description').notify('Bạn chưa chọn danh mục','error');
                    document.getElementById('meta_description').scrollIntoView();
                    return false;
                }
            });
        });
    </script>
@endsection


