Have this running while coding, to auto compile tailwiind css:
```utf-8
npx tailwindcss -i ./src/input.css -o ./dist/style.css --watch
```

## H2 Assignment
Úkolem zadání je vytvořit informační systém pro procházení uživatelských profilů a tvorbu uzavřených diskusních skupin. Každá diskusní skupina má nějaké označení, pomocí kterého ji uživatelé systému budou moci vhodně odlišit a další atributy (např. popis, ikona, apod.). Skupina se dále skládá z libovolného množství diskusních vláken. Diskusní vlákno má nějaký předmět a je složeno z posloupnosti příspěvků vložených členy skupiny. Každý příspěvek má nějaký formátovaný obsah a dále pak ranking (celočíselná hodnota udělená členy skupiny – každý člen může jednou inkrementovat nebo dekrementovat ranking každého příspěvku). Uživatelé budou moci informační systém použít jak pro procházení uživatelských profilů, tak pro správu a diskutování v diskusních skupinách – a to následujícím způsobem:

**Administrátor**
- spravuje uživatele
- má práva všech následujících rolí

**Registrovaný uživatel:**
- má možnost editovat svůj profil
- spravuje zabezpečení svého profilu (viditelnost pro registrované, neregistrované uživatele a členy skupin)
- zakládá a spravuje skupiny – stává se správcem skupiny
  - spravuje obsah skupiny, moderátory a členy skupiny
  - nastavuje zabezpečení skupiny (viditelnost profilů pro členy a neregistrované uživatele)
  - má rovněž práva moderátora skupiny
- registruje se do skupin – stává se členem skupiny (po přijetí registrace moderátorem nebo správcem skupiny)
  - zakládá diskusní vlákna ve skupině, odpovídá v existujících diskusních vláknech
  - žádá o zvýšení práv na moderátora skupiny – stává se moderátorem skupiny (po přijetí správcem skupiny)
    - spravuje vlákna, promazává příspěvky
    - má práva člena skupiny
- má mimo jiné práva neregistrovaného návštěvníka
**Neregistrovaný návštěvník**
- má možnost procházet profily uživatelů a skupin (dle povolených práv uživatele a skupiny)

Náměty na rozšíření:
- propracovaný editor pro vkládání příspěvků (pokročilé formátování textu, vkládání obrázků, videí z YouTube, apod.)
- podrobné statistiky uživatelů (počty příspěvků), ranking příspěvků apod.
- použití web sockets.
