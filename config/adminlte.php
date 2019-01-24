<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Cpanel',

    'title_prefix' => '',

    'title_postfix' => ' - admins and customer services',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Ospaa</b>',

    'logo_mini' => '<b>Ospaa</b>',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'purple',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => 'fixed',


    'collapse_sidebar' => false,

	

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',



    'menu' => [
        
        [
            'text'    => 'المستخدمين',
            'route'   => 'cpanel',
            'icon'    => 'user',
			'can' =>'boss'
        ],
        [
            'text' => 'الاعلانات',
            'route'  => 'ads.all',
            'icon' => 'buysellads',
			'can' =>'admin'			
        ],
        [
            'text' => 'الاقسام',
            'route'  => 'category.all',
            'icon' => 'shopping-cart ',
			'can' =>'admin'			
        ],
        [
            'text' => 'كلمات البحث',
            'route'  => 'tag.all',
            'icon' => 'adn ',
			'can' =>'admin'

        ],[
            'text' => 'الدعم الفني ',
            'route'  => 'discuss',
            'icon' => 'question',
			'can' =>'customer-service'
        ],
    
	],

   

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],



    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
