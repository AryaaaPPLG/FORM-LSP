<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa LSP - SMEMSA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            overflow-x: hidden;
            background-color: #0f172a;
        }

        #rainCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-gradient:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #818cf8;
            box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.2);
        }

        .signature-container {
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(255, 255, 255, 0.2);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .floating {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-6">
    <!-- Optimized Background Animation -->
    <canvas id="rainCanvas"></canvas>

    <div class="max-w-md w-full relative">
        <!-- Decoration -->
        <div class="absolute -top-12 -left-12 w-24 h-24 bg-indigo-500 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-12 -right-12 w-24 h-24 bg-purple-500 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-pulse"></div>

        <div class="glass-card rounded-[2.5rem] shadow-2xl overflow-hidden text-white">
            <div class="p-8 text-center border-b border-white/10">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-tr from-indigo-600 to-purple-600 rounded-3xl flex items-center justify-center shadow-xl floating">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold tracking-tight uppercase mb-1">Absensi Siswa</h2>
                <p class="text-indigo-200/70 text-sm font-medium tracking-widest uppercase">Lembaga Sertifikasi Profesi</p>
            </div>
            
            <div class="p-8">
                @if(session('success'))
                    <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-300 p-4 rounded-2xl mb-6 flex items-center text-sm animate-bounce">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('lsp-form.store') }}" method="POST" id="lspForm" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-indigo-200 text-xs font-bold uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" required 
                            class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white/10 transition-all duration-300 text-white placeholder-white/20" 
                            placeholder="Ketik nama anda...">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-indigo-200 text-xs font-bold uppercase tracking-widest ml-1">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" required 
                            class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white/10 transition-all duration-300 text-white placeholder-white/20" 
                            placeholder="Contoh: SMK Negeri 1 Surabaya">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-indigo-200 text-xs font-bold uppercase tracking-widest ml-1">Tanda Tangan</label>
                        <div class="relative group">
                            <div class="signature-container rounded-2xl overflow-hidden transition-all duration-300 group-hover:border-indigo-500/50">
                                <canvas id="signature-pad" class="w-full h-40 cursor-crosshair bg-white/5"></canvas>
                            </div>
                            <div class="flex justify-between items-center mt-2 px-1">
                                <p class="text-[10px] text-white/40 italic">Tanda tangan dalam kotak di atas</p>
                                <button type="button" id="clear" class="text-xs font-bold text-rose-400 hover:text-rose-300 transition-colors flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    HAPUS
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="signature" id="signature">
                    </div>

                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-extrabold py-5 px-6 rounded-2xl shadow-xl shadow-indigo-500/20 transform transition active:scale-[0.98] duration-200 uppercase tracking-widest text-sm flex items-center justify-center">
                        <span>Kirim Kehadiran</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </form>
            </div>
            
            <div class="bg-black/20 p-6 text-center border-t border-white/5">
                <p class="text-white/30 text-[10px] font-bold tracking-[0.2em] uppercase">
                    Dibuat oleh <span class="text-indigo-400">PPLG SMEMSA</span> {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>

    <script>
        // --- High Performance Rain Animation ---
        const canvas = document.getElementById('rainCanvas');
        const ctx = canvas.getContext('2d');
        let width, height, drops;

        function initRain() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
            
            // Mobile optimization: fewer drops on smaller screens
            const dropCount = width < 768 ? 40 : 100;
            drops = [];
            
            for (let i = 0; i < dropCount; i++) {
                drops.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    len: Math.random() * 20 + 10,
                    speed: Math.random() * 10 + 5
                });
            }
        }

        function drawRain() {
            ctx.clearRect(0, 0, width, height);
            ctx.strokeStyle = 'rgba(174, 194, 224, 0.15)';
            ctx.lineWidth = 1;
            ctx.lineCap = 'round';

            for (let i = 0; i < drops.length; i++) {
                const p = drops[i];
                ctx.beginPath();
                ctx.moveTo(p.x, p.y);
                ctx.lineTo(p.x, p.y + p.len);
                ctx.stroke();

                p.y += p.speed;
                if (p.y > height) {
                    p.y = -p.len;
                    p.x = Math.random() * width;
                }
            }
            requestAnimationFrame(drawRain);
        }

        window.addEventListener('resize', initRain);
        initRain();
        drawRain();

        // --- Signature Pad Logic ---
        const sigCanvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(sigCanvas, {
            penColor: 'rgb(255, 255, 255)'
        });
        const form = document.getElementById('lspForm');
        const signatureInput = document.getElementById('signature');
        const clearButton = document.getElementById('clear');

        function resizeSigCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            sigCanvas.width = sigCanvas.offsetWidth * ratio;
            sigCanvas.height = sigCanvas.offsetHeight * ratio;
            sigCanvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        window.addEventListener("resize", resizeSigCanvas);
        resizeSigCanvas();

        clearButton.addEventListener('click', () => {
            signaturePad.clear();
        });

        form.addEventListener('submit', (e) => {
            if (signaturePad.isEmpty()) {
                alert("Silakan bubuhkan tanda tangan terlebih dahulu.");
                e.preventDefault();
            } else {
                signatureInput.value = signaturePad.toDataURL();
            }
        });
    </script>
</body>
</html>
