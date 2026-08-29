import { Language, NewsArticle, Complaint, Application } from './types';
import { NEWS_DATA } from './data';

// --- Types ---
export interface CabinetMember {
  id: string;
  name: string;
  image: string;
  role: Record<Language, string>;
  desk: Record<Language, string>;
  email: string;
}

export interface MayorInfo {
  name: string;
  image: string;
  role: Record<Language, string>;
  desk: Record<Language, string>;
  email: string;
  term: Record<Language, string>;
  priorities: Record<Language, string[]>;
}

// --- Defaults ---
const DEFAULT_CABINET: CabinetMember[] = [
  {
    id: 'cab-1',
    name: 'Hon. Jemal Abasimel',
    image: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=256',
    role: { en: 'City Administrator / Mayor', om: 'Kantiibaa Magaalaa', am: 'የከተማው አስተዳዳሪ / ከንቲባ' },
    desk: { en: 'Executive Cabinet & Strategy', om: 'Koree Hojii Raawwachiiftuu', am: 'ስራ አስፈጻሚ ካቢኔ እና ስትራቴጂ' },
    email: 'mayor@agarocity.gov.et'
  },
  {
    id: 'cab-2',
    name: 'Ato Muktar Kedir',
    image: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=256',
    role: { en: 'Cabinet Member / Secretary', om: 'Miseensa Kaabineefi Barreessaa', am: 'የካቢኔ አባል እና ፀሃፊ' },
    desk: { en: 'Revenue, Finance & Public Procurement', om: 'Kutaa Galii fi Finaansii', am: 'ገቢዎች፣ ፋይናንስ እና ግዢ' },
    email: 'finance@agarocity.gov.et'
  },
  {
    id: 'cab-3',
    name: 'W/ro Chaltu Gemeda',
    image: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=256',
    role: { en: 'Cabinet Member', om: 'Miseensa Kaabinee', am: 'የካቢኔ አባል' },
    desk: { en: 'Land Development & Zoning Masterplan', om: 'Ijaarama Lafaa fi Pilaanii', am: 'የመሬት ልማት እና ፕላን' },
    email: 'land@agarocity.gov.et'
  },
  {
    id: 'cab-4',
    name: 'Ato Kedir Abamila',
    image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256',
    role: { en: 'Cabinet Member', om: 'Miseensa Kaabinee', am: 'የካቢኔ አባል' },
    desk: { en: 'Trade, Industry, & Cooperatives Promotion', om: 'Daldalaa fi Gabaa', am: 'ንግድ፣ ኢንዱስትሪ እና ህብረት ስራ' },
    email: 'trade@agarocity.gov.et'
  },
  {
    id: 'cab-5',
    name: 'Dr. Sisay Abadi',
    image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=256',
    role: { en: 'Cabinet Board Member', om: 'Miseensa Kaabinee', am: 'የካቢኔ ቦርድ አባል' },
    desk: { en: 'Health Clinics, Sanitation & Environment', om: 'Fayyaa fi Qulqullina Magaalaa', am: 'ጤና፣ ጽዳት እና አካባቢ ጥበቃ' },
    email: 'health@agarocity.gov.et'
  }
];

const DEFAULT_MAYOR: MayorInfo = {
  name: 'Hon. Jemal Abasimel',
  image: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=256',
  role: { en: 'Honorary Regional Mayor', om: 'Kantiibaa Kabajaa Magaalaa', am: 'የክብር ከንቲባ' },
  desk: { en: 'Agaro Strategic Executive Council', om: 'Marii Hojii Raawwachiiftuu Tarsiimoo', am: 'የአጋሮ ስትራቴጂክ ስራ አስፈፃሚ ምክር ቤት' },
  email: 'mayor@agarocity.gov.et',
  term: { en: '2022 - present', om: '2022 - Amma', am: 'ከ2014 - አሁን' },
  priorities: {
    en: [
      'Expand high-yield coffee export value chains.',
      'Decentralize municipal support desks into 9 robust Kebeles.',
      'Achieve 100% electronic billing and rapid public works response.'
    ],
    om: [
      'Valdaalee gurgurtaa buna guddina kennuufi jabeessuu.',
      'Tajaajila bulchiinsa magaalaa goxoota 9tti fiduu.',
      'Nageenya kaffaltii elektirooniksii 100% fi daandii ijaaruu.'
    ],
    am: [
      'የላቀ የቡና ምርት ወጪ ንግድን እና እሴት ሰንሰለትን ማስፋፋት።',
      'የማዘጋጃ ቤት አገልግሎት መስኮቶችን ወደ 9 ጠንካራ ቀበሌዎች ማሰራጨት።',
      '100% ኤሌክትሮኒክ የክፍያ ሥርዓት መዘርጋት እና ፈጣን ምላሽ ማረጋገጥ።'
    ]
  }
};

const DEFAULT_COMPLAINTS: Complaint[] = [
  {
    id: 'compl-1',
    category: 'Water & Utilities',
    title: 'Kebele 03 Water Main Leakage',
    description: 'A major water pipeline has ruptured near Agaro High School. Water has been flooding the gravel lane for over 12 hours.',
    location: 'Agaro High School gravel path exit',
    kebele: 'Kebele 03',
    reporterName: 'Ato Mohammed Chala',
    reporterPhone: '+251 911 234 567',
    isAnonymous: false,
    date: '2026-06-07',
    status: 'investigating',
    ticketNo: 'AG-TX-45920'
  }
];

// --- LocalStorage Helpers ---
export function getStoredNews(): NewsArticle[] {
  const fileData = localStorage.getItem('ag_news');
  if (!fileData) {
    localStorage.setItem('ag_news', JSON.stringify(NEWS_DATA));
    return NEWS_DATA;
  }
  try {
    return JSON.parse(fileData);
  } catch {
    return NEWS_DATA;
  }
}

export function saveStoredNews(news: NewsArticle[]) {
  localStorage.setItem('ag_news', JSON.stringify(news));
}

export function getStoredCabinet(): CabinetMember[] {
  const fileData = localStorage.getItem('ag_cabinet');
  if (!fileData) {
    localStorage.setItem('ag_cabinet', JSON.stringify(DEFAULT_CABINET));
    return DEFAULT_CABINET;
  }
  try {
    return JSON.parse(fileData);
  } catch {
    return DEFAULT_CABINET;
  }
}

export function saveStoredCabinet(members: CabinetMember[]) {
  localStorage.setItem('ag_cabinet', JSON.stringify(members));
}

export function getStoredMayor(): MayorInfo {
  const fileData = localStorage.getItem('ag_mayor');
  if (!fileData) {
    localStorage.setItem('ag_mayor', JSON.stringify(DEFAULT_MAYOR));
    return DEFAULT_MAYOR;
  }
  try {
    return JSON.parse(fileData);
  } catch {
    return DEFAULT_MAYOR;
  }
}

export function saveStoredMayor(mayor: MayorInfo) {
  localStorage.setItem('ag_mayor', JSON.stringify(mayor));
}

export function getStoredComplaints(): Complaint[] {
  const fileData = localStorage.getItem('ag_comps');
  if (!fileData) {
    localStorage.setItem('ag_comps', JSON.stringify(DEFAULT_COMPLAINTS));
    return DEFAULT_COMPLAINTS;
  }
  try {
    return JSON.parse(fileData);
  } catch {
    return DEFAULT_COMPLAINTS;
  }
}

export function saveStoredComplaints(complaints: Complaint[]) {
  localStorage.setItem('ag_comps', JSON.stringify(complaints));
}

export function getStoredApplications(): Application[] {
  const fileData = localStorage.getItem('ag_apps');
  if (!fileData) {
    return [];
  }
  try {
    return JSON.parse(fileData);
  } catch {
    return [];
  }
}

export function saveStoredApplications(apps: Application[]) {
  localStorage.setItem('ag_apps', JSON.stringify(apps));
}
