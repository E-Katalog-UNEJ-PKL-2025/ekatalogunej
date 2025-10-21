<aside id="sidebar" class="sidebar">
                @if(Route::is('profile.*'))
                <div id="profile-nav">
                    <nav class="sidebar-nav">
                        <h3 class="sidebar-section-title">Akun Saya</h3>
                        <a href="{{route('profile.index')}}" class="sidebar-link {{ Route::is('profile.index') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">Profil</a>
                        <a href="{{route('profile.edit')}}" class="sidebar-link {{ Route::is('profile.edit') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">Ubah Password</a>
                        <a href="{{route('dashboard')}}" class="sidebar-link {{ Route::is('dashboard') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">Dashboard</a>
                    </nav>
                </div>
                @else
                <div id="main-nav">
                    <nav class="sidebar-nav">
                        <a href="{{route('dashboard')}}" data-content="dashboardHome" class="sidebar-link {{ Route::is('dashboard') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">Dashboard</a>
                        @role('admin')
                        <!-- Admin -->
                        
                        {{-- Menu Khusus Admin (Dropdown) --}}
                            @if(Auth::user()->can('users.view') || Auth::user()->can('roles.view'))
                            <div x-data="{ open: {{ (Route::is('admin.users.*') || Route::is('admin.roles.*')) ? 'true' : 'false' }} }">
                                <button @click="open = ! open" class="sidebar-link {{ Route::is('admin.users.*','admin.roles.*') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">
                                    <span class="flex items-center">

                                        <span>Manajemen User</span>
                                    </span>
                                    <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                                <div x-show="open" class="mt-1 ml-4 space-y-2">
                                    @can('users.view')
                                    <li>
                                        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ Route::is('admin.users.*') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">
                                            Kelola User
                                        </a>
                                    </li>
                                    @endcan
                                    @can('roles.view')
                                    <li>
                                        <a href="{{ route('admin.roles.index') }}" class="sidebar-link {{ Route::is('admin.roles.*') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">
                                            Kelola Role
                                        </a>
                                    </li>
                                    @endcan
                                </div>
                            </div>
                            @endif
                        @endrole
                        @can('products.view')
                        @if(Auth::user()->supplierProfile && Auth::user()->supplierProfile->is_verified)
                            <!-- Supplier -->
                            <a href="{{ route('products.index') }}" data-content="testis" class="sidebar-link {{ Route::is('products.*') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">Produk Saya</a>
                        @endif
                        @endcan
                        <!-- Pimpinan -->
                        @role('pimpinan')
                        <a href="#" data-content="catalogReport" class="sidebar-link">Laporan Catalog</a>
                        @endrole
                        <!-- Verifikator -->
                        
                        @role('supplier')
                        @can('documents.view')
                        <a href="{{ route('documents.index') }}" data-content="verifySuppliers" class="sidebar-link {{ Route::is('documents.index') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">Verifikasi Supplier</a>
                        @endcan
                        @endrole
                        
                        
                        @can('suppliers.verify')
                        <a href="{{ route('verificator.suppliers.index') }}" data-content="dashboardHome" class="sidebar-link {{ Route::is('verificator.suppliers.*') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">Menu verifikasi</a>
                        @endcan

                        <!-- Operator Fakultas -->
                        <a href="{{route('profile.index')}}" data-content="ProfilSaya" class="sidebar-link {{ Route::is('profile.*') ? 'active' : 'text-white hover:bg-white hover:text-unej-green' }}">Profil Saya</a>


                    </nav>
                </div>
                @endif
                <div class="sidebar-footer">
                    <a href="#" class="sidebar-footerhelp">Bantuan</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class="sidebar-footerlogout">
                            Logout
                        </a>
                    </form>
                </div>
                {{-- <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const sidebarLinks = document.querySelectorAll('.sidebar-nav .sidebar-link');
                        const dropdownToggles = document.querySelectorAll('.has-dropdown');


                        
                    // Event listener for all sidebar links
                    sidebarLinks.forEach(link => {
                        if (!link.classList.contains('has-dropdown')) {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const contentId = this.dataset.content;
                                showContent(contentId);
                                setActiveLink(this);
                            });
                        }
                    });

                    // Event listener for dropdown toggles
                    dropdownToggles.forEach(toggle => {
                        toggle.addEventListener('click', function(e) {
                            e.preventDefault();
                            this.parentElement.classList.toggle('open');
                        });
                    });
                    });
                </script> --}}
            </aside>