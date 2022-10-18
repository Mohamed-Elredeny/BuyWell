<?php $guard = '' ?>
<li>
    <a href="">
        <div class="parent-icon">
            <ion-icon name="home-sharp"></ion-icon>
        </div>
        @if(Auth::guard($guard)->check())
            @if(Auth::guard('admin')->user()->is_super_admin)
                <div class="menu-title">{{__('Super Admin Dashboard')}} </div>
            @else
                <div class="menu-title">{{__('Admin Dashboard')}} </div>
            @endif
        @endif
    </a>
</li>


<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="people-outline"></ion-icon>
        </div>
        <div class="menu-title">Manage Users</div>

    </a>
    <ul>
        <li>
            <a href="javascript: void(0);">
                <span>Users</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{route('brand.users.index')}}">
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('View All')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('brand.users.create')}}">
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('Add New User')}}</div>

                    </a>
                </li>

            </ul>
        </li>


    </ul>

</li>

<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="copy-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Categories')}} </div>

    </a>
    <ul>

        <li>
            <a href="{{route('brand.categories.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('brand.categories.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="duplicate-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Sub Categories')}} </div>

    </a>
    <ul>

        <li>
            <a href="{{route('brand.subCategories.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('brand.subCategories.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="duplicate-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Sub Sub Categories')}} </div>

    </a>
    <ul>

        <li>
            <a href="{{route('brand.subSubCategories.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('brand.subSubCategories.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="storefront-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Products')}} </div>

    </a>
    <ul>

        <li>
            <a href="{{route('brand.products.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('brand.products.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="albums-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Collages')}} </div>

    </a>
    <ul>

        <li>
            <a href="{{route('brand.collages.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('brand.collages.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="apps-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Orders')}} </div>

    </a>
    <ul>

        <li>
            <a href="{{route('brand.orders.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('brand.orders.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="wallet-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Transactions')}} </div>

    </a>
    <ul>

        <li>
            <a href="">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>
    </ul>
</li>
<li>
    <a href="{{route('brand.transactions.create')}}">
        <div class="parent-icon">
            <ion-icon name="book-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Reports')}} </div>

    </a>

</li>
@if(Auth::guard($guard)->check())

    @if(Auth::guard('admin')->user()->is_super_admin)

        <li>
            <a href="javascript: void(0);">
                <div class="parent-icon">
                    <ion-icon name="earth-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Countries')}} </div>

            </a>
            <ul>

                <li>
                    <a href="{{route('countries.index')}}">
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('View All')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('countries.create')}}">
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('Add New')}}</div>

                    </a>
                </li>
            </ul>
        </li>
    @endif
@endif
@if(Auth::guard($guard)->user())

    <li>
        <a href="javascript:;">
            <div class="parent-icon">
                <ion-icon name="settings-outline"></ion-icon>
            </div>
            <div class="menu-title">Settings</div>

        </a>
        <ul>

            <li>
                <a href="{{route('admin.orders.settings')}}">
                    <div class="parent-icon">
                        <ion-icon name="cube-outline"></ion-icon>
                    </div>
                    <div class="menu-title">{{__(' Order Settings ')}}</div>
                </a>
            </li>

        </ul>
    </li>
@endif
