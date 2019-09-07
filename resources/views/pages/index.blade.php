@extends('layout.layout')
@section('content')   
<section id="main-content">
    <section class="wrapper">
      <div class="panel panel-body">
        <section class="content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>
                    Danh sách đơn hàng 
                    @if($status==0)
                    chưa xác nhận
                    @elseif($status==1)
                    đã xác nhận
                    @elseif($status==2)
                    hoàn tất
                    @else 
                    bị huỷ
                    @endif
                    </b>
                </div>
                <div class="panel-body">
                    @if(count($bills)>0)
                    <table class="table table-striped">
                        <thead>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Khách hàng</th>
                            <th>Địa chỉ giao hàng</th>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Ghi chú</th>
                            @if($status==0 || $status==1)
                            <th>Tuỳ chọn</th>
                            @endif
                        </thead>
                        <tbody>
                            @foreach($bills as $bill)
                            <tr id="bill-{{$bill->id}}">
                                <td>DH-{{$bill->id}}</td>
                                {{-- <td>{{date('d-m-Y  H:m:s', strtotime($bill->date_order))}}</td> --}}
                                <td>{{$bill->date_order}}</td>
                                <td>
                                    <p>{{$bill->customer->name}}</p>
                                    <p>{{$bill->customer->email}}</p>
                                    <p>{{$bill->customer->phone}}</p>
                                </td>
                                <td>
                                        <p>{{$bill->customer->address}}</p></td>
                                <td>
                                    @foreach($bill->product as $product)
                                        <div>
                                            <p>{{$product->name}}</p>
                                        </div>
                                    @endforeach
                                </td>
                                {{$a = 0}}
                                <td>
                                    {{number_format($bill->promt_price)}}
                                    {{-- @foreach($bill->product as $product)
                                    @if($product->promotion_price==0)
                                    <p>{{number_format($product->price)}}</p>
                                    @else
                                    <p>{{number_format($product->promotion_price)}}</p>
                                    @endif

                                    @endforeach --}}
                                </td>
                                <td>{{$bill->note}}</td>
                                @if($status==0 || $status==1)
                                <td>
                                    <button style="width:100%" class="btn btn-danger btn-cancel" 
                                        data-id="{{$bill->id}}">Huỷ đơn hàng</button>
                                    @if($status==0)
                                    {{-- <button style="width:100%" class="btn btn-success btn-ok" data-id="{{$bill->id}}">Xác nhận</button> --}}
                                    @endif
                                <br>
                                @if($status==1)
                                    <button style="width:100%" class="btn btn-success btn-successd" 
                                        data-id="{{$bill->id}}">Hoàn tất</button> 
                                @endif
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$bills->links()}} 

                    @else
                    Chưa có đơn hàng
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

<div class="modal fade" id="myModa" role="dialog">
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
                    <button type="button" class="btn btn-primary" id="continue" data-id="null">Tiếp tục</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="myModall" role="dialog">
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
                    <button type="button" class="btn btn-primary" id="continued" data-id="null">Tiếp tục</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.btn-cancel').click(function(){
            var idBill = $(this).attr('data-id')
            console.log(idBill)
            $('.modal-title').text('Đơn hàng HD-'+idBill+' sẽ chuyển sang trạng thái huỷ!')
            $('#myModal').modal('show')
            $('#btn-continue').attr('data-id',idBill)
        })
        $('#btn-continue').click(function(){
            var idBill = $(this).attr('data-id')
            $.ajax({
                url:"{{route('updatebill')}}",
                type:'POST',
                data:{
                    id_bill:idBill,
                    status:3,
                    _token:"{{csrf_token()}}"
                },
                success:function(res){
                    // console.log(res)
                    if($.trim(res)=='ok'){
                        $('#bill-'+idBill).remove()
                        $('#myModal').modal('hide')
                        // alert('Huỷ đơn hàng thành công')
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

<script>
    $(document).ready(function(){
        $('.btn-successd').click(function(){
            var idBill = $(this).attr('data-id')
            $('.modal-title').text('ĐH HD-'+idBill+' sẽ chuyển sang trạng thái hoàn tất!')
            $('#myModa').modal('show')
            $('#continue').attr('data-id',idBill)
        })
        $('#continue').click(function(){
            var idBill = $(this).attr('data-id')
            $.ajax({
                url:"{{route('successbill')}}",
                type:'POST',
                data:{
                    id_bill:idBill,
                    status:2,
                    _token:"{{csrf_token()}}"
                },
                success:function(res){
                    // console.log(res)
                    if($.trim(res)=='ok'){
                        $('#bill-'+idBill).css("background-color", "yellow");
                        $('#myModa').modal('hide')
                        // alert('Hoàn tất đơn hàng')
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

<script>
    $(document).ready(function(){
        $('.btn-ok').click(function(){
            var idBill = $(this).attr('data-id');
            $('.modal-title').text('ĐH HD-'+idBill+' sẽ chuyển sang trạng thái xác nhận!');
            $('#myModall').modal('show')
            $('#continued').attr('data-id',idBill)
        })
        $('#continued').click(function(){
            var idBill = $(this).attr('data-id')
            $.ajax({
                url:"{{route('updatebill')}}",
                type:'POST',
                data:{
                    id_bill:idBill,
                    status:1,
                    _token:"{{csrf_token()}}"
                },
                success:function(res){
                    console.log(res)
                    if($.trim(res)=='ok'){
                        $('#bill-'+idBill).css("background-color", "yellow");
                        $('#myModall').modal('hide')
                        // alert('Hoàn tất đơn hàng')
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