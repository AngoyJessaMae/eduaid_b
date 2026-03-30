<nav class="bg-white/95 backdrop-blur shadow-md border-b border-gray-200 sticky top-0 z-40">
    @php
        $brandName = config('app.name', 'EduAid');
        $logoPath = config('app.brand_logo');
        $hasLogo = is_string($logoPath) && $logoPath !== '' && file_exists(public_path($logoPath));
    @endphp
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    @if($hasLogo)
                        <div class="brand-logo-frame brand-logo-frame-nav">
                            <img src="{{ asset($logoPath) }}" alt="{{ $brandName }} logo" class="brand-logo-image">
                        </div>
                    @else
                        <x-brand-mark
                            wrapperClass="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center overflow-hidden"
                            logoClass="w-full h-full object-contain"
                            fallbackClass="text-white font-bold"
                        />
                        <span class="ml-3 text-xl font-bold text-primary-700">{{ $brandName }}</span>
                    @endif
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-2">
                @auth
                    @if(auth()->user()->isStudent())
                        <a href="{{ route('student.dashboard') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.dashboard') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Dashboard</a>
                        <a href="{{ route('student.lessons.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.lessons.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Lessons</a>
                        <a href="{{ route('student.quizzes.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.quizzes.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Quizzes</a>
                        <a href="{{ route('student.reports.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.reports.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Reports</a>
                        <a href="{{ route('student.pretest.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.pretest.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Pretest</a>
                        <a href="{{ route('student.tutor.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.tutor.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">AI Tutor</a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Admin</a>
                        <a href="{{ route('admin.analytics') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.analytics') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Analytics</a>
                        <a href="{{ route('admin.subjects.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.subjects.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Subjects</a>
                        <a href="{{ route('admin.lessons.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.lessons.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Lessons</a>
                        <a href="{{ route('admin.quizzes.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.quizzes.*') || request()->routeIs('admin.questions.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:text-primary-500 hover:bg-primary-50' }}">Quizzes</a>
                    @endif
                @endauth
            </div>

            <!-- User Menu -->
            @auth
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600 hidden sm:block">
                        {{ auth()->user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-700 transition">
                            Logout
                        </button>
                    </form>
                    <button id="mobile-nav-toggle" type="button" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 text-gray-700 hover:bg-primary-50" aria-expanded="false" aria-controls="mobile-nav-panel">
                        <span class="sr-only">Toggle navigation</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                </div>
            @else
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-500 transition">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-700 transition">
                        Register
                    </a>
                </div>
            @endauth
        </div>

                @auth
                        <div id="mobile-nav-panel" class="md:hidden hidden py-3 border-t border-gray-100">
                                <div class="flex flex-col gap-1">
                                        @if(auth()->user()->isStudent())
                                                <a href="{{ route('student.dashboard') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.dashboard') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Dashboard</a>
                                                <a href="{{ route('student.lessons.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.lessons.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Lessons</a>
                                                <a href="{{ route('student.quizzes.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.quizzes.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Quizzes</a>
                                                <a href="{{ route('student.reports.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.reports.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Reports</a>
                                                <a href="{{ route('student.pretest.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.pretest.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Pretest</a>
                                                <a href="{{ route('student.tutor.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('student.tutor.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">AI Tutor</a>
                                        @elseif(auth()->user()->isAdmin())
                                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Admin</a>
                                                <a href="{{ route('admin.analytics') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.analytics') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Analytics</a>
                                                <a href="{{ route('admin.subjects.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.subjects.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Subjects</a>
                                                <a href="{{ route('admin.lessons.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.lessons.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Lessons</a>
                                                <a href="{{ route('admin.quizzes.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.quizzes.*') || request()->routeIs('admin.questions.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50' }}">Quizzes</a>
                                        @endif
                                </div>
                        </div>
                @endauth
    </div>
</nav>

@auth
<script>
    (function () {
        const toggle = document.getElementById('mobile-nav-toggle');
        const panel = document.getElementById('mobile-nav-panel');
        if (!toggle || !panel) return;

        toggle.addEventListener('click', function () {
            panel.classList.toggle('hidden');
            const expanded = panel.classList.contains('hidden') ? 'false' : 'true';
            toggle.setAttribute('aria-expanded', expanded);
        });
    })();
</script>
@endauth
