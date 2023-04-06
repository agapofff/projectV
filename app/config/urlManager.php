<?php

return [
    'class' => 'app\components\lang\LangUrlManager',
    'baseUrl' => '',
    'suffix' => '/',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'cache' => false,
    'rules' => [
        // Main
            '' => 'main/site/index',
            'video-v-hit' => 'main/site/video-v-hit',
            '<category:(nutraceuticals|cosmeceuticals)?>' => 'main/site/view',
            'error' => 'main/site/error',
            'privacy' => 'main/site/privacy',
            'terms-and-conditions' => 'main/site/terms-and-conditions',
            'component/<id:[0-9]+?>-<url:[a-z0-9-_]+?>' => 'main/component/view',
            'component/<id:[0-9]+?>' => 'main/component/index',
            'set-cookies' => 'main/site/set-cookies',

        // User
            '<_a:(login|logout)>' => 'auth/auth/<_a>',
            '<_a:(request|confirm)>' => 'auth/reset/<_a>',
            '<_a:(settings)>' => 'user/<_a>',

        // Store
            // Catalog
                'catalog/category-<category:[a-z0-9-]+?>/collection-<collection:[a-z0-9-]+?>' => 'store/default/catalog',
                'catalog/category-<category:[a-z0-9-]+?>' => 'store/default/catalog',
                'catalog' => 'store/default/catalog',
            // Product
                'product/<id:[0-9]+?>-<url:[a-z0-9-_]+?>' => 'store/default/product',
                'product/<id:[0-9]+?>' => 'store/default/product',
            // Cart
                'cart' => 'store/default/cart',
            // Thank you page
                'thank-you-page' => 'store/default/thank-you-page',
            // Referral
                'ref/<member_id:[A-Za-z0-9-_]+?>' => 'store/default/referral',

        // About
            'about/<type:(mass-media|blog)?>/add' => 'about/post/add',
            'about/<type:(mass-media|blog)?>/delete/<id:[0-9]+?>' => 'about/post/delete',
            'about/<type:(mass-media|blog)?>/form/<id:[0-9]+?>' => 'about/post/form',
            'about/<type:(mass-media|blog)?>/<id:[0-9]+?>-<url:[a-z0-9-_]+?>' => 'about/post/view',
            'about/<type:(mass-media|blog)?>/<id:[0-9]+?>' => 'about/post/view',
            'about/<type:(mass-media|blog)?>/<id:[0-9]+?>/<url:[a-z0-9-_]+?>' => 'about/post/view',
            'about/<type:(mass-media|blog)?>/page-<page:\d+>' => 'about/post/index',
            'about/<type:(mass-media|blog)?>' => 'about/post/index',
            'about/ambassadors/<id:[0-9]+?>' => 'about/ambassador/view',
            'about/ambassadors' => 'about/ambassador/index',
            'about/certificates' => 'about/certificates/index',
            'about/mission' => 'about/mission/index',
            'about/production' => 'about/production/index',
            'about/team' => 'about/team/index',

        // Contacts
            'sitemap' => 'contacts/sitemap/index',
            'mail/write' => 'contacts/contacts/write',
            'mail/call' => 'contacts/contacts/call',
            'delivery' => 'contacts/delivery/index/',
            'contact-<alias:[a-z_-]+?>' => 'contacts/contacts/index',
            'contacts' => 'contacts/contacts/index',
            'info/<url:[a-z0-9-_\/]+?>' => 'contacts/info/index',
    ],
];
