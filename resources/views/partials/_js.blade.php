
<script src="{{ asset('js/scripts/pages/app-chat.js') }}"></script>


{{-- Vendor Scripts --}}
@livewireScripts
<script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>
@yield('vendor-script')
{{-- Theme Scripts --}}
<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script src="{{ asset('js/core/app.js') }}"></script>

    <script src="{{ asset('js/scripts/customizer.js') }}"></script>

    <script type="text/javascript">
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14, height: 14
        });
      }
    })

  </script>