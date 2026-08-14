<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <div class="mx-auto flex min-h-screen max-w-6xl items-center justify-center p-4 sm:p-6 lg:p-8">
        <div
            class="w-full overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
            <div class="grid lg:grid-cols-[1.2fr_0.8fr]">
                <div
                    class="relative hidden overflow-hidden bg-linear-to-br from-slate-950 via-slate-800 to-slate-700 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.16),transparent_30%),radial-gradient(circle_at_bottom_right,rgba(251,146,60,0.18),transparent_35%)]">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="mb-10 inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/5 px-4 py-2 text-sm font-medium backdrop-blur-sm">
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-400 text-sm font-black text-slate-900">L</span>
                            Laravel
                        </div>

                        <p class="mb-3 text-sm uppercase tracking-[0.2em] text-slate-300">Welcome back</p>
                        <h2 class="max-w-md text-3xl font-semibold leading-tight">Manage your dashboard with confidence.
                        </h2>
                    </div>

                    <div class="relative z-10 space-y-4 text-sm text-slate-200">
                        <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-3">
                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-400/20 text-emerald-300">✓</span>
                            <span>Simple access to your admin panel</span>
                        </div>
                        <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-3">
                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-sky-400/20 text-sky-300">⚡</span>
                            <span>Fast workflows and modern interface</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-7 sm:p-10 lg:p-12">
                    <div class="mb-8">
                        <p class="text-sm font-medium uppercase tracking-[0.2em] text-amber-600">Laravel</p>
                        <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Sign in</h1>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">
                                Email address <span class="text-red-500">*</span>
                            </label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                autofocus placeholder="name@example.com"
                                class="{{ $errors->has('email')
                                    ? 'w-full rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-red-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-red-100'
                                    : 'w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-100' }}">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input id="password" name="password" type="password" required placeholder="••••••••"
                                class="{{ $errors->has('password')
                                    ? 'w-full rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-red-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-red-100'
                                    : 'w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-100' }}">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between gap-3 text-sm">
                            <label class="inline-flex items-center gap-2 text-slate-600">
                                <input type="checkbox" name="remember"
                                    class="h-4 w-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                                <span>Remember me</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-200 transition hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-200">
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
