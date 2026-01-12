 <form id="admissionForm" method="POST" action="{{ route('company.demo-classes.participant.store',$demoClass->id) }}">
     @csrf
     <div class="flex h-screen overflow-hidden">

         <!-- Left: Scrollable (col-9) -->
         <div class="w-full overflow-y-auto ">
             <!-- Your scroll content -->
             <div class=" space-y-4">
                 {{-- Student search (simple) --}}
                 <div class="mb-4">
                     <label class="block text-sm font-medium">Search Student</label>
                     <input type="text" id="studentSearch" value="{{ old('student_display') }}"
                         placeholder="Search name/email/mobile" class="border p-2 rounded w-full" autocomplete="off">
                     <input type="hidden" name="student_id" id="student_id" value="{{ old('student_id') }}">
                     <div id="studentResults" class="hidden mt-1 bg-white border rounded overflow-auto"
                         style="max-height:200px"></div>
                     @error('student_id')
                         <p class="text-red-600 text-sm">{{ $message }}</p>
                     @enderror
                 </div>
             </div>
             <div class="flex gap-3 text-center align-center justify-center items-center  mt-5">
                 <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Submit </button>
             </div>
         </div>
     </div>
 </form>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    <script>
        $(function() {

            /* ---------- student inline search (no select2) ---------- */
            let timer = null;
            $('#studentSearch').on('keyup', function() {
                const q = $(this).val().trim();
                clearTimeout(timer);
                if (q.length < 1) {
                    $('#studentResults').addClass('hidden').html('');
                    $('#student_id').val('');
                    return;
                }
                timer = setTimeout(() => {
                    $.get('{{ route('company.admissions.student.search') }}', {
                        q
                    }, function(data) {
                        let html = '';
                        if (data.length === 0) html = '<div class="p-2">No results</div>';
                        data.forEach(u => {
                            html +=
                                `<div class="p-2 border-b cursor-pointer studentRow" data-id="${u.id}" data-name="${u.name}"><b>${u.name}</b><br><small>${u.email||''} ${u.mobile||''}</small></div>`;
                        });
                        $('#studentResults').removeClass('hidden').html(html);
                    }, 'json');
                }, 300);
            });

            $(document).on('click', '.studentRow', function() {
                $('#studentSearch').val($(this).data('name'));
                $('#student_id').val($(this).data('id'));
                $('#studentResults').addClass('hidden');
            });

        });
    </script>
