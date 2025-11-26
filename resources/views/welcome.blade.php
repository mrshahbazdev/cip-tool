<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CIP Tools – Simple workforce management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
<header class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
        <div class="flex items-center gap-2">
            <span class="h-8 w-8 rounded-lg bg-amber-500"></span>
            <span class="text-lg font-semibold tracking-tight">CIP Tools</span>
        </div>
        <nav class="hidden gap-8 text-sm text-slate-600 md:flex">
            <a href="#product" class="hover:text-slate-900">Product</a>
            <a href="#teams" class="hover:text-slate-900">For teams</a>
            <a href="#pricing" class="hover:text-slate-900">Pricing</a>
        </nav>
        <div class="flex items-center gap-3 text-sm">
            <a href="{{ url('/admin/login') }}" class="text-slate-600 hover:text-slate-900">Admin login</a>
            <a href="https://work.cip-tools.de/login" class="rounded-md bg-amber-500 px-4 py-2 font-semibold text-white hover:bg-amber-400">
                Team login
            </a>
        </div>
    </div>
</header>

<main>
    {{-- Hero --}}
    <section class="bg-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-10 px-4 py-16 md:flex-row md:items-center">
            <div class="md:w-1/2">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-amber-600">
                    Modern workforce tool
                </p>
                <h1 class="mb-4 text-3xl font-bold tracking-tight md:text-4xl">
                    Keep your people, work and schedules in one simple place.
                </h1>
                <p class="mb-6 text-sm text-slate-600">
                    CIP Tools gives small and mid‑size teams an easy way to organize work, share schedules and stay aligned across locations.
                </p>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="#pricing" class="rounded-md bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-amber-400">
                        Start free trial
                    </a>
                    <a href="#product" class="text-sm text-slate-700 hover:text-slate-900">
                        See how it works →
                    </a>
                </div>
                <p class="mt-3 text-xs text-slate-500">
                    No setup fee · Cancel anytime
                </p>
            </div>
            <div class="md:w-1/2">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 shadow-sm">
                    <p class="mb-3 text-xs font-medium text-slate-500">A calm overview of your day</p>
                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between rounded-xl bg-white px-3 py-2 border border-slate-100">
                            <div>
                                <p class="font-medium text-slate-900">Today’s work</p>
                                <p class="text-slate-500">Everyone sees the same plan in one place.</p>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-medium text-emerald-700">
                                On track
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-xl bg-white p-3 border border-slate-100">
                                <p class="text-[10px] text-slate-500">People</p>
                                <p class="text-lg font-semibold">24</p>
                            </div>
                            <div class="rounded-xl bg-white p-3 border border-slate-100">
                                <p class="text-[10px] text-slate-500">Locations</p>
                                <p class="text-lg font-semibold">8</p>
                            </div>
                            <div class="rounded-xl bg-white p-3 border border-slate-100">
                                <p class="text-[10px] text-slate-500">Tasks today</p>
                                <p class="text-lg font-semibold">36</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Product --}}
    <section id="product" class="border-t border-slate-200 bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 py-12">
            <h2 class="mb-2 text-xl font-semibold">A clear home for everyday work</h2>
            <p class="mb-6 text-sm text-slate-600 max-w-2xl">
                Replace scattered chats and spreadsheets with one simple workspace your whole team can understand in a few minutes.
            </p>
            <div class="grid gap-6 md:grid-cols-3 text-sm">
                <div class="rounded-xl bg-white p-4 border border-slate-200">
                    <p class="mb-1 text-xs font-semibold text-amber-600 uppercase">Overview</p>
                    <p class="mb-1 font-medium">See the full picture</p>
                    <p class="text-slate-600">Get a quick view of people, work and status without clicking through ten different tools.</p>
                </div>
                <div class="rounded-xl bg-white p-4 border border-slate-200">
                    <p class="mb-1 text-xs font-semibold text-amber-600 uppercase">Scheduling</p>
                    <p class="mb-1 font-medium">Share plans clearly</p>
                    <p class="text-slate-600">Everyone sees the same up‑to‑date plan on desktop or phone, so there’s less confusion.</p>
                </div>
                <div class="rounded-xl bg-white p-4 border border-slate-200">
                    <p class="mb-1 text-xs font-semibold text-amber-600 uppercase">Tracking</p>
                    <p class="mb-1 font-medium">Know what’s done</p>
                    <p class="text-slate-600">Simple status updates keep you informed without long reports or extra meetings.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Simple pricing / CTA --}}
    <section id="pricing" class="bg-white border-t border-slate-200">
        <div class="mx-auto max-w-3xl px-4 py-12 text-center">
            <h2 class="mb-2 text-xl font-semibold">Start small, grow over time</h2>
            <p class="mb-6 text-sm text-slate-600">
                Try CIP Tools with your own team first. Add more people and locations when it works for you.
            </p>
            <a href="#contact" class="rounded-md bg-amber-500 px-6 py-2.5 text-sm font-semibold text-white hover:bg-amber-400">
                Talk to us
            </a>
        </div>
    </section>
</main>

<footer class="border-t border-slate-200 bg-slate-50">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-4 text-xs text-slate-500 md:flex-row">
        <span>© {{ date('Y') }} CIP Tools. All rights reserved.</span>
        <div class="flex gap-4">
            <a href="#" class="hover:text-slate-900">Imprint</a>
            <a href="#" class="hover:text-slate-900">Privacy</a>
        </div>
    </div>
</footer>
</body>
</html>
