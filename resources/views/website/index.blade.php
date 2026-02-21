 @extends('website.layout.header')

 @section('content')
     <div class="page-container">
         <!-- Carousel -->
         <div class="mb-3" data-aos="fade-up">

             @if (count($slider))
                 <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                     <div class="carousel-inner">
                         @foreach ($slider as $i => $data)
                             <div class="carousel-item @if ($i == 0) active @endif"><img
                                     src="{{ asset('storage/' . ($data->photo ?? 'default.jpg')) }}" class="d-block w-100"
                                     alt="{{ $data->name ?? 'image' }}"></div>
                         @endforeach
                     </div>
                     <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel"
                         data-bs-slide="prev">
                         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                         <span class="visually-hidden">Prev</span>
                     </button>
                     <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel"
                         data-bs-slide="next">
                         <span class="carousel-control-next-icon" aria-hidden="true"></span>
                         <span class="visually-hidden">Next</span>
                     </button>
                 </div>
             @else
                 <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                     <div class="carousel-inner">
                         <div class="carousel-item active"><img src="{{ asset('asset/dummy_images/gp.png') }}"
                                 class="d-block w-100" alt="{{ 'image' }}"></div>
                     </div>
                 </div>
             @endif
         </div>
         <!-- Marquee -->
         @if ($marquee)
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
         @else
             <div class="mb-3 marquee-wrap" data-aos="fade-up">
                 <div class="d-flex align-items-center" style="padding:6px 12px;">
                     <div class="me-3"><i class="fa fa-bullhorn" aria-hidden="true"></i></div>
                     <div class="flex-grow-1 overflow-hidden">
                         <div id="marqueeText" class="marquee"><span class="section-title">"मुख्यमंत्री समृद्ध पंचायतराज
                                 अभियान शुभारंभ १७ सप्टेंबर २०२५ रोजी सकाळी १० वाजता"</span>
                         </div>
                     </div>
                     <div class="ms-3">
                         <button id="marqueeToggle" class="btn btn-sm btn-primary" onclick="toggleMarquee()">⏸</button>
                     </div>
                 </div>
             </div>
         @endif




     </div>
     <!-- page-container -->
     <!-- Main content -->
     <main class="page-container">
         <!-- Welcome -->
         <section id="welcome" class="card-section" data-aos="fade-up">
             @if ($welcomenote)
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
             @else
                 <div class="container">
                     <h4 style="color: #0056b3; border-bottom: 3px solid #0056b3; padding-bottom: 5px; margin-top: 20px;">
                         ग्रामपंचायतमध्ये आपले स्वागत आहे.</h4>

                     <p>ग्रामपंचायतीचे कार्य विविध क्षेत्रांमध्ये विभागलेले आहे:</p>

                     <h5 id="public-works" style="color: #d9534f; margin-top: 15px;">अ. सार्वजनिक सुविधा आणि बांधकाम (Public
                         Utilities and Construction)</h5>
                     <ul style="list-style-type: none; padding-left: 0;">
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">पाणीपुरवठा:</span>
                             पिण्याच्या पाण्याची व्यवस्था करणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">दिवाबत्ती:</span>
                             गावातील रस्त्यांवर पथदिवे (Street Lights) लावणे व त्यांची देखभाल करणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">रस्ते:</span>
                             गावातील रस्ते, पूल, नाले (Drains) यांची बांधणी व दुरुस्ती करणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">सार्वजनिक
                                 स्वच्छता:</span> गावातील सार्वजनिक जागांची व गटारांची स्वच्छता राखणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">बांधकामे:</span>
                             सार्वजनिक सभागृह, वाचनालये, व्यायामशाळा, क्रीडांगणे, इत्यादींची व्यवस्था करणे.
                         </li>
                     </ul>

                     <h5 id="social-welfare" style="color: #d9534f; margin-top: 15px;">ब. सामाजिक आणि कल्याणकारी कार्ये
                         (Social and Welfare Functions)</h5>
                     <ul style="list-style-type: none; padding-left: 0;">
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">शिक्षण:</span>
                             प्राथमिक शिक्षणाच्या सुविधा उपलब्ध करून देणे आणि साक्षरता वाढवणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">आरोग्य:</span>
                             सार्वजनिक आरोग्य आणि स्वच्छता राखणे, वैद्यकीय सेवांसाठी मदत करणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">समाज
                                 कल्याण:</span> दारूबंदी, जुगारबंदी यांस प्रोत्साहन देणे. निराधार, विधवा, अपंग व्यक्तींना
                             शासकीय योजनांचा लाभ मिळवून देणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">जन्म-मृत्यू-विवाह
                                 नोंदणी:</span> गावातील जन्म, मृत्यू आणि विवाहाची अधिकृत नोंदणी ठेवणे.
                         </li>
                     </ul>

                     <h5 id="financial-admin" style="color: #d9534f; margin-top: 15px;">क. आर्थिक आणि प्रशासकीय कार्ये
                         (Financial and Administrative Functions)</h5>
                     <ul style="list-style-type: none; padding-left: 0;">
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">कर
                                 आकारणी:</span> घरपट्टी, पाणीपट्टी, व्यवसाय कर (Trade Tax) इत्यादी स्थानिक कर आणि शुल्के
                             आकारणे व त्यांची वसुली करणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">नियोजन:</span>
                             गावाच्या विकासासाठी वार्षिक अंदाजपत्रक (Budget) आणि ग्राम विकास आराखडा (GPDP - Gram Panchayat
                             Development Plan) तयार करणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">योजना
                                 अंमलबजावणी:</span> केंद्र व राज्य शासनाच्या विविध विकास योजना (उदा. मनरेगा, घरकुल योजना)
                             गावामध्ये राबवणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">अभिलेख
                                 (Records):</span> ग्रामपंचायतीचे दफ्तर, मालमत्ता नोंदी व इतर कागदपत्रे सुस्थितीत ठेवणे.
                         </li>
                     </ul>

                     <h5 id="agriculture" style="color: #d9534f; margin-top: 15px;">ड. कृषी आणि पशुसंवर्धन (Agriculture
                         and Animal Husbandry)</h5>
                     <ul style="list-style-type: none; padding-left: 0;">
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">शेती:</span>
                             शेतीत सुधारणा करण्यासाठी शेतकऱ्यांना मार्गदर्शन करणे.
                         </li>
                         <li style="margin-bottom: 10px; padding-left: 20px; position: relative;"><span
                                 style="color: #5cb85c;  margin-left: -1em; width: 1em; display: inline-block;">&#x2022;</span>
                             <span style=" font-size: 1em; color: #333; margin-bottom: 5px;">पशुसंवर्धन:</span>
                             पशुधनाची काळजी घेण्यासाठी प्रयत्न करणे.
                         </li>
                     </ul>
                 </div>
             @endif

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
             @if (count($AbhiyanAll))
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
             @else
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
                             <tr>
                                 <td>1</td>
                                 <td>मुख्यमंत्री समृद्ध पंचायतराज अभियान शुभारंभ १७ सप्टेंबर २०२५ रोजी सकाळी १० वाजता </td>
                                 <td>17-09-2025</td>

                             </tr>
                         </tbody>
                     </table>
                 </div>
             @endif
         </section>


         @if (Str::contains(url()->current(), 'aapligrampanchayat.com'))

             <!-- पंचायत समिती सदस्य -->
             <section id="committee_members" class="card-section" data-aos="fade-up">
                 <h3 class="section-title">समिती सदस्य तपशील</h3>
                 @if (count($sadsyaAll))
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
                                         <td>
                                             @if ($sadsya->email == '0000000')
                                                 {{ '  ' }}
                                             @else
                                                 {{ $sadsya->mobile ?? 'mobile' }}
                                             @endif
                                         </td>
                                         <td>
                                             @if ($sadsya->email == 'dummy@gmail.com')
                                                 {{ '  ' }}
                                             @else
                                                 {{ $sadsya->email ?? 'email' }}
                                             @endif
                                         </td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 @else
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
                                 <tr>
                                     <td>1</td>
                                     <td>सरपंच</td>
                                     <td>सरपंच नाव</td>
                                     <td>
                                         00000000
                                     </td>
                                     <td>
                                         dummy@gmail.com
                                     </td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                 @endif
             </section>

             <!-- Sadysay Photo -->
             <section id="places" class="card-section" data-aos="fade-up">
                 <div class="container">
                     <div class="section-title">
                     </div>

                     <div class="row justify-content-center">
                         @if (count($sadsyaAll))
                             @foreach ($sadsyaAll as $i => $sadsya_photo)
                                 <div class="col-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                                     <div class="hovereffect text-center w-100">
                                         <img src="{{ asset('storage/' . ($sadsya_photo->photo ?? 'default.jpg')) }}"
                                             alt="{{ $sadsya_photo->name ?? 'name' }}" class="rounded-circle mb-2"
                                             style="width:88px; height:105px; object-fit:cover;">
                                         <h5 class="section-title mb-2">{{ $sadsya_photo->name ?? 'name' }}</h5>
                                         <div class="overlay">
                                             <h2 class="section-title one_rem">
                                                 {{ $sadsya_photo->designation ?? 'designation' }}
                                             </h2>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         @else
                             <div class="col-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                                 <div class="hovereffect text-center w-100">
                                     <img src="{{ asset('asset/dummy_images/person.jpg') }}" alt="सरपंच"
                                         class="rounded-circle mb-2" style="width:88px; height:105px; object-fit:cover;">
                                     <h5 class="section-title mb-2">सरपंच नाव</h5>
                                     <div class="overlay">
                                         <h2 class="section-title one_rem">सरपंच
                                         </h2>
                                     </div>
                                 </div>
                             </div>
                         @endif
                     </div>
                 </div>
             </section>
         @endif

         <!-- Officers Contact Details -->
         <section id="officers_details" class="card-section" data-aos="fade-up">
             <h3 class="section-title">अधिकाऱ्यांचा संपर्क तपशील</h3>
             @if (count($officerData))
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
                                     <td>
                                         @if ($officer->email == '0000000')
                                             {{ '  ' }}
                                         @else
                                             {{ $officer->mobile ?? 'mobile' }}
                                         @endif
                                     </td>
                                     <td>
                                         @if ($officer->email == 'dummy@gmail.com')
                                             {{ '  ' }}
                                         @else
                                             {{ $officer->email ?? 'email' }}
                                         @endif
                                     </td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             @else
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

                             <tr>
                                 <td>1</td>
                                 <td>ग्रामवीकास अधिकारी</td>
                                 <td>ग्रामवीकास अधिकारी नाव</td>
                                 <td>
                                     000000000
                                 </td>
                                 <td>
                                     dummy@gmail.com
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             @endif
         </section>


         <!-- Officers Photo -->
         <section id="places" class="card-section" data-aos="fade-up">
             <div class="container">
                 <div class="section-title">
                 </div>

                 <div class="row justify-content-center">
                     @if (count($officerData))
                         @foreach ($officerData as $i => $officer_photo)
                             <div class="col-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                                 <div class="hovereffect text-center w-100">
                                     <img src="{{ asset('storage/' . ($officer_photo->photo ?? 'default.jpg')) }}"
                                         alt="{{ $officer_photo->name ?? 'name' }}" class="rounded-circle mb-2"
                                         style="width:88px; height:105px; object-fit:cover;">
                                     <h5 class="section-title mb-2">{{ $officer_photo->name ?? 'name' }}</h5>
                                     <div class="overlay">
                                         <h2 class="section-title one_rem">
                                             {{ $officer_photo->designation ?? 'designation' }}
                                         </h2>
                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     @else
                         <div class="col-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                             <div class="hovereffect text-center w-100">
                                 <img src="{{ asset('asset/dummy_images/person.jpg') }}" alt="ग्रामवीकास अधिकारी"
                                     class="rounded-circle mb-2" style="width:88px; height:105px; object-fit:cover;">
                                 <h5 class="section-title mb-2">ग्रामवीकास अधिकारी नाव</h5>
                                 <div class="overlay">
                                     <h2 class="section-title one_rem">ग्रामवीकास अधिकारी
                                     </h2>
                                 </div>
                             </div>
                         </div>
                     @endif
                 </div>
             </div>
         </section>

         <!-- Schemes -->
         <section id="schemes" class="card-section" data-aos="fade-up">
             <div class="section-title">शासकीय योजना</div>

             @if (count($yojna_all))
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
             @else
                 <div class="table-responsive">
                     <div id="DataTables_Table_3_wrapper" class="dataTables_wrapper no-footer">
                         <table class="newsTable display table table-striped dataTable no-footer dtr-inline"
                             style="width: 100%;" id="DataTables_Table_3" aria-describedby="DataTables_Table_3_info">
                             <thead>
                                 <tr>
                                     <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 849px;">
                                         योजना</th>
                                     <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 148px;">
                                         तपशील</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr class="odd">
                                     <td class="dtr-control" tabindex="0">अनुसूचित जातीच्या मुला-मुलींना परदेशात विशेष
                                         अध्ययन करण्यासाठी राजर्षी शाहू महाराज शिष्यवृत्ती योजना</td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                                 <tr class="even">
                                     <td class="dtr-control" tabindex="0">राजर्षी छत्रपती शाहू महाराज गुणवत्ता पुरस्कार
                                     </td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                                 <tr class="odd">
                                     <td class="dtr-control" tabindex="0">सैनिकी शाळेतील अनुसूचित जातीच्या
                                         विद्यार्थ्यांना निर्वाह भत्ता योजना</td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                                 <tr class="even">
                                     <td class="dtr-control" tabindex="0">शासकीय निवासी शाळा प्रवेशासाठी माहिती</td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                                 <tr class="odd">
                                     <td class="dtr-control" tabindex="0">शासकीय वसतीगृह प्रवेशासाठीची माहिती</td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                                 <tr class="even">
                                     <td class="dtr-control" tabindex="0">कर्मवीर दादासाहेब गायकवाड सबळीकरण व स्वाभिमान
                                         योजना</td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                                 <tr class="odd">
                                     <td class="dtr-control" tabindex="0">केंद्र शासनाच्या स्टँड अप इंडिया योजनेत
                                         अनुसूचित जाती व नवबौध्द समाजाकरीता मार्जिन मनी योजना</td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                                 <tr class="even">
                                     <td class="dtr-control" tabindex="0">गटई कामगारांना पत्र्याचे स्टॉल पुरविणे योजना
                                     </td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                                 <tr class="odd">
                                     <td class="dtr-control" tabindex="0">मिनी ट्रॅक्टर योजना</td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                                 <tr class="even">
                                     <td class="dtr-control" tabindex="0">रमाई आवास योजना</td>
                                     <td>
                                         <a class="one_rem info btn btn-primary btn-sm mt-2" href="#schemes"
                                             target="_blank"
                                             style="background-color: rgb(233, 130, 12); border-color: rgb(233, 130, 12);">इथे
                                             क्लिक करा </a>
                                     </td>
                                 </tr>
                             </tbody>
                         </table>

                     </div>
                 </div>
             @endif
         </section>

         <!-- Places -->
         <section id="places" class="card-section" data-aos="fade-up">
             <div class="container">
                 <div class="section-title">प्रसिद्ध स्थळे</div>
                 @if (count($famouslocations))
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
                 @else
                     <div class="row g-4 places">
                         <div
                             class="col-12 col-sm-6 col-lg-4 d-flex flex-column align-items-center text-center place-card">
                             <img src="{{ asset('asset/dummy_images/person.jpg') }}"
                                 alt="{{ $locations->name ?? 'image name' }}" class="img-fluid rounded mb2"><strong>
                                 पर्यटन स्थळे</strong>
                             <p>ऐतिहासिक, धार्मिक आणि नैसर्गिक सौंदर्याने नटलेली अनेक प्रसिद्ध पर्यटन स्थळे माहिती
                             </p>
                         </div>

                     </div>
                 @endif
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

         <section class="max-w-screen-xl mx-auto my-6 overflow-hidden relative bg-white py-5 mb-5">
             <marquee behavior="scroll" direction="left" scrollamount="7" class="flex space-x-16 px-5">
                 <!-- Logo 1 -->
                 <a href="https://data.gov.in/" target="_blank" rel="noopener">
                     <img src="{{ asset('asset/dummy_images/other_logo/mygov.webp') }}" alt="data.gov.in"
                         class="h-12 object-contain">
                 </a>

                 <!-- Logo 2 -->
                 <a href="https://www.makeinindia.com/" target="_blank" rel="noopener">
                     <img src="{{ asset('asset/dummy_images/other_logo/makeinindia.webp') }}" alt="Make in India"
                         class="h-12 object-contain">
                 </a>

                 <!-- Logo 3 -->
                 <a href="https://www.incredibleindia.org/" target="_blank" rel="noopener">
                     <img src="{{ asset('asset/dummy_images/other_logo/incredible.webp') }}" alt="Incredible India"
                         class="h-12 object-contain">
                 </a>

                 <!-- Logo 4 -->
                 <a href="https://www.india.gov.in/" target="_blank" rel="noopener">
                     <img src="{{ asset('asset/dummy_images/other_logo/indiagovin.webp') }}" alt="india.gov.in"
                         class="h-12 object-contain">
                 </a>

                 <!-- Logo 5 -->
                 <a href="https://www.digitalindia.gov.in/" target="_blank" rel="noopener">
                     <img src="{{ asset('asset/dummy_images/other_logo/digitalindia.webp') }}" alt="Digital India"
                         class="h-12 object-contain">
                 </a>

                 <!-- Logo 6 -->
                 <a href="https://www.pmindia.gov.in/" target="_blank" rel="noopener">
                     <img src="{{ asset('asset/dummy_images/other_logo/pmindia.webp') }}" alt="PM India"
                         class="h-12 object-contain">
                 </a>
             </marquee>
         </section>

         <!-- Dakhala Form Section -->
<section id="dakhala" class="card-section" data-aos="fade-up">
    <div class="section-title">दाखला</div>

    @if (session('dakhala_success'))
        <div class="alert alert-success">{{ session('dakhala_success') }}</div>
    @endif

    <form action="{{ route('dakhala.store') }}" method="POST">
        @csrf

        <!-- मोबाईल नंबर -->
        <div class="mb-3">
            <label class="form-label">मोबाईल नंबर</label>
            <input type="tel" 
                name="mobile_no" 
                class="form-control" 
                placeholder="आपला १० अंकी मोबाईल नंबर टाका" 
                pattern="[0-9]{10}" 
                maxlength="10" 
                required>
        </div>
        <!-- अर्जदाराचे नाव -->
        <div class="mb-3">
            <label class="form-label">अर्जदाराचे नाव</label>
            <input type="text" name="applicant_name" class="form-control" placeholder="अर्जदाराचे पूर्ण नाव" required>
            <input type="hidden" name="gp_name_in_url" value="{{ request()->segment(count(request()->segments())) }}">
        </div>

        <!-- अर्जावर छापायचे नाव -->
        <div class="mb-3">
            <label class="form-label">अर्जावर छापायचे नाव</label>
            <input type="text" name="print_name" class="form-control" placeholder="अर्जावर छापायचे नाव" required>
        </div>

        <!-- पत्ता -->
        <div class="mb-3">
            <label class="form-label">पूर्ण पत्ता</label>
            <textarea name="address" class="form-control" rows="4" placeholder="आपला पूर्ण पत्ता येथे लिहा" required></textarea>
        </div>

        <!-- दाखल्याचा प्रकार -->
        <div class="mb-3">
            <label class="form-label">दाखल्याचा प्रकार निवडा</label>
            <select name="certificate_type" class="form-select" required>
                <option value="">-- निवडा --</option>
                <option value="birth_certificate">जन्म दाखला</option>
                <option value="marriage_certificate">विवाह दाखला</option>
            </select>
        </div>

        <!-- सबमिट बटण -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">सबमिट करा</button>
        </div>
    </form>
</section>

         <!-- Map Section -->
         <section id="map" class="card-section" data-aos="fade-up">
             <div class="section-title">स्थानिक नकाशा</div>
             <div id="leafletMap"
                 style="width:100%;height:300px;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
             </div>
         </section>
     @endsection
