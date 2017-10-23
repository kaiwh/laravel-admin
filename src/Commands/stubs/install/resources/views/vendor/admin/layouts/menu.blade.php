<li>
    <a href="{{ route('admin') }}"><i class="fa fa-dashboard fa-fw"></i><span>{{ trans('admin::home.heading.catalog') }}</span></a>
</li>

{{-- 
<li id="menu-product">
    <a class="parent"><i class="fa fa-tags fa-fw"></i><span>商品目录</span></a>
    <ul>
        <li><a href="">分类管理</a></li>
        <li><a href="">商品管理</a></li>
        <li><a href="">评论管理</a></li>
    </ul>
</li>
--}}
@if(Auth::guard('admin')->user()->administrator)
<li id="menu-admin">
    <a  href="{{ route('admin.admin.index') }}"><i class="fa fa-user fa-fw"></i><span>{{ trans('admin::admin.heading.catalog') }}</span></a>
</li>
@endif
