@php
    $id = Auth::user()->id;
    $vendor = \App\Models\User::query()->find($id);
@endphp
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Vendor</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('vendor.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        @if($vendor->status ==='active')
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-cookie'></i>
                    </div>
                    <div class="menu-title">Product manage</div>
                </a>
                <ul>
                    <li> <a href="#"><i class="bx bx-right-arrow-alt"></i>All Product</a>
                    </li>
                    <li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">All Order</div>
                </a>
                <ul>
                    <li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Email</a>
                    </li>
                    <li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Chat Box</a>
                    </li>
                </ul>
            </li>
        @endif
        <li>
            <a href="#">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Support</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
