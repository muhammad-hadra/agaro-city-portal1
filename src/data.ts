import { Language, NewsArticle, Project, Department } from './types';

export const DICTIONARY: Record<string, Record<Language, string>> = {
  // Navigation & Brand
  portalName: {
    en: 'Agaro Connect Hub',
    om: 'Agaro Connect Hub',
    am: 'አጋሮ ኮኔክት ሃብ'
  },
  cityAdmin: {
    en: 'Agaro City Administration',
    om: 'Bulchiinsa Magaalaa Aggaaroo',
    am: 'የአጋሮ ከተማ አስተዳደር'
  },
  officialPortal: {
    en: 'Official Portal',
    om: 'Kuusaa Bulchiinsaa',
    am: 'ይፋዊ መድረክ'
  },
  home: {
    en: 'Home',
    om: 'Mana',
    am: 'ዋና ገጽ'
  },
  about: {
    en: 'About Agaro',
    om: "Waa'ee Aggaaroo",
    am: 'ስለ አጋሮ'
  },
  services: {
    en: 'Services',
    om: 'Tajaajiloota',
    am: 'አገልግሎቶች'
  },
  departments: {
    en: 'Government',
    om: 'Mootummaa',
    am: 'መንግስት'
  },
  news: {
    en: 'News & Events',
    om: 'Oduuf Mudannoo',
    am: 'ዜና እና ክስተቶች'
  },
  projects: {
    en: 'Projects',
    om: 'Pirojektoota',
    am: 'ፕሮጀክቶች'
  },
  contact: {
    en: 'Contact Us',
    om: 'Nu Quunnamaa',
    am: 'ያግኙን'
  },

  // Hero section
  heroTitle: {
    en: 'Building a smarter, prouder Agaro',
    om: 'Aggaaroo Bilchinaafi Boonaa Ijaaranii',
    am: 'ብልህ እና ኩሩ አጋሮን መገንባት'
  },
  heroSubtitle: {
    en: 'Your digital gateway to city services, transparent governance, and community life in the heart of Jimma Zone, Oromia, Ethiopia.',
    om: 'Karra keessan dijitaalaa tajaajila magaalaa, bulchiinsa ifaafi jireenya hawaasaa handhuura Gooroo Jimmaatti, Oromiyaa, Itoophiyaa.',
    am: 'በጅማ ዞን፣ ኦሮሚያ፣ ኢትዮጵያ እምብርት ውስጥ ለከተማ አገልግሎቶች፣ ግልጽ አስተዳደር እና ለማህበረሰብ ህይወት ዲጂታል መግቢያ በርዎ።'
  },
  quickSearchPlaceholder: {
    en: 'What service do you need today? e.g. license, complaint...',
    om: 'Tajaajila akkamii barbaaddu? Fkn: hayyama, iyyannoo...',
    am: 'ዛሬ ምን ዓይነት አገልግሎት ይፈልጋሉ? ምሳሌ፡ ፍቃድ፣ አቤቱታ...'
  },
  trackedNotice: {
    en: 'Track your existing application in real-time instantly',
    om: 'Waraqaa iyyannoo keessan yeroodhaan hordofaa',
    am: 'ያለውን ማመልከቻ በቀጥታ ይከታተሉ'
  },
  searchBtn: {
    en: 'Search',
    om: 'Barbaadi',
    am: 'ፈልግ'
  },

  // Fast Facts
  welcomeTitle: {
    en: 'Welcome to Agaro City',
    om: 'Baga Gara Aggaaroo Dhuftan',
    am: 'ወደ አጋሮ ከተማ እንኳን ደህና መጡ'
  },
  welcomeText: {
    en: 'Agaro is a vibrant town in Jimma Zone, Oromia, known for its rich coffee heritage, warm people, and growing economy. Our administration is committed to transparent, citizen-first governance.',
    om: 'Aggaaroon magaalaa kaayyoo dhimma bunaan beekamtu, hawaasa jaalala qabuufi guddina ariifataadhaan handhuura Jimmaatti argamti. Bulchiinsi keenya tajaajila haqa-qabeessa uummataaf qopheessa.',
    am: 'አጋሮ በጅማ ዞን በኦሮሚያ ክልል የምትገኝ፣ በበለጸገ የቡና ቅርሷ፣ በደግ ህዝቧ እና ታዳጊ ኢኮኖሚዋ የምትታወቅ ውብ ከተማ ናት። አስተዳደራችን ለህዝብ ቅድሚያ የሚሰጥ ግልጽ አሰራር ለመዘርጋት ቁርጠኛ ነው።'
  },
  fastFacts: {
    en: 'Fast Facts About Our City',
    om: 'Oddeeffannoofi Beekumsa Magaalaa',
    am: 'ስለ ከተማችን አጫጭር እውነታዎች'
  },

  // Services Widget
  govTitle: {
    en: 'Government at your fingertips',
    om: 'Bulchiinsa Harkatti Argatan',
    am: 'የመንግስት አገልግሎቶች በእጅዎ ስልክ'
  },
  govSubtitle: {
    en: 'Apply, pay, track and book appointments securely online — without standing in lines.',
    om: 'Iyyadhaa, kaffalaa, hordofaa dhimma keessan hunda bilisaan — sarara dhabbiitiin ala.',
    am: 'በሰልፍ ሳይቸገሩ ማመልከቻዎን ያስገቡ፣ ይክፈሉ፣ ይከታተሉ እና ቀጠሮዎችን ደህንነቱ በተጠበቀ ሁኔታ በመስመር ላይ ይያዙ።'
  },

  // Footer & Contact Info
  cityHallAddress: {
    en: 'City Hall, Main Road, Agaro, Oromia, Ethiopia',
    om: 'Kellaa Magaalaa, Daandii Guddaa, Aggaaroo, Oromiyaa, Itoophiyaa',
    am: 'ከተማ መስተዳድር ጽ/ቤት፣ ዋና መንገድ፣ አጋሮ፣ ኦሮሚያ፣ ኢትዮጵያ'
  },
  governanceIntegrity: {
    en: 'Serving citizens with integrity, transparency, and care.',
    om: 'Amanamummaa, iftoominaafi kunuunsaan tajaajiluu.',
    am: 'ህዝብን በታማኝነት፣ በግልጽነት እና በትክክለኛ እንክብካቤ ማገልገል።'
  }
};

export const NEWS_DATA: NewsArticle[] = [
  {
    id: 'news-1',
    category: 'Infrastructure',
    date: '2026-06-02',
    title: {
      en: 'New asphalt road project launched in Kebele 03',
      om: 'Pirojektiin daandii aspaaltii haaraa Kebele 03 keessatti jalqabame',
      am: 'በቀበሌ 03 አዲስ የአስፋልት መንገድ ግንባታ ፕሮጀክት ተጀመረ'
    },
    excerpt: {
      en: 'The city administration has initiated a massive 5.2 km urban road paving project starting from Kebele 03 to improve access.',
      om: 'Bulchiinsi magaalaa pirojektii daandii aspaaltii km 5.2 kebele 03 keessaa jalqabun quunnamtii fooyyeessuf murteesse.',
      am: 'የከተማው አስተዳደር ትስስርን ለማሻሻል ከቀበሌ 03 የሚጀምር የ 5.2 ኪሎ ሜትር የከተማ መንገድ ግንባታ ፕሮጀክት ሥራ አስጀምሯል።'
    },
    content: {
      en: 'The Mayor of Agaro officially launched the construction of the new 5.2 km asphalt road. This multi-million Birr infrastructure investment is co-funded by regional development schemes and municipal funds, aiming to connect residential and agricultural zones directly with the major central coffee warehouses. Completion is anticipated in 6 months, and it will bring high-quality drainage systems to minimize soil degradation during the heavy rainy seasons.',
      om: 'Kantiibaan Aggaaroo ijaarsa daandii aspaaltii km 5.2 haaraa ifatti jalqabsiisan. Pirojektiin miiliyoonaan lakkaa’amu kun guddina magaalichaatiif qooda guddaa qaba, keessumaa mana kuusa bunaa gurguddoo wal quunnamsiisuuf gargaara. ji’oota 6 keessatti xumurama jedhamee yaadama.',
      am: 'የአጋሮ ከንቲባ የ 5.2 ኪሎ ሜትር አዲሱን የአስፋልት መንገድ ግንባታ በይፋ አስጀምረዋል። ይህ በሚሊዮን የሚቆጠር ብር የላቀ መሠረተ ልማት ኢንቨስትመንት የመኖሪያ እና የግብርና ቀጠናዎችን በቀጥታ ከዋና ዋናዎቹ የቡና መጋዘኖች ጋር ለማገናኘት ያለመ ነው። በ 6 ወራት ውስጥ ይጠናቀቃል ተብሎ ይጠበቃል፣ እና በዝናብ ወቅት የተፈጥሮ አፈር መሸርሸርን ለመከላከል የሚያስችል ዘመናዊ የፍሳሽ ማስወገጃ ዘዴን ያካትታል።'
    },
    image: '/src/assets/images/agaro_landscape_1780989482675.png'
  },
  {
    id: 'news-2',
    category: 'Health',
    date: '2026-06-05',
    title: {
      en: 'Free vaccination campaign begins next Monday',
      om: 'Duulli talaallii bilisaa Wiixata dhufu jalqabama',
      am: 'ነፃ የክትባት ዘመቻ ከሚቀጥለው ሰኞ ጀምሮ ይካሄዳል'
    },
    excerpt: {
      en: 'A city-wide health initiative targeting infants and young children covering all 9 kebeles starts next Monday at local health posts.',
      om: 'Duulli talaallii masiibaa daaimmanii kebele saglanuu keessatti Wiixata dhufu buufataalee fayyaatti ifatti eegala.',
      am: 'ሁሉንም 9 ቀበሌዎች የሚያጠቃልል እና ህጻናትን ያነጣጠረ ከተማ አቀፍ የጤና ዘመቻ በሚቀጥለው ሰኞ በአካባቢው የጤና ኬላዎች ይጀምራል።'
    },
    content: {
      en: 'In collaboration with the Jimma Zone Health Department and the Ministry of Health, Agaro City is launching an extensive immunization campaign. The campaign aims to vaccinate over 12,000 children under five years of age against polio, measles, and rotavirus. Mobile clinics will also visit outer settlements to guarantee full demographic coverage. All services are entirely free.',
      om: 'Waliigaltee Waajjira Fayyaa Gooroo Jimmaafi Ministira Fayyaa waliin ta’uun Bulchiinsi Aggaaroo talaallii daaimman 12,000 oliif Wiixata jalqaba. Kuusaan talaallii kun dhukkuboota akka poliyoo, measles fi rootaavaayiras kan ittisu yoo ta’u tajaajilli hundi bilisa.',
      am: 'ከጅማ ዞን ጤና መምሪያ እና ከጤና ጥበቃ ሚኒስቴር ጋር በመተባበር የአጋሮ ከተማ ሰፊ የክትባት ዘመቻ ይጀምራል። ዘመቻው እድሜያቸው ከஐந்து ዓመት በታች የሆኑ ከ 12,000 በላይ ህፃናት ላይ የፖሊዮ፣ የኩፍኝ እና የሮታቫይረስ መከላከያ ክትባቶችን ለመስጠት ያለመ ነው። ሙሉ ሽፋን ለማረጋገጥ ተንቀሳቃሽ ክሊኒኮችም ወደ ዳር አካባቢዎች ይሄዳሉ። አገልግሎቱ ሙሉ በሙሉ በነጻ ይከናወናል።'
    }
  },
  {
    id: 'news-3',
    category: 'Agriculture',
    date: '2026-06-08',
    title: {
      en: 'Agaro coffee wins international quality award',
      om: 'Bunni Aggaaroo badhaasa qulqullinaa addunyaa mo’ate',
      am: 'የአጋሮ ቡና ዓለም አቀፍ የጥራት ሽልማት አሸነፈ'
    },
    excerpt: {
      en: 'Locally grown organic coffee from Agaro cooperatives secured first place at the global specialty coffee expo in Milan.',
      om: 'Bunni uumamaa oomisha waldaa Aggaaroo expo buna addunyaa Miilaan keessatti sadarkaa tokkoffaa argate.',
      am: 'በአጋሮ የህብረት ጨምሮ አምራቾች የሚመረተው የተፈጥሮ ኦርጋኒክ ቡና በሚላን በተካሄደው ዓለም አቀፍ ልዩ የቡና ኤክስፖ ላይ አንደኛ ደረጃን አግኝቷል።'
    },
    content: {
      en: 'We are extremely proud to announce that the coffee variety processed by the Agaro farmer cooperative unions won the prestigious Grand Prix for washing station specialty coffees in Milan. Renowned for its floral aroma, sweet jasmine undertones, and balanced citrus acidity, Agaro coffee continues to solidify its legacy as one of the fines coffees of southwestern Ethiopia, bringing economic opportunities to thousands of local smallholders.',
      om: 'Bunni waldaa qonnaan bultoota Aggaarootiin qophaa’u badhaasa guguddaa expoo Miilaan biyya Xaaliyaanitti argateera. Kunis qulqullina buna keenyaa, mi’aa isaa fi urgoofu jasmatiin beekame gooroo Jimmaaf boonsa guddaadha.',
      am: 'በአጋሮ አርሶ አደሮች የህብረት ሥራ ማህበር የተመረተው የቡና ዝርያ በሚላን በተደረገው ልዩ የቡና ኤግዚቢሽን ላይ ከፍተኛውን ሽልማት ማግኘቱን ስናበስር ታላቅ ኩራት ይሰማናል። በደማቅ የአበባ መዓዛው፣ በሚ ጣፋጭ የጃስሚን ጣዕሙ እና በተመጣጣኝ የሎሚ አሲድነቱ የሚታወቀው የአጋሮ ቡና፣ በሺዎች ለሚቆጠሩ የአካባቢው አነስተኛ አምራቾች የላቀ የኢኮኖሚ ዕድል በማምጣት በደቡብ ምዕራብ ኢትዮጵያ ያለውን የቡና ዝና እያረጋገጠ ይገኛል።'
    }
  }
];

export const PROJECTS_DATA: Project[] = [
  {
    id: 'proj-1',
    name: {
      en: 'Kebele 03 Highway Bypass',
      om: 'Kellaa Daandii Kebele 03',
      am: 'የቀበሌ 03 የመንገድ ማስፋፊያ'
    },
    description: {
      en: 'Paving 5.2 kilometers of main bypass connecting agricultural depots directly to trade centers.',
      om: 'Dilaala km 5.2 kuusa qonnaa gara gabaatti fidu daandii aspaalteen ijaaru.',
      am: 'የግብርና ምርቶችን በቀጥታ ወደ ንግድ ማዕከላት ለማድረስ 5.2 ኪሎ ሜትር የሚረዝም ዋና መንገድ መገንባት።'
    },
    status: 'ongoing',
    progress: 68,
    budget: '45,000,000 ETB',
    kebele: 'Kebele 03',
    manager: 'Eng. Solomon Tadesse'
  },
  {
    id: 'proj-2',
    name: {
      en: 'Agaro Primary Health Center Upgrade',
      om: 'Buufata Fayyaa Jalqabaa Aggaaroo Guddisuu',
      am: 'የአጋሮ የመጀመሪያ ደረጃ ጤና ጣቢያ ማሻሻያ'
    },
    description: {
      en: 'Expanding pediatric wards, obstetric care units, and installing centralized oxygen support panels.',
      om: 'Kutaa fayyaa masiibaa daaimmanii, handhuura dhaloota fooyyeessun meeshalee oksijiinii haaraa kaa’u.',
      am: 'የህጻናት እና የእናቶች ክፍልን ማስፋፋት፣ የኦክስጂን ሲስተም መዘርጋት እና የላቀ የህክምና ቁሳቁሶችን መግጠም።'
    },
    status: 'ongoing',
    progress: 85,
    budget: '18,500,000 ETB',
    kebele: 'Kebele 01',
    manager: 'Dr. Chaltu Gemeda'
  },
  {
    id: 'proj-3',
    name: {
      en: 'Central Youth Multimedia Library',
      om: 'Kuusaa Kitaabaafi Miidiyaa Dargaggootaa',
      am: 'የማዕከላዊ ወጣቶች መልቲሚዲያ ቤተ-መጽሐፍት'
    },
    description: {
      en: 'Fully digitized library and educational research hub featuring 50 active high-speed internet work stations.',
      om: 'Mana kitaabaa ammayyaa kooppiitaroota 50 fi interneetii saffisaan lafatan ijaaruu.',
      am: 'ለወጣቶች 50 የኮምፒውተር ጣቢያዎች እና ባለከፍተኛ ፍጥነት የኢንተርኔት አገልግሎት የያዘ አዲስ የዲጂታል ቤተ-መጽሐፍት ግንባታ።'
    },
    status: 'planning',
    progress: 15,
    budget: '12,000,000 ETB',
    kebele: 'Kebele 02',
    manager: 'Ato Abebe Kebede'
  },
  {
    id: 'proj-4',
    name: {
      en: 'Municipal E-Governance Integration',
      om: 'Tajaajila Dijitaalaa Bulchiinsa Magaalaa',
      am: 'የከተማው አስተዳደር ዲጂታል አገልግሎቶች ትስስር'
    },
    description: {
      en: 'Creating online applications and portal integrations for fast payment and transparent tracking.',
      om: 'Ammayyeessu sirna tajaajila kaffaltii fi iyyannoo intarneetiidhaan ifa taasisu.',
      am: 'ለፈጣን ክፍያ እና ግልጽ ክትትል የመስመር ላይ ማመልከቻዎችን እና የተቀናጁ የዲጂታል አገልግሎቶችን ማዘጋጀት።'
    },
    status: 'completed',
    progress: 100,
    budget: '3,800,000 ETB',
    kebele: 'All Kebeles',
    manager: 'WMS Solution Group'
  }
];

export const DEPARTMENTS_DATA: Department[] = [
  {
    id: 'dept-mayor',
    name: {
      en: "Mayor's Executive Office",
      om: "Waajjira Kantiibaa Executive",
      am: "የከንቲባ አስፈፃሚ ጽሕፈት ቤት"
    },
    head: 'Ato Kemal Jemal (Mayor)',
    email: 'mayor@agarocity.gov.et',
    phone: '+251 47 555 1010',
    hours: 'Mon - Fri (8:30 AM - 5:30 PM)',
    mandate: {
      en: [
        'Defining strategic development goals for the municipality.',
        'Assuring rule of law and executing council approvals.',
        'Sponsoring central community welfare initiatives.',
        'Coordinating relations between Zonal and Regional governments.'
      ],
      om: [
        'Kallattiifi tarsiimoo guddina magaalichaa murteessun hojiirra oolchuu.',
        'Kabaja seeraa fi murtii koreewwan bulchiinsaa mirkaneessuu.',
        'Waliin hojjechuu bulchiinsawwan Gooroo fi Naannoo waliin.'
      ],
      am: [
        'የከተማዋን ስልታዊ የልማት ግቦች መወሰን እና ማስፈጸም።',
        'የህግ የበላይነትን ማረጋገጥ እና የምክር ቤት ውሳኔዎችን መተግበር።',
        'የማህበረሰብ ደህንነት እና ልማት ተነሳሽነቶችን መደገፍ።',
        'ከዞን እና ከክልል መንግስታት ጋር ያለውን ግንኙነት ማስተባበር።'
      ]
    }
  },
  {
    id: 'dept-finance',
    name: {
      en: 'Revenue & Finance Administration',
      om: 'Bulchiinsa Galii Finaansii',
      am: 'የገቢዎችና ፋይናንስ አስተዳደር ክፍል'
    },
    head: 'W/ro Kidist Hailu',
    email: 'finance@agarocity.gov.et',
    phone: '+251 47 555 1012',
    hours: 'Mon - Fri (8:30 AM - 5:30 PM; closed 12:30-1:30 PM)',
    mandate: {
      en: [
        'Collecting municipal taxes, levies, and service fees.',
        'Managing capital budgets and annual city balance sheets.',
        'Auditing public infrastructure expenses to prevent waste.',
        'Providing business and trade licensing assessments.'
      ],
      om: [
        'Kaffaltii tajaajilaafi taxii magaalaa sassaabuu.',
        'Bulchiinsa bajata waggaafi dhimmoota qarshii hordofuu.',
        'Hojii iyyata hayyama daldalaa mirkaneessu madaaluu.'
      ],
      am: [
        'የከተማ ግብር፣ ታክስ እና የአገልግሎት ክፍያዎችን መሰብሰብ።',
        'የከተማዋን በጀት እና ዓመታዊ የፋይናንስ መግለጫዎችን ማስተዳደር።',
        'ብክነትን ለመከላከል የሕዝብ መሠረተ ልማት ወጪዎችን መመርመር።',
        'የንግድ ፈቃድ ግምገማዎችን ማካሄድ እና የፋይናንስ ማረጋገጫ መስጠት።'
      ]
    }
  },
  {
    id: 'dept-land',
    name: {
      en: 'Land Development & Urban Planning',
      om: 'Ijaarama Lafaa Pilaanii Magaalaa',
      am: 'የመሬት ልማት እና ከተማ ፕላን መምሪያ'
    },
    head: 'Ato Obsa Dejene',
    email: 'land@agarocity.gov.et',
    phone: '+251 47 555 1015',
    hours: 'Mon - Thu (8:30 AM - 5:30 PM)',
    mandate: {
      en: [
        'Managing public land leases and title deed transfers.',
        'Drafting zoning master plans and surveying boundaries.',
        'Regulating environmental standards and land conservation.',
        'Registering housing deeds and cadastral maps.'
      ],
      om: [
        'Kiriifi dabarsa qabeenya lafa uummataa bulchuu.',
        'Pilaanii magaalaa qopheessufi madaalota qulqullinaa hordofuu.',
        'Galmeessa ragaa abbaa qabeenyummaa lafaafi mana mirkaneessu.'
      ],
      am: [
        'የመንግስት መሬት ኪራይ እና የይዞታ ማረጋገጫ የምስክር ወረቀቶችን ማስተዳደር።',
        'የከተማ ፕላን ማዘጋጀት እና ድንበሮችን መለካት።',
        'የአካባቢ ጥበቃ መስፈርቶችን እና የመሬት ጥበቃን መቆጣጠር።',
        'የቤቶች ይዞታ ምዝገባዎችን ማከናወን እስትራቴጂያዊ ካርታዎችን ማዘጋጀት።'
      ]
    }
  },
  {
    id: 'dept-health',
    name: {
      en: 'Health, Education & Social Affairs',
      om: 'Fayyaa, Barnootaafi Dhimmottan Hawaasaa',
      am: 'የጤና፣ ትምህርት እና ማህበራዊ ጉዳዮች መመሪያ'
    },
    head: 'Sister Hanna Mulgeta',
    email: 'socialsupport@agarocity.gov.et',
    phone: '+251 47 555 1020',
    hours: 'Mon - Fri (8:30 AM - 5:30 PM)',
    mandate: {
      en: [
        'Sponsoring local vaccination campaigns and public clinics.',
        'Supervising regional schools and nursery centers.',
        'Providing support mechanisms for vulnerable households.',
        'Registering local vital statistics (births, deaths, marriages).'
      ],
      om: [
        'Talaallii adda addaa gargaaruufi buufataalee fayyaa hordofuu.',
        'Mana barnootaa magaalaa keessaa mirkaneessun hordofuu.',
        'Kunuunsa maatii rakkatan gargaaruu fi ragaa lubbuu galmeessuu.'
      ],
      am: [
        'የአካባቢ የክትባት ዘመቻዎችን እና የህዝብ ጤና ክሊኒኮችን መደገፍ።',
        'የከተማዋን ትምህርት ቤቶች እና የህጻናት ማቆያዎችን መቆጣጠር።',
        'ተጋላጭ ለሆኑ አባወራዎች እና ቤተሰቦች የድጋፍ ስርዓት መዘርጋት።',
        'የወሳኝ ኩነቶችን ምዝገባ (ልደት፣ ሞት፣ ጋብቻ) ማከናወን።'
      ]
    }
  }
];
