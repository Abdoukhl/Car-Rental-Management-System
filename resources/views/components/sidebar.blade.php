<!-- resources/views/components/sidebar.blade.php -->
@php
    $menuItems = [
        [
            'route' => 'agency.dashboard',
            'icon' => 'fa-home',
            'label' => 'الرئيسية',
            'active' => request()->routeIs('agency.dashboard')
        ],
        [
            'route' => 'agency.cars.index',
            'icon' => 'fa-car',
            'label' => 'السيارات',
            'active' => request()->routeIs('agency.cars*')
        ],
        [
            'route' => 'agency.bookings.index',
            'icon' => 'fa-calendar-alt',
            'label' => 'الحجوزات',
            'active' => request()->routeIs('agency.bookings*')
        ],
        [
            'route' => 'agency.reports',
            'icon' => 'fa-chart-line',
            'label' => 'التقارير',
            'active' => request()->routeIs('agency.reports*')
        ],
        [
            'route' => 'agency.settings',
            'icon' => 'fa-cog',
            'label' => 'الإعدادات',
            'active' => request()->routeIs('agency.settings*')
        ]
    ];
@endphp

<div class="col-md-3 sidebar p-0 vh-100 sticky-top">
    <div class="p-4">
        <div class="text-center mb-4">
            <i class="fas fa-car fa-2x mb-2" style="color: #6e8efb;"></i>
            <h4 class="m-0">لوحة التحكم</h4>
            <small class="text-muted">{{ auth()->user()->agency->name }}</small>
        </div>
        
        <ul class="nav flex-column">
            @foreach($menuItems as $item)
            <li class="nav-item">
                <a class="nav-link {{ $item['active'] ? 'active' : '' }}" href="{{ route($item['route']) }}">
                    <i class="fas {{ $item['icon'] }} me-2"></i> {{ $item['label'] }}
                    @if($item['active'])
                    <span class="position-absolute end-0 me-3">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                    @endif
                </a>
            </li>
            @endforeach
        </ul>
        
        <div class="mt-4 pt-3 border-top">
            <a href="#" class="btn btn-sm btn-outline-light w-100" data-bs-toggle="modal" data-bs-target="#supportModal">
                <i class="fas fa-headset me-2"></i> الدعم الفني
            </a>
        </div>
    </div>
</div>

<!-- Modal الدعم الفني -->
<div class="modal fade" id="supportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="fas fa-headset me-2"></i>الدعم الفني</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control bg-secondary border-0" value="support@caragency.com" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="text" class="form-control bg-secondary border-0" value="+123456789" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">ساعات العمل</label>
                    <input type="text" class="form-control bg-secondary border-0" value="09:00 ص - 05:00 م (كل أيام الأسبوع)" readonly>
                </div>
            </div>
        </div>
    </div>
</div>