import { ui, defaultLang } from './ui';

export type TranslationKey = keyof (typeof ui)[typeof defaultLang];

export function useTranslations(lang: keyof typeof ui) {
  return function t(key: TranslationKey) {
    return ui[lang][key] || ui[defaultLang][key] || key;
  };
}
