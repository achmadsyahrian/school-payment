@if (session()->has('error'))
{{-- <script>
   Swal.fire({
      icon: 'error', 
      title: 'Gagal!', 
      text: "{{ session('error') }}", 
      showConfirmButton: true, 
      // timer: 3000
   });
</script> --}}

<script>
   iziToast.error({
      title: 'Gagal!',
      message: '{{ session('error') }}',
      position: 'topRight'
   });
</script>

@elseif (session()->has('success'))
{{-- <script>
   Swal.fire({
      icon: 'success', 
      title: 'Berhasil!', 
      text: "{{ session('success') }}", 
      showConfirmButton: true, 
      // timer: 3000
   });

</script> --}}

<script>
   iziToast.success({
      title: 'Berhasil!',
      message: '{{ session('success') }}',
      position: 'topRight'
   });
</script>
@endif
