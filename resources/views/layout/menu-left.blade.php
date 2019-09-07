<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <li class="sub-menu">
                <a class="@if(Request::segment(1)=='bill') active @endif" href="javascript:;" >
                    <i class=" fa fa-envelope"></i>
                    <span>Quản lý đơn hàng</span>
                </a>
                <ul class="sub">
                    <li><a  href="{{route('listbill',0)}}">Đơn hàng chưa xác nhận</a></li>
                    <li><a  href="{{route('listbill',1)}}">Đơn hàng đã xác nhận</a></li>
                    <li><a  href="{{route('listbill',2)}}">Đơn hàng đã hoàn tất</a></li>
                    <li><a  href="{{route('listbill',3)}}">Đơn hàng bị huỷ</a></li>
                </ul>
            </li>
            <li>
                <a class="@if(Request::segment(1)=='add-product') active @endif"  href="{{route('add-product')}}" >
                    <i class="fa fa-plus"></i>
                    <span>Thêm sản phẩm</span>
                </a>
            </li>
            <li class="sub-menu">
                <a class="@if(Request::segment(1)=='list-product') active @endif" href="javascript:;" >
                    <i class=" fa fa-bar-chart-o"></i>
                    <span>Loại sản phẩm</span>
                </a>
                <ul class="sub">
                    @foreach($menu as $m)
                        <li><a  href="{{route('list-product',$m->id)}}">{{$m->name}}</a></li>
                    @endforeach
                </ul>
            </li>
            
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>