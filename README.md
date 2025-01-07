# Empire Builder

Gra została napisana jako projekt do portfolio - projekt powstał z zamysłem implementacji technologii z którą nie byłem najlepiej zapoznany (React) wraz z frameworkiem który dobrze znam (Laravel) - projekt posiada tyle rzeczy na ile pozwoliło mi ograniczenie czasowe w postaci 48H od początku jego tworzenia do końca ( nie ciągłej pracy tylko okres). 
Empire Builder to gra, w której użytkownicy mogą tworzyć postacie, zarządzać zasobami oraz wykonywać zadania. Gra
została zbudowana przy użyciu Laravel na backendzie oraz Inertia.js do renderowania frontendowego. Komponenty
frontendowe są napisane w TypeScript.

## Wykorzystane Technologie

- **Laravel**: Framework PHP służący do tworzenia aplikacji webowych.
- **Inertia.js**: Framework umożliwiający tworzenie nowoczesnych aplikacji jednostronicowych (SPA) w React, z
  wykorzystaniem klasycznego routingu i kontrolerów po stronie serwera.
- **TypeScript**:
- **Tailwind CSS**: Framework CSS, który pozwala na szybkie tworzenie responsywnych interfejsów użytkownika.
- **PostgreSQL**: System zarządzania relacyjnymi bazami danych.
- **Laravel Reverb**: Pakiet Laravela, który pozwala na tworzenie websocketów.
- **Laravel Sanctum**: Pakiet Laravela, który pozwala na autoryzację użytkowników za pomocą sesji.
- **Zustand**: Biblioteka do zarządzania stanem w React.


## Kontekst Aplikacji

Empire Builder to gra, w której użytkownicy mają możliwość tworzenia postaci, zarządzania zasobami i realizowania zadań.
Aplikacja wykorzystuje Laravel do obsługi backendu, a Inertia.js do dynamicznego renderowania interfejsu użytkownika na
frontendzie. Wszystkie komponenty frontendowe zostały napisane w TypeScript.

## Aspekty w aplikacji 

W aplikacji postarałem się użyć jak najwięcej technologii czy wzorców projektowych, które używane są w prawdziwych projektach

- **Autoryzacja**: Użytkownicy mogą się zarejestrować, zalogować oraz wylogować. Wszystkie te operacje są zabezpieczone
  za pomocą Laravel Sanctum.
- **Zarządzanie Postaciami**: Użytkownicy mogą tworzyć postacie, zarządzać nimi oraz je usuwać.
- **Zarządzanie Zasobami**: Użytkownicy mogą zarządzać zasobami, takimi jak złoto, drewno, kamień, itp. Zasoby są
  przypisywane do postaci a dzięki budowaniu budynków można zwiększać ich przyrost - dane są wysyłąne do uzytkownika za pomocą **WEBSOCKETÓW**
- **Zadania**: Użytkownicy mogą wykonywać zadania, które są przypisywane do postaci. Każde zadanie ma swoje wymagania,
  które muszą zostać spełnione, aby zadanie zostało ukończone.
- **Integracja API** - Aplikacja korzysta z API do pobrania różnych danych w czasie rzeczywistym.
- **CRUD**: Użytkownicy mogą zarządzać postaciami, zasobami oraz zadaniami za pomocą operacji CRUD.
- **Widoki**: Aplikacja wykorzystuje Inertia.js do renderowania widoków. Wszystkie widoki są napisane w TypeScript / React.
- **Kolejki**: Aplikacja wykorzystuje kolejkę do wykonywania zadań w tle. Kolejka zajmuje się generowaniem zasobów z budynków postaci i tworzeniem zadań które przekazują informacje na frontend za pomocą websocketów.
- **Harmonogramy**: Aplikacja wykorzystuje harmonogramy do wykonywania zadań cyklicznych, takich jak generowanie zasobów z budynków postaci.
- **Dockeryzacja**: Aplikacja pozwala na konteneryzowanie za pomocą Dockera. Wszystkie zależności oraz kroki są zdefiniowane w pliku
  `Dockerfile`. W obrazie umieszczam również PostgresQL, który jest używany jako baza danych. Nie powinna ona się znajdować w kontenerze produkcyjnym, ale dla celów testowych jest to wystarczające oraz dla użytkownika który chce otworzyć grę i chwile poklikać nawet wygodne.

   Dobrym pomysłem byłoby również wydzielenie z obrazu dockera obrazu PHP i stworzyć "przedbudowaną wersję", która będzie zawierała wszystkie zależności PHP, a następnie użyć tego obrazu jako bazowego dla obrazu aplikacji. W ten sposób uniknelibyśmy dosyć uciązliwego docker-php-ext-configure / docker-php-ext-install za kazdym razem przy budowie.

- **Github Actions**: Aplikacja wykorzystuje Github Actions do automatycznego testowania kodu oraz budowania obrazu Dockera. (Nie zaimplementowane tak, żeby to działało aczkolwiek plik z github actions jest dostepny w projekcie `/github-actions/actions.yml`) 
- **Feature Testy**: Aplikacja posiada szczątkowe feature testy które pokrywają podstawową funkcjonalność (tworzenie postaci)
## Potrzebne Narzędzia

- **PHP 8.2+**
- **Node 22.7.0**
- **supervisord ( nie jest końieczny )**
- **docker**

## Uruchomienie projektu (DEV):

1. Sklonuj repozytorium
2. Zainstaluj zależności PHP oraz Node:
   ```bash
   composer install
   npm install
   npm run build
   ```
3. Skonfiguruj plik `.env`:
   ```bash
    cp .env.example .env
    ```
   
    Następnie uzupełnij dane dostępowe do bazy danych oraz inne zmienne środowiskowe.
    ```dotenv
    DB_CONNECTION=___
    DB_HOST=___
    DB_PORT=___
    DB_DATABASE=___
    DB_USERNAME=___
   ```
   
4. Wygeneruj klucz aplikacji:
   ```bash
    php artisan key:generate
    ```
   
5. Wykonaj migracje (jeżeli masz skonfigurowane dane dostępowe do bazy danych):
   ```bash
    php artisan migrate --seed
    ```
   
6. Uruchom serwer (dewelopersko - kazda komenda w innym terminalu):
    ```bash
     php artisan serve
     php artisan queue:work
     php artisan schedule:work
     php artisan reverb:start
     ```
   
## Uruchomienie projektu (DOCKER):

1. Sklonuj repozytorium
2. Zbuduj obraz dockera:
   ```bash
   docker compose build
   ```
3. Uruchom kontener dockera:
   ```bash
    docker compose up
    ```
   
4. Aplikacja będzie dostępna pod adresem `http://localhost:8000`.
