# Plan de implementare — Azur Dent

## Situația proiectului

Folderul primit conținea doar promptul, fără instalare WordPress, temă, pluginuri sau fotografii proprii. Livrarea va fi o temă WordPress instalabilă, cu suport Gutenberg, plus instrucțiuni de instalare. La activare, tema va crea paginile lipsă și meniul principal fără să suprascrie pagini cu aceleași adrese deja existente.

## Pagini și traseul pacientului

1. **Acasă** — mesaj de prezentare, imagine ilustrativă, traseu spre serviciile public listate și buton de solicitare a programării.
2. **Servicii** — categorii din listarea publică a cabinetului, explicații generale și mențiunea că disponibilitatea se confirmă cu cabinetul.
3. **Cabinet și echipă** — galerie cu fotografii stock etichetate clar ca ilustrative; informațiile despre medicii și spațiul real rămân de completat numai cu materiale aprobate de cabinet.
4. **Programare** — formular care cere numele, telefonul, emailul opțional, serviciul și ziua/intervalul preferat. Confirmarea este făcută ulterior de cabinet.
5. **Contact** — adresa, emailul, link de traseu și apel telefonic doar după configurarea numărului confirmat.
6. **Confidențialitate** — informare pentru solicitarea de programare, cu identitatea juridică a operatorului marcată pentru completare de cabinet.

Traseul principal: vizitatorul citește prezentarea, verifică serviciile sau contactul, completează solicitarea, vede rezumatul înainte de trimitere, apoi primește un mesaj care precizează că solicitarea trebuie confirmată de cabinet.

## Interacțiuni

- meniu mobil cu buton accesibil și închidere la navigare;
- antet sticky și legături rapide către programare, email, apel și traseu;
- validare HTML și PHP, nonce WordPress, câmp honeypot și limită temporară pentru trimiteri;
- rezumat înainte de trimiterea formularului;
- galerie lightbox cu dialog accesibil, tastele Escape și săgeți și navigare tactilă;
- întrebări frecvente în elemente native `details`;
- reducerea mișcării respectată prin `prefers-reduced-motion`.

## Fotografii și identitate

Nu există fotografii furnizate de cabinet. Tema va include opt fotografii stock Pexels, optimizate în WebP la trei lățimi responsive (720, 1280 și 1800 px) și descrise în lista de credite. În pagină vor fi etichetate ca ilustrative și nu vor fi atribuite cabinetului sau medicilor. Identitatea vizuală va folosi o semnătură tipografică „Azur Dent”, fără logo medical inventat și fără SVG.

## Formular și configurare

Formularul transmite prin `wp_mail()` la emailul configurat în pagina de setări a temei și nu salvează solicitările în WordPress. Setarea implicită folosește emailul din prompt; telefonul rămâne gol până când cabinetul confirmă numărul actual. Pentru livrarea emailurilor, hostingul trebuie să poată trimite emailuri WordPress sau să fie configurat cu un singur furnizor SMTP de încredere. Tema afișează succes numai dacă `wp_mail()` acceptă mesajul.

## SEO și verificare

Titlurile, descrierile, Open Graph și datele LocalBusiness/Dentist vor folosi doar numele și adresa cunoscute, emailul configurat și telefonul doar când este completat. Nu se afișează program, prețuri, rezultate medicale sau date despre echipă. Verificarea va include sintaxa PHP/JSON, absența SVG, conținutul paginilor și navigarea/interacțiunile într-o instanță WordPress de test dacă mediul local permite.

## Informații care necesită confirmare înainte de publicarea live

- numărul actual de telefon: sursele publice consultate afișează valori diferite;
- identitatea juridică și datele operatorului pentru informarea de confidențialitate;
- fotografii reale și informații aprobate despre cabinet și echipă;
- disponibilitatea curentă a serviciilor listate public și programul de lucru;
- configurarea SMTP și testul real al livrării emailului.

## Rezultat și verificări

Tema personalizată este în `theme/azur-dent/`, iar arhiva de instalare este `azur-dent-theme.zip`. Tema generează șase pagini Gutenberg, meniuri, setări administrabile de contact și formularul de solicitare prin `wp_mail()`. Cele opt fotografii au fiecare trei variante WebP responsive.

Verificarea locală a folosit WordPress Playground (WordPress latest, PHP 8.3): paginile Acasă, Servicii, Cabinet și echipă, Programare, Contact și Confidențialitate s-au randat; galeria s-a deschis, a navigat înainte și înapoi și s-a închis cu Escape; formularul a afișat rezumatul local înainte de trimitere. Nu s-a trimis email real. Verificarea vizuală de mobil nu a putut fi rulată deoarece browserul disponibil în sesiune nu oferă emulare de viewport. Comentariile Gutenberg ale paginilor create au fost verificate ca structură; editorul Playground a afișat un canvas `about:blank` și pentru pagina implicită WordPress, deci editarea vizuală în acea instanță nu a putut fi inspectată.

Tema și arhiva nu conțin fișiere SVG sau referințe la SVG. Configurarea SMTP, numărul de telefon și datele juridice rămân de confirmat de cabinet înainte de publicare live.
