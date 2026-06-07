<x-app-layout>
    <!-- Welcome Banner -->
    <div class="mb-6 bg-gradient-to-r from-nature-600 via-nature-700 to-teal-800 rounded-2xl p-6 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-1/2 w-48 h-48 bg-white/5 rounded-full translate-y-1/2"></div>
        <div class="absolute top-4 right-8 opacity-10">
            <i class="fa-solid fa-leaf text-6xl text-white"></i>
        </div>
        <div class="relative">
            <h2 class="text-xl font-bold">สวัสดี, {{ auth()->user()->name }}</h2>
            <p class="text-nature-200 mt-1">นี่คือภาพรวมข้อมูลผู้ป่วย NCD ของคุณวันนี้</p>
            <div class="flex gap-3 mt-4">
                <button class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm font-medium transition-colors backdrop-blur-sm">
                    <i class="fa-solid fa-plus mr-2"></i>เพิ่มผู้ป่วย
                </button>
                <button class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-medium transition-colors backdrop-blur-sm">
                    <i class="fa-solid fa-file-export mr-2"></i>รายงาน
                </button>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="stat-card bg-white rounded-xl border border-slate-200/60 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">ผู้ป่วยทั้งหมด</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">1,247</p>
                    <p class="text-xs text-emerald-600 mt-2 font-medium">
                        <i class="fa-solid fa-arrow-up mr-1"></i>+12% จากเดือนก่อน
                    </p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-nature-100 flex items-center justify-center">
                    <i class="fa-solid fa-users text-nature-600 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white rounded-xl border border-slate-200/60 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">นัดหมายวันนี้</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">28</p>
                    <p class="text-xs text-amber-600 mt-2 font-medium">
                        <i class="fa-solid fa-clock mr-1"></i>8 รอพบแพทย์
                    </p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-day text-amber-600 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white rounded-xl border border-slate-200/60 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">เบาหวาน</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">486</p>
                    <p class="text-xs text-emerald-600 mt-2 font-medium">
                        <i class="fa-solid fa-arrow-down mr-1"></i>-3% จากเดือนก่อน
                    </p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-rose-100 flex items-center justify-center">
                    <i class="fa-solid fa-droplet text-rose-500 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white rounded-xl border border-slate-200/60 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">ความดันโลหิตสูง</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">372</p>
                    <p class="text-xs text-emerald-600 mt-2 font-medium">
                        <i class="fa-solid fa-arrow-down mr-1"></i>-5% จากเดือนก่อน
                    </p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center">
                    <i class="fa-solid fa-heart-pulse text-purple-500 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
        <!-- Line Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200/60 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-slate-700">ความดันโลหิตเฉลี่ย (6 เดือน)</h3>
                <select class="text-sm bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-slate-600 focus:ring-2 focus:ring-nature-300 outline-none">
                    <option>6 เดือน</option>
                    <option>1 ปี</option>
                </select>
            </div>
            <div class="relative h-64">
                <canvas id="bpChart"></canvas>
            </div>
        </div>
        <!-- Doughnut Chart -->
        <div class="bg-white rounded-xl border border-slate-200/60 p-5">
            <h3 class="font-semibold text-slate-700 mb-4">การกระจายตามประเภท NCD</h3>
            <div class="relative h-56 flex items-center justify-center">
                <canvas id="ncdChart"></canvas>
            </div>
            <div class="mt-4 space-y-2">
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                    <span class="text-slate-600">เบาหวาน</span>
                    <span class="ml-auto font-semibold text-slate-700">38.9%</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-3 h-3 rounded-full bg-purple-400"></span>
                    <span class="text-slate-600">ความดันโลหิตสูง</span>
                    <span class="ml-auto font-semibold text-slate-700">29.8%</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                    <span class="text-slate-600">อ้วน</span>
                    <span class="ml-auto font-semibold text-slate-700">18.3%</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-3 h-3 rounded-full bg-sky-400"></span>
                    <span class="text-slate-600">ไขมันสูง</span>
                    <span class="ml-auto font-semibold text-slate-700">13.0%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Patient Table -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200/60 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-slate-700">ผู้ป่วยล่าสุด</h3>
                <a href="#" class="text-sm text-nature-600 hover:text-nature-700 font-medium">ดูทั้งหมด <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-500 border-b border-slate-100">
                            <th class="pb-3 font-medium">ชื่อผู้ป่วย</th>
                            <th class="pb-3 font-medium">ประเภท NCD</th>
                            <th class="pb-3 font-medium">ความดัน</th>
                            <th class="pb-3 font-medium">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr class="hover:bg-nature-50/30 transition-colors">
                            <td class="py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-nature-100 flex items-center justify-center text-nature-600 text-xs font-bold">สม</div>
                                    <span class="font-medium text-slate-700">สมหญิง ใจดี</span>
                                </div>
                            </td>
                            <td class="py-3 text-slate-600">เบาหวาน</td>
                            <td class="py-3 text-slate-600">130/85</td>
                            <td class="py-3"><span class="px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">ควบคุมได้</span></td>
                        </tr>
                        <tr class="hover:bg-nature-50/30 transition-colors">
                            <td class="py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 text-xs font-bold">วิ</div>
                                    <span class="font-medium text-slate-700">วิชัย มั่นคง</span>
                                </div>
                            </td>
                            <td class="py-3 text-slate-600">ความดันโลหิตสูง</td>
                            <td class="py-3 text-slate-600">155/95</td>
                            <td class="py-3"><span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">เฝ้าระวัง</span></td>
                        </tr>
                        <tr class="hover:bg-nature-50/30 transition-colors">
                            <td class="py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 text-xs font-bold">สุ</div>
                                    <span class="font-medium text-slate-700">สุภาพร เก่งกาจ</span>
                                </div>
                            </td>
                            <td class="py-3 text-slate-600">อ้วน + เบาหวาน</td>
                            <td class="py-3 text-slate-600">140/90</td>
                            <td class="py-3"><span class="px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">ควบคุมยาก</span></td>
                        </tr>
                        <tr class="hover:bg-nature-50/30 transition-colors">
                            <td class="py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-xs font-bold">ปร</div>
                                    <span class="font-medium text-slate-700">ประเสริฐ รุ่งเรือง</span>
                                </div>
                            </td>
                            <td class="py-3 text-slate-600">ไขมันสูง</td>
                            <td class="py-3 text-slate-600">120/80</td>
                            <td class="py-3"><span class="px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">ควบคุมได้</span></td>
                        </tr>
                        <tr class="hover:bg-nature-50/30 transition-colors">
                            <td class="py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 text-xs font-bold">จิ</div>
                                    <span class="font-medium text-slate-700">จิตตา แสงดาว</span>
                                </div>
                            </td>
                            <td class="py-3 text-slate-600">โรคไต</td>
                            <td class="py-3 text-slate-600">145/92</td>
                            <td class="py-3"><span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">เฝ้าระวัง</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Activity + Appointments -->
        <div class="space-y-5">
            <!-- Appointments -->
            <div class="bg-white rounded-xl border border-slate-200/60 p-5">
                <h3 class="font-semibold text-slate-700 mb-4">นัดหมายวันนี้</h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-nature-50/60 border border-nature-100/40 hover:border-nature-200 transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-nature-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-stethoscope text-white text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-medium text-slate-700 text-sm">คนไข้นัดตรวจ</p>
                            <p class="text-xs text-slate-500 mt-0.5">09:00 — สมหญิง ใจดี</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-50/60 border border-amber-100/40 hover:border-amber-200 transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-utensils text-white text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-medium text-slate-700 text-sm">ปรึกษาโภชนาการ</p>
                            <p class="text-xs text-slate-500 mt-0.5">10:30 — วิชัย มั่นคง</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-purple-50/60 border border-purple-100/40 hover:border-purple-200 transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-purple-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-dumbbell text-white text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-medium text-slate-700 text-sm">ติดตามกายภาพ</p>
                            <p class="text-xs text-slate-500 mt-0.5">14:00 — สุภาพร เก่งกาจ</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Activity -->
            <div class="bg-white rounded-xl border border-slate-200/60 p-5">
                <h3 class="font-semibold text-slate-700 mb-4">กิจกรรมล่าสุด</h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-nature-400 mt-1"></div>
                            <div class="w-px h-full bg-slate-200"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">บันทึกความดันใหม่</p>
                            <p class="text-xs text-slate-400">2 นาทีที่แล้ว</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 mt-1"></div>
                            <div class="w-px h-full bg-slate-200"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">เพิ่มเมนูอาหารใหม่</p>
                            <p class="text-xs text-slate-400">15 นาทีที่แล้ว</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-amber-400 mt-1"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">แก้ไขแผนออกกำลังกาย</p>
                            <p class="text-xs text-slate-400">1 ชั่วโมงที่แล้ว</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Init -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Blood Pressure Chart
            const bpCtx = document.getElementById('bpChart');
            if (bpCtx) {
                new Chart(bpCtx, {
                    type: 'line',
                    data: {
                        labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
                        datasets: [
                            {
                                label: 'ความดันตัวบน',
                                data: [135, 130, 128, 132, 125, 122],
                                borderColor: '#20a98e',
                                backgroundColor: 'rgba(32, 169, 142, 0.1)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#20a98e',
                            },
                            {
                                label: 'ความดันตัวล่าง',
                                data: [88, 85, 82, 84, 80, 78],
                                borderColor: '#176e5e',
                                backgroundColor: 'rgba(23, 110, 94, 0.05)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#176e5e',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top', labels: { usePointStyle: true, padding: 20, font: { family: 'Anuphan' } } }
                        },
                        scales: {
                            y: { beginAtZero: false, grid: { color: '#f1f5f9' }, ticks: { font: { family: 'Anuphan' } } },
                            x: { grid: { display: false }, ticks: { font: { family: 'Anuphan' } } }
                        }
                    }
                });
            }

            // NCD Distribution Chart
            const ncdCtx = document.getElementById('ncdChart');
            if (ncdCtx) {
                new Chart(ncdCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['เบาหวาน', 'ความดันโลหิตสูง', 'อ้วน', 'ไขมันสูง'],
                        datasets: [{
                            data: [38.9, 29.8, 18.3, 13.0],
                            backgroundColor: ['#fb7185', '#c084fc', '#fbbf24', '#38bdf8'],
                            borderWidth: 0,
                            hoverOffset: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>