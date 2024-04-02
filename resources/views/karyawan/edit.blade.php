 <form action="/karyawan/{{ $karyawan->nik }}/update" method="POST" id="formKaryawan" enctype="multipart/form-data">
     @csrf
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-code-dots" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M15 12h.01" />
                         <path d="M12 12h.01" />
                         <path d="M9 12h.01" />
                         <path d="M6 19a2 2 0 0 1 -2 -2v-4l-1 -1l1 -1v-4a2 2 0 0 1 2 -2" />
                         <path d="M18 19a2 2 0 0 0 2 -2v-4l1 -1l-1 -1v-4a2 2 0 0 0 -2 -2" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $karyawan->nik }}" name="nik" id="nik" class="form-control"
                     placeholder="NIK" readonly>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                         <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                         <path d="M15 8l2 0" />
                         <path d="M15 12l2 0" />
                         <path d="M7 16l10 0" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $karyawan->nama_lengkap }}" name="nama_lengkap" id="nama_lengkap"
                     class="form-control" placeholder="Nama Lengkap">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                         <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                         <path d="M15 8l2 0" />
                         <path d="M15 12l2 0" />
                         <path d="M7 16l10 0" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $karyawan->jabatan }}" name="jabatan" id="jabatan"
                     class="form-control" placeholder="Jabatan">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path
                             d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $karyawan->no_hp }}" id="no_hp" name="no_hp" class="form-control"
                     placeholder="No HP">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <input type="file" class="form-control" name="foto" id="foto">
             <input type="hidden" name="old_foto" id="" value="{{ $karyawan->foto }}">
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <select name="kode_dept" id="kode_dept" class="form-select">
                 <option value="">Departemen</option>
                 @foreach ($departemen as $d)
                     <option value="{{ $d->kode_dept }}" {{ $karyawan->kode_dept == $d->kode_dept ? 'selected' : '' }}>
                         {{ $d->nama_dept }}</option>
                 @endforeach
             </select>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="form-group">
                 <button class="btn btn-primary w-100">Simpan</button>
             </div>
         </div>
     </div>
 </form>
