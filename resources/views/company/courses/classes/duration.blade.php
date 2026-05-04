<style>
    .dur-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 6px;
        display: block;
        font-weight: 500;
        letter-spacing: .3px;
    }

    .dur-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .dur-input-wrap .dur-icon {
        position: absolute;
        left: 11px;
        pointer-events: none;
        color: #aaa;
        display: flex;
        align-items: center;
    }

    .dur-input-wrap input,
    .dur-input-wrap textarea {
        width: 100%;
        padding: 9px 12px 9px 36px;
        font-size: 14px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: #fff;
        box-sizing: border-box;
        outline: none;
        transition: border-color .15s;
    }

    .dur-input-wrap input:focus,
    .dur-input-wrap textarea:focus {
        border-color: #1D9E75;
        box-shadow: 0 0 0 3px rgba(29, 158, 117, .1);
    }

    .dur-readonly {
        width: 100%;
        padding: 9px 12px 9px 36px;
        font-size: 14px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: #f8f9fa;
        color: #6c757d;
        box-sizing: border-box;
    }

    .dur-metric {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px 14px;
        flex: 1;
    }

    .dur-metric-label {
        font-size: 11px;
        color: #aaa;
        margin-bottom: 3px;
    }

    .dur-metric-value {
        font-size: 20px;
        font-weight: 600;
        color: #212529;
        margin: 0;
    }

    .dur-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 500;
    }

    .dur-pill.more {
        background: #E1F5EE;
        color: #085041;
    }

    .dur-pill.less {
        background: #FCEBEB;
        color: #791F1F;
    }

    .dur-pill.same {
        background: #F1EFE8;
        color: #444441;
    }

    .dur-btn {
        width: 100%;
        height: 48px;
        background: #1D9E75;
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background .15s;
    }

    .dur-btn:hover {
        background: #0F6E56;
    }

    /* Force native appearance back on picker inputs */
    select,
    [type=date],
    [type=time],
    [type=datetime-local],
    [type=month],
    [type=week] {
        appearance: auto !important;
        -webkit-appearance: auto !important;
    }

    /* Make sure picker icons are always visible */
    [type=date]::-webkit-calendar-picker-indicator,
    [type=time]::-webkit-calendar-picker-indicator,
    [type=datetime-local]::-webkit-calendar-picker-indicator,
    [type=month]::-webkit-calendar-picker-indicator,
    [type=week]::-webkit-calendar-picker-indicator {
        opacity: 1 !important;
        cursor: pointer;
        filter: invert(40%) sepia(80%) saturate(400%) hue-rotate(120deg);
        /* green tint */
    }
</style>

@php
    $scheduled = \Carbon\Carbon::parse($class->start_time)->diffInMinutes(\Carbon\Carbon::parse($class->end_time));

    $actual =
        $class->classDuration?->started_at && $class->classDuration->ended_at
            ? \Carbon\Carbon::parse($class->classDuration?->started_at)->diffInMinutes(
                \Carbon\Carbon::parse($class->classDuration->ended_at),
            )
            : \Carbon\Carbon::parse($class->start_time)->diffInMinutes(
                \Carbon\Carbon::parse($class->end_time),
            );

    $scheduledH = floor($scheduled / 60);
    $scheduledM = $scheduled % 60;

    $clockIcon =
        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';

    $noteIcon =
        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>';

    $saveIcon =
        '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>';
@endphp

<form method="POST"
    action="{{ route('company.courses.schedule-class.duration.update', ['identity' => $class->course->course_identity, 'schedule_class' => $class->id]) }}">
    @csrf
    <input type="hidden" name="class_id" value="{{ $class->id }}">

    {{-- Header --}}
    <div class="d-flex align-items-center gap-3 mb-3">
        <div
            style="width:36px;height:36px;border-radius:50%;background:#E1F5EE;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#0F6E56;">
            {!! $clockIcon !!}
        </div>
        <div>
            <div style="font-size:15px;font-weight:600;color:#212529;">Update duration</div>
            <div class="text-muted" style="font-size:12px;">{{ $class->title }} · {{ $class->date }}</div>
        </div>
    </div>

    {{-- Scheduled Time Card --}}
    <div class="card border mb-3" style="border-radius:12px;">
        <div class="card-body py-3 px-3">
            <div class="text-muted mb-2" style="font-size:12px;font-weight:500;">Scheduled time</div>
            <div class="row g-2">
                <div class="col">

                    <div class="text-muted mt-1" style="font-size:11px;">Start</div>
                    <div class="dur-input-wrap">
                        <span class="dur-icon">{!! $clockIcon !!}</span>
                        <div class="dur-readonly">{{ \Carbon\Carbon::parse($class->start_time)->format('Y-m-d h:i A') }}</div>
                    </div>
                </div>
                <div class="col">

                    <div class="text-muted mt-1" style="font-size:11px;">End</div>
                    <div class="dur-input-wrap">
                        <span class="dur-icon">{!! $clockIcon !!}</span>
                        <div class="dur-readonly">{{ \Carbon\Carbon::parse($class->end_time)->format('Y-m-d h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Actual Time Card --}}
    <div class="card border mb-3" style="border-radius:12px;">
        <div class="card-body py-3 px-3">
            <div class="text-muted mb-3" style="font-size:12px;font-weight:500;">Actual time</div>

            <div class="row g-2 mb-3">
                <div class="col">
                    <label class="dur-label">Actual start</label>
                    <div class="dur-input-wrap">
                        <span class="dur-icon" style="color:#1D9E75;">{!! $clockIcon !!}</span>
                        <input type="datetime-local" name="actual_start" id="actual_start" class="border appearance-auto"
                            value="{{ optional($class->classDuration?->started_at ? \Carbon\Carbon::parse($class->classDuration?->started_at) : \Carbon\Carbon::parse($class->start_time))->format('Y-m-d H:i') }}"
                            oninput="calcDuration()">
                    </div>
                </div>
                <div class="col">
                    <label class="dur-label">Actual end</label>
                    <div class="dur-input-wrap">
                        <span class="dur-icon" style="color:#1D9E75;">{!! $clockIcon !!}</span>
                        <input type="datetime-local" name="actual_end" id="actual_end" class="border appearance-auto"
                            value="{{ optional($class->classDuration?->ended_at ? \Carbon\Carbon::parse($class->classDuration?->ended_at) : \Carbon\Carbon::parse($class->end_time))->format('Y-m-d H:i') }}"
                            oninput="calcDuration()">
                    </div>
                </div>
            </div>

            <hr style="border-color:#dee2e6;margin:12px 0;">

            {{-- Duration Metrics --}}
            <div class="d-flex gap-2">
                <div class="dur-metric">
                    <div class="dur-metric-label">Scheduled</div>
                    <div class="dur-metric-value">{{ $scheduledH }}h {{ $scheduledM > 0 ? $scheduledM . 'min' : '' }}
                    </div>
                </div>
                <div class="dur-metric">
                    <div class="dur-metric-label">Actual</div>
                    <div class="dur-metric-value" style="color:#1D9E75;" id="actual_display">
                        @if ($actual)
                            {{ floor($actual / 60) }}h {{ $actual % 60 > 0 ? $actual % 60 . 'min' : '' }}
                        @else
                            --
                        @endif
                    </div>
                </div>
                <div class="dur-metric">
                    <div class="dur-metric-label">Difference</div>
                    <div class="dur-metric-value" id="diff_display" style="font-size:15px;padding-top:3px;">
                        @if ($actual)
                            @php $diff = $actual - $scheduled; @endphp
                            @if ($diff > 0)
                                <span class="dur-pill more">+{{ $diff }} min</span>
                            @elseif($diff < 0)
                                <span class="dur-pill less">{{ $diff }} min</span>
                            @else
                                <span class="dur-pill same">Same</span>
                            @endif
                        @else
                            <span class="dur-pill same">--</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Note Card --}}
    <div class="card border mb-3" style="border-radius:12px;">
        <div class="card-body py-3 px-3">
            <label class="dur-label">
                Note <span style="font-weight:400;color:#aaa;">(optional)</span>
            </label>
            <div class="dur-input-wrap">
                <span class="dur-icon" style="top:10px;">{!! $noteIcon !!}</span>
                <textarea name="note" class="border" rows="2" placeholder="e.g. Extended due to Q&A session" style="padding-top:10px;">{{ $class->classDuration?->note }}</textarea>
            </div>
        </div>
    </div>

    {{-- Submit --}}
    <button type="submit" class="dur-btn">
        {!! $saveIcon !!}
        Update duration
    </button>

</form>

<script>
    const scheduledMins = {{ $scheduled }};

    function fmtMins(m) {
        if (isNaN(m) || m < 0) return '--';
        let h = Math.floor(m / 60),
            min = m % 60;
        return h > 0 ? h + 'h ' + (min > 0 ? min + 'min' : '') : min + 'min';
    }

    function toMins(t) {
        let [h, m] = t.split(':').map(Number);
        return h * 60 + m;
    }

    function calcDuration() {
        let s = document.getElementById('actual_start').value;
        let e = document.getElementById('actual_end').value;
        let pill = document.getElementById('diff_display');

        if (!s || !e) {
            document.getElementById('actual_display').textContent = '--';
            pill.innerHTML = '<span class="dur-pill same">--</span>';
            return;
        }

        let actual = toMins(e) - toMins(s);
        if (actual < 0) actual += 1440;

        document.getElementById('actual_display').textContent = fmtMins(actual);

        let diff = actual - scheduledMins;
        if (diff > 0)
            pill.innerHTML = `<span class="dur-pill more">+${diff} min</span>`;
        else if (diff < 0)
            pill.innerHTML = `<span class="dur-pill less">${diff} min</span>`;
        else
            pill.innerHTML = `<span class="dur-pill same">Same</span>`;
    }
</script>
