export type Language = 'en' | 'om' | 'am';

export interface ServiceCategory {
  id: string;
  icon: string;
  title: Record<Language, string>;
  description: Record<Language, string>;
}

export interface Application {
  id: string;
  serviceId: string;
  serviceName: string;
  applicantName: string;
  submittalDate: string;
  status: 'pending' | 'reviewing' | 'kebele_approved' | 'completed' | 'rejected';
  details: Record<string, string>;
  history: {
    status: string;
    date: string;
    comments: string;
  }[];
}

export interface Complaint {
  id: string;
  category: string;
  title: string;
  description: string;
  location: string;
  kebele: string;
  reporterName: string;
  reporterPhone: string;
  isAnonymous: boolean;
  date: string;
  status: 'received' | 'investigating' | 'resolved';
  ticketNo: string;
}

export interface Appointment {
  id: string;
  applicantName: string;
  applicantEmail: string;
  applicantPhone: string;
  departmentId: string;
  departmentName: string;
  date: string;
  time: string;
  purpose: string;
}

export interface PaymentTransaction {
  id: string;
  referenceNo: string;
  serviceType: string;
  taxpayerName: string;
  amount: number;
  date: string;
  paymentMethod: string;
  status: 'success' | 'failed';
}

export interface NewsArticle {
  id: string;
  title: Record<Language, string>;
  excerpt: Record<Language, string>;
  content: Record<Language, string>;
  date: string;
  category: 'Infrastructure' | 'Health' | 'Agriculture' | 'Municipal';
  image?: string;
}

export interface Project {
  id: string;
  category?: string;
  name: {
    en: string;
    om: string;
    am: string;
  };
  description: {
    en: string;
    om: string;
    am: string;
  };
  status: 'planning' | 'ongoing' | 'completed';
  progress: number;
  budget: string;
  manager: string;
  kebele: string;
  image?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface Department {
  id: string;
  name: Record<Language, string>;
  head: string;
  email: string;
  phone: string;
  hours: string;
  mandate: Record<Language, string[]>;
}
