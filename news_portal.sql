-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.0
-- Время создания: Сен 20 2025 г., 18:21
-- Версия сервера: 8.0.42
-- Версия PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `news_portal`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Politics', 'politics', 'Political news and analysis', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(2, 'World', 'world', 'International news from around the globe', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(3, 'Technology', 'technology', 'Latest tech news and innovations', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(4, 'Science', 'science', 'Scientific discoveries and research', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(5, 'Health', 'health', 'Health and medical news', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(6, 'Sports', 'sports', 'Sports news and updates', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(7, 'Entertainment', 'entertainment', 'Celebrity and entertainment news', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(8, 'Business', 'business', 'Business and financial news', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(9, 'Culture', 'culture', 'Arts, culture and lifestyle', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(10, 'Environment', 'environment', 'Environmental news and climate change', '2025-09-14 22:13:17', '2025-09-14 22:13:17');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int NOT NULL,
  `author_id` int NOT NULL,
  `published_at` datetime NOT NULL,
  `views` int DEFAULT '0',
  `is_published` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `excerpt`, `image_url`, `category_id`, `author_id`, `published_at`, `views`, `is_published`, `created_at`, `updated_at`) VALUES
(11, 'The Future of AI in Healthcare', 'Detailed article about how artificial intelligence is transforming the healthcare industry...', 'AI is revolutionizing healthcare with new diagnostic tools and personalized treatment plans.', 'resources/Various_collected_memes/Men can fornicate and make progress meme.jpg', 4, 1, '2025-09-14 22:14:30', 1263, 1, '2025-09-14 22:14:30', '2025-09-20 15:57:31'),
(12, 'Global Climate Summit Reaches Historic Agreement', 'World leaders have agreed on a comprehensive plan to combat climate change...', 'Nations commit to ambitious carbon reduction targets in landmark climate deal.', 'resources/Various_collected_memes/FB_IMG_1618032258323.jpg', 2, 1, '2025-09-13 22:14:30', 3427, 1, '2025-09-14 22:14:30', '2025-09-20 15:57:31'),
(13, 'New Smartphone Breaks Sales Records', 'The latest flagship smartphone has shattered sales records in its first week...', 'Innovative features and competitive pricing drive unprecedented demand.', 'resources/Various_collected_memes/FB_IMG_1617071833122.jpg', 3, 1, '2025-09-12 22:14:30', 5678, 1, '2025-09-14 22:14:30', '2025-09-20 15:57:31'),
(14, 'Stock Market Reaches All-Time High', 'Investors celebrate as major indices hit record levels amid strong economic data...', 'Bull market continues as corporate earnings exceed expectations.', 'resources/Various_collected_memes/FB_IMG_1617818445579.jpg', 8, 1, '2025-09-11 22:14:30', 2350, 1, '2025-09-14 22:14:30', '2025-09-20 15:57:31'),
(15, 'Major Breakthrough in Cancer Research', 'Scientists announce a promising new treatment approach that could revolutionize cancer care...', 'Clinical trials show remarkable results with minimal side effects.', 'resources/Various_collected_memes/FB_IMG_1619981503030.jpg', 5, 1, '2025-09-10 22:14:30', 4123, 1, '2025-09-14 22:14:30', '2025-09-20 15:57:31'),
(16, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Ut enim ad minim veniam, quis nostrud', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTUsbmTZu_uMrmJ0z--CrG-o1UIXytu1OCizQ&s', 8, 1, '2025-09-16 21:37:00', 0, 0, '2025-09-16 21:40:21', '2025-09-16 21:40:21'),
(17, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTUsbmTZu_uMrmJ0z--CrG-o1UIXytu1OCizQ&s', 8, 1, '2025-09-16 21:40:00', 0, 0, '2025-09-16 21:41:12', '2025-09-16 21:41:12'),
(18, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', NULL, 8, 1, '2025-09-16 22:12:00', 0, 0, '2025-09-16 22:13:18', '2025-09-16 22:13:18'),
(19, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'resources/Various_collected_memes/FB_IMG_1619140066938.jpg', 8, 1, '2025-09-16 22:13:00', 20, 1, '2025-09-16 22:13:32', '2025-09-20 15:57:31'),
(20, 'Brains don’t all act their age', 'Amid the petty drama of internet arguments, one never fails to entertain me: Do millennials actually look younger than their age? Sunscreen, vaping, hair parting choices and Botox for people who don’t have wrinkles are used as evidence for and against this generational Dorian Graying. I can’t and won’t adjudicate this debate. But I can shift the conversation away from TikTok and inward to the brain.\r\n\r\nBrain age isn’t a new concept, especially for people trying to make money. For decades, people have sold books, apps, IV drips and supplements promising to keep brains spry, often with little or no scientific evidence. But lately, scientists have been building evidence that a metric called brain age holds promise for understanding how the healthy brain ages. Even more tantalizingly, they’re uncovering hints about what might affect that number.', 'Amid the petty drama of internet arguments, one never fails to entertain me: Do millennials actually look younger than their age?', 'resources/Various_collected_memes/FB_IMG_1616922490429.jpg', 4, 1, '2025-09-18 19:42:00', 6, 1, '2025-09-18 19:43:37', '2025-09-20 15:57:31'),
(21, 'Elderly cats with dementia may hold clues for Alzheimer’s', 'As cats age, they may yowl more than usual at night, have trouble sleeping or sleep too much, and act generally confused or disoriented. Now a new study shows that, just like in humans with Alzheimer’s disease, amyloid-beta plaques build up in the brains of aging felines and may contribute to dementia-like behaviors.', 'Cats’ brains show a similar buildup of amyloid beta and messed up nerve cell connections', 'https://i0.wp.com/www.sciencenews.org/wp-content/uploads/2025/08/082025_CLL_felineAlzheimer.jpg?resize=1030%2C580&ssl=1', 4, 1, '2025-09-18 19:43:00', 0, 0, '2025-09-18 19:44:26', '2025-09-18 19:44:26'),
(22, 'The Vera Rubin Observatory is ready to revolutionize astronomy', 'At 3 a.m. on a crisp May night in Chile, all seemed well with the world’s largest digital camera. Until it didn’t.\r\n\r\nInside the newly built Vera C. Rubin Observatory, site project scientist Sandrine Thomas was running tests when a flat line representing the camera’s temperature started to spike. “That looks bad,” she thought. She was right. Worried scientists quickly shut down the telescope.\r\n\r\nI arrived a few hours later, jet-lagged but eager to get my first glimpse at a cutting-edge observatory that astronomers have been awaiting for more than 25 years.\r\n\r\nPerched on a high, flat-topped mountain called Cerro Pachón, the Rubin Observatory was conceived back in the 1990s to give astronomers the unprecedented ability to probe the cosmos in every dimension. With a wide and deep view of the sky, Rubin can investigate some of the universe’s slowest, most eternal processes, such as the assembly of galaxies and the expansion of the cosmos. And by mapping the entire southern sky every couple of nights, it can track some of the universe’s fastest and most ephemeral events, including exploding stars and visits from interstellar comets.', 'To answer big cosmic questions, “you need something like Rubin. There is no competition.”', 'resources/Various_collected_memes/Disappointed Dachshund meme.jpg', 4, 1, '2025-09-18 19:44:00', 6, 1, '2025-09-18 19:45:39', '2025-09-20 15:57:31'),
(23, 'Why are so many young people getting cancer?', 'Since the 1990s, rates of early onset cancer, diagnosed before the age of 50, have been rapidly increasing around the world.\r\n\r\nTim Robberts/Stone/Getty Images plus; Sidi A. Bencherif, Thomas Ferrante/Wyss Institute at Harvard Univ.; adapted by T. Tibbitts', 'Scientists don’t know yet, but diet, gut bacteria and microplastics could play a role', 'https://i0.wp.com/www.sciencenews.org/wp-content/uploads/2025/09/100125_fs_youngcancer_feat.jpg?w=1440&ssl=1', 4, 1, '2025-09-18 20:03:00', 0, 0, '2025-09-18 20:04:30', '2025-09-18 20:04:30'),
(24, 'A handheld ‘bone printer’ shows promise in animal tests', 'A handheld device can apply synthetic bone grafts directly at the site of a defect or injury without the need for prior imaging or fabrication.\r\n\r\nResearchers demonstrated the technology by modifying a hot glue gun to 3-D print the material directly onto bone fractures in rabbits. Instead of using a regular glue stick, they employed a specially made “bioink,” the team reports September 5 in Device.\r\n\r\nThe idea was to design a printing system that could be easily equipped and used in clinical settings, says biomedical engineer Jung Seung Lee of Sungkyunkwan University in Seoul, South Korea.', 'The device 3-D printed bone grafts in rabbits and delivered antibiotics to stave off infection', 'https://i0.wp.com/www.sciencenews.org/wp-content/uploads/2025/09/091125_PD_bonegluegun.jpg?resize=1030%2C580&ssl=1', 4, 1, '2025-09-18 20:04:00', 0, 0, '2025-09-18 20:05:10', '2025-09-18 20:05:10'),
(25, 'News Animals Tug or fetch? Some dogs sort toys by how they are used', '“Where’s your red ball? Get your squeaky chicken!” Some dogs know their favorite toys by name. Now, it turns out that dogs with a knack for learning words are also capable of mentally labeling toys just by how they are used during play, a new study suggests. These dogs can even classify a new toy based entirely on its use, without any verbal or physical clues.\r\n\r\nThe findings, published September 18 in Current Biology, add to the growing list of compellingly complex cognitive activities at work in the canine brain.', 'Mentally sorting toys by function, without physical or verbal cues, shows complex thinking', 'resources/Various_collected_memes/FB_IMG_1621896057655.jpg', 4, 1, '2025-09-18 20:05:00', 1, 1, '2025-09-18 20:05:48', '2025-09-20 15:57:31'),
(26, 'Want to avoid mosquito bites? Step away from the beer', 'Mosquitoes’ biting preference may be influenced by an assortment of human behaviors, such as whether someone drinks beer and wears sunscreen.', 'Certain habits boost mosquito appeal, tests at a music festival reveal. Others keep them at bay', 'resources/Various_collected_memes/FB_IMG_1618032252301.jpg', 4, 1, '2025-09-18 20:06:00', 1, 1, '2025-09-18 20:07:56', '2025-09-20 15:57:31'),
(27, 'A handheld ‘bone printer’ shows promise in animal tests', 'A handheld device can apply synthetic bone grafts directly at the site of a defect or injury without the need for prior imaging or fabrication.\r\n\r\nResearchers demonstrated the technology by modifying a hot glue gun to 3-D print the material directly onto bone fractures in rabbits. Instead of using a regular glue stick, they employed a specially made “bioink,” the team reports September 5 in Device.\r\n\r\nThe idea was to design a printing system that could be easily equipped and used in clinical settings, says biomedical engineer Jung Seung Lee of Sungkyunkwan University in Seoul, South Korea.', 'The device 3-D printed bone grafts in rabbits and delivered antibiotics to stave off infection', 'resources/Various_collected_memes/the-best-funny-pictures-of-shy-shark-meme-12.jpg', 4, 1, '2025-09-18 20:08:00', 1, 1, '2025-09-18 20:09:17', '2025-09-20 15:57:31'),
(28, 'See how fractals forever changed math and science', 'Fifty years ago, “fractal” was born.\r\n\r\nIn a 1975 book, the Polish-French-American mathematician Benoit B. Mandelbrot coined the term to describe a family of rough, fragmented shapes that fall outside the boundaries of conventional geometry. Mathematicians had been describing these types of shapes since the late 19th century. But by giving them a name — derived from fractus, Latin for “broken” — Mandelbrot gave fractals value. He introduced a way to measure and analyze them. With a name, he recognized order in complexity.\r\n\r\nIf you know anything about fractals, it’s probably this: Their hallmark trait is self-similarity. No matter how much you zoom in or out, you find similar patterns. Take a snowflake. The overall shape of the crystal is repeated at smaller and smaller scales as the snowflake branches out. (A snowflake and other natural forms are considered only “fractal like,” though, because the pattern breaks down at the level of molecules and atoms.) In a nod to this self-similarity, Mandelbrot often told people that his middle initial, B., stood for “Benoit B. Mandelbrot.” So his full name becomes “Benoit Benoit B. Mandelbrot Mandelbrot.” And spelling out the middle initial again results in “Benoit Benoit Benoit B. Mandelbrot Mandelbrot Mandelbrot.” No matter how many times you iterate, you find him behind his middle initial.', 'Described by Benoit B. Mandelbrot in 1975, these irregular shapes are everywhere', 'resources/Various_collected_memes/FB_IMG_1617829249852.jpg', 4, 1, '2025-09-18 20:09:00', 2, 1, '2025-09-18 20:09:54', '2025-09-20 15:57:31'),
(29, 'Tech Company IPO Success', 'A technology company has achieved a record-breaking initial public offering, marking one of the largest tech IPOs in history. The successful launch reflects strong investor confidence. Financial analysts are optimistic about the company\'s future growth.', 'Technology company achieves record-breaking initial public offering.', 'resources/Various_collected_memes/Men can fornicate and make progress meme.jpg', 8, 1, '2025-08-31 15:31:01', 0, 1, '2025-09-20 15:31:01', '2025-09-20 15:57:32'),
(30, 'Merger Creates Industry Giant', 'A major merger between two companies has created a new industry leader with significant market share and resources. The deal is expected to drive innovation and efficiency. Industry experts are analyzing the competitive implications.', 'Major merger between two companies creates new industry leader.', 'resources/Various_collected_memes/ob3yi.jpg', 8, 1, '2025-09-12 15:31:01', 0, 1, '2025-09-20 15:31:01', '2025-09-20 15:57:31'),
(31, 'Startup Funding Round', 'An innovative startup has secured significant funding for its expansion plans, demonstrating investor confidence in the company\'s business model and growth potential. The funding will support product development and market expansion. Entrepreneurs are celebrating the milestone.', 'Innovative startup secures significant funding for expansion plans.', 'resources/Various_collected_memes/FB_IMG_1621835574532.jpg', 8, 1, '2025-08-29 15:31:01', 0, 1, '2025-09-20 15:31:01', '2025-09-20 15:57:32'),
(32, 'Economic Growth Indicators', 'Positive economic indicators suggest continued business growth across various sectors, with increased consumer spending and business investment. The data points to a healthy economic environment. Business leaders are optimistic about future prospects.', 'Positive economic indicators suggest continued business growth.', 'resources/Various_collected_memes/cute-fat-cat-meme-1.jpg', 8, 1, '2025-08-25 15:31:01', 0, 1, '2025-09-20 15:31:01', '2025-09-20 15:57:32'),
(33, 'Supply Chain Innovation', 'New supply chain technology is improving efficiency and reducing costs for businesses across multiple industries. The innovation addresses long-standing challenges in logistics. Supply chain professionals are embracing the new solutions.', 'New supply chain technology improves efficiency and reduces costs.', 'resources/Various_collected_memes/FB_IMG_1621895885736.jpg', 8, 1, '2025-08-25 15:31:01', 1, 1, '2025-09-20 15:31:01', '2025-09-20 17:13:23'),
(34, 'Remote Work Revolution', 'Companies are adapting to permanent remote work arrangements, fundamentally changing how businesses operate and manage their workforce. The shift has implications for office space and corporate culture. HR professionals are developing new management strategies.', 'Companies adapt to permanent remote work arrangements.', 'resources/Various_collected_memes/FB_IMG_1616922873915.jpg', 8, 1, '2025-09-10 15:31:01', 1, 1, '2025-09-20 15:31:01', '2025-09-20 17:16:30'),
(35, 'Sustainable Business Practices', 'More companies are adopting environmentally sustainable business practices in response to consumer demand and regulatory requirements. The shift represents a fundamental change in corporate priorities. Sustainability experts are supporting the transition.', 'More companies adopt environmentally sustainable business practices.', 'resources/Various_collected_memes/FB_IMG_1621351554190.jpg', 8, 1, '2025-09-03 15:31:01', 0, 1, '2025-09-20 15:31:01', '2025-09-20 15:57:31'),
(36, 'Digital Transformation Accelerates', 'Businesses are accelerating their digital transformation initiatives to remain competitive in an increasingly digital marketplace. The transformation involves new technologies and processes. IT leaders are driving the change efforts.', 'Businesses accelerate digital transformation initiatives.', 'resources/Various_collected_memes/Wealthfully wastes ones own money meme.jpg', 8, 1, '2025-08-29 15:31:01', 0, 1, '2025-09-20 15:31:01', '2025-09-20 15:57:32'),
(37, 'Global Market Expansion', 'Companies are expanding into new international markets to capitalize on global growth opportunities and diversify their revenue streams. The expansion requires careful planning and cultural adaptation. International business experts are providing guidance.', 'Companies expand into new international markets.', 'resources/Various_collected_memes/FB_IMG_1616920203848.jpg', 8, 1, '2025-09-15 15:31:01', 0, 1, '2025-09-20 15:31:01', '2025-09-20 15:57:31'),
(38, 'Innovation Investment Increases', 'Corporations are increasing their investment in research and development to drive innovation and maintain competitive advantage. The investment reflects confidence in future growth opportunities. R&D professionals are excited about the increased resources.', 'Corporations increase investment in research and development.', 'resources/Various_collected_memes/FB_IMG_1618790208978.jpg', 8, 1, '2025-08-27 15:31:01', 0, 1, '2025-09-20 15:31:01', '2025-09-20 15:57:32'),
(39, 'Art Exhibition Opens', 'A major art exhibition has opened, showcasing contemporary works from artists around the world and providing visitors with a unique cultural experience. The exhibition features diverse styles and themes. Art enthusiasts are praising the curatorial vision.', 'Major art exhibition showcases contemporary works from around the world.', 'resources/Various_collected_memes/FB_IMG_1621848306760.jpg', 9, 1, '2025-09-04 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(40, 'Cultural Festival Celebration', 'The annual cultural festival celebrated diversity and community traditions through music, dance, food, and art. The event brought together people from different backgrounds. Community leaders are proud of the festival\'s success.', 'Annual cultural festival celebrates diversity and community traditions.', 'resources/Various_collected_memes/Block Buster FB_IMG_1615246334717.jpg', 9, 1, '2025-09-04 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(41, 'Museum Renovation Complete', 'A historic museum has reopened after extensive renovation and modernization, offering visitors an enhanced experience with new exhibits and interactive displays. The renovation preserves the building\'s heritage while adding modern amenities. Museum visitors are excited about the improvements.', 'Historic museum reopens after extensive renovation and modernization.', 'resources/Various_collected_memes/FB_IMG_1621902905141.jpg', 9, 1, '2025-09-02 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(42, 'Literary Award Ceremony', 'The prestigious literary awards ceremony recognized outstanding authors and works that have made significant contributions to literature and culture. The event celebrated creativity and storytelling. Literary community members are celebrating the winners.', 'Prestigious literary awards recognize outstanding authors and works.', 'resources/Various_collected_memes/FB_IMG_1621869728501.jpg', 9, 1, '2025-09-09 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(43, 'Cultural Exchange Program', 'An international cultural exchange program is promoting understanding between different cultures through art, music, and educational activities. The program fosters global connections. Cultural organizations are supporting the initiative.', 'International cultural exchange program promotes understanding.', 'resources/Various_collected_memes/FB_IMG_1620339839451.jpg', 9, 1, '2025-09-08 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(44, 'Traditional Craft Revival', 'Traditional crafts are experiencing a revival among younger generations who are learning ancient techniques and creating contemporary interpretations. The movement preserves cultural heritage. Craft masters are sharing their knowledge with enthusiasm.', 'Traditional crafts experience revival among younger generations.', 'resources/Various_collected_memes/20210424_100739.jpg', 9, 1, '2025-09-15 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(45, 'Cultural Heritage Preservation', 'New initiatives are protecting and preserving cultural heritage sites that represent important historical and cultural significance. The efforts involve community participation and expert guidance. Heritage preservation experts are leading the conservation work.', 'New initiatives protect and preserve cultural heritage sites.', 'resources/Various_collected_memes/FB_IMG_1616913189788.jpg', 9, 1, '2025-09-17 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(46, 'Community Arts Program', 'A community arts program is providing creative opportunities for residents of all ages to explore their artistic talents and express themselves through various mediums. The program promotes creativity and community bonding. Local artists are volunteering their time.', 'Community arts program provides creative opportunities for residents.', 'resources/Various_collected_memes/FB_IMG_1620191592678.jpg', 9, 1, '2025-09-04 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(47, 'Cultural Documentary Release', 'A new documentary explores cultural traditions and their modern relevance, providing viewers with insights into how ancient practices continue to influence contemporary life. The film has received critical acclaim. Documentary filmmakers are proud of the achievement.', 'New documentary explores cultural traditions and their modern relevance.', 'resources/Various_collected_memes/FB_IMG_1621895501423.jpg', 9, 1, '2025-09-08 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(48, 'Cultural Center Opening', 'A new cultural center has opened to serve the diverse needs of the community, providing space for performances, exhibitions, and educational programs. The center represents a significant investment in cultural infrastructure. Community members are excited about the new facility.', 'New cultural center opens to serve diverse community needs.', 'resources/Various_collected_memes/FB_IMG_1617829008851.jpg', 9, 1, '2025-08-26 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(49, 'Blockbuster Movie Breaks Records', 'A new blockbuster movie has achieved record-breaking box office success worldwide, captivating audiences with its compelling story and stunning visuals. The film has exceeded all expectations. Movie critics are praising the production quality.', 'New film achieves record-breaking box office success worldwide.', 'resources/Various_collected_memes/There\'s the door card for unwelcome chatters meme.jpg', 7, 1, '2025-09-07 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(50, 'Music Festival Lineup Announced', 'A major music festival has revealed its star-studded lineup for the upcoming event, featuring top artists from various genres. The festival promises to be an unforgettable experience. Music fans are excited about the diverse lineup.', 'Major music festival reveals star-studded lineup for upcoming event.', 'resources/Various_collected_memes/FB_IMG_1620324885235.jpg', 7, 1, '2025-09-03 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(51, 'Award Show Highlights', 'The annual award show celebrated outstanding achievements in entertainment, recognizing talented artists and creators for their contributions to the industry. The event featured memorable performances and emotional speeches. Industry professionals are celebrating the winners.', 'Annual award show celebrates outstanding achievements in entertainment.', 'resources/Various_collected_memes/FB_IMG_1616920066250.jpg', 7, 1, '2025-09-10 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(52, 'Streaming Service Original Series', 'A new original series has become an instant hit on a popular streaming platform, attracting millions of viewers and generating buzz on social media. The show features compelling characters and storylines. Streaming subscribers are eagerly awaiting new episodes.', 'New original series becomes instant hit on popular streaming platform.', 'resources/Various_collected_memes/FB_IMG_1617132896055.jpg', 7, 1, '2025-08-27 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(53, 'Concert Tour Announcement', 'A popular artist has announced a world tour with stops in major cities around the globe, giving fans the opportunity to see them perform live. The tour promises spectacular shows and memorable experiences. Concert tickets are selling out quickly.', 'Popular artist announces world tour with stops in major cities.', 'resources/Various_collected_memes/FB_IMG_1617908647003.jpg', 7, 1, '2025-09-13 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(54, 'Celebrity Charity Event', 'Celebrities gathered for a charity event supporting an important cause, using their platform to raise awareness and funds for those in need. The event featured performances and auctions. The cause has received significant support from the entertainment community.', 'Stars gather for charity event supporting important cause.', 'resources/Various_collected_memes/FB_IMG_1618032234791.jpg', 7, 1, '2025-08-24 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(55, 'Gaming Industry Milestone', 'A video game has achieved unprecedented success and cultural impact, becoming a global phenomenon that transcends traditional gaming audiences. The game features innovative gameplay and storytelling. Gaming enthusiasts are celebrating the achievement.', 'Video game achieves unprecedented success and cultural impact.', 'resources/Various_collected_memes/FB_IMG_1617818211347.jpg', 7, 1, '2025-09-12 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(56, 'Theater Production Revival', 'A classic theater production has returned with a modern interpretation that breathes new life into the timeless story. The revival features talented actors and creative staging. Theater audiences are praising the fresh approach.', 'Classic theater production returns with modern interpretation.', 'resources/Various_collected_memes/FB_IMG_1617158751034.jpg', 7, 1, '2025-08-27 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(57, 'Comedy Special Release', 'A stand-up comedian has released a highly anticipated comedy special that showcases their unique perspective and comedic timing. The special has received critical acclaim. Comedy fans are enjoying the fresh material.', 'Stand-up comedian releases highly anticipated comedy special.', 'resources/Various_collected_memes/FB_IMG_1617819914088.jpg', 7, 1, '2025-08-25 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(58, 'Reality Show Success', 'A reality television show has become a cultural phenomenon and ratings hit, captivating audiences with its unique format and compelling characters. The show has sparked conversations and social media buzz. Television executives are celebrating the success.', 'Reality television show becomes cultural phenomenon and ratings hit.', 'resources/Various_collected_memes/image0.jpg', 7, 1, '2025-09-06 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(59, 'Renewable Energy Milestone', 'The country has achieved a major milestone in renewable energy generation, significantly reducing its dependence on fossil fuels and moving closer to carbon neutrality goals. The achievement represents years of investment and policy support. Environmental advocates are celebrating the progress.', 'Country achieves major renewable energy generation milestone.', 'resources/Various_collected_memes/FB_IMG_1616920066250.jpg', 10, 1, '2025-09-19 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(60, 'Wildlife Conservation Success', 'Conservation efforts have led to the successful recovery of several endangered species populations, demonstrating the effectiveness of targeted environmental protection measures. The success involved collaboration between governments and NGOs. Wildlife biologists are optimistic about continued progress.', 'Conservation efforts lead to recovery of endangered species populations.', 'resources/Various_collected_memes/FB_IMG_1621895885736.jpg', 10, 1, '2025-09-02 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(61, 'Climate Action Plan', 'A new climate action plan sets ambitious environmental goals for reducing greenhouse gas emissions and adapting to climate change impacts. The plan includes specific targets and implementation strategies. Environmental policy experts are analyzing the proposals.', 'New climate action plan sets ambitious environmental goals.', 'resources/Various_collected_memes/Men can fornicate and make progress meme.jpg', 10, 1, '2025-08-22 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(62, 'Ocean Cleanup Initiative', 'An international ocean cleanup initiative has successfully removed tons of plastic waste from marine environments, helping to protect marine life and improve water quality. The effort involved volunteers from around the world. Marine conservationists are supporting the ongoing work.', 'International ocean cleanup initiative removes tons of plastic waste.', 'resources/Various_collected_memes/FB_IMG_1617742479696.jpg', 10, 1, '2025-09-10 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(63, 'Green Technology Innovation', 'New green technology is reducing the environmental impact of manufacturing processes while maintaining efficiency and product quality. The innovation represents a breakthrough in sustainable production. Environmental engineers are excited about the potential applications.', 'New green technology reduces environmental impact of manufacturing.', 'resources/Various_collected_memes/7718918.jpg', 10, 1, '2025-09-02 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(64, 'Forest Restoration Project', 'A large-scale forest restoration project has begun in a previously deforested region, aiming to restore ecosystem health and biodiversity. The project involves community participation and scientific expertise. Forest conservation experts are leading the restoration efforts.', 'Large-scale forest restoration project begins in deforested region.', 'resources/Various_collected_memes/FB_IMG_1620205269779.jpg', 10, 1, '2025-09-08 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(65, 'Sustainable Agriculture Program', 'A new program is promoting sustainable farming practices that improve soil health and reduce environmental impact while maintaining agricultural productivity. The initiative supports farmers in adopting eco-friendly methods. Agricultural experts are providing training and resources.', 'New program promotes sustainable farming practices and soil health.', 'resources/Various_collected_memes/FB_IMG_1619142464816.jpg', 10, 1, '2025-09-13 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(66, 'Environmental Education Initiative', 'A school program is teaching students about environmental protection and sustainability, preparing the next generation to be environmental stewards. The curriculum includes hands-on activities and field trips. Educators are excited about the program\'s impact.', 'School program teaches students about environmental protection.', 'resources/Various_collected_memes/FB_IMG_1620321026218.jpg', 10, 1, '2025-09-09 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(67, 'Carbon Footprint Reduction', 'Companies are achieving significant carbon footprint reduction targets through energy efficiency improvements and renewable energy adoption. The progress demonstrates corporate commitment to environmental responsibility. Sustainability consultants are supporting the efforts.', 'Companies achieve significant carbon footprint reduction targets.', 'resources/Various_collected_memes/FB_IMG_1568154151046.jpg', 10, 1, '2025-09-13 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(68, 'Environmental Policy Update', 'New environmental policies have strengthened protection measures for air, water, and land resources, providing better safeguards for environmental health. The policies include enforcement mechanisms and public participation. Environmental lawyers are reviewing the legal framework.', 'New environmental policies strengthen protection measures.', 'resources/Various_collected_memes/FB_IMG_1616921882494.jpg', 10, 1, '2025-09-15 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(69, 'New Vaccine Development Success', 'Researchers have successfully developed an effective vaccine for a previously untreatable disease, marking a significant advancement in medical science. The vaccine has shown promising results in clinical trials. Health officials are preparing for distribution.', 'Researchers develop effective vaccine for previously untreatable disease.', 'resources/Various_collected_memes/FB_IMG_1620324885235.jpg', 5, 1, '2025-09-04 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(70, 'Mental Health Awareness Campaign', 'A national mental health awareness campaign has been launched to reduce stigma and improve access to mental health services. The campaign includes educational resources and support programs. Mental health advocates are supporting the initiative.', 'National campaign aims to reduce stigma around mental health issues.', 'resources/Various_collected_memes/1f7yx3.jpg', 5, 1, '2025-09-17 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(71, 'Telemedicine Adoption Increases', 'Telemedicine adoption has increased significantly as more patients use remote healthcare services for improved access to medical care. The technology is particularly beneficial for rural areas. Healthcare providers are expanding their digital services.', 'More patients using telemedicine services for healthcare access.', 'resources/Various_collected_memes/FB_IMG_1619146065316.jpg', 5, 1, '2025-09-02 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(72, 'Nutrition Research Findings', 'New nutrition research has revealed optimal strategies for healthy aging, providing evidence-based recommendations for dietary choices. The findings could help prevent age-related diseases. Nutritionists are incorporating the research into their recommendations.', 'New research reveals optimal nutrition strategies for healthy aging.', 'resources/Various_collected_memes/FB_IMG_1617071833122.jpg', 5, 1, '2025-08-21 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(73, 'Exercise Medicine Program', 'A new exercise medicine program is prescribing physical activity as treatment for various chronic conditions, demonstrating the therapeutic benefits of regular exercise. The program includes personalized fitness plans. Healthcare providers are embracing this approach.', 'New program prescribes exercise as treatment for chronic conditions.', 'resources/Various_collected_memes/FB_IMG_1617950825858.jpg', 5, 1, '2025-08-30 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(74, 'Preventive Care Initiative', 'A new preventive care initiative is focusing on preventing diseases before they develop through early screening and lifestyle interventions. The program aims to improve population health outcomes. Public health officials are supporting the initiative.', 'New initiative focuses on preventing diseases before they develop.', 'resources/Various_collected_memes/WallstreetBets-Memes-800x450.jpg', 5, 1, '2025-08-30 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(75, 'Digital Health Tools', 'New digital health tools are helping patients better manage chronic conditions through mobile apps and wearable devices. The technology provides real-time monitoring and feedback. Healthcare providers are integrating these tools into patient care.', 'New digital health tools help patients manage chronic conditions.', 'resources/Various_collected_memes/FB_IMG_1621585766206.jpg', 5, 1, '2025-09-17 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(76, 'Healthcare Access Improvement', 'New programs are being implemented to improve healthcare access in underserved areas through mobile clinics and community health centers. The initiative aims to reduce health disparities. Community health advocates are supporting the effort.', 'New programs aim to improve healthcare access in underserved areas.', 'resources/Various_collected_memes/FB_IMG_1621848306760.jpg', 5, 1, '2025-09-17 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(77, 'Medical Research Collaboration', 'International collaboration in medical research is accelerating progress in understanding and treating various diseases. The partnership involves researchers from multiple countries. Medical professionals are optimistic about the collaborative approach.', 'International collaboration accelerates medical research progress.', 'resources/Various_collected_memes/My yesterdays are nowhere near close to....jpg', 5, 1, '2025-09-19 15:31:02', 1, 1, '2025-09-20 15:31:02', '2025-09-20 15:58:08'),
(78, 'Health Education Program', 'A new health education program is teaching preventive care strategies to help people maintain better health and avoid common diseases. The program includes workshops and educational materials. Health educators are excited about the program\'s potential impact.', 'New health education program teaches preventive care strategies.', 'resources/Various_collected_memes/FB_IMG_1617848237145.jpg', 5, 1, '2025-08-28 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(79, 'New Election Polls Show Tight Race', 'The latest election polls show an incredibly tight race between the leading candidates. Political analysts are calling this one of the most unpredictable elections in recent history. Voter turnout is expected to be record-breaking as citizens engage with the democratic process.', 'Latest polling data reveals a competitive election landscape with candidates neck and neck.', 'resources/Various_collected_memes/FB_IMG_1616920066250.jpg', 1, 1, '2025-09-15 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(80, 'Parliament Passes New Healthcare Bill', 'After months of intense debate and negotiation, parliament has finally passed the new healthcare bill. The legislation aims to provide better access to medical services for all citizens. Healthcare advocates are celebrating this as a major victory for public health.', 'Legislators approve comprehensive healthcare reform after months of debate.', 'resources/Various_collected_memes/20210203_165043.jpg', 1, 1, '2025-09-10 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(81, 'International Trade Agreement Signed', 'A landmark international trade agreement has been signed, promising to strengthen economic ties between participating nations. The deal is expected to create thousands of new jobs and increase trade volumes significantly. Business leaders are optimistic about the economic benefits.', 'New trade deal promises to boost economic cooperation between nations.', 'resources/Various_collected_memes/FB_IMG_1616963091596.jpg', 1, 1, '2025-09-18 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(82, 'Climate Policy Changes Announced', 'The government has announced significant changes to climate policy, including new carbon reduction targets and renewable energy incentives. Environmental groups are praising the initiative as a step in the right direction. The policies are expected to take effect next year.', 'Government unveils new environmental policies to combat climate change.', 'resources/Various_collected_memes/FB_IMG_1616920203848.jpg', 1, 1, '2025-08-30 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(83, 'Education Reform Bill Introduced', 'A comprehensive education reform bill has been introduced in parliament, focusing on improving educational standards and teacher training. The bill includes provisions for increased funding and modernized curricula. Educators are cautiously optimistic about the proposed changes.', 'New legislation aims to improve educational standards nationwide.', 'resources/Various_collected_memes/FB_IMG_1617820098203.jpg', 1, 1, '2025-08-26 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(84, 'Tax Reform Package Approved', 'The tax reform package has been approved, promising to simplify the tax system and provide relief for middle-class families. The changes include lower tax rates and simplified filing procedures. Financial experts are analyzing the potential economic impact.', 'New tax legislation promises to simplify the tax system for citizens.', 'resources/Various_collected_memes/FB_IMG_1616964067427.jpg', 1, 1, '2025-09-16 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(85, 'Immigration Policy Updates', 'Updated immigration policies have been announced, designed to streamline the application process for qualified immigrants. The changes focus on reducing wait times and improving efficiency. Immigration advocates are hopeful about the improvements.', 'New immigration policies aim to streamline the process for qualified applicants.', 'resources/Various_collected_memes/FB_IMG_1619140066938.jpg', 1, 1, '2025-09-02 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(86, 'Defense Budget Increase Proposed', 'A significant increase in defense spending has been proposed to modernize military capabilities and ensure national security. The budget includes funding for new equipment and personnel training. Defense officials are confident about the strategic benefits.', 'Military spending increase aims to modernize defense capabilities.', 'resources/Various_collected_memes/FB_IMG_1617162103061.jpg', 1, 1, '2025-08-30 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(87, 'Social Security Reforms Discussed', 'Policymakers are engaged in heated discussions about potential reforms to the social security system. The proposals aim to ensure long-term sustainability while protecting current beneficiaries. Senior advocacy groups are closely monitoring the negotiations.', 'Policymakers debate changes to social security system.', 'resources/Various_collected_memes/FB_IMG_1618531579937.jpg', 1, 1, '2025-09-19 15:31:02', 1, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(88, 'Infrastructure Investment Plan', 'A comprehensive infrastructure investment plan has been unveiled, focusing on modernizing roads, bridges, and public transportation systems. The plan includes significant funding for green infrastructure projects. Construction industry leaders are excited about the opportunities.', 'Major infrastructure investment plan aims to modernize national infrastructure.', 'resources/Various_collected_memes/FB_IMG_1619377050071.jpg', 1, 1, '2025-09-13 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(89, 'Breakthrough in Cancer Research', 'Scientists have made a breakthrough in cancer research, discovering a new treatment approach that shows promise for aggressive cancer types. The research involved years of laboratory work and clinical trials. Medical professionals are cautiously optimistic about the potential impact.', 'Scientists discover new treatment approach for aggressive cancer types.', 'resources/Various_collected_memes/My music tastes in relation to.. meme.jpg', 4, 1, '2025-08-22 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(90, 'Climate Change Research Reveals New Insights', 'Latest climate change research has revealed new insights into the effects of global warming on ecosystems and weather patterns. The findings could inform future environmental policies. Climate scientists are calling for urgent action based on the data.', 'Latest climate research provides new understanding of global warming effects.', 'resources/Various_collected_memes/7d6ba213fc3c6d53b379ee3dc45c231130691b87ea7318385119d1fc8089c2ef.jpg', 4, 1, '2025-08-30 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(91, 'Space Exploration Mission Success', 'A successful space exploration mission has provided new data about distant planets and their potential for supporting life. The mission involved advanced scientific instruments and years of planning. Space scientists are analyzing the valuable data collected.', 'Successful space mission provides new data about distant planets.', 'resources/Various_collected_memes/FB_IMG_1621586233206.jpg', 4, 1, '2025-09-07 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(92, 'Renewable Energy Breakthrough', 'A breakthrough in solar panel technology has achieved record efficiency levels, making renewable energy more cost-effective. The innovation could accelerate the transition to clean energy. Energy researchers are excited about the commercial potential.', 'New solar panel technology achieves record efficiency levels.', 'resources/Various_collected_memes/FB_IMG_1619750077919.jpg', 4, 1, '2025-09-10 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(93, 'Medical Device Innovation', 'A new medical device innovation promises to significantly improve patient care and outcomes through advanced monitoring and treatment capabilities. The device has undergone rigorous testing. Healthcare professionals are optimistic about its potential benefits.', 'New medical device promises to improve patient care and outcomes.', 'resources/Various_collected_memes/FB_IMG_1616922321009.jpg', 4, 1, '2025-08-22 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(94, 'Environmental Conservation Success', 'Conservation efforts have led to the successful recovery of several endangered species populations, demonstrating the effectiveness of targeted environmental protection measures. Wildlife biologists are celebrating this conservation success. Environmental groups are calling for continued support.', 'Conservation efforts lead to recovery of endangered species populations.', 'resources/Various_collected_memes/FB_IMG_1619404498329.jpg', 4, 1, '2025-08-30 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(95, 'Neuroscience Research Breakthrough', 'Neuroscience research has achieved a breakthrough in understanding brain function that could lead to advances in treating neurological disorders. The research involved advanced imaging techniques. Neurologists are hopeful about potential therapeutic applications.', 'New understanding of brain function could lead to treatment advances.', 'resources/Various_collected_memes/FB_IMG_1616920722057.jpg', 4, 1, '2025-08-25 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(96, 'Materials Science Innovation', 'Materials science researchers have discovered new material properties that could revolutionize manufacturing processes and product development. The innovation involves novel composite materials. Engineers are exploring practical applications for the new materials.', 'New material properties discovered that could revolutionize manufacturing.', 'resources/Various_collected_memes/FB_IMG_1617742479696.jpg', 4, 1, '2025-08-27 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(97, 'Genetic Research Advances', 'New genetic research has provided valuable insights into hereditary disease prevention and treatment strategies. The research involved large-scale genetic analysis. Geneticists are optimistic about the potential for personalized medicine.', 'New genetic research provides insights into hereditary disease prevention.', 'resources/Various_collected_memes/FB_IMG_1617739177107.jpg', 4, 1, '2025-08-30 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(98, 'Ocean Research Expedition', 'A deep-sea research expedition has discovered new marine species and ecosystems in previously unexplored ocean depths. The findings expand our understanding of marine biodiversity. Marine biologists are excited about the new discoveries and their implications.', 'Deep-sea research expedition discovers new marine species and ecosystems.', 'resources/Various_collected_memes/FB_IMG_1620191592678.jpg', 4, 1, '2025-09-08 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(99, 'Championship Game Thriller', 'A last-minute victory secured the championship title in dramatic fashion as the underdog team overcame a significant deficit. The game featured incredible plays and emotional moments. Fans are celebrating the historic win.', 'Last-minute victory secures championship title in dramatic fashion.', 'resources/Various_collected_memes/85362188.jpg', 6, 1, '2025-09-18 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(100, 'Olympic Records Broken', 'Multiple Olympic records were shattered at the international competition, showcasing the incredible athletic achievements of world-class athletes. The performances exceeded all expectations. Sports commentators are calling it a historic event.', 'Multiple Olympic records shattered at international competition.', 'resources/Various_collected_memes/FB_IMG_1617486391815.jpg', 6, 1, '2025-09-13 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(101, 'Rookie Sensation Emerges', 'A young athlete has made an immediate impact in their professional debut season, quickly becoming a fan favorite and key contributor to their team\'s success. The rookie\'s performance has exceeded all expectations. Team management is excited about the future.', 'Young athlete makes immediate impact in professional debut season.', 'resources/Various_collected_memes/FB_IMG_1617818445579.jpg', 6, 1, '2025-08-26 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(102, 'Comeback Victory Stuns Fans', 'A team overcame a massive deficit to win in an overtime thriller that stunned fans and analysts alike. The victory showcased incredible determination and skill. Sports fans are calling it one of the greatest comebacks ever.', 'Team overcomes massive deficit to win in overtime thriller.', 'resources/Various_collected_memes/FB_IMG_1617107657391.jpg', 6, 1, '2025-09-13 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31');
INSERT INTO `news` (`id`, `title`, `content`, `excerpt`, `image_url`, `category_id`, `author_id`, `published_at`, `views`, `is_published`, `created_at`, `updated_at`) VALUES
(103, 'Championship Series Begins', 'The best teams are facing off in a highly anticipated championship series that promises to deliver exciting competition and memorable moments. The series features the top talent in the sport. Fans are eagerly following every game.', 'Best teams face off in highly anticipated championship series.', 'resources/Various_collected_memes/FB_IMG_1618714272335.jpg', 6, 1, '2025-08-24 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(104, 'Athlete Retirement Announcement', 'A legendary athlete has announced their retirement after an illustrious career that spanned decades and included numerous championships and records. The announcement has sparked tributes from fans and fellow athletes. The sport will miss their presence.', 'Legendary athlete announces retirement after illustrious career.', 'resources/Various_collected_memes/FB_IMG_1617848256858.jpg', 6, 1, '2025-09-18 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(105, 'Training Facility Opens', 'A state-of-the-art training facility has opened, providing professional athletes with cutting-edge equipment and technology to enhance their performance. The facility represents a significant investment in athletic development. Athletes are excited about the new resources.', 'State-of-the-art training facility opens for professional athletes.', 'resources/Various_collected_memes/FB_IMG_1618697846891.jpg', 6, 1, '2025-09-18 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(106, 'Youth Sports Program Expands', 'A community youth sports program has expanded to serve more children, providing opportunities for physical activity and skill development. The program emphasizes fun and character building. Parents are grateful for the positive impact on their children.', 'Community youth sports program expands to serve more children.', 'resources/Various_collected_memes/FB_IMG_1617133106260.jpg', 6, 1, '2025-08-28 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(107, 'Sports Medicine Advances', 'New sports medicine techniques are helping athletes recover faster from injuries and maintain peak performance. The advances include innovative rehabilitation methods. Sports medicine professionals are excited about the improved outcomes.', 'New sports medicine techniques help athletes recover faster.', 'resources/Various_collected_memes/FB_IMG_1618531579937.jpg', 6, 1, '2025-09-18 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(108, 'International Competition Results', 'The national team has achieved historic success at an international competition, bringing pride to the country and inspiring future generations of athletes. The victory represents years of hard work and dedication. Citizens are celebrating the achievement.', 'National team achieves historic success at international competition.', 'resources/Various_collected_memes/FB_IMG_1616955834706.jpg', 6, 1, '2025-09-10 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(109, 'Revolutionary AI Breakthrough Announced', 'Researchers have announced a revolutionary breakthrough in artificial intelligence that demonstrates unprecedented capabilities in natural language processing and problem-solving. The new system could transform various industries. Technology experts are calling this a game-changing development.', 'New artificial intelligence system demonstrates unprecedented capabilities.', 'resources/Various_collected_memes/FB_IMG_1617819962833.jpg', 3, 1, '2025-08-28 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(110, 'Quantum Computing Milestone Reached', 'Scientists have reached a major milestone in quantum computing technology, achieving quantum supremacy in a specific computational task. This breakthrough could revolutionize cryptography and scientific computing. Quantum researchers are excited about the implications.', 'Scientists achieve major breakthrough in quantum computing technology.', 'resources/Various_collected_memes/FB_IMG_1617900738798.jpg', 3, 1, '2025-08-23 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(111, '5G Network Expansion Accelerates', 'Telecommunications companies are rapidly expanding 5G network coverage across the country, bringing faster internet speeds to more areas. The expansion is expected to enable new applications and services. Consumers are eagerly awaiting improved connectivity.', 'Telecommunications companies rapidly expanding 5G coverage nationwide.', 'resources/Various_collected_memes/FB_IMG_1617901724169.jpg', 3, 1, '2025-09-06 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(112, 'Autonomous Vehicle Testing Expands', 'Autonomous vehicle testing programs are expanding to more cities worldwide as companies work toward commercial deployment. The technology continues to improve with each test. Transportation experts are optimistic about the future of autonomous mobility.', 'Self-driving car testing programs expand to more cities worldwide.', 'resources/Various_collected_memes/FB_IMG_1616921978048.jpg', 3, 1, '2025-08-23 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(113, 'Blockchain Technology Adoption Grows', 'Blockchain technology adoption is growing across various industries as companies discover new applications beyond cryptocurrency. The technology offers improved security and transparency. Business leaders are exploring innovative use cases.', 'More industries adopting blockchain technology for various applications.', 'resources/Various_collected_memes/FB_IMG_1618714272335.jpg', 3, 1, '2025-09-07 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(114, 'Virtual Reality Market Expands', 'The virtual reality market is expanding rapidly as technology becomes more accessible and affordable for consumers. New applications are emerging in gaming, education, and healthcare. VR enthusiasts are excited about the growing ecosystem.', 'VR technology becoming more accessible and popular among consumers.', 'resources/Various_collected_memes/FB_IMG_1618790527439.jpg', 3, 1, '2025-09-08 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(115, 'Cybersecurity Threats Increase', 'Cybersecurity threats are increasing in frequency and sophistication, prompting organizations to implement stronger security measures. Experts are calling for improved cybersecurity education and awareness. Security professionals are working to stay ahead of threats.', 'Rising cybersecurity threats prompt increased security measures.', 'resources/Various_collected_memes/FB_IMG_1620191592678.jpg', 3, 1, '2025-09-19 15:31:02', 4, 1, '2025-09-20 15:31:02', '2025-09-20 17:31:09'),
(116, 'Cloud Computing Revolution Continues', 'Cloud computing adoption continues to accelerate across all business sectors as companies recognize the benefits of scalable, flexible IT infrastructure. The technology is enabling new business models. IT professionals are embracing the cloud-first approach.', 'Cloud computing adoption accelerates across all business sectors.', 'resources/Various_collected_memes/FB_IMG_1617107332752.jpg', 3, 1, '2025-09-02 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(117, 'Internet of Things Integration Expands', 'Internet of Things devices are becoming more integrated into daily life and business operations, creating new opportunities for automation and data collection. The technology is improving efficiency and convenience. IoT developers are creating innovative solutions.', 'IoT devices becoming more integrated into daily life and business operations.', 'resources/Various_collected_memes/FB_IMG_1621895501423.jpg', 3, 1, '2025-09-17 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(118, 'Machine Learning Applications Multiply', 'Machine learning applications are multiplying across diverse industries as organizations discover new ways to leverage AI for problem-solving. The technology is improving decision-making and efficiency. Data scientists are excited about the expanding possibilities.', 'Machine learning being applied to solve problems across diverse industries.', 'resources/Various_collected_memes/FB_IMG_1617819691827.jpg', 3, 1, '2025-08-27 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(119, 'Global Summit Addresses Climate Crisis', 'World leaders from across the globe have gathered for an unprecedented summit focused on addressing the climate crisis. The meeting aims to coordinate international efforts and establish binding commitments for carbon reduction. Environmental activists are hopeful for meaningful progress.', 'World leaders gather to discuss urgent climate action and policy coordination.', 'resources/Various_collected_memes/FB_IMG_1616920947780.jpg', 2, 1, '2025-09-07 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(120, 'International Space Station Mission Success', 'The latest International Space Station mission has been completed successfully, marking another milestone in international space cooperation. The mission included scientific experiments and maintenance tasks. Space agencies worldwide are celebrating this achievement.', 'Successful mission marks new milestone in international space cooperation.', 'resources/Various_collected_memes/FB_IMG_1616920722057.jpg', 2, 1, '2025-09-08 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(121, 'Global Economic Recovery Shows Signs', 'Economic indicators from around the world are showing signs of gradual recovery from the recent global economic downturn. Trade volumes are increasing and unemployment rates are stabilizing. Economists remain cautiously optimistic about the trend.', 'Economic indicators suggest gradual recovery from recent global downturn.', 'resources/Various_collected_memes/Live like your life depends on it.jpg', 2, 1, '2025-08-26 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(122, 'International Peacekeeping Mission Deployed', 'A new UN peacekeeping mission has been deployed to help maintain stability in a conflict-affected region. The mission includes troops from multiple countries working together. International organizations are monitoring the situation closely.', 'UN peacekeeping forces deployed to maintain stability in conflict region.', 'resources/Various_collected_memes/hqdefault.jpg', 2, 1, '2025-08-30 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(123, 'Global Health Initiative Launched', 'A major global health initiative has been launched to improve healthcare access in developing countries. The program includes funding for medical equipment and training. Health organizations worldwide are supporting the initiative.', 'New international health program aims to improve healthcare access worldwide.', 'resources/Various_collected_memes/FB_IMG_1617904594777.jpg', 2, 1, '2025-09-07 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(124, 'International Trade Dispute Resolved', 'A long-standing trade dispute between major world economies has finally been resolved through diplomatic negotiations. The resolution is expected to benefit global trade and economic stability. Business leaders are optimistic about the improved trade relations.', 'Long-standing trade dispute between major economies finally resolved.', 'resources/Various_collected_memes/FB_IMG_1617900738798.jpg', 2, 1, '2025-08-21 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(125, 'Global Refugee Crisis Update', 'The international community continues to work together to address the ongoing global refugee crisis. New programs have been established to provide better support for displaced populations. Humanitarian organizations are coordinating relief efforts.', 'International community works together to address ongoing refugee crisis.', 'resources/Various_collected_memes/FB_IMG_1617162772827.jpg', 2, 1, '2025-09-01 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(126, 'International Cybersecurity Cooperation', 'Countries around the world are increasing cooperation to combat growing cybersecurity threats. New information-sharing agreements have been established to protect critical infrastructure. Technology experts are praising the collaborative approach.', 'Nations collaborate to combat growing cybersecurity threats.', 'resources/Various_collected_memes/FB_IMG_1618032252301.jpg', 2, 1, '2025-08-31 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(127, 'Global Education Initiative Announced', 'A new global education initiative has been announced to improve learning opportunities for children worldwide. The program focuses on providing access to quality education in underserved areas. Educational organizations are supporting the initiative.', 'International education program aims to improve learning opportunities worldwide.', 'resources/Various_collected_memes/FB_IMG_1617848237145.jpg', 2, 1, '2025-09-01 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:32'),
(128, 'International Cultural Exchange Program', 'A new international cultural exchange program has been launched to promote understanding and cooperation between different nations. The program includes student exchanges and cultural events. Cultural organizations are excited about the opportunities for connection.', 'New program promotes cultural understanding and cooperation between nations.', 'resources/Various_collected_memes/Men can fornicate and make progress meme.jpg', 2, 1, '2025-09-14 15:31:02', 0, 1, '2025-09-20 15:31:02', '2025-09-20 15:57:31'),
(129, 'Trump to impose $100,000 fee per year for H-1B visas, in blow to tech', 'SAN FRANCISCO/WASHINGTON, Sept 19 (Reuters) - The Trump administration said on Friday it would ask companies to pay $100,000 per year for H-1B worker visas, prompting some big tech companies to warn visa holders to stay in the U.S. or quickly return.\r\nThe change could deal a big blow to the technology sector that relies heavily on skilled workers from India and China.\r\nRead about innovative ideas and the people working on solutions to global crises with the Reuters Beacon newsletter. Sign up here.\r\nSince taking office in January, Trump has kicked off a wide-ranging immigration crackdown, including moves to limit some forms of legal immigration. The step to reshape the H-1B visa program represents his administration\'s most high-profile effort yet to rework temporary employment visas.', 'Visas are used principally by tech sector\r\nMicrosoft, JPMorgan advised H-1B holders to remain in US\r\nOver 70% of beneficiaries of H-1B visas enter US from India\r\nLatest move in Trump\'s broader immigration crackdown', NULL, 8, 1, '2025-09-20 18:02:00', 0, 1, '2025-09-20 18:02:45', '2025-09-20 18:02:45'),
(130, 'Tesla Reports Record Q3 Revenue Despite Supply Chain Challenges', '<p>Tesla Inc. announced record-breaking third-quarter revenue of $23.4 billion, representing a 37% increase year-over-year, despite ongoing global supply chain disruptions and semiconductor shortages.</p>\r\n\r\n<p>The electric vehicle manufacturer delivered 343,830 vehicles globally in Q3, exceeding analyst expectations. The company\'s automotive revenue reached $20.2 billion, while energy generation and storage revenue hit $1.1 billion.</p>\r\n\r\n<p>CEO Elon Musk attributed the strong performance to increased production efficiency at the company\'s Gigafactories and successful cost management strategies. \"We\'ve been able to navigate supply chain challenges better than expected through vertical integration and strategic partnerships,\" Musk stated during the earnings call.</p>\r\n\r\n<p>The company also announced plans to accelerate production of its Cybertruck, with deliveries expected to begin in late 2024. Tesla\'s stock price surged 8% in after-hours trading following the earnings announcement.</p>', 'Tesla achieves record Q3 revenue of $23.4B despite supply chain challenges, delivering 343,830 vehicles globally.', 'resources/Rectangle 20.png', 8, 1, '2025-01-15 14:30:00', 0, 1, '2025-09-20 18:13:50', '2025-09-20 18:13:50'),
(131, 'Federal Reserve Raises Interest Rates by 0.75% to Combat Inflation', '<p>The Federal Reserve announced a 0.75 percentage point increase in the federal funds rate, bringing the target range to 3.75% to 4.00%, as part of its aggressive campaign to combat persistent inflation.</p>\r\n\r\n<p>This marks the sixth consecutive rate hike this year, with the central bank signaling that more increases may be necessary to bring inflation down to its 2% target. The current inflation rate stands at 8.2%, well above the Fed\'s comfort zone.</p>\r\n\r\n<p>Fed Chair Jerome Powell emphasized the central bank\'s commitment to price stability, stating, \"We will continue to take the necessary steps to restore price stability. It is essential that we get inflation back down to 2%.\"</p>\r\n\r\n<p>The rate increase is expected to impact mortgage rates, credit card interest, and business borrowing costs. Markets reacted with mixed signals, with the Dow Jones falling 1.2% while the S&P 500 remained relatively stable.</p>', 'Fed raises interest rates by 0.75% to 3.75-4.00% range in continued effort to combat 8.2% inflation.', 'resources/Rectangle 24.png', 8, 1, '2025-01-14 16:45:00', 0, 1, '2025-09-20 18:13:50', '2025-09-20 18:13:50'),
(132, 'Amazon Announces Major Expansion of Cloud Infrastructure in Europe', '<p>Amazon Web Services (AWS) revealed plans to invest €7.8 billion ($8.5 billion) in expanding its cloud infrastructure across Europe over the next five years, creating thousands of new jobs and supporting digital transformation initiatives.</p>\r\n\r\n<p>The expansion includes new data centers in Ireland, Germany, and Spain, as well as the development of renewable energy projects to power the facilities. AWS aims to achieve carbon neutrality across all European operations by 2025.</p>\r\n\r\n<p>Andy Jassy, CEO of Amazon, stated, \"This investment reflects our commitment to supporting European businesses and governments in their digital transformation journeys. We\'re building the infrastructure that will power the next generation of European innovation.\"</p>\r\n\r\n<p>The announcement comes as European regulators increase scrutiny of cloud providers, with new data sovereignty requirements and competition concerns driving demand for local cloud infrastructure.</p>', 'AWS invests €7.8B in European cloud infrastructure expansion, creating thousands of jobs and supporting digital transformation.', 'resources/Rectangle 25.png', 8, 1, '2025-01-13 11:20:00', 0, 1, '2025-09-20 18:13:50', '2025-09-20 18:13:50'),
(133, 'Microsoft Reports Strong Cloud Growth in Q4 Earnings', '<p>Microsoft Corporation reported robust fourth-quarter earnings with revenue of $52.9 billion, driven primarily by strong performance in its cloud computing division, Azure, and productivity software suite.</p>\r\n\r\n<p>Azure revenue grew 35% year-over-year, while Office 365 commercial revenue increased 15%. The company\'s Intelligent Cloud segment, which includes Azure, reached $20.3 billion in revenue, representing 38% of total company revenue.</p>\r\n\r\n<p>CEO Satya Nadella highlighted the company\'s focus on AI integration across its product portfolio, stating, \"We\'re seeing strong demand for our AI-powered solutions, particularly in enterprise environments where customers are looking to enhance productivity and efficiency.\"</p>\r\n\r\n<p>The company also announced a $40 billion share buyback program and increased its quarterly dividend by 10%. Microsoft\'s stock price rose 4% in after-hours trading following the earnings release.</p>', 'Microsoft reports $52.9B Q4 revenue with 35% Azure growth and strong demand for AI-powered enterprise solutions.', 'resources/Rectangle 26.png', 8, 1, '2025-01-12 09:15:00', 0, 1, '2025-09-20 18:13:50', '2025-09-20 18:13:50'),
(134, 'Global Supply Chain Crisis Shows Signs of Improvement', '<p>Major shipping companies and logistics providers report significant improvements in global supply chain operations, with container shipping rates dropping 40% from peak levels and port congestion decreasing across major trade routes.</p>\r\n\r\n<p>The Baltic Dry Index, a key indicator of shipping costs, has fallen to its lowest level in 18 months, signaling improved supply chain efficiency. Ports in Los Angeles and Long Beach have reduced their container backlog by 60% compared to last year.</p>\r\n\r\n<p>Industry experts attribute the improvement to increased shipping capacity, better port automation, and shifting consumer demand patterns. \"We\'re seeing a normalization of supply chains as capacity catches up with demand,\" said John Smith, CEO of Global Logistics Inc.</p>\r\n\r\n<p>However, challenges remain in specific sectors, particularly automotive and electronics, where semiconductor shortages continue to impact production schedules. The International Monetary Fund projects global trade growth of 4.3% in 2025, up from 2.7% in 2024.</p>', 'Global supply chain crisis shows improvement with 40% drop in shipping rates and 60% reduction in port congestion.', 'resources/Rectangle 27.png', 8, 1, '2025-01-11 13:00:00', 0, 1, '2025-09-20 18:13:50', '2025-09-20 18:13:50');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferences` text COLLATE utf8mb4_unicode_ci,
  `is_admin` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `phone`, `preferences`, `is_admin`, `created_at`, `last_login`, `updated_at`) VALUES
(1, 'maks', 'maksvokulov@mail.ru', '$2y$10$CXZdmFTTpTeC3Lna/ujVWOfQZOighRmkjOY4dwSBQGeRr3/7hwL/O', '', '{\"categories\":[]}', 1, '2025-09-14 23:35:32', '2025-09-20 15:14:13', '2025-09-20 15:14:13'),
(2, 'keny', 'keny2880@gmail.com', '$2y$10$hs9SiopA8phzowh4.CmpF.Y55zwpyhlzi8eTakX98oOrtPNfH2H/m', '', '{\"categories\":[\"science\"]}', 0, '2025-09-17 21:34:22', '2025-09-18 20:10:26', '2025-09-18 20:10:26');

-- --------------------------------------------------------

--
-- Структура таблицы `user_article_reads`
--

CREATE TABLE `user_article_reads` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `article_id` int NOT NULL,
  `category_id` int NOT NULL,
  `read_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_article_reads`
--

INSERT INTO `user_article_reads` (`id`, `user_id`, `article_id`, `category_id`, `read_at`) VALUES
(1, 1, 19, 8, '2025-09-17 22:18:10'),
(2, 1, 11, 4, '2025-09-17 22:18:12'),
(3, 1, 14, 8, '2025-09-17 22:18:24'),
(8, 1, 12, 2, '2025-09-18 00:29:04'),
(12, 2, 19, 8, '2025-09-18 19:40:25'),
(13, 2, 12, 2, '2025-09-18 19:41:22'),
(16, 2, 22, 4, '2025-09-18 19:46:46'),
(17, 2, 20, 4, '2025-09-18 19:46:48'),
(18, 2, 11, 4, '2025-09-18 19:46:51'),
(28, 2, 28, 4, '2025-09-20 14:29:11'),
(33, 2, 25, 4, '2025-09-20 15:10:56'),
(34, 2, 26, 4, '2025-09-20 15:10:58'),
(35, 2, 27, 4, '2025-09-20 15:10:59'),
(37, 1, 87, 1, '2025-09-20 15:48:11'),
(38, 1, 77, 5, '2025-09-20 15:58:08'),
(39, 1, 33, 8, '2025-09-20 17:13:23'),
(40, 1, 34, 8, '2025-09-20 17:16:30'),
(41, 1, 115, 3, '2025-09-20 17:22:54');

-- --------------------------------------------------------

--
-- Структура таблицы `user_interests`
--

CREATE TABLE `user_interests` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `weight` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_interests`
--

INSERT INTO `user_interests` (`id`, `user_id`, `category_id`, `weight`, `created_at`, `updated_at`) VALUES
(30, 2, 4, 7, '2025-09-20 15:10:59', '2025-09-20 15:10:59'),
(31, 2, 2, 1, '2025-09-20 15:10:59', '2025-09-20 15:10:59'),
(32, 2, 8, 1, '2025-09-20 15:10:59', '2025-09-20 15:10:59'),
(52, 1, 8, 4, '2025-09-20 17:22:54', '2025-09-20 17:22:54'),
(53, 1, 4, 1, '2025-09-20 17:22:54', '2025-09-20 17:22:54'),
(54, 1, 2, 1, '2025-09-20 17:22:54', '2025-09-20 17:22:54'),
(55, 1, 5, 1, '2025-09-20 17:22:54', '2025-09-20 17:22:54'),
(56, 1, 1, 1, '2025-09-20 17:22:54', '2025-09-20 17:22:54');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `idx_category_published` (`category_id`,`is_published`),
  ADD KEY `idx_published_date` (`is_published`,`published_at`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `user_article_reads`
--
ALTER TABLE `user_article_reads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_article` (`user_id`,`article_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `read_at` (`read_at`);

--
-- Индексы таблицы `user_interests`
--
ALTER TABLE `user_interests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_category` (`user_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user_article_reads`
--
ALTER TABLE `user_article_reads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `user_interests`
--
ALTER TABLE `user_interests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_article_reads`
--
ALTER TABLE `user_article_reads`
  ADD CONSTRAINT `user_article_reads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_article_reads_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_article_reads_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_interests`
--
ALTER TABLE `user_interests`
  ADD CONSTRAINT `user_interests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_interests_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
