 <!-- Leaflet CSS -->
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
 <!-- Leaflet JS -->
 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const photoModal = document.getElementById('photoModal');
         photoModal.addEventListener('show.bs.modal', function(event) {
             let trigger = event.relatedTarget;
             let imageSrc = trigger.getAttribute('data-bs-image');
             let modalImage = photoModal.querySelector('#modalImage');
             modalImage.src = imageSrc;
         });
     });


     // Coordinates for Panchayat Samiti Nandgaon
     const nandgaonLatLng = ['{{ $navbar->lat ?? '00.000' }}', '{{ $navbar->lon ?? '00.000' }}'];

     // Initialize the map
     const map = L.map('leafletMap').setView(nandgaonLatLng, 15);

     // Add OpenStreetMap tiles
     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
         attribution: '© OpenStreetMap contributors',
         maxZoom: 10,
     }).addTo(map);

     // Add marker
     const marker = L.marker(nandgaonLatLng).addTo(map);
     marker.bindPopup("<b>{{ $navbar->name ?? 'Name ' }} {{ $navbar->address ?? 'Address' }}").openPopup();
 </script>
 </main>
 <!-- Footer Updated-->
 <footer>
     <div class="container">
         <div class="row">
             <div class="col-md-4 mb-3">
                 <h5>{{ $navbar->name ?? 'पंचायत समिती' }}</h5>
                 <p>{{ $navbar->footer_desc ?? 'पंचायत समिती' }}</p>
             </div>
             <div class="col-md-4 mb-3">
                 <h5>झटपट दुवे</h5>
                 <p><a href="#welcome">स्वागत</a></p>
                 <p><a href="#news">अभियान</a></p>
                 <p><a href="#schemes">शासकीय योजना</a></p>
                 <p><a href="#places">प्रसिद्ध स्थळे</a></p>
             </div>
             <div class="col-md-4 mb-3">
                 <h5>संपर्क</h5>
                 <p>📍 {{ $navbar->address ?? 'पंचायत समिती' }}</p>
                 <p>📧 @if ($navbar->email_id == 'dummy@gmail.com')
                         {{ '  ' }}
                     @else
                         {{ $navbar->email_id ?? 'email' }}
                     @endif
                 </p>
                 <p>📞 @if ($navbar->contact_number == '0000000')
                         {{ '  ' }}
                     @else
                         {{ $navbar->contact_number ?? '1234567890' }}
                     @endif
                 </p>
             </div>
         </div>
         <div class="text-center mt-3">
             © {{ $navbar->name ?? 'पंचायत समिती' }} • <span id="year"></span>
         </div>
     </div>
 </footer>
 <script>
     document.getElementById("year").textContent = new Date().getFullYear();
 </script>
 <!-- Back to top -->
 <button id="backToTop" aria-label="Back to top"><i class="fas fa-arrow-up"></i></button>
 <!-- Scripts -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
 <script>
     AOS.init();
     const root = document.documentElement;
     const minFont = 12,
         maxFont = 24,
         defaultFont = 16;
     let currentFont = parseInt(getComputedStyle(document.documentElement).fontSize) || defaultFont;

     function applyRootFont(size) {
         if (size < minFont) size = minFont;
         if (size > maxFont) size = maxFont;
         root.style.fontSize = size + "px";
         currentFont = size;
     }
     document.getElementById('increaseFont').addEventListener('click', () => applyRootFont(currentFont + 1));
     document.getElementById('decreaseFont').addEventListener('click', () => applyRootFont(currentFont - 1));
     document.getElementById('resetFont').addEventListener('click', () => applyRootFont(defaultFont));

     function toggleDark() {
         document.body.classList.toggle('dark');
     }
     window.toggleDark = toggleDark;

     function applyColor(color) {
         root.style.setProperty('--primary', color);

         // Update all buttons
         document.querySelectorAll('.btn-primary').forEach(el => {
             el.style.backgroundColor = color;
             el.style.borderColor = color;
         });

         // Update navbar to solid color (no gradient)
         document.querySelectorAll('.navbar').forEach(n => {
             n.style.background = color;
         });

         // Update footer to solid color
         const footer = document.querySelector('footer');
         if (footer) footer.style.background = color;

         // Update back to top button
         const back = document.getElementById('backToTop');
         if (back) back.style.backgroundColor = color;
     }

     function toggleColorPicker() {
         const el = document.getElementById('colorPicker');
         el.style.display = (el.style.display === 'block') ? 'none' : 'block';
     }
     window.toggleColorPicker = toggleColorPicker;
     let marqueeRunning = true;

     function toggleMarquee() {
         const m = document.getElementById('marqueeText');
         const btn = document.getElementById('marqueeToggle');
         if (!m) return;
         if (marqueeRunning) {
             m.style.animationPlayState = 'paused';
             if (btn) btn.textContent = '▶️';
         } else {
             m.style.animationPlayState = 'running';
             if (btn) btn.textContent = '⏸';
         }
         marqueeRunning = !marqueeRunning;
     }
     window.toggleMarquee = toggleMarquee;
     // const back = document.getElementById('backToTop'); window.addEventListener('scroll', () => { if (window.scrollY > 300) back.style.display = 'block'; else back.style.display = 'none'; }); back.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

     /* Back to top */
     let backToTop = document.getElementById("backToTop");
     window.onscroll = function() {
         if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
             backToTop.style.display = "block";
         } else {
             backToTop.style.display = "none";
         }
     };
     backToTop.onclick = function() {
         window.scrollTo({
             top: 0,
             behavior: 'smooth'
         });
     };

     document.addEventListener('DOMContentLoaded', () => {
         applyColor(document.getElementById('colorPicker').value || getComputedStyle(root).getPropertyValue(
             '--primary').trim());
         applyRootFont(currentFont);
     });
 </script>
 <script>
     $(document).ready(function() {

         applyColor('{{ $navbar->color ?? 'red' }}');
         $('.dataTables_wrapper .dataTables_paginate .paginate_button').addClass('btn btn-sm');

         /* DataTables init */
         $('.newsTable').DataTable({

             paging: true,
             searching: false,
             lengthChange: false,
             pageLength: 10,
             responsive: true,
             responsive: true,
             language: {
                 url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/mr.json"
             },
             ordering: false
         });

     });
 </script>
 </body>

 </html>
