@extends('layout.layout')
@section('content')   
<section id="main-content">
    <section class="wrapper">
      <div class="panel panel-body">
        <section class="content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>
                    Thêm sản phẩm mới
                    </b>
                </div>
                <div class="panel-body">
                    <form action="{{route('add-product')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm:</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>

                                 <div class="form-group">
                                    <label for="price">Đơn giá:</label>
                                    <input type="text" class="form-control" name="price" required>
                                </div>


                             </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Chọn loại:</label>
                                    <select name="type" class="form-control" required>
                                        @foreach($menu as $m)
                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Đơn giá khuyến mãi:</label>
                                    <input type="text" class="form-control" name="promotion_price" value="0">
                                </div>
                            </div>
                        </div>

                         <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Khuyến mãi kèm theo:</label>
                                        <textarea rows=5 class="form-control" name="promotion" id="promotion"></textarea>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="price">Mô tả:</label>
                                    <textarea rows="10" class="form-control" name="detail" id="detail"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="file" name="image" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="checkbox">
                                    <label>Sản phẩm đặc biệt</label>
                                    <label>
                                        <input value="1" type="radio" name="status" checked> Yes
                                    </label>
                                    <label>
                                        <input value="0" type="radio" name="status"> No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                        <label>Sản phẩm mới</label>
                                        <label>
                                            <input value="1" type="radio" name="new" checked> Yes
                                        </label>
                                        <label>
                                            <input value="0" type="radio" name="new"> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
                    </form>
                </div>
            </div>
        </section>
      </div>
    </section>
</section>
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace('detail')
CKEDITOR.replace('promotion')
 </script>
@endsection 