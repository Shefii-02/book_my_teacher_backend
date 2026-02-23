 <div class="mt-4">
     <h4 class="font-bold mb-3">Tasks level List</h4>

     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
         <div>
             <label class="block">Role : {{ $level->role  }}</label>
         </div>

         <div>
             <label class="block">Level Number : {{ $level->level_number }}</label>

         </div>

         <div>
             <label class="block">Title : {{ $level->title }}</label>
         </div>

         <div>
             <label class="block">Position : {{ $level->position }}</label>
         </div>

         <div class="md:col-span-2">
             <label class="block">Description : {{ $level->description }}</label>
         </div>
     </div>

     <div class="mt-4">
         <label class="inline-flex items-center">
            <span class="ml-2">{{ $level->is_active ? 'Active': 'Deactive' }}</span>
         </label>
     </div>

 </div>


 <div class="bg-white p-6 rounded shadow mt-6">
     {{-- ------------Task List--------------- --}}
     @include('company.mobile-app.achievements.task-list', [
         'tasks' => $level->tasks,
     ])
 </div>
