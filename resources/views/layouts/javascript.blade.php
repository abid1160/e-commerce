<!-- jQuery Library -->
<script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>

<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<!-- Chart.js Plugin -->
{{-- <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script> --}}

<!-- PerfectScrollbar CDN -->
<script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>

<!-- PerfectScrollbar CSS (required for proper styling of the scrollbars) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/css/perfect-scrollbar.css">

<!-- Now UI Dashboard JS -->
<script src="{{ asset('assets/js/now-ui-dashboard.min.js?v=1.5.0') }}" type="text/javascript"></script>

<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

{{-- <script>
  $(document).ready(function() {
    // Ensure demo.js is loaded and its init function is available
    if (typeof demo !== 'undefined' && demo.initDashboardPageCharts) {
      demo.initDashboardPageCharts();
    }

    // Initialize PerfectScrollbar for the sidebar and main panel
    if (typeof PerfectScrollbar !== "undefined") {
      var isWindows = navigator.platform.indexOf('Win') > -1;

      if (isWindows) {
        var ps = new PerfectScrollbar('.sidebar-wrapper');
        var ps2 = new PerfectScrollbar('.main-panel');
        $('html').addClass('perfect-scrollbar-on');
      } else {
        $('html').addClass('perfect-scrollbar-off');
      }
    } else {
      console.error("PerfectScrollbar is not loaded");
    }
  });
</script> --}}
