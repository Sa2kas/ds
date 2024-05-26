import { createI18n } from 'vue-i18n';
import en from '../lang/en.json';
import lt from '../lang/lt.json';

const messages = {
  en,
  lt,
};

const i18n = createI18n({
  locale: document.documentElement.lang || 'en', // Default locale
  allowComposition: true,
  fallbackLocale: 'en',
  messages,
});

export default i18n;
