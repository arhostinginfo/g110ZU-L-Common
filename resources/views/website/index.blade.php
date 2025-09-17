 @extends('website.layout.header')

 @section('content')
     <div class="page-container">
         <!-- Carousel -->
         <div class="mb-3" data-aos="fade-up">
             <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                 <div class="carousel-inner">
                     @foreach ($slider as $i => $data)
                         <div class="carousel-item @if ($i == 0) active @endif"><img
                                 src="{{ asset('storage/' . ($data->photo ?? 'default.jpg')) }}" class="d-block w-100"
                                 alt="{{ $data->name ?? 'image' }}"></div>
                     @endforeach
                 </div>
                 <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Prev</span>
                 </button>
                 <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Next</span>
                 </button>
             </div>
         </div>
         <!-- Marquee -->
         <div class="mb-3 marquee-wrap" data-aos="fade-up">
             <div class="d-flex align-items-center" style="padding:6px 12px;">
                 <div class="me-3"><i class="fa fa-bullhorn" aria-hidden="true"></i></div>
                 <div class="flex-grow-1 overflow-hidden">
                     <div id="marqueeText" class="marquee"><span
                             class="section-title">{{ $marquee ?? 'Scrolling News' }}</span>
                     </div>
                 </div>
                 <div class="ms-3">
                     <button id="marqueeToggle" class="btn btn-sm btn-primary" onclick="toggleMarquee()">⏸</button>
                 </div>
             </div>
         </div>
     </div>
     <!-- page-container -->
     <!-- Main content -->
     <main class="page-container">
         <!-- Welcome -->
         <section id="welcome" class="card-section" data-aos="fade-up">
             <div class="row align-start">
                 <div class="col-lg-12">
                     <div class="section-title">{{ $welcomenote->title ?? 'Welcome' }}</div>
                     <p>
                         @if (!empty($welcomenote) && !empty($welcomenote->content))
                             {!! $welcomenote->content !!}
                         @else
                             <p>No welcome note available.</p>
                         @endif
                     </p>
                 </div>
             </div>
             </div>
         </section>



         <!-- Video Gallery -->
         <section id="gallary" class="card-section" data-aos="fade-up">
             <div class="row align-start">
                 <div class="col-lg-12">
                     <div class="section-title">चलतचित्र प्रदर्शनी</div>
                     <div class="row">
                         @foreach ($gallay_videos as $i => $gallay_video)
                             <div class="col-md-4 col-sm-6 mb-4">
                                 <h6 class="mt-2">{{ $gallay_video->name ?? 'शीर्षक उपलब्ध नाही' }}</h6>
                                 <div class="video-wrapper text-center">
                                     <video controls class="w-100 rounded shadow-sm mb-2">
                                         <source
                                             src="{{ asset('storage/' . ($gallay_video->attachment ?? 'default.mp4')) }}"
                                             type="video/mp4">
                                         Your browser does not support the video tag.
                                     </video>

                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </div>
         </section>



         <!-- Photo Gallery -->
         <section id="gallary" class="card-section" data-aos="fade-up">
             <div class="row align-start">
                 <div class="col-lg-12">
                     <div class="section-title">छायाचित्र प्रदर्शनी</div>
                     <div class="row">
                         @foreach ($gallay_photos as $i => $gallay_photo)
                             <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                 <h6 class="mt-2">{{ $gallay_photo->name ?? 'शीर्षक उपलब्ध नाही' }}</h6>
                                 <div class="photo-wrapper">
                                     <img src="{{ asset('storage/' . ($gallay_photo->attachment ?? 'default.jpg')) }}"
                                         class="galarysetting img-fluid rounded shadow-sm cursor-pointer"
                                         alt="{{ $gallay_photo->name ?? 'name of image' }}" data-bs-toggle="modal"
                                         data-bs-target="#photoModal"
                                         data-bs-image="{{ asset('storage/' . ($gallay_photo->attachment ?? 'default.jpg')) }}">
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </div>
         </section>

         <!-- Modal -->
         <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered modal-lg">
                 <div class="modal-content bg-transparent border-0 shadow-none">
                     <div class="modal-header border-0">
                         <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"
                             aria-label="Close"></button>
                     </div>
                     <div class="modal-body text-center p-0">
                         <img id="modalImage" src="" class="img-fluid rounded shadow" alt="preview">
                     </div>
                 </div>
             </div>
         </div>


       




         <!-- Abhiyan -->
         <section id="news" class="card-section" data-aos="fade-up">
             <div class="section-title">अभियान</div>
             <div class="table-responsive">
                 <table class="newsTable display table table-striped" style="width:100%">
                     <thead>
                         <tr>
                             <th>क्र. नं.</th>
                             <th>बातमी</th>
                             <th>दिनांक</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($AbhiyanAll as $i => $sadsya)
                             <tr>
                                 <td>{{ $i + 1 }}</td>
                                 <td>{{ $sadsya->abhiyan_name ?? 'abhiyan_name' }}</td>
                                 <td>{{ date('d-m-Y', strtotime($sadsya->abhiyan_date ?? '1970-01-01')) }}</td>

                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </section>



         <!-- पंचायत समिती सदस्य -->
         <section id="committee_members" class="card-section" data-aos="fade-up">
             <h3 class="section-title">समिती सदस्य तपशील</h3>
             <div class="table-responsive">
                 <table class="newsTable display table table-striped" style="width:100%">
                     <thead>
                         <tr>
                             <th>क्र. नं.</th>
                             <th>पदनाम</th>
                             <th>नाव</th>
                             <th>मोबाईल नंबर</th>
                             <th>ई-मेल आयडी</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($sadsyaAll as $i => $sadsya)
                             <tr>
                                 <td>{{ $i + 1 }}</td>
                                 <td>{{ $sadsya->designation ?? 'designation' }}</td>
                                 <td>{{ $sadsya->name ?? 'name' }}</td>
                                 <td> {{ $sadsya->mobile ?? 'mobile' }}</td>
                                 <td>@if($sadsya->email == 'dummy@gmail.com') {{'  ' }} @else {{ $sadsya->email ?? 'email' }} @endif</td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </section>




         <!-- Officers Contact Details -->
         <section id="officers_details" class="card-section" data-aos="fade-up">
             <h3 class="section-title">अधिकाऱ्यांचा संपर्क तपशील</h3>
             <div class="table-responsive">
                 <table class="newsTable display table table-striped" style="width:100%">
                     <thead>
                         <tr>
                             <th>क्र. नं.</th>
                             <th>पदनाम</th>
                             <th>नाव</th>
                             <th>मोबाईल नंबर</th>
                             <th>ई-मेल आयडी</th>
                         </tr>
                     </thead>
                     <tbody>

                         @foreach ($officerData as $i => $officer)
                             <tr>
                                 <td>{{ $i + 1 }}</td>
                                 <td>{{ $officer->designation ?? 'designation' }}</td>
                                 <td>{{ $officer->name ?? 'name' }}</td>
                                 <td> {{ $officer->mobile ?? 'mobile' }}</td>
                                 <td>@if($officer->email == 'dummy@gmail.com') {{'  ' }} @else {{ $officer->email ?? 'email' }} @endif</td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </section>


         <!-- Officers Photo -->
         <section id="places" class="card-section" data-aos="fade-up">
             <div class="container">
                 <div class="section-title">
                 </div>

                 <div
                     class="col-12 col-sm-6 col-lg-12 d-flex justify-content-center align-items-center text-center place-card">
                     @foreach ($officerData as $i => $officer_photo)
                         <div class="hovereffect w-100">
                             <img src="{{ asset('storage/' . ($officer_photo->photo ?? 'default.jpg')) }}"
                                 alt="{{ $locations->name ?? 'name' }}" class="rounded-circle mb-2"
                                 style="width:80px; height:80px; object-fit:cover;">
                             <h5 class=" section-title mb-2">{{ $officer_photo->name ?? 'name' }}</h5>
                             <div class="overlay">
                                 <h2 class=" section-title one_rem">{{ $officer_photo->designation ?? 'designation' }}
                                 </h2>
                             </div>
                         </div>
                     @endforeach
                 </div>

             </div>
         </section>

         <!-- Schemes -->
         <section id="schemes" class="card-section" data-aos="fade-up">
             <div class="section-title">शासकीय योजना</div>
             <div class="table-responsive">
                 <table class="newsTable display table table-striped" style="width:100%">
                     <thead>
                         <tr>
                             <th>योजना</th>
                             <th>तपशील</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($yojna_all as $i => $yojna)
                             <tr>
                                 <td>{{ $yojna->name ?? 'Yojna name' }}</td>
                                 <td>
                                     @if ($yojna->type_attachment == 'Image')
                                         <img style="height: 250px;width: 250px;"
                                             src="{{ asset('storage/' . ($yojna->attachment ?? 'default.jpg')) }}"
                                             alt="{{ $yojna->name ?? 'image name' }}" class="img-fluid rounded mb2">
                                     @elseif($yojna->type_attachment == 'Link')
                                         <a class="one_rem info btn btn-primary btn-sm mt-2"
                                             href="{{ $yojna->attachment_link ?? 'image name' }}" target="_blank">इथे
                                             क्लिक करा </a>
                                     @elseif($yojna->type_attachment == 'PDF')
                                         <a href="{{ asset('storage/' . $yojna->attachment) }}" target="_blank"
                                             class="one_rem info btn btn-primary btn-sm mt-2">
                                             PDF उघडा / डाउनलोड करा
                                         </a>
                                     @endif
                                 </td>
                             </tr>
                         @endforeach

                     </tbody>
                 </table>
             </div>
         </section>

         <!-- Places -->
         <section id="places" class="card-section" data-aos="fade-up">
             <div class="container">
                 <div class="section-title">प्रसिद्ध स्थळे</div>
                 <div class="row g-4 places">
                     @foreach ($famouslocations as $i => $locations)
                         <div
                             class="col-12 col-sm-6 col-lg-4 d-flex flex-column align-items-center text-center place-card">
                             <img src="{{ asset('storage/' . ($locations->photo ?? 'default.jpg')) }}"
                                 alt="{{ $locations->name ?? 'image name' }}"
                                 class="img-fluid rounded mb2"><strong>{{ $locations->name ?? 'Short Description' }}</strong>
                             <p>{{ $locations->desc ?? 'Description' }}
                             </p>
                         </div>
                     @endforeach

                 </div>
             </div>
         </section>



         <!-- Contact form -->
         <section id="contact" class="card-section" data-aos="fade-up">
             <div class="section-title">संपर्क</div>

             @if (session('success'))
                 <div class="alert alert-success">{{ session('success') }}</div>
             @endif

             <form action="{{ route('frontwebsitecontact.store') }}" method="POST">
                 @csrf
                 <div class="mb-2">
                     <input type="text" name="name" class="form-control" placeholder="नाव" required>
                 </div>
                 <div class="mb-2">
                     <input type="email" name="email" class="form-control" placeholder="ईमेल" required>
                 </div>
                 <div class="mb-2">
                     <textarea name="message" class="form-control" rows="3" placeholder="संदेश" required></textarea>
                 </div>
                 <div class="mb-2">
                     <input type="number" name="mobile_no" class="form-control" rows="3"
                         placeholder="मोबाईल नंबर" required>
                 </div>
                 <button type="submit" class="btn btn-primary">पाठवा</button>
             </form>
         </section>



         <section id="mopr" class="card-section" data-aos="fade-up">
             <div class="container">
                 <!-- Section Title -->
                 <div class="section-title mb-4">महत्वाच्या लिंक</div>
                 <div class="accordion" id="moprAccordion">
                     <!-- एम ओपी आर -->
                     <div class="accordion-item">
                         <h2 class="accordion-header" id="headingMopr1">
                             <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapseMopr1" aria-expanded="false" aria-controls="collapseMopr1">
                                 🏛 एम ओपी आर
                             </button>
                         </h2>
                         <div id="collapseMopr1" class="accordion-collapse collapse show" aria-labelledby="headingMopr1"
                             data-bs-parent="#moprAccordion">
                             <div class="accordion-body">
                                 <div class="row g-4">
                                     <!-- GPDP -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">जीपीडीपी</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://gpdp.nic.in/" target="_blank">इथे क्लिक करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- पंचायत निर्णय पोर्टलसभा -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">पंचायत निर्णय पोर्टलसभा</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://meetingonline.gov.in/" target="_blank">इथे क्लिक
                                                     करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- India@75 -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">India@75</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://indiaat75.nic.in/" target="_blank">इथे क्लिक करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- LGD -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">एल जी डी</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://lgdirectory.gov.in/" target="_blank">इथे क्लिक करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- ऑडिट ऑनलाइन -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">ऑनलाइन लेखा परीक्षा</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://auditonline.gov.in/" target="_blank">इथे क्लिक करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- नागरिक चार्टर -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">नागरिक चार्टर</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://panchayatcharter.nic.in/#/" target="_blank">इथे क्लिक
                                                     करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- ग्राम ऊर्जा स्वराज -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">ग्राम ऊर्जा स्वराज</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://egramswaraj.gov.in/urjaDashboard.do"
                                                     target="_blank">इथे क्लिक
                                                     करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- सर्विस प्लस -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">सर्विस प्लस</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://serviceonline.gov.in/" target="_blank">इथे क्लिक
                                                     करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- प्रशिक्षण प्रबंधन -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">प्रशिक्षण प्रबंधन</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://trainingonline.gov.in/" target="_blank">इथे क्लिक
                                                     करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- आरजीएसए -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">आरजीएसए</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://rgsa.gov.in/" target="_blank">इथे क्लिक करा</a>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- पंचायत पुरस्कार -->
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">पंचायत पुरस्कार</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="http://panchayataward.gov.in/" target="_blank">इथे क्लिक
                                                     करा</a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <!-- महाराष्ट्र राज्य ग्रामीण जीवनोन्नती अभियान -->
                     <div class="accordion-item">
                         <h2 class="accordion-header" id="headingMopr2">
                             <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapseMopr2" aria-expanded="false" aria-controls="collapseMopr2">
                                 🏛 महाराष्ट्र राज्य ग्रामीण जीवनोन्नती अभियान
                             </button>
                         </h2>
                         <div id="collapseMopr2" class="accordion-collapse collapse" aria-labelledby="headingMopr2"
                             data-bs-parent="#moprAccordion">
                             <div class="accordion-body">
                                 <div class="row g-4">
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">महाराष्ट्र राज्य ग्रामीण जीवनोन्नती अभियान</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://www.umed.in/" target="_blank">इथे क्लिक करा</a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <!-- स्वच्छ भारत अभियान -->
                     <div class="accordion-item">
                         <h2 class="accordion-header" id="headingMopr3">
                             <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapseMopr3" aria-expanded="false" aria-controls="collapseMopr3">
                                 🏛 स्वच्छ भारत अभियान
                             </button>
                         </h2>
                         <div id="collapseMopr3" class="accordion-collapse collapse" aria-labelledby="headingMopr3"
                             data-bs-parent="#moprAccordion">
                             <div class="accordion-body">
                                 <div class="row g-4">
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">स्वच्छ भारत अभियान</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://swachhbharatmission.ddws.gov.in/" target="_blank">इथे
                                                     क्लिक करा</a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <!-- महात्मा गांधी राष्ट्रीय ग्रामीण रोजगार हमी योजना -->
                     <div class="accordion-item">
                         <h2 class="accordion-header" id="headingMopr4">
                             <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapseMopr4" aria-expanded="false" aria-controls="collapseMopr4">
                                 🏛 महात्मा गांधी राष्ट्रीय ग्रामीण रोजगार हमी योजना
                             </button>
                         </h2>
                         <div id="collapseMopr4" class="accordion-collapse collapse" aria-labelledby="headingMopr4"
                             data-bs-parent="#moprAccordion">
                             <div class="accordion-body">
                                 <div class="row g-4">
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">महात्मा गांधी राष्ट्रीय ग्रामीण रोजगार हमी योजना</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://nregastrep.nic.in/netnrega/homestciti.aspx?state_code=18&state_name=MAHARASHTRA&lflag=eng&labels=labels"
                                                     target="_blank">इथे क्लिक करा</a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <!-- प्रधान मंत्री आवास योजना-ग्रामीण -->
                     <div class="accordion-item">
                         <h2 class="accordion-header" id="headingMopr5">
                             <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapseMopr5" aria-expanded="false" aria-controls="collapseMopr5">
                                 🏛 प्रधान मंत्री आवास योजना-ग्रामीण
                             </button>
                         </h2>
                         <div id="collapseMopr5" class="accordion-collapse collapse" aria-labelledby="headingMopr5"
                             data-bs-parent="#moprAccordion">
                             <div class="accordion-body">
                                 <div class="row g-4">
                                     <div
                                         class="col-12 col-sm-6 col-lg-3 d-flex flex-column align-items-center text-center place-card">
                                         <div class="hovereffect w-100">
                                             <div class="overlay">
                                                 <h2 class="one_rem">प्रधान मंत्री आवास योजना-ग्रामीण</h2>
                                                 <a class="one_rem info btn btn-primary btn-sm mt-2"
                                                     href="https://pmayg.nic.in/netiayHome/home.aspx/" target="_blank">इथे
                                                     क्लिक
                                                     करा</a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </section>

         <!-- Map Section -->
         <section id="map" class="card-section" data-aos="fade-up">
             <div class="section-title">स्थानिक नकाशा</div>
             <div id="leafletMap"
                 style="width:100%;height:300px;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
             </div>
         </section>
     @endsection
