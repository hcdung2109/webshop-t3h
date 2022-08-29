@extends('backend.layouts.main')

@section('content')
    <section class="content-header">
        <h1>
            Banner
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">Banner</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách banner</h3>
                        <a href="{{ route('admin.banner.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">TT</th>
                                <th>Hình ảnh</th>
                                <th>Tên</th>
                                <th>Loại</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($data as $key => $item)
                                @php

                                @endphp
                            <tr class="item-{{ $item->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($item->image && file_exists(public_path($item->image)))
                                        <img src="{{ asset($item->image) }}" width="100" height="75" alt="">
                                    @else
                                        <img src="{{ asset('upload/404.png') }}" width="100" height="75" alt="">
                                    @endif
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    @if($item->type == 1)
                                        Banner home
                                    @elseif($item->type == 2)
                                        Banner left
                                    @elseif($item->type ==3)
                                        Banner right
                                    @elseif($item->type == 4)
                                        Background
                                    @else
                                        None
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.banner.edit', ['banner' => $item->id]) }}"><span title="Chỉnh sửa" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>
                                    <span data-id="{{ $item->id }}" title="Xóa" class="btn btn-flat btn-danger deleteItem"><i class="fa fa-trash"></i></span>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $data->links() }}
                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $( document ).ready(function() {

            $('.deleteItem').click(function () {
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Bạn có muốn xóa?',
                    text: "Không thể khôi phục được dữ liệu",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url : '/admin/banner/'+id,
                            type: 'DELETE',
                            data: {},
                            success: function (res) {
                                if(res.status) {
                                    $('.item-'+id).remove();
                                }
                            },
                            error: function (res) {

                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
