{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('administrator.classrooms.index') }}" method="get">
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
                            <input type="text" class="form-control" placeholder="Masukkan Nama"
                                value="{{ request('name') }}" name="name" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Wali Kelas</label>
                        <select class="form-control selectric" name="user_id">
                            <option selected disabled>Pilih Wali Kelas</option>
                            @foreach ($teachers as $item)
                                <option value="{{ $item->id }}" {{ request('user_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Biaya SPP / Bulan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    Rp.
                                </div>
                            </div>
                            <input type="numeric" class="form-control"
                                id="price-input" name="spp_fee" value="{{ request('spp_fee') }}" placeholder="250000"
                                autocomplete="off">
                        </div>
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
