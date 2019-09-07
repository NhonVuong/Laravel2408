@extends('layout.layout')
@section('content')   
<section id="main-content">
    <section class="wrapper">
      <div class="panel panel-body">
        <section class="content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>
                    Cập nhật sản phẩm <i>{{$product->name}}</i>
                    </b>
                </div>
                <div class="panel-body">
                    <form action="{{route('update-product',$product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm:</label>
                                    <input type="text" class="form-control" name="name" value="{{$product->name}}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="price">Đơn giá:</label>
                                    <input type="text" class="form-control" name="price"
                                    value="{{$product->price}}">
                                </div>
                                
                                
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Chọn loại:</label>
                                    <select name="type" class="form-control">
                                        @foreach($menu as $m)
                                        <option @if($product->id_type==$m->id) selected @endif value="{{$m->id}}">{{$m->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="checkbox">
                                    <label for="price">Đơn giá khuyến mãi:</label>
                                    <input type="text" class="form-control" name="promotion_price" value="{{$product->promotion_price}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Khuyến mãi kèm theo:</label>
                                        <textarea rows=5 class="form-control" name="promotion" id="promotion">{{$product->promotion}}</textarea>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="price">Mô tả:</label>
                                    <textarea rows="10" class="form-control" name="detail" id="detail">{{$product->detail}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <img src="../shop2408/public/source/images/products-images/{{$product->image}}" height="80px">
                                    <input type="file" name="image">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="checkbox">
                                    <label>Sản phẩm đặc biệt</label>
                                    <label>
                                        <input value="1" type="radio" name="status" @if($product->status==1) checked @endif> Yes
                                    </label>
                                    <label>
                                        <input value="0" type="radio" name="status" @if($product->status==0) checked @endif> No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="checkbox">
                                    <label>Sản phẩm mới</label>
                                    <label>
                                        <input value="1" type="radio" name="new" @if($product->new==1) checked @endif> Yes
                                    </label>
                                    <label>
                                        <input value="0" type="radio" name="new" @if($product->new==0) checked @endif> No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Cập nhật</button>
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