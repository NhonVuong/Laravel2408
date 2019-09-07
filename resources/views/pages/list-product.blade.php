@extends('layout.layout')
@section('content')   
<section id="main-content">
    <section class="wrapper">
      <div class="panel panel-body">
        <section class="content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>
                    Danh sách sản phẩm loại <i>{{$type->name}}</i>
                    </b>
                </div>
                <div class="panel-body">
                    @if(count($listProduct)>0)
                    <table class="table table-striped">
                        <thead>
                            <th>Mã SP</th>
                            <th>Tên SP</th>
                            <th>Hình</th>
                            {{-- <th>Sản phẩm</th> --}}
                            <th>Đơn giá</th>
                            <th>Đơn giá khuyến mãi</th>
                            <th>Ghi chú</th>
                            <th>Tuỳ chọn</th>
                        </thead>
                        <tbody>
                            @foreach($listProduct as $product)
                            <tr id="bill-{{$product->id}}">
                                <td>SP-{{$product->id}}</td>
                                <td>
                                    {{$product->name}}
                                </td>
                                
                                <td>
                                <img src="products-images/{{$product->image}}" height="80px">
                                </td>
                                <td>
                                    {{number_format($product->price)}}
                                </td>
                                <td>
                                    @if($product->promotion_price==0)
                                    không có
                                    @else
                                    {{number_format($product->promotion_price)}}
                                    @endif
                                </td>
                                 <td>...</td>
                                <td>
                                    <button class="btn btn-success" style="width:50%">
                                        <a href="{{route('update-product',$product->id)}}" style="color:#fff">
                                            Cập nhật
                                        </a>
                                    </button>
                                    <button style="width:50%" class="btn btn-danger btn-deleted" data-id="{{$product->id}}">
                                        Xoá
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$listProduct->links()}}

                     @else
                    Chưa có sản phẩm
                    @endif
                </div>
            </div>
        </section>
      </div>
    </section>
</section>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <form action="" method="post">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
    
                     </h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ</button>
                    <button type="button" class="btn btn-primary" id="btn-continue" data-id="null">Tiếp tục</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.btn-deleted').click(function(){
            var idBill = $(this).attr('data-id')
            $('.modal-title').text('Bạn có chắc sẽ xoá sản phẩm SP-'+idBill+' ?')
            $('#myModal').modal('show')
            $('#btn-continue').attr('data-id',idBill)
        })
        $('#btn-continue').click(function(){
            var idBill = $(this).attr('data-id')
            $.ajax({
                url:"{{route('delete-product')}}",
                type:'POST',
                data:{
                    id:idBill,
                    // deleted:1,
                    _token:"{{csrf_token()}}"
                },
                success:function(res){
                    // console.log(res)
                    if(res.result == true){
                        $('#bill-'+idBill).remove()
                        $('#myModal').modal('hide')
                        // alert('Xoá sản phẩm thành công')
                    }
                    else 
                        alert('Vui lòng thử lại')
                },
                error:function(){
                    console.log('errr')
                }
            })
        })

    })
</script>
 @endsection 