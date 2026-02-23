 <h4 class="font-bold mb-3">Tasks for this level</h4>
 <form method="POST" action="{{ route('company.app.achievements.tasks.store', $level->id) }}">
     @csrf
     <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
         <div class="">
             <label class="block">Task type (Referral, Complete classes)</label>
             <input name="task_type" placeholder="" class="border p-2 w-full">
         </div>
         <div>
             <label class="block">Task title</label>

             <input name="title" placeholder="" class="border p-2 w-full">
         </div>
         <div>
             <label class="block">Target value</label>
             <input name="target_value" placeholder="" type="number" class="border p-2 w-full">
         </div>
         <div>
             <label class="block">Points</label>

             <input name="points" placeholder="" type="number" class="border p-2 w-full">
         </div>

     </div>
     <div class="w-full">
         <label class="block">Description</label>
         <textarea name="description" placeholder="" class="border p-2 md:col-span-2 w-full"></textarea>
     </div>
     <div class="md:col-span-2 mt-4 text-center">
         <button class="px-3 py-2 bg-blue-600 text-white rounded">Add Task</button>
     </div>

 </form>
