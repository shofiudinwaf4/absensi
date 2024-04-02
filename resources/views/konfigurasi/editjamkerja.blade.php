 <form action="/konfigurasi/updatejamkerja" method="POST" id="frmjk">
     @csrf
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-barcode">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                         <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                         <path d="M8 13h1v3h-1z" />
                         <path d="M12 13v3" />
                         <path d="M15 13h1v3h-1z" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $jamkerja->kode_jam_kerja }}" id="kode_jam_kerja" class="form-control"
                     placeholder="Kode Jam Kerja" name="kode_jam_kerja">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-barcode">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                         <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                         <path d="M8 13h1v3h-1z" />
                         <path d="M12 13v3" />
                         <path d="M15 13h1v3h-1z" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $jamkerja->nama_jam_kerja }}" id="nama_jam_kerja" class="form-control"
                     placeholder="Nama Jam Kerja" name="nama_jam_kerja">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-barcode">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                         <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                         <path d="M8 13h1v3h-1z" />
                         <path d="M12 13v3" />
                         <path d="M15 13h1v3h-1z" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $jamkerja->awal_jam_masuk }}" id="awal_jam_masuk" class="form-control"
                     placeholder="Awal Jam Masuk" name="awal_jam_masuk">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-barcode">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                         <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                         <path d="M8 13h1v3h-1z" />
                         <path d="M12 13v3" />
                         <path d="M15 13h1v3h-1z" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $jamkerja->jam_masuk }}" id="jam_masuk" class="form-control"
                     placeholder="Jam Masuk" name="jam_masuk">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-file-barcode">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                         <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                         <path d="M8 13h1v3h-1z" />
                         <path d="M12 13v3" />
                         <path d="M15 13h1v3h-1z" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $jamkerja->akhir_jam_masuk }}" id="akhir_jam_masuk"
                     class="form-control" placeholder="Akhir Jam Masuk" name="akhir_jam_masuk">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <div class="input-icon mb-3">
                 <span class="input-icon-addon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-file-barcode">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                         <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                         <path d="M8 13h1v3h-1z" />
                         <path d="M12 13v3" />
                         <path d="M15 13h1v3h-1z" />
                     </svg>
                 </span>
                 <input type="text" value="{{ $jamkerja->jam_pulang }}" id="jam_pulang" class="form-control"
                     placeholder="Jam Pulang" name="jam_pulang">
             </div>
         </div>
     </div>
     <div class="row mt-2">
         <div class="col-12">
             <div class="form-group">
                 <button class="btn btn-primary w-100">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                         <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                         <path d="M14 4l0 4l-6 0l0 -4" />
                     </svg>
                     Simpan
                 </button>
             </div>
         </div>
     </div>
 </form>
