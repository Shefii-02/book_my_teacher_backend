window.initInfiniteTable = function (config) {

  let page = 1;
  let loading = false;
  let lastPage = false;
  let autoLoadCount = 0;
  let maxAutoLoad = config.maxAutoLoad || 2;
  let tab = config.tab || null;

  // ─── Re-init Flowbite after DOM changes ──────────────────────────────
    function reinitDropdowns() {
        if (typeof initFlowbite === 'function') {
            initFlowbite();
        }
    }

  const container = $(config.container);
  const form = $(config.form);
  const loader = $(config.loader || '#scrollLoader');
  const loadMoreBtn = $(config.loadMoreBtn || '#loadMoreBtn');

  function getUrl() {
    return config.url + "?page=" + page + (tab ? "&tab=" + tab : "");
  }

  function loadData(isManual = false) {

    if (loading || lastPage) return;

    loading = true;
    page++;

    loader.removeClass('hidden');

    $.ajax({
      url: getUrl(),
      type: config.method || "GET",
      data: form.serialize(),

      headers: config.csrf ? {
        'X-CSRF-TOKEN': config.csrf
      } : {},

      success: function (data) {

        let newRows = $(data).find("tbody").html();

        if (!newRows || newRows.trim() === '' || newRows.includes('No data')) {
          lastPage = true;
          loader.html("No more data");
          loadMoreBtn.hide();
          return;
        }

        container.find('tbody').append(newRows);

        loading = false;
        loader.addClass('hidden');
            reinitDropdowns();

        // if (!isManual) {
        //     autoLoadCount++;

        //     if (autoLoadCount >= maxAutoLoad) {
        //         loadMoreBtn.removeClass('hidden');
        //     }
        // }
      },

      error: function () {
        loading = false;
      }
    });
  }

  // 🔁 RESET
  function resetAndReload() {
    page = 1;
    lastPage = false;
    autoLoadCount = 0;
    loadMoreBtn.addClass('hidden');

    $.ajax({
      url: config.url,
      type: config.method || "GET",
      data: form.serialize(),
      success: function (data) {
        container.html(data);
        reinitDropdowns();
      }
    });
  }

  // 📌 FORM SUBMIT
  form.on('submit', function (e) {
    e.preventDefault();
    resetAndReload();
  });

  // 📌 RESET BUTTON
  $(config.resetBtn || '#resetBtn').on('click', function () {
    form[0].reset();
    resetAndReload();
  });

  // 📌 LIVE SEARCH
  if (config.liveSearch) {
    form.find('input[name="search"]').on('keyup', function () {
      resetAndReload();
    });
  }

  // 📌 SCROLL
  $(window).on('scroll', function () {

    if (loadMoreBtn.is(':visible')) return;

    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 120) {
      loadData(false);
    }
  });

  // 📌 LOAD MORE BUTTON
  loadMoreBtn.on('click', function () {
    loadData(true);
  });

  // ===============================
  // ACTIVE FILTER HANDLER (GLOBAL)
  // ===============================

  // $(document).on('click', '.active-filter-remove', function (e) {
  //   e.preventDefault();

  //   let url = $(this).attr('href');
  //   let target = $(this).closest('[data-table-container]').data('table-container') || '#studentTable';

  //   loadData();

  // });

  // $(document).on('click', '.active-filter-reset', function (e) {
  //   e.preventDefault();

  //   let url = $(this).attr('href');
  //   let target = $(this).closest('[data-table-container]').data('table-container') || '#studentTable';

  //   loadData();

  // });


};


