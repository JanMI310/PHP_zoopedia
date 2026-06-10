-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 10, 2026 at 07:52 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zoopedia_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `title` varchar(180) NOT NULL,
  `animal_type` varchar(30) NOT NULL DEFAULT 'ssak',
  `species` varchar(180) NOT NULL,
  `habitat` varchar(255) NOT NULL,
  `diet` varchar(180) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `slug`, `title`, `animal_type`, `species`, `habitat`, `diet`, `content`, `image`, `created_at`) VALUES
(1, 'lis-tybeta-nski', 'Lis tybetański', 'ssak', 'Vulpes ferrilata', 'Górskie stepy do wysokości 5300 m n.p.m. na Wyżynie Tybetańskiej, w Indiach, Chinach i Nepalu', 'mięsożerny i padlinożerny', 'Lis tybetański (Vulpes ferrilata) to niewielki przedstawiciel wielkiej lisiej rodziny. Podobnie jak inne lisy, lisy tybetańskie są drapieżnikami i padlinożercami. Ich głównym łupem padają szczekuszki, a następnie drobne gryzonie, świstaki, zające wełniste i jaszczurki. Zjadają również padlinę antylop tybetańskich, jeleni piżmowych, owiec i zwierząt gospodarskich. Czasami uzupełniają dietę roślinami.\r\n\r\nGłównym składnikiem pożywienia lisów są jednak szczekuszki. Czyli małe, krępe zwierzęta z krótkimi kończynami, zaokrąglonymi uszami, pozbawione ogona. Aby je zdobyć, lisy tybetańskie współpracują z niedźwiedziami brunatnymi. Gdy niedźwiedź rozkopuje norę szczekuszek, lisy pozostają w odwodzie i wyłapują uciekinierów.', 'animal_6a284a3c065bb1.25219349.jpg', '2026-06-09'),
(2, 'wilk-szary', 'Wilk szary', 'ssak', 'Canis lupus', 'Lasy, tereny podgórskie, tajga i tundra', 'Mięsożerca (głównie jelenie, sarny, dziki)', 'Wilk szary to inteligentne zwierzę stadne, które żyje w ściśle zharmonizowanych grupach zwanych watahami. Posiada niesamowicie rozwinięty zmysł węchu i słuchu, co czyni go doskonałym łowcą. Odgrywa kluczową rolę w ekosystemie, regulując populację dzikich ssaków kopytnych.', 'animal_6a284c730d1976.35872222.jpg', '2026-06-09'),
(3, 'ry-s-euroazjatycki', 'Ryś euroazjatycki', 'ssak', 'Lynx lynx', 'Gęste lasy iglaste i mieszane', 'Mięsożerca', 'Ryś to największy dziki kot żyjący w Europie. Jest samotnikiem, który prowadzi głównie nocny tryb życia. Charakteryzuje się pędzelkami czarnych włosów na uszach, które pomagają mu lepiej lokalizować dźwięki, oraz krótkim ogonem. W Polsce jest gatunkiem ściśle chronionym.', 'animal_6a284ceacd1635.29878548.jpg', '2026-06-09'),
(4, 'slo-n-afryka-nski', 'Słoń afrykański', 'ssak', 'Loxodonta africana', 'Sawanny, lasy tropikalne i półpustynie Afryki', 'Roślinożerca (trawy, liście, kora drzew, owoce)', 'Słoń afrykański to największe żyjące zwierzę lądowe na Ziemi. Jego najbardziej charakterystyczną cechą jest trąba, która powstała ze zrośnięcia nosa i górnej wargi – służy mu do oddychania, picia, zrywania jedzenia oraz komunikacji. Słonie to niezwykle inteligentne i emocjonalne zwierzęta, które żyją w stadach rodzinnych rządzonych przez najstarszą samicę (matriarchat).', 'animal_6a284d94dd2504.94660318.jpg', '2026-06-09'),
(5, 'okapi-le-sne', 'Okapi leśne', 'ssak', 'Okapia johnstoni', 'Gęste i wilgotne lasy równikowe Demokratycznej Republiki Konga', 'Roślinożerca (liście, pąki drzew, owoce, paprocie)', 'Okapi to jedno z najbardziej niezwykłych zwierząt na świecie. Choć z wyglądu przypomina połączenie konia z zebrą (ze względu na pasiaste umaszczenie na tylnych nogach), jego najbliższym żyjącym krewnym jest żyrafa. Posiada bardzo długi, chwytny język w kolorze sinoniebieskim, którym potrafi nawet oczyścić swoje własne oczy i uszy. Jest zwierzęciem płochliwym i bardzo trudnym do zaobserwowania w naturze.', 'animal_6a284de6a4e605.41235085.jpg', '2026-06-09'),
(6, 'szop-pracz', 'Szop pracz', 'ssak', 'Procyon lotor', 'Lasy liściaste w pobliżu zbiorników wodnych, a także obszary zurbanizowane', 'Wszystkożerca (owoce, orzechy, owady, małe gryzonie, ryby, jajka, odpadki)', 'Szop pracz pochodzi z Ameryki Północnej, ale stał się gatunkiem inwazyjnym w Europie. Słynie ze swojej charakterystycznej czarnej „maski” wokół oczu oraz niezwykle chwytnych przednich łap, które przypominają ludzkie dłonie. Szopy potrafią nimi bez problemu otwierać szafki, drzwi czy pojemniki na śmieci. Nazwę zawdzięczają nawykowi płukania pokarmu w wodzie, co w warunkach naturalnych pomaga im lepiej wyczuć dotykiem to, co zaraz zjedzą.', 'animal_6a284f91950e72.36679172.jpg', '2026-06-09'),
(7, 'salamandra-plamista', 'Salamandra plamista', 'plaz', 'Salamandra salamandra', 'Wilgotne lasy liściaste, okolice górskich potoków', 'Mięsożerca (dżdżownice, ślimaki, owady, pająki)', 'Salamandra plamista to największy płaz ogoniasty żyjący w Polsce. Jej czarne ciało pokryte jest jaskrawożółtymi lub pomarańczowymi plamami – to ubarwienie ostrzegawcze, które mówi drapieżnikom: „uwaga, jestem trująca”. Salamandry prowadzą nocny tryb życia, a w dzień aktywne są głównie po intensywnych opadach deszczu.', 'animal_6a28501338f8d4.57286730.jpg', '2026-06-09'),
(8, 'jaszczurka-zwinka', 'Jaszczurka zwinka', 'gad', 'Lacerta agilis', 'Nasłonecznione skraje lasów, łąki, wrzosowiska, przydrożne skarpy', 'Mięsożerca (pająki, owady, ślimaki, gąsienice)', 'Jaszczurka zwinka to najpospolitszy gad w Europie Środkowej. Jako zwierzę zmiennocieplne, rano uwielbia wygrzewać się na słońcu, aby nabrać energii do polowania. Samce w okresie godowym przybierają przepiękną, jaskrawozieloną barwę. W razie niebezpieczeństwa zwinka potrafi odrzucić ogon (autotomia), który po pewnym czasie jej odrasta.', 'animal_6a285058b705d7.40299163.jpg', '2026-06-09'),
(9, 'zabnica', 'Żabnica', 'ryba', 'Lophius piscatorius', 'Ciemne, piaszczyste i muliste dna oceanów', 'Mięsożerca (ryby, skorupiaki, a nawet polujące przy powierzchni ptaki wodne)', 'Żabnica, nazywana też diabłem morskim, to jedna z najdziwniejszych ryb świata. Posiada ogromną, spłaszczoną głowę z paszczą pełną ostrych zębów. Jej najbardziej niesamowitą cechą jest \"wędka\" (ilicjum) – przekształcony promień płetwy grzbietowej, który zwisa tuż przed jej pyskiem. Na końcu wędki znajduje się świecący wabik, który przyciąga zdezorientowane ofiary wprost w otwartą paszczę żabnicy. Co ciekawe, mimo swojego przerażającego wyglądu, jest uważana za rarytas w kuchni.', 'animal_6a2851958282c9.98974729.jpg', '2026-06-09'),
(10, 'cudowronka-blekitna', 'Cudowronka błękitna', 'ptak', 'Parotia lawesii', 'Górskie lasy deszczowe Nowej Gwinei', 'Wszystkożerca (głównie owoce, stawonogi, nasiona)', 'Cudowronka (rajski ptak) to absolutne mistrzostwo natury. Samce tego gatunku posiadają aksamitnoczarne pióra, które pochłaniają niemal 100% światła, oraz neonowo połyskującą tarczę na piersi. Aby zaimponować samicy, samiec czyści fragment lasu z liści, tworząc idealną „scenę”, a następnie wykonuje niesamowity taniec baletowy – stroszy pióra tak, że przypomina czarną spódnicę, i kołysze głową, na której sterczą długie, ozdobne pióra przypominające anteny.', 'animal_6a2851e6219b97.13311279.jpg', '2026-06-09'),
(11, 'trzewikodzi-ob', 'Trzewikodziób', 'ptak', 'Balaeniceps rex', 'Rozległe, niedostępne bagniska i trzęsawiska Afryki Wschodniej (głównie Sudan Południowy i Uganda)', 'Mięsożerca (głównie ryby dwudyszne, ale też młode krokodyle, węże i wodne gryzonie)', 'Trzewikodziób to jeden z najbardziej niezwykłych i fotogenicznych ptaków na świecie. Osiąga do 1,5 metra wysokości, a jego rozpiętość skrzydeł przekracza 2 metry. Jego znak rozpoznawczy to potężny, przypominający drewniany but dziób, zakończony ostrym hakiem, który służy do chwytania śliskich ryb. Ptak ten potrafi stać całkowicie nieruchomo przez wiele godzin, wypatrując ofiary, przez co przypomina posąg. Kiedy się komunikuje, kłapie dziobem, co wydaje dźwięk przypominający serię z karabinu maszynowego. Mimo groźnego, wręcz prehistorycznego wyglądu, wobec ludzi wykazuje niezwykłą... potulność i potrafi kłaniać się w geście powitania.', 'animal_6a285287a437b5.04532342.jpg', '2026-06-09'),
(12, 'zyzu-s-tlu-scioch', 'Zyzuś tłuścioch', 'owad', 'Steatoda bipunctata', 'Ciemne, suche zakamarki w ludzkich domostwach, piwnicach, strychach, a także pod korą drzew', 'Mięsożerca (głównie mrówki, muchy, komary i inne drobne owady)', 'Zyzuś tłuścioch to mały pająk, który swoją zabawną nazwę zawdzięcza charakterystycznemu, mocno zaokrąglonemu i błyszczącemu odwłokowi. Samice są nieco większe i mają ciemnobrązowe, wręcz czekoladowe ubarwienie. Zyzuś jest niezwykle pożytecznym współlokatorem – buduje nieregularne sieci w kątach pokoi lub za meblami, skutecznie oczyszczając nasz dom z natrętnych much i komarów. Co fascynujące, samce tego gatunku potrafią wydawać dźwięki (słyszalne dla innych pająków), pocierając o siebie części swojego ciała, co służy do wabienia partnerek. Dla człowieka jest całkowicie niegroźny.', 'animal_6a286e3b1e5b56.18915445.jpg', '2026-06-09'),
(13, 'suhak-stepowy', 'Suhak stepowy', 'ssak', 'Saiga tatarica', 'Suche stepy i półpustynie Azji Środkowej', 'Roślinożerca (trawy, zioła)', 'Suhak to antylopa, która wygląda, jakby urwała się z epoki lodowcowej. Jej najbardziej charakterystyczną cechą są wielkie, obwisłe, przypominające trąbę nozdrza. Ten specyficzny nos działa jak zaawansowany filtr klimatyzacyjny: latem filtruje wszechobecny pył i kurz ze stepu, a zimą ogrzewa lodowate powietrze, zanim trafi ono do płuc zwierzęcia. Suhaki to świetni biegacze, potrafiący pędzić z prędkością do 80 km/h.', 'animal_6a2894c1973d97.91246647.jpg', '2026-06-10'),
(14, 'skoczek-nosaty', 'Skoczek nosaty', 'owad', 'Fulgora laternaria', 'Wilgotne lasy tropikalne Ameryki Środkowej i Południowej', 'Roślinożerca (wysysa soki z drzew i roślin)', 'Ten owad to absolutny mistrz dziwacznego wyglądu. Na jego głowie znajduje się ogromny, pusty w środku wyrostek, który z profilu do złudzenia przypomina... orzeszek ziemny albo łeb małego krokodyla (łącznie z namalowanymi „zębami”). Ma to na celu odstraszanie ptaków i jaszczurek. Dodatkowo, gdy Fulgora rozłoży skrzydła, widać na nich wielkie plamy przypominające oczy drapieżnika. Dawniej wierzono, że jej \"nos\" świeci w ciemności, stąd jej angielska nazwa Lantern fly.', 'animal_6a2895416aa7e4.88189902.jpg', '2026-06-10'),
(15, 'czakalaka-rdzaworzytna', 'Czakalaka rdzaworzytna', 'ptak', 'Ortalis ruficauda', 'Suche lasy, zarośla i ogrody w Wenezueli, Kolumbii oraz na wyspach Tobago i Grenada', 'Roślinożerca/ Wszystkożerca (owoce, nasiona, liście, czasem duże owady)', 'Czakalaka rdzaworzytna (narodowy ptak wyspy Tobago) swoją egzotyczną nazwę zawdzięcza dźwiękom, jakie z siebie wydaje. Ptaki te żyją w głośnych stadach i o świcie rozpoczynają niesamowicie hałaśliwy „koncert”, w którym powtarzają rytmiczne, skrzeczące „cza-ka-la-ka!”. Z wyglądu przypominają smukłe kury o długich ogonach. Choć spędzają dużo czasu na ziemi szukając pożywienia, są świetnymi akrobatami i potrafią zwinnie biegać po gałęziach drzew. Są tak popularne i towarzyskie, że w niektórych rejonach Karaibów podchodzą pod domy ludzi jak u nas gołębie.', 'animal_6a28963841dd39.25492848.jpg', '2026-06-10');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `forum_comments`
--

CREATE TABLE `forum_comments` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `author_login` varchar(80) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `forum_comments`
--

INSERT INTO `forum_comments` (`id`, `topic_id`, `author_id`, `author_login`, `content`, `created_at`) VALUES
(1, 1, 3, '456', 'Jeż nigdzie nie tupta. To Ziemia obraca się pod jego stópkami.', '2026-06-09 21:54:45'),
(2, 1, 4, 'abc', 'Próbuje zindeksować tabelę z artykułami o zwierzętach, bo wyszukiwarka ładuje się dłużej niż on tupta przez las.', '2026-06-09 21:56:52'),
(3, 2, 3, '456', 'Mój kot ma wzrok seryjnego mordercy, ale na szczęście brakuje mu kciuków, żeby otworzyć szafkę z nożami. Tylko to mnie ratuje.', '2026-06-10 00:27:34'),
(4, 3, 3, '456', 'Rekin młot patrzy na zwykłego rekina i myśli: \'Stary, twój promień widzenia to jakiś żart. Weź zmień rozdzielczość na ultrawide tak jak ja\'.', '2026-06-10 00:29:57'),
(5, 2, 4, 'abc', 'U mnie nie ma przepraszania. Obydwa grają w tę samą grę. Kot stosuje terror psychiczny i wykańcza mnie wzrokiem, a pies udaje słodkiego, żeby podbierać mi ze stołu narzędzia zbrodni. Wspólnie pracują nad tym, żebym \'przypadkowo\' potknął się o nich na schodach.', '2026-06-10 00:30:57');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `forum_topics`
--

CREATE TABLE `forum_topics` (
  `id` int(11) NOT NULL,
  `title` varchar(180) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `author_login` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `forum_topics`
--

INSERT INTO `forum_topics` (`id`, `title`, `content`, `author_id`, `author_login`, `created_at`) VALUES
(1, 'Ważne pytanie!!!', 'Dokąd nocą tupta jeż?', 1, '123', '2026-06-09 21:53:03'),
(2, 'Ostateczne starcie!', 'Czy masz kota, który patrzy na Ciebie, jakby planował Twoje morderstwo, czy może masz psa, który przeprasza wzrokiem, że żyje?', 1, '123', '2026-06-10 00:20:38'),
(3, 'Co myślicie??', 'Czy rekiny młoty kiedykolwiek patrzą na inne rekiny i myślą: \'Boże, ale oni mają nudne kształty głów\'?', 1, '123', '2026-06-10 00:25:14');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(80) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password_hash`, `role`, `created_at`) VALUES
(1, '123', '$2y$10$0GkdeHx4XxWmpbz5FOvX5Ojwbb7vDlIydyE.a3WxzqcdCTS5btC5m', 1, '2026-06-09 19:09:27'),
(2, 'admin', '$2y$10$xgSZlsJ2DrqaOax7Qf1nte6C.NSts61LoQ25WH95MuKdT59zhQFT2', 0, '2026-06-09 19:36:14'),
(3, '456', '$2y$10$5myD6IHTrfTbwobxXUD7veM1V5ujbV1AgEcCtC2sORh27tRiN.Iiy', 0, '2026-06-09 19:36:51'),
(4, 'abc', '$2y$10$1AamHv3OUr/rY9O9q1V0JODp6dGLku1mrfMKGTkdDo1SFohWpSYmG', 0, '2026-06-09 21:55:07');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeksy dla tabeli `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indeksy dla tabeli `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `forum_comments`
--
ALTER TABLE `forum_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `forum_topics`
--
ALTER TABLE `forum_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD CONSTRAINT `forum_comments_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `forum_topics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_comments_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD CONSTRAINT `forum_topics_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
