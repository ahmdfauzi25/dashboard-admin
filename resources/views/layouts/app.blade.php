<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Boilerplate') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
    <style>
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
        }
        .navbar-gradient {
            background: linear-gradient(90deg, #ffffff 0%, #f8fafc 100%);
        }
        .sidebar-toggle {
            transition: all 0.3s ease;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        .main-content-expanded {
            margin-left: 0;
        }
        /* Animate width/margin for expand/collapse */
        #sidebar {
            transition: width 0.3s ease, transform 0.3s ease;
        }
        .main-content {
            transition: margin-left 0.3s ease;
        }
        @media (min-width: 768px) {
            .sidebar-toggle {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 16rem;
            }
        }

        /* Modern Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.4s ease-out;
        }

        /* Glassmorphism Effects */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Modern Shadow Effects */
        .shadow-modern {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .shadow-modern-lg {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Hover Glow Effects */
        .hover-glow {
            transition: all 0.3s ease;
        }

        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
        }

        /* Modern Loading Spinner */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #5a6fd8, #6a4190);
        }
        /* Collapsible Sidebar (icon-only when collapsed) */
        body.sidebar-collapsed #sidebar {
            width: 5rem;
        }
        @media (min-width: 768px) {
            body.sidebar-collapsed .main-content {
                margin-left: 5rem;
            }
        }
        body.sidebar-collapsed #sidebar .sidebar-text {
            display: none !important;
        }
        body.sidebar-collapsed #sidebar a svg {
            margin-right: 0 !important;
        }
        body.sidebar-collapsed #sidebar .logout-icon {
            margin-right: 0 !important;
            display: inline-block !important;
            color: #ffffff !important;
        }
        body.sidebar-collapsed #sidebar button svg.logout-icon {
            margin-right: 0 !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @auth
        <div class="min-h-screen">
            <!-- Sidebar -->
            <div id="sidebar" class="sidebar-toggle fixed inset-y-0 left-0 z-50 w-64 sidebar-gradient shadow-xl transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between h-16 px-4 bg-black bg-opacity-20">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-white font-semibold text-base tracking-wide sidebar-text">
                            Dashboard Admin
                        </span>

                    </div>
                    <button id="sidebar-collapse-toggle" type="button" class="hidden md:inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white focus:outline-none" title="Collapse sidebar">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Sidebar Navigation -->
                <nav class="mt-8 px-4">
                    <div class="space-y-2">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            <span class="sidebar-text">Dashboard</span>
                        </a>

                        <!-- User Management -->
                        @permission('users.view')
                            <a href="{{ route('users.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('users.*') ? 'bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                <span class="sidebar-text">Users</span>
                            </a>
                        @endpermission


                        <!-- Role Management -->
                        @permission('roles.view')
                        <a href="{{ route('roles.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('roles.*') ? 'bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span class="sidebar-text">Roles & Permissions</span>
                        </a>
                        <!-- Server Utilities -->
                        <a href="{{ route('utils.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ (request()->routeIs('utils.index') || request()->routeIs('utils.maintenance')) ? 'bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3a.75.75 0 00-.75.75V6H6.75A.75.75 0 006 6.75v2.25H3.75a.75.75 0 00-.75.75v3a.75.75 0 00.75.75H6v2.25c0 .414.336.75.75.75H9v2.25c0 .414.336.75.75.75h3a.75.75 0 00.75-.75V18h2.25a.75.75 0 00.75-.75V15h2.25a.75.75 0 00.75-.75v-3a.75.75 0 00-.75-.75H18V6.75A.75.75 0 0017.25 6H15V3.75A.75.75 0 0014.25 3h-3z" />
                            </svg>
                            <span class="sidebar-text">Server Utilities</span>
                        </a>
                        <a href="{{ route('utils.sessions') }}" class="group mt-1 flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('utils.sessions') ? 'bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 19h14M5 11a2 2 0 012-2h10a2 2 0 012 2M5 19a2 2 0 002 2h10a2 2 0 002-2" />
                            </svg>
                            <span class="sidebar-text">Session History</span>
                        </a>
                        @endpermission

                        <!-- Account Settings -->
                        <div class="pt-4 mt-4 border-t border-blue-400 border-opacity-30">
                            <p class="px-4 text-xs font-semibold text-blue-200 uppercase tracking-wider sidebar-text">Account</p>
                            <div class="mt-2 space-y-2">
                                <a href="{{ route('profile.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('profile.*') ? 'bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="sidebar-text">Profile Settings</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </nav>

                <!-- User Profile Section -->
                <div class="absolute bottom-0 w-full p-4">
                    <div class="bg-white bg-opacity-10 rounded-lg p-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-blue-600">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                            <div class="ml-3 flex-1 sidebar-text">
                                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-blue-200 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="mt-3" id="logout-form">
                            @csrf
                            <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-blue-100 bg-white bg-opacity-10 rounded-md hover:bg-opacity-20 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 logout-icon text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="sidebar-text">Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div id="main-content" class="main-content transition-all duration-300 ease-in-out">
                <!-- Top Navigation Bar -->
                <nav class="navbar-gradient shadow-sm border-b border-gray-200">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <!-- Mobile menu button -->
                                <button id="sidebar-toggle" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>

                                <!-- Breadcrumb -->
                                <nav class="ml-4 md:ml-0">
                                    <ol class="flex items-center space-x-2 text-sm">
                                        <li>
                                            <div class="flex items-center">
                                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                                                </svg>
                                                <a href="{{ route('dashboard') }}" class="ml-2 text-gray-500 hover:text-gray-700">Dashboard</a>
                                            </div>
                                        </li>
                                        @if(!request()->routeIs('dashboard'))
                                            <li>
                                                <div class="flex items-center">
                                                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="ml-2 text-gray-700 font-medium">
                                                        @if(request()->routeIs('users.*'))
                                                            Users Management
                                                        @elseif(request()->routeIs('roles.*'))
                                                            Roles & Permissions
                                                        @elseif(request()->routeIs('profile.*'))
                                                            Profile Settings
                                                        @else
                                                            {{ ucwords(str_replace(['-', '_'], ' ', request()->route()->getName())) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </li>
                                        @endif
                                    </ol>
                                </nav>
                            </div>

                            <!-- Right side items -->
                            <div class="flex items-center space-x-4">
                                <!-- Notifications -->
                                <button class="p-2 text-gray-400 hover:text-gray-600 relative">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-8a4.5 4.5 0 00-4.5-4.5h-1"></path>
                                    </svg>
                                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                                </button>

                                <!-- Search -->
                                <div class="relative hidden md:block">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" placeholder="Quick search..." class="block w-64 pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <main class="p-6 min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-purple-50/30">
                    <!-- Modern Flash Messages -->
                    @if (session('message'))
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-lg backdrop-blur-sm" role="alert">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ session('message') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-lg backdrop-blur-sm" role="alert">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </main>

                <!-- Modern Footer -->
                <footer class="bg-gradient-to-r from-white via-gray-50 to-white border-t border-gray-200 shadow-lg">
                    <div class="px-6 py-6">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-3 text-gray-600">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ config('app.name', 'Laravel Boilerplate') }}</div>
                                    <div class="text-xs text-gray-500">© {{ date('Y') }} All rights reserved.</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6 text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs font-medium">Version 1.0.0</span>
                                </div>
                                <div class="hidden md:flex items-center space-x-4">
                                    <a href="#" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>Documentation</span>
                                    </a>
                                    <a href="#" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <span>Support</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Mobile sidebar overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 md:hidden transform opacity-0 pointer-events-none transition-opacity duration-300 ease-linear"></div>

        <script>
            // Sidebar toggle functionality
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebar-toggle');
                const sidebarCollapseToggle = document.getElementById('sidebar-collapse-toggle');
                const sidebar = document.getElementById('sidebar');
                const sidebarOverlay = document.getElementById('sidebar-overlay');
                const mainContent = document.getElementById('main-content');

                function toggleSidebar() {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebarOverlay.classList.toggle('opacity-0');
                    sidebarOverlay.classList.toggle('pointer-events-none');
                }

                // Expand/Collapse (icon-only) with persistence
                const COLLAPSE_KEY = 'sidebar:collapsed';
                const applyCollapsed = () => {
                    if (localStorage.getItem(COLLAPSE_KEY) === '1') {
                        document.body.classList.add('sidebar-collapsed');
                    } else {
                        document.body.classList.remove('sidebar-collapsed');
                    }
                };
                applyCollapsed();

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', toggleSidebar);
                }

                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', toggleSidebar);
                }

                if (sidebarCollapseToggle) {
                    sidebarCollapseToggle.addEventListener('click', function() {
                        const next = localStorage.getItem(COLLAPSE_KEY) === '1' ? '0' : '1';
                        localStorage.setItem(COLLAPSE_KEY, next);
                        applyCollapsed();
                    });
                }
            });
        </script>
    @else
        <!-- Not authenticated content -->
        <div class="min-h-screen flex items-center justify-center">
            <div class="text-center">
                <p class="text-gray-500">Please log in to access the application.</p>
                <a href="{{ route('login') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Login</a>
            </div>
        </div>
    @endauth

    @livewireScripts

    <!-- SweetAlert2 for modern alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Modern Alert System
        window.showAlert = function(type, title, text, options = {}) {
            const config = {
                title: title,
                text: text,
                icon: type,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'OK',
                ...options
            };

            return Swal.fire(config);
        };

        window.showConfirm = function(title, text, confirmText = 'Yes, proceed!', cancelText = 'Cancel') {
            return Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true
            });
        };

        window.showSuccess = function(title, text = '') {
            return showAlert('success', title, text);
        };

        window.showError = function(title, text = '') {
            return showAlert('error', title, text);
        };

        window.showWarning = function(title, text = '') {
            return showAlert('warning', title, text);
        };

        window.showInfo = function(title, text = '') {
            return showAlert('info', title, text);
        };

        // Toast notifications
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        window.showToast = function(type, title) {
            Toast.fire({
                icon: type,
                title: title
            });
        };

        // Handle Laravel flash messages with modern alerts
        @if (session('message'))
            showToast('success', '{{ session('message') }}');
        @endif

        @if (session('error'))
            showToast('error', '{{ session('error') }}');
        @endif

        @if (session('warning'))
            showToast('warning', '{{ session('warning') }}');
        @endif

        @if (session('info'))
            showToast('info', '{{ session('info') }}');
        @endif

        // Livewire integration
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-alert', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                showAlert(data.type, data.title, data.text, data.options || {});
            });

            Livewire.on('show-toast', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                showToast(data.type, data.title);
            });

            Livewire.on('show-confirm', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                showConfirm(data.title, data.text, data.confirmText, data.cancelText)
                    .then((result) => {
                        if (result.isConfirmed && data.method) {
                            Livewire.dispatch(data.method, data.params || {});
                        }
                    });
            });
        });

        // Logout confirmation
        function confirmLogout() {
            showConfirm(
                'Sign Out',
                'Are you sure you want to sign out?',
                'Yes, sign out',
                'Cancel'
            ).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>
</html>
