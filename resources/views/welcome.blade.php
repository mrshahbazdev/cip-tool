<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CIP Tools – Workforce Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-50">
    <header class="border-b border-slate-800">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <div class="flex items-center gap-2">
                <span class="h-8 w-8 rounded-lg bg-amber-500"></span>
                <span class="text-lg font-semibold">CIP Tools</span>
            </div>
            <nav class="hidden gap-8 text-sm md:flex">
                <a href="#features" class="hover:text-amber-400">Features</a>
                <a href="#how-it-works" class="hover:text-amber-400">How it works</a>
                <a href="#pricing" class="hover:text-amber-400">Pricing</a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ url('/admin/login') }}" class="text-sm hover:text-amber-400">Admin login</a>
                <a href="{{ url('https://work.cip-tools.de/login') }}" class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-400">
                    Team login
                </a>
            </div>
        </div>
    </header>

    <main>
        {{-- Hero --}}
        <section class="border-b border-slate-800 bg-gradient-to-b from-slate-950 to-slate-900">
            <div class="mx-auto flex max-w-6xl flex-col gap-10 px-4 py-16 md:flex-row md:items-center">
                <div class="md:w-1/2">
                    <p class="mb-3 inline-flex rounded-full bg-slate-900 px-3 py-1 text-xs font-medium text-amber-300 ring-1 ring-amber-500/20">
                        Workforce management for cleaning teams
                    </p>
                    <h1 class="mb-4 text-3xl font-bold tracking-tight md:text-4xl">
                        Plan shifts, track work and pay bonuses in one place.
                    </h1>
                    <p class="mb-6 text-sm text-slate-300">
                        CIP Tools helps cleaning companies organize projects, assign staff, and keep every site on track – from any device.
                    </p>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="#pricing" class="rounded-md bg-amber-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-amber-400">
                            Start free trial
                        </a>
                        <a href="#features" class="text-sm text-slate-200 hover:text-amber-300">
                            See how it works →
                        </a>
                    </div>
                    <p class="mt-3 text-xs text-slate-400">
                        No credit card required · Cancel anytime
                    </p>
                </div>
                <div class="md:w-1/2">
                    <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 shadow-xl">
                        <div class="mb-3 flex items-center justify-between text-xs text-slate-400">
                            <span>Today’s schedule</span>
                            <span>Wed, 26 Nov</span>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between rounded-lg bg-slate-800 px-3 py-2">
                                <div>
                                    <p class="font-medium text-slate-100">Morning shift – Office A</p>
                                    <p class="text-slate-400">08:00 – 12:00 · 4 staff</p>
                                </div>
                                <span class="rounded-full bg-emerald-500/10 px-2 py-0.5 text-[10px] text-emerald-300">
                                    In progress
                                </span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-slate-800 px-3 py-2">
                                <div>
                                    <p class="font-medium text-slate-100">Deep clean – Site B</p>
                                    <p class="text-slate-400">14:00 – 18:00 · 3 staff</p>
                                </div>
                                <span class="rounded-full bg-amber-500/10 px-2 py-0.5 text-[10px] text-amber-300">
                                    Scheduled
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Features --}}
        <section id="features" class="border-b border-slate-800 bg-slate-950">
            <div class="mx-auto max-w-6xl px-4 py-12">
                <h2 class="mb-6 text-xl font-semibold">Everything your cleaning team needs</h2>
                <div class="grid gap-6 md:grid-cols-3 text-sm">
                    <div class="rounded-xl border border-slate-800 bg-slate-900 p-4">
                        <p class="mb-1 text-amber-300 text-xs font-semibold">Projects & sites</p>
                        <p class="font-medium mb-1">Organize every location</p>
                        <p class="text-slate-300">Group staff, tasks and schedules per client site so nothing falls through the cracks.</p>
                    </div>
                    <div class="rounded-xl border border-slate-800 bg-slate-900 p-4">
                        <p class="mb-1 text-amber-300 text-xs font-semibold">Shift planning</p>
                        <p class="font-medium mb-1">Plan and track work</p>
                        <p class="text-slate-300">Create recurring shifts, assign employees and monitor completion in real time.</p>
                    </div>
                    <div class="rounded-xl border border-slate-800 bg-slate-900 p-4">
                        <p class="mb-1 text-amber-300 text-xs font-semibold">Bonuses</p>
                        <p class="font-medium mb-1">Reward good work</p>
                        <p class="text-slate-300">Configure bonus rules per project so your team sees exactly how extra pay is calculated.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Simple pricing / CTA --}}
        <section id="pricing" class="bg-slate-950">
            <div class="mx-auto max-w-3xl px-4 py-12 text-center">
                <h2 class="mb-3 text-xl font-semibold">Start with a free trial</h2>
                <p class="mb-6 text-sm text-slate-300">
                    Try CIP Tools with your own projects and team. Upgrade only when you’re ready.
                </p>
                <a href="#contact" class="rounded-md bg-amber-500 px-6 py-2.5 text-sm font-semibold text-slate-950 hover:bg-amber-400">
                    Book onboarding call
                </a>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-800 bg-slate-950">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-4 text-xs text-slate-500 md:flex-row">
            <span>© {{ date('Y') }} CIP Tools. All rights reserved.</span>
            <div class="flex gap-4">
                <a href="#" class="hover:text-amber-300">Imprint</a>
                <a href="#" class="hover:text-amber-300">Privacy</a>
            </div>
        </div>
    </footer>
</body>
</html>
