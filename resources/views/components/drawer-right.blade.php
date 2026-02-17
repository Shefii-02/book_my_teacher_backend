  <!-- drawer component -->
  <div id="drawer-right-example"
      class="fixed top-0 right-0 z-990 h-screen p-4 overflow-y-auto translate-x-full bg-white shadow-lg transition-transform w-1/2"
      tabindex="-1">
      <button type="button" role="button" id="closeDrawer"
          class="absolute top-2 end-6 text-2xl text-gray-400 hover:text-gray-800">
          ✕
      </button>
      <div id="drawerContent" class="mb-4">
          <!-- Step form will load here -->
          <div class="text-center text-gray-400">Loading...</div>
      </div>
  </div>

  @push('scripts')
  <script>
    function openDrawer() {
        $('#drawer-right-example').removeClass('translate-x-full');
    }

    function closeDrawer() {
        $('#drawer-right-example').addClass('translate-x-full');
    }

    $(document).ready(function() {
        $(document).on('click', '#closeDrawer', function() {
            closeDrawer();
        });
    });
</script>


      {{-- <script>
          $(document).ready(function() {

              function openDrawer() {
                  $('#drawer-right-example').removeClass('translate-x-full');
              }

              function closeDrawer() {
                  $('#drawer-right-example').addClass('translate-x-full');
              }

              $(document).on('click', '#closeDrawer', function() {
                  closeDrawer();
              });
          });
      </script> --}}
  @endpush
