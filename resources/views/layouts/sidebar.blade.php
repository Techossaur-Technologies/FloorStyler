<aside id="menu">
    <div id="navigation">

        <div class="profile-picture">
            @if(!empty(Auth::user()->user_image))
                {!! HTML::image(Auth::user()->image_path, Auth::user()->fname, array('class'=>'img-circle m-b', 'width'=>'70', 'height'=>'70')) !!}
            @else
                {!!HTML::image('storage/user_images/default.png', 'alt', array('class'=>'img-circle m-b', 'width'=>'70', 'height'=>'70'))!!}
            @endif
            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">Hello {{Auth::user()->fname}}!</span>
            </div>
        </div>

        <?php
            if (Auth::user()->user_type == 'ADMIN') {
                $parent_match = ['parent_id' => '0', 'admin_access' => 'YES'];
            } elseif (Auth::user()->user_type == 'SUPERUSER') {
                $parent_match = ['parent_id' => '0', 'superuser_access' => 'YES'];
            } elseif (Auth::user()->user_type == 'USER') {
                $parent_match = ['parent_id' => '0', 'user_access' => 'YES'];
            } elseif (Auth::user()->user_type == 'AGENT') {
                $parent_match = ['parent_id' => '0', 'agency_access' => 'YES'];
            } else {
                $parent_match = ['parent_id' => ''];
            }
                $parent = DB::table('menus')->where($parent_match)->get();

        ?>
        <ul class="nav" id="side-menu">
            @foreach($parent as $parent)
                @if($parent->menu_id == $live['parent'])
                    <li class="active"><a href="#"><span class="nav-label">
                    {{$parent->menu_name}}
                @else
                    <li><a href="#"><span class="nav-label">
                    {{$parent->menu_name}}
                @endif
                    <?php
                        if (Auth::user()->user_type == 'ADMIN') {
                            $menu_match = ['parent_id' => $parent->menu_id, 'admin_access' => 'YES'];
                        } elseif (Auth::user()->user_type == 'SUPERUSER') {
                            $menu_match = ['parent_id' => $parent->menu_id, 'superuser_access' => 'YES'];
                        } elseif (Auth::user()->user_type == 'USER') {
                            $menu_match = ['parent_id' => $parent->menu_id, 'user_access' => 'YES'];
                        } elseif (Auth::user()->user_type == 'AGENT') {
                            $menu_match = ['parent_id' => $parent->menu_id, 'agency_access' => 'YES'];
                        } else {
                            $menu_match = ['parent_id' => ''];
                        }
                        $menu = DB::table('menus')->where($menu_match)->get();
                    ?>
                </span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                @foreach($menu as $menu)
                    @if($menu->menu_id == $live['menu'])
                        <li class="active">{!!HTML::link($menu->menu_page, $menu->menu_name)!!}</li>
                    @else
                        <li>{!!HTML::link($menu->menu_page, $menu->menu_name)!!}</li>
                    @endif
                @endforeach
                </ul></li>
            @endforeach

        </ul>
    </div>
</aside>
