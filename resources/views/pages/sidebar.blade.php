<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('home')}}" class="brand-link">
      <img src="{{asset('assets/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Store Software</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/img/AdminLTELogo.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
          <li class="nav-item">
            <a href="{{route('live-store')}}" class="nav-link">
              <i class="nav-icon fas fa-store"></i>
              <p>Live Stock</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript::void(0)" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Products Name
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('save-product-name')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Product Name</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('product-name-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Name List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="javascript::void(0)" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Purchase
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('product-store')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('all-product')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Product List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="javascript::void(0)" class="nav-link">
              <i class="nav-icon fas fa-window-restore"></i>
              <p>
                Sold
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('usage-product')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sold Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('all-usage-product')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sold Product List</p>
                </a>
              </li>
            </ul>
          </li>
<!--           <li class="nav-item">
            <a href="javascript::void(0)" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Departments
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('department-store')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Department</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('all-department')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Department List</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item">
            <a href="javascript::void(0)" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Supplier
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('supplier-store')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('all-supplier')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('req-list')}}" class="nav-link">
              <i class="nav-icon fas fa-store"></i>
              <p>Requisation List</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('register-user')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('user-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User List</p>
                </a>
              </li>
          </ul>
          <li class="nav-item">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
              <i class="fa fa-sign-out-alt nav-icon"></i>
              <p>Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>