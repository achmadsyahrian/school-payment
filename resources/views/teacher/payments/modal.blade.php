{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
       <form action="{{ route('employee.payments.index') }}" method="get">
          <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pencarian Lanjutan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <div class="modal-body">
                <div class="form-group">
                   <label>Nama</label>
                   <div class="input-group">
                      <input type="text" class="form-control" placeholder="Masukkan Nama" value="{{ request("name") }}" name="name" autocomplete="off">
                   </div>
                </div>
                <div class="form-group">
                   <label>NISN</label>
                   <div class="input-group">
                      <input type="text" class="form-control" placeholder="Masukkan NISN" value="{{ request("nisn") }}" name="nisn" autocomplete="off">
                   </div>
                </div>
                <div class="form-group">
                   <label>Tahun Ajaran</label>
                   <select class="form-control selectric" name="academic_year_id">
                      <option selected disabled>Pilih Tahun Ajaran</option>
                      @foreach ($academicYears as $item)
                      <option value="{{ $item->id }}" {{ request('academic_year_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                      @endforeach
                   </select>
                </div>
                <div class="form-group">
                   <label>Kelas</label>
                   <select class="form-control selectric" name="classroom_id">
                      <option selected disabled>Pilih Kelas</option>
                      @foreach ($classrooms as $item)
                      <option value="{{ $item->id }}" {{ request('classroom_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                      @endforeach
                   </select>
                </div>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
             </div>
          </div>
       </form>
    </div>
 </div>
 
 