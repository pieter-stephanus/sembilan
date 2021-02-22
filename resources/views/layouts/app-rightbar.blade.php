@section('right-sidebar')
  <div class="wrapper">
    <!-- The Right Sidebar -->
    <aside class="control-sidebar control-sidebar-light">
      <!-- Content of the sidebar goes here -->
      <ul class="nav nav-treeview" style="display: block;">
        <li class="nav-item">
          <a class="nav-link  " href="#">
            <i class="far fa-fw fa-circle "></i>
            Induk
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a class="nav-link  " href="#">
                <i class="far fa-fw fa-circle "></i>
                Anak
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link  " href="#">
                <i class="far fa-fw fa-circle "></i>
                Saudara
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </aside>
    <!-- The sidebar's background -->
    <!-- This div must placed right after the sidebar for it to work-->
    <div class="control-sidebar-bg"></div>
  </div>
@stop
