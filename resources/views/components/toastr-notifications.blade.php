<div x-data="toastrNotifications"></div>

@push('scripts')
<script>
    function toastrNotifications() {
        return {
            init() {
                @if(session('success'))
                    this.$toastr.success('{{ session('success') }}');
                @endif

                @if(session('error'))
                    this.$toastr.error('{{ session('error') }}');
                @endif

                @if(session('warning'))
                    this.$toastr.warning('{{ session('warning') }}');
                @endif

                @if(session('info'))
                    this.$toastr.info('{{ session('info') }}');
                @endif
            },
        }
    }
</script>
@endpush
