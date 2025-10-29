<section class="relative bg-gradient-to-b from-slate-50 to-white py-20 md:py-32">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid md:grid-cols-12 gap-8 md:gap-12 items-center">
            <div class="md:col-span-7">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 leading-tight mb-6">
                    Бегайте умнее<br> <span class="text-blue-600">Растите стабильнее</span>
                </h1>

                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-8">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-amber-600 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-amber-800 font-medium">
                            <strong>Закрытая бета-версия</strong> — регистрация только по приглашению
                        </p>
                    </div>
                </div>

                <p class="text-lg md:text-xl text-slate-600 mb-8 leading-relaxed">
                    <strong class="text-slate-900">RunTracker</strong> — минималистичное приложение для учёта тренировок и аналитики бега. Готовьтесь к цели осознанно.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#signup" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        Регистрация
                    </a>
                    <a href="#demo" class="inline-flex items-center justify-center px-6 py-3 border-2 border-slate-300 text-slate-700 font-medium rounded-lg hover:border-slate-400 hover:bg-slate-50 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        Посмотреть демо
                    </a>
                </div>
            </div>

            <div class="md:col-span-5">
                <div class="relative">
                    <div class="bg-slate-100 rounded-2xl shadow-xl p-6 border border-slate-200">
                        <div class="bg-white rounded-lg p-4 mb-4">
                            <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-50 rounded flex items-center justify-center text-slate-400" data-lazy-svg="hero-map-svg">
                                <!-- SVG будет подгружен лениво через IntersectionObserver -->
                            </div>
                            <template id="hero-map-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full max-w-md mx-auto" viewBox="0 0 1200 600" role="img" aria-label="Пример карты пробежки">
                                    <defs>
                                        <linearGradient id="gPath" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="0%" stop-color="#10B981"/>
                                            <stop offset="100%" stop-color="#047857"/>
                                        </linearGradient>
                                        <filter id="softShadow" x="-20%" y="-20%" width="140%" height="140%">
                                            <feDropShadow dx="0" dy="6" stdDeviation="12" flood-color="#0f172a" flood-opacity="0.12"/>
                                        </filter>
                                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                            <rect width="40" height="40" fill="none"/>
                                            <path d="M40 0H0V40" fill="none" stroke="#E2E8F0" stroke-width="1"/>
                                            <path d="M20 0V40M0 20H40" fill="none" stroke="#F1F5F9" stroke-width="1"/>
                                        </pattern>
                                        <style>
                                            :root { --ink:#0f172a; --muted:#64748b; --tile:#ffffff; --accent:#10B981; --accentDark:#047857; }
                                            @media (prefers-color-scheme: dark) {
                                                :root { --ink:#e5e7eb; --muted:#94a3b8; --tile:#0b1220; --accent:#34d399; --accentDark:#10b981; }
                                            }
                                            .tile { fill: var(--tile); }
                                            .ink { stroke: var(--ink); fill: var(--ink); }
                                            .muted { stroke: var(--muted); fill: var(--muted); }
                                        </style>
                                    </defs>

                                    <!-- Background -->
                                    <rect width="1200" height="600" fill="url(#grid)"/>

                                    <!-- Map card -->
                                    <g filter="url(#softShadow)">
                                        <rect x="80" y="60" width="1040" height="480" rx="24" class="tile" stroke="#E2E8F0" stroke-width="1"/>
                                        <!-- Subtle water/park blocks -->
                                        <rect x="120" y="100" width="220" height="120" rx="14" fill="#ECFDF5"/>
                                        <rect x="320" y="360" width="200" height="120" rx="14" fill="#F0FDFA"/>
                                        <rect x="880" y="140" width="180" height="140" rx="14" fill="#F0FDFA"/>
                                        <rect x="700" y="330" width="260" height="150" rx="14" fill="#ECFDF5"/>

                                        <!-- Minor roads (thin) -->
                                        <path d="M150 200H1000M220 160V480M520 120V500M780 120V500M980 120V500"
                                              fill="none" stroke="#E2E8F0" stroke-width="1" stroke-linecap="round"/>

                                        <!-- Track path -->
                                        <path d="
                                                  M 180 420
                                                  C 260 420, 280 380, 330 360
                                                  C 420 325, 430 300, 500 280
                                                  C 580 260, 640 260, 690 300
                                                  C 740 340, 760 360, 830 350
                                                  C 900 340, 960 300, 980 250
                                              "
                                              fill="none" stroke="url(#gPath)" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>

                                        <!-- Direction arrows -->
                                        <g stroke="#10B981" stroke-width="2" fill="none">
                                            <path d="M420 310 l14 -8 l-6 16" stroke-linejoin="round"/>
                                            <path d="M700 295 l14 -8 l-6 16" stroke-linejoin="round"/>
                                            <path d="M860 345 l14 -8 l-6 16" stroke-linejoin="round"/>
                                        </g>

                                        <!-- Start pin -->
                                        <g transform="translate(180,420)">
                                            <circle r="9" fill="#10B981"/>
                                            <circle r="4" fill="#ffffff"/>
                                        </g>

                                        <!-- Split markers -->
                                        <g>
                                            <circle cx="330" cy="360" r="6" fill="#10B981"/>
                                            <circle cx="500" cy="280" r="6" fill="#10B981"/>
                                            <circle cx="690" cy="300" r="6" fill="#10B981"/>
                                            <circle cx="830" cy="350" r="6" fill="#10B981"/>
                                        </g>

                                        <!-- Finish flag -->
                                        <g transform="translate(980,250)">
                                            <path d="M0 0 v30" stroke="#0f172a" stroke-width="2"/>
                                            <path d="M0 0 h18 c6 0 6 10 0 10 h-18 z" fill="#0f172a"/>
                                            <circle cx="0" cy="0" r="3" fill="#10B981"/>
                                        </g>

                                        <!-- Info pill -->
                                        <g transform="translate(120,100)">
                                            <rect x="0" y="0" rx="12" width="220" height="56" fill="#ffffff" stroke="#E2E8F0"/>
                                            <circle cx="22" cy="28" r="6" fill="#10B981"/>
                                            <text x="40" y="26" font-family="Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif"
                                                  font-size="16" fill="#0f172a" font-weight="700">Сегодня</text>
                                            <text x="40" y="44" font-family="Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif"
                                                  font-size="13" fill="#64748b" font-weight="500">8.2 км • 5:12/км • TIZ 2</text>
                                        </g>
                                    </g>
                                </svg>
                            </template>
                        </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div class="bg-white rounded-lg p-3 border border-slate-200">
                                <div class="text-xs text-slate-500 mb-1">Неделя</div>
                                <div class="text-lg font-semibold text-slate-900">42 км</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-slate-200">
                                <div class="text-xs text-slate-500 mb-1">Темп</div>
                                <div class="text-lg font-semibold text-slate-900">5:12</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-slate-200">
                                <div class="text-xs text-slate-500 mb-1">ЧСС ср.</div>
                                <div class="text-lg font-semibold text-slate-900">142</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
