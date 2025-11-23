=== Accessibility Toolkit ===
Contributors: Midgardsson
Tags: accessibility, wcag, dyslexia, a11y, font-size, high-contrast
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Comprehensive accessibility toolkit with dyslexia support, customizable font sizes, and color adjustments for WCAG compliance.

== Description ==

Az Accessibility Toolkit egy átfogó akadálymentesítési megoldás WordPress weboldalakhoz, amely segíti a látássérült, gyengénlátó és dislexiás látogatókat a könnyebb böngészésben.

= Főbb funkciók =

* **Állítható betűméretek** - Három előre definiált méret (kicsi, közepes, nagy) pixel szintű testreszabással
* **OpenDyslexic betűtípus** - Speciális, dislexiás emberek számára optimalizált betűtípus
* **Nagy kontraszt mód** - Fokozott kontrasztú megjelenítés gyengénlátók számára
* **Színek testreszabása** - Szöveg, háttér és link színek módosítása
* **WCAG 2.1 kompatibilis** - Megfelel az akadálymentesítési szabványoknak
* **Reszponzív widget** - Mobil- és asztali nézethez optimalizált
* **Beállítások mentése** - A látogatók preferenciái localStorage-ban tárolódnak
* **Könnyű használat** - Egyszerű be/ki kapcsolás az admin felületen

= Használat =

1. Telepítse és aktiválja a plugint
2. Menjen a Beállítások > Accessibility menüpontra
3. Állítsa be a betűméreteket és színeket
4. A frontend oldalon automatikusan megjelenik az akadálymentesítési widget
5. A látogatók az ikonra kattintva állíthatják be a preferenciáikat

= Támogatott funkciók =

* Betűméret váltás (kis/közepes/nagy)
* Dislexia barát OpenDyslexic font
* Nagy kontraszt mód
* Testreszabható színek
* Beállítások visszaállítása
* Reszponzív megjelenés
* Billentyűzet navigáció
* Screen reader támogatás

== Installation ==

= Automatikus telepítés =

1. Jelentkezzen be WordPress admin felületére
2. Menjen a Bővítmények > Új hozzáadása menüpontra
3. Keresse meg az "Accessibility Toolkit" plugint
4. Kattintson a "Telepítés most" gombra
5. Aktiválja a plugint

= Manuális telepítés =

1. Töltse le a plugin zip fájlját
2. Menjen a Bővítmények > Új hozzáadása > Feltöltés menüpontra
3. Válassza ki a letöltött zip fájlt
4. Kattintson a "Telepítés most" gombra
5. Aktiválja a plugint

= FTP telepítés =

1. Töltse le és csomagolja ki a plugin fájlokat
2. Töltse fel a `wp-accessibility-toolkit` mappát a `/wp-content/plugins/` könyvtárba
3. Aktiválja a plugint a WordPress admin felületén

== Frequently Asked Questions ==

= Működik a plugin minden témával? =

Igen, az Accessibility Toolkit minden WordPress témával kompatibilis. A widget a body elemen alkalmazza a módosításokat, így minden téma stílusát felülírja.

= Hogyan változtathatom meg a betűméreteket? =

Menjen a Beállítások > Accessibility menüpontra, ahol pixel pontossággal állíthatja be a kis, közepes és nagy betűméreteket.

= Mi az OpenDyslexic betűtípus? =

Az OpenDyslexic egy nyílt forráskódú betűtípus, amelyet kifejezetten dislexiás emberek számára terveztek. Segíti az olvashatóságot és csökkenti a betűtévesztést.

= Mentődnek a látogatók beállításai? =

Igen, a beállítások a böngésző localStorage-ában tárolódnak, így a következő látogatáskor automatikusan betöltődnek.

= WCAG kompatibilis a plugin? =

Igen, a plugin WCAG 2.1 AA szintű akadálymentesítési irányelveknek megfelel.

= Működik mobilon is? =

Igen, a widget teljesen reszponzív és minden eszközön jól működik.

== Screenshots ==

1. Akadálymentesítési widget a frontend oldalon
2. Admin beállítások oldal
3. Widget panel megnyitva
4. Nagy kontraszt mód aktív
5. OpenDyslexic betűtípus használatban

== Changelog ==

= 1.0.0 =
* Első kiadás
* Állítható betűméretek
* OpenDyslexic betűtípus integráció
* Nagy kontraszt mód
* Színek testreszabása
* Reszponzív widget
* WCAG 2.1 kompatibilitás
* Admin beállítások felület
* LocalStorage preferenciák mentés

== Upgrade Notice ==

= 1.0.0 =
Első kiadás - tiszta telepítés.

== Privacy Policy ==

Az Accessibility Toolkit csak a látogatók böngészőjében (localStorage) tárol adatokat. Semmilyen személyes adatot nem küld külső szerverekre.

= Tárolt adatok =

* Betűméret preferencia
* Dislexia font beállítás
* Kontraszt mód beállítás

Ezek az adatok csak a látogató saját eszközén tárolódnak és bármikor törölhetők.

== Credits ==

* OpenDyslexic font: https://opendyslexic.org/
* Fejlesztő: Midgardsson
* GitHub: https://github.com/Midgardsson/wp-accessibility-plugin

== Support ==

Ha bármilyen kérdése vagy problémája van, kérjük nyisson issue-t a GitHub repository-ban:
https://github.com/Midgardsson/wp-accessibility-plugin/issues
