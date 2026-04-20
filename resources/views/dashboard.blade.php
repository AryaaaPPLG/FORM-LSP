<x-app-layout>
    <x-slot name="title">Dashboard Admin | Sistem Absensi LSP SMEMSA</x-slot>
    <style>
        .glass-dashboard {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        #adminParticles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(to bottom right, #f8fafc, #e2e8f0);
            pointer-events: none;
        }
    </style>

    <canvas id="adminParticles"></canvas>

    <x-slot name="header">
        <h2 class="font-black text-2xl text-indigo-900 leading-tight tracking-tight">
            {{ __('Admin Control Center') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 rounded-[2.5rem] p-8 sm:p-14 shadow-2xl mb-12 text-white transform hover:scale-[1.01] transition-transform duration-500">
                <div class="relative z-10">
                    <span class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-widest mb-4">Sistem Absensi Digital</span>
                    <h1 class="text-4xl sm:text-5xl font-black mb-4 tracking-tighter italic">Selamat Datang, Admin!</h1>
                    <p class="text-indigo-100 text-lg opacity-90 max-w-2xl font-medium leading-relaxed">
                        Kelola data kehadiran siswa SMEMSA dengan dashboard terintegrasi. Pantau, validasi, dan export data dalam satu klik.
                    </p>
                </div>
                <!-- Abstract Decorations -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/10 rounded-full blur-[80px]"></div>
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-purple-500/20 rounded-full blur-[60px]"></div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10">
                <!-- Card 1: Monitoring -->
                <div class="glass-dashboard group rounded-[3rem] p-10 shadow-xl shadow-indigo-100/50 hover:shadow-2xl transition-all duration-500 flex flex-col justify-between border-b-4 border-indigo-500">
                    <div>
                        <div class="w-20 h-20 bg-indigo-600 text-white rounded-3xl flex items-center justify-center mb-8 group-hover:rotate-12 transition-all duration-500 shadow-lg shadow-indigo-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">Monitoring Data</h3>
                        <p class="text-gray-600 mb-10 leading-relaxed font-medium">Validasi kehadiran siswa secara real-time. Dilengkapi dengan preview tanda tangan digital untuk verifikasi data yang akurat.</p>
                    </div>
                    <a href="{{ route('admin.lsp.index') }}" class="group/btn inline-flex items-center justify-center w-full bg-indigo-600 text-white font-black py-5 px-8 rounded-2xl hover:bg-indigo-700 transform transition active:scale-95 duration-200 shadow-xl shadow-indigo-200 uppercase tracking-widest text-sm">
                        <span>Buka Monitoring</span>
                        <svg class="w-5 h-5 ml-2 group-hover/btn:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>

                <!-- Card 2: Export -->
                <div class="glass-dashboard group rounded-[3rem] p-10 shadow-xl shadow-emerald-100/50 hover:shadow-2xl transition-all duration-500 flex flex-col justify-between border-b-4 border-emerald-500">
                    <div>
                        <div class="w-20 h-20 bg-emerald-600 text-white rounded-3xl flex items-center justify-center mb-8 group-hover:rotate-12 transition-all duration-500 shadow-lg shadow-emerald-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">Export Laporan</h3>
                        <p class="text-gray-600 mb-10 leading-relaxed font-medium">Generate file rekapitulasi DOCX secara otomatis. Seluruh list siswa yang sudah mengabsen akan terangkum dalam tabel profesional.</p>
                    </div>
                    <a href="{{ route('admin.lsp.export-all') }}" class="group/btn inline-flex items-center justify-center w-full bg-emerald-600 text-white font-black py-5 px-8 rounded-2xl hover:bg-emerald-700 transform transition active:scale-95 duration-200 shadow-xl shadow-emerald-200 uppercase tracking-widest text-sm">
                        <span>Download Rekap</span>
                        <svg class="w-5 h-5 ml-2 group-hover/btn:translate-y-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4-4v12"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Footer Branding -->
            <div class="mt-20 text-center pb-10">
                <div class="flex justify-center items-center space-x-3 opacity-30 grayscale hover:grayscale-0 transition-all duration-500 cursor-default">
                    <span class="h-[1px] w-12 bg-gray-400"></span>
                    <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.5em]">
                        PPLG SMEMSA &bull; {{ date('Y') }}
                    </p>
                    <span class="h-[1px] w-12 bg-gray-400"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // High Performance Particle Animation for Admin Dashboard
        const canvas = document.getElementById('adminParticles');
        const ctx = canvas.getContext('2d');
        let width, height, particles;

        function initParticles() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
            
            // Reduced particle count for performance
            const particleCount = width < 768 ? 25 : 60;
            particles = [];
            
            for (let i = 0; i < particleCount; i++) {
                particles.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    size: Math.random() * 2 + 1,
                    vx: (Math.random() - 0.5) * 0.5,
                    vy: (Math.random() - 0.5) * 0.5,
                    color: 'rgba(79, 70, 229, ' + (Math.random() * 0.15).toFixed(2) + ')'
                });
            }
        }

        function drawParticles() {
            ctx.clearRect(0, 0, width, height);
            
            for (let p of particles) {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fillStyle = p.color;
                ctx.fill();

                p.x += p.vx;
                p.y += p.vy;

                if (p.x < 0 || p.x > width) p.vx *= -1;
                if (p.y < 0 || p.y > height) p.vy *= -1;
            }
            requestAnimationFrame(drawParticles);
        }

        window.addEventListener('resize', initParticles);
        initParticles();
        drawParticles();
    </script>
</x-app-layout>
