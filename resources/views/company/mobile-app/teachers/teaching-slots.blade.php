<div class="container py-4">

    <h4 class="fw-bold mb-4">Edit Working Hours</h4>
    <div class="container-fluid">
        <div class="row">

            {{-- LEFT SIDE DAYS --}}
            <div class="col-md-3 border-end">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    @foreach ($days as $key => $day)
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $key }}"
                            data-bs-toggle="pill" data-bs-target="#content-{{ $key }}" type="button">
                            {{ $day }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT SIDE SLOTS --}}
            <div class="col-md-9">
                <form method="POST" action="{{ route('company.app.teachers.slots.update', $teacherId) }}">
                    @csrf

                    <div class="tab-content">

                        @foreach ($days as $key => $day)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="content-{{ $key }}">
                                <h5 class="mb-3 text-primary">{{ $day }} Slots</h5>
                                <div class="row">
                                    @foreach ($timeSlots as $slot)
                                        @php
                                            $checked =
                                                isset($selectedSlots[$day]) &&
                                                in_array($slot['label'], $selectedSlots[$day]);
                                        @endphp
                                        <div class="col-md-4 mb-2">
                                            <label class="slot-box text-xxs {{ $checked ? 'active' : '' }}">
                                                <input type="checkbox" name="slots[{{ $day }}][]" class="border me-2"
                                                    value="{{ $slot['label'] }}" {{ $checked ? 'checked' : '' }}>
                                                {{ $slot['label'] }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        @endforeach

                    </div>

                    <button class="btn btn-success mt-4 px-4">
                        Update Slots
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>


<style>
.slot-box {
    display: block;
    border: 1px solid #ddd;
    padding: 8px;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
    background: #f9f9f9;


}
.nav-link{
        text-align: left !important;
}
.slot-box:hover {
    border-color: #0d6efd;
    background: #eef5ff;
}
/*
.slot-box.active,
.slot-box input:checked{
    background: #0dfd5d;
    color: white;
} */
</style>
