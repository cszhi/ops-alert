  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset("/s/dist/img/user2-160x160.jpg")}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{!!\Auth::user()->name!!}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
      {{--
      @foreach($menus as $menu)
        <li class="treeview {{isset($parent_active[$menu->active]) ? $parent_active[$menu->active] : ''}}">
          <a href="#"><i class="{!!$menu->icon!!}"></i> <span>{!!$menu->name!!}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @foreach($menu->submenus as $submenu)
              <li class="{{isset($active[$submenu->active]) ? $active[$submenu->active] : ''}}">
                <a href="{{route($submenu->url)}}"><i class="{!!$submenu->icon!!}"></i>{!!$submenu->name!!}</a>
              </li>
            @endforeach
          </ul>
        </li>
      @endforeach
      --}}
        <li class="treeview {{isset($parent_active['alert']) ? $parent_active['alert'] : ''}}">
          <a href="#"><i class="fa fa-fire-extinguisher"></i> <span>报警</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{isset($active['alert.user']) ? $active['alert.user'] : ''}}"><a href="{{route('alert.user')}}"><i class="fa fa-circle-o"></i>成员</a></li>
            <li class="{{isset($active['alert.group']) ? $active['alert.group'] : ''}}"><a href="{{route('alert.group')}}"><i class="fa fa-circle-o"></i>分组</a></li>
            <li class="{{isset($active['alert.log']) ? $active['alert.log'] : ''}}"><a href="{{route('alert.log')}}"><i class="fa fa-circle-o"></i>记录</a></li>
          </ul>
        </li>

        <li class="treeview {{isset($parent_active['admin']) ? $parent_active['admin'] : ''}}">
          <a href="#"><i class="fa fa-cog"></i> <span>管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{isset($active['admin.config']) ? $active['admin.config'] : ''}}"><a href="{{route('admin.config')}}"><i class="fa fa-circle-o"></i>配置</a></li>
            <li class="{{isset($active['admin.password']) ? $active['admin.password'] : ''}}"><a href="{{route('admin.password')}}"><i class="fa fa-circle-o"></i>密码</a></li>
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>