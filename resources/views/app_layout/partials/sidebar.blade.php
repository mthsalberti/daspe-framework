<!-- SideNav slide-out button -->
<a href="#" data-activates="slide-out" class=" p-3 button-collapse">
    <i class="fas fa-bars"></i>
</a>

<!-- Sidebar navigation -->
<div id="slide-out" class="side-nav fixed wide sn-bg-1 slim ">
    <ul class="custom-scrollbar">
        <li>

            <div class="d-flex">
                <img style="max-height: 80px;"
                     src="/daspeweb_assets/img/logo_daspe.png"
                     class="pl-3 logo-navbar mx-auto " alt="">
            </div>
        </li>
        <li>
            <ul class="collapsible collapsible-accordion">
                {!! \Daspeweb\Framework\DaspewebMenu::renderMenuItem('App center', '/admin/app-center', 'fas fa-th') !!}
                {!! \Daspeweb\Framework\DaspewebMenu::renderMenuItemModel('users') !!}
                {!! \Daspeweb\Framework\DaspewebMenu::renderCollapseMenuItem(
                        'Segurança',
                        'fas fa-shield-alt',
                        [
                            \Daspeweb\Framework\DaspewebMenu::renderMenuItemModel('users'),
                            \Daspeweb\Framework\DaspewebMenu::renderMenuItemModel('roles'),
                            \Daspeweb\Framework\DaspewebMenu::renderMenuItem('Permissões', '/admin/custom/permission-control/all', 'fas fa-unlock-alt' ),
                        ])
                !!}

                {!! \Daspeweb\Framework\DaspewebMenu::renderCollapseMenuItem(
                    'Sistema',
                    'fas fa-cogs',
                    [
                        \Daspeweb\Framework\DaspewebMenu::renderMenuItemModel('list_views'),
                        \Daspeweb\Framework\DaspewebMenu::renderMenuItemModel('dw_models'),
                    ])
                !!}

                <li><a id="toggle" class="waves-effect"><i class="sv-slim-icon fas fa-angle-double-right"></i>Resumir</a></li>
            </ul>
        </li>
        <!--/. Side navigation links -->
    </ul>
    <div class="sidenav-bg rgba-blue-strong"></div>
</div>
<!--/. Sidebar navigation -->
