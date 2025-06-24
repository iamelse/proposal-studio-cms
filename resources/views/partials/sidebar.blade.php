<!-- ===== Sidebar Start ===== -->
<aside
   :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
   class="sidebar fixed left-0 top-0 z-40 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
<!-- SIDEBAR HEADER -->
<div
      :class="sidebarToggle ? 'justify-center' : 'justify-between'"
      class="flex items-center gap-2 pt-8 sidebar-header pb-7"
   >
    <a class="hidden lg:block" href="{{ route('be.dashboard.index') }}"> <!-- default no class -->
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <!-- Light mode logo -->
        <div class="flex items-center space-x-2 dark:hidden">
          <img
              class="h-10 w-auto rounded"
              src="{{ getLogoImagePath($settings) }}"
              alt="Logo"
          />
          <span class="ps-1 text-2xl font-bold text-gray-900 dark:text-white">
            Proposal Studio
          </span>
        </div>

        <!-- Dark mode logo -->
        <div class="flex items-center space-x-2 hidden dark:flex">
          <img
              class="h-10 w-auto rounded"
              src="{{ getLogoImagePath($settings) }}"
              alt="Logo"
          />
          <span class="ps-1 text-2xl font-bold text-gray-900 dark:text-white">
            Proposal Studio
          </span>
        </div>
      </span>

      <!-- Logo icon when sidebar is toggled -->
      <img
          class="logo-icon hidden lg:block rounded h-10 w-10"
          :class="{ 'lg:block': sidebarToggle, 'lg:hidden': !sidebarToggle }"
          src="{{ getLogoImagePath($settings) }}"
          alt="Logo"
      />
    </a>
</div>
<!-- SIDEBAR HEADER -->
<div
    id="sidebar-scroll-container"
    x-init="
      $nextTick(() => {
         const activeItem = $el.querySelector('.menu-item-active');
         if (activeItem) {
            $el.scrollTop = activeItem.offsetTop - $el.clientHeight / 2;
         }
      })"
     class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
>
   <!-- Sidebar Menu -->
   <nav>
      <!-- Menu Group -->
      <div>
         @php
            use App\Enums\PermissionEnum;

            $menus = collect([
                [
                    'title' => 'Main',
                    'order' => 1,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => 'be.dashboard',
                            'route' => 'be.dashboard.index',
                            'icon' => 'bx-home', // dashboard = home icon lebih umum
                            'label' => 'Dashboard',
                            'permission' => PermissionEnum::READ_DASHBOARD
                        ],
                    ]
                ],
                [
                    'title' => 'Content Management',
                    'order' => 2,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => [
                                'be.post.index',
                                'be.post.create',
                                'be.post.edit'
                            ],
                            'exact' => true,
                            'route' => 'be.post.index',
                            'icon' => 'bx-news', // sudah oke untuk Posts
                            'label' => 'Posts',
                            'permission' => PermissionEnum::READ_POST
                        ],
                        [
                            'order' => 2,
                            'active' => 'be.post-category',
                            'route' => 'be.post-category.index',
                            'icon' => 'bx-category', // sudah tepat untuk Categories
                            'label' => 'Categories',
                            'permission' => PermissionEnum::READ_POST_CATEGORY
                        ],
                    ]
                ],
                [
                    'title' => 'Homepage Builder',
                    'order' => 3,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => 'be.home.hero',
                            'route' => 'be.home.hero.index',
                            'icon' => 'bx-image', // hero = gambar
                            'label' => 'Hero',
                            'permission' => PermissionEnum::UPDATE_HOME_HERO
                        ],
                        [
                            'order' => 2,
                            'active' => 'be.home.about',
                            'route' => 'be.home.about.index',
                            'icon' => 'bx-user', // about us biasanya user/profile icon
                            'label' => 'About Us',
                            'permission' => PermissionEnum::UPDATE_HOME_ABOUT
                        ],
                        [
                            'order' => 3,
                            'active' => 'be.home.our-service',
                            'route' => 'be.home.our-service.index',
                            'icon' => 'bx-briefcase', // service biasanya icon briefcase
                            'label' => 'Our Service',
                            'permission' => PermissionEnum::UPDATE_HOME_OUR_SERVICE
                        ],
                        [
                            'order' => 4,
                            'active' => 'be.home.proposal',
                            'route' => 'be.home.proposal.index',
                            'icon' => 'bx-file', // proposal = dokumen/file icon
                            'label' => 'Proposal',
                            'permission' => PermissionEnum::UPDATE_HOME_PROPOSAL
                        ],
                        [
                            'order' => 5,
                            'active' => 'be.home.event',
                            'route' => 'be.home.event.index',
                            'icon' => 'bx-calendar-event', // event = kalender acara
                            'label' => 'Event',
                            'permission' => PermissionEnum::UPDATE_HOME_EVENT
                        ],
                        [
                            'order' => 6,
                            'active' => 'be.home.review',
                            'route' => 'be.home.review.index',
                            'icon' => 'bx-comment-detail', // review = komentar/ulasan
                            'label' => 'Review',
                            'permission' => PermissionEnum::UPDATE_HOME_REVIEW
                        ],
                        [
                            'order' => 7,
                            'active' => 'be.home.faq',
                            'route' => 'be.home.faq.index',
                            'icon' => 'bx-help-circle', // FAQ = icon tanda tanya
                            'label' => 'Frequently Asked Question',
                            'permission' => PermissionEnum::UPDATE_HOME_FAQ
                        ],
                        [
                            'order' => 7,
                            'active' => 'be.home.cta',
                            'route' => 'be.home.cta.index',
                            'icon' => 'bx-rocket', // call to action cocok
                            'label' => 'Call To Action',
                            'permission' => PermissionEnum::UPDATE_HOME_CTA
                        ],
                    ]
                ],
                [
                    'title' => 'Master Data',
                    'order' => 5,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => 'be.feature',
                            'route' => 'be.feature.index',
                            'icon' => 'bx-star', // fitur/feature = star icon
                            'label' => 'Features',
                            'permission' => PermissionEnum::READ_FEATURE
                        ],
                        [
                            'order' => 2,
                            'active' => 'be.our-service-list',
                            'route' => 'be.our-service-list.index',
                            'icon' => 'bx-briefcase', // service list
                            'label' => 'Services',
                            'permission' => PermissionEnum::READ_OUR_SERVICE
                        ],
                        [
                            'order' => 3,
                            'active' => 'be.proposal',
                            'route' => 'be.proposal.index',
                            'icon' => 'bx-file', // proposal list
                            'label' => 'Proposals',
                            'permission' => PermissionEnum::READ_PROPOSAL
                        ],
                        [
                            'order' => 4,
                            'active' => 'be.event',
                            'route' => 'be.event.index',
                            'icon' => 'bx-calendar-event', // event list
                            'label' => 'Events',
                            'permission' => PermissionEnum::READ_EVENT
                        ],
                        [
                            'order' => 5,
                            'active' => 'be.review',
                            'route' => 'be.review.index',
                            'icon' => 'bx-comment-detail', // review list
                            'label' => 'Reviews',
                            'permission' => PermissionEnum::READ_REVIEW
                        ],
                        [
                            'order' => 6,
                            'active' => 'be.faq',
                            'route' => 'be.faq.index',
                            'icon' => 'bx-help-circle', // FAQ = icon tanda tanya
                            'label' => 'Frequently Asked Questions',
                            'permission' => PermissionEnum::READ_FAQ
                        ],
                        [
                            'order' => 7,
                            'active' => 'be.social-media',
                            'route' => 'be.social-media.index',
                            'icon' => 'bx-share-alt', // social media = share icon
                            'label' => 'Social Media',
                            'permission' => PermissionEnum::READ_SOCIAL_MEDIA
                        ],
                    ]
                ],
                [
                    'title' => 'Settings',
                    'order' => 99,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => 'be.settings.general',
                            'route' => 'be.settings.general.index',
                            'icon' => 'bx-wrench', // general = umum
                            'label' => 'General',
                            'permission' => PermissionEnum::UPDATE_SETTING_GENERAL
                        ],
                        [
                            'order' => 2,
                            'active' => 'be.role.and.permission',
                            'route' => 'be.role.and.permission.index',
                            'icon' => 'bx-lock-alt', // role & permission = lock icon
                            'label' => 'Role & Permissions',
                            'permission' => PermissionEnum::READ_ROLE
                        ],
                        [
                            'order' => 3,
                            'active' => [
                                'be.user.index',
                                'be.user.create',
                                'be.user.edit'
                            ],
                            'exact' => true,
                            'route' => 'be.user.index',
                            'icon' => 'bx-user', // users
                            'label' => 'Users',
                            'permission' => PermissionEnum::READ_USER
                        ],
                    ]
                ]
            ]);

            $userPermissions = Auth::user()->permissions;

            // Filter and sort menus based on user permissions
            $filteredMenus = $menus->map(function ($menu) use ($userPermissions) {
               $menu['children'] = collect($menu['children'])
                  ->filter(fn($child) => Auth::user()->can($child['permission'], $userPermissions))
                  ->sortBy('order'); // Sort children
               return $menu;
            })->filter(fn($menu) => $menu['children']->isNotEmpty()) // Remove empty parents
            ->sortBy('order'); // Sort parents
         @endphp

         <div class="mt-5 lg:mt-0">
            @foreach ($filteredMenus as $menu)
               <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                  {{ $menu['title'] }}
               </h3>
               <ul class="flex flex-col gap-4 mb-6">
                  @foreach ($menu['children'] as $child)
                     @php
                           $isActive = is_array($child['active'])
                              ? collect($child['active'])->some(fn($route) => request()->routeIs($route . ($child['exact'] ?? false ? '' : '*')))
                              : request()->routeIs($child['active'] . ($child['exact'] ?? false ? '' : '*'));
                     @endphp
                     <li>
                        <a href="{{ route($child['route']) }}"
                           class="menu-item group {{ $isActive ? 'menu-item-active' : 'menu-item-inactive' }}">
                           <i class="bx bx-sm {{ $child['icon'] }}"></i>
                           {{ $child['label'] }}
                        </a>
                     </li>
                  @endforeach
               </ul>
            @endforeach
         </div>
      </div>
      <!-- Menu Group -->
   </nav>
   <!-- Sidebar Menu -->
</div>
</aside>
<!-- ===== Sidebar End ===== -->
