--
-- PostgreSQL database dump
--

\restrict 9N9VDcbbkdUFuhr739FcCSUmIyrDPv57bb0pydGznkuVxqZjUh8YrQirypBeiaT

-- Dumped from database version 17.6
-- Dumped by pg_dump version 18.6 (Homebrew)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: audit_log_entries; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: custom_oauth_providers; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: flow_state; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: users; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: identities; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: instances; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: oauth_clients; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: sessions; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: mfa_amr_claims; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: mfa_factors; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: mfa_challenges; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: mfa_recovery_code_sets; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: mfa_recovery_codes; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: oauth_authorizations; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: oauth_client_states; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: oauth_consents; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: one_time_tokens; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: refresh_tokens; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: sso_providers; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: saml_providers; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: saml_relay_states; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: schema_migrations; Type: TABLE DATA; Schema: auth; Owner: -
--

INSERT INTO auth.schema_migrations VALUES ('20171026211738');
INSERT INTO auth.schema_migrations VALUES ('20171026211808');
INSERT INTO auth.schema_migrations VALUES ('20171026211834');
INSERT INTO auth.schema_migrations VALUES ('20180103212743');
INSERT INTO auth.schema_migrations VALUES ('20180108183307');
INSERT INTO auth.schema_migrations VALUES ('20180119214651');
INSERT INTO auth.schema_migrations VALUES ('20180125194653');
INSERT INTO auth.schema_migrations VALUES ('00');
INSERT INTO auth.schema_migrations VALUES ('20210710035447');
INSERT INTO auth.schema_migrations VALUES ('20210722035447');
INSERT INTO auth.schema_migrations VALUES ('20210730183235');
INSERT INTO auth.schema_migrations VALUES ('20210909172000');
INSERT INTO auth.schema_migrations VALUES ('20210927181326');
INSERT INTO auth.schema_migrations VALUES ('20211122151130');
INSERT INTO auth.schema_migrations VALUES ('20211124214934');
INSERT INTO auth.schema_migrations VALUES ('20211202183645');
INSERT INTO auth.schema_migrations VALUES ('20220114185221');
INSERT INTO auth.schema_migrations VALUES ('20220114185340');
INSERT INTO auth.schema_migrations VALUES ('20220224000811');
INSERT INTO auth.schema_migrations VALUES ('20220323170000');
INSERT INTO auth.schema_migrations VALUES ('20220429102000');
INSERT INTO auth.schema_migrations VALUES ('20220531120530');
INSERT INTO auth.schema_migrations VALUES ('20220614074223');
INSERT INTO auth.schema_migrations VALUES ('20220811173540');
INSERT INTO auth.schema_migrations VALUES ('20221003041349');
INSERT INTO auth.schema_migrations VALUES ('20221003041400');
INSERT INTO auth.schema_migrations VALUES ('20221011041400');
INSERT INTO auth.schema_migrations VALUES ('20221020193600');
INSERT INTO auth.schema_migrations VALUES ('20221021073300');
INSERT INTO auth.schema_migrations VALUES ('20221021082433');
INSERT INTO auth.schema_migrations VALUES ('20221027105023');
INSERT INTO auth.schema_migrations VALUES ('20221114143122');
INSERT INTO auth.schema_migrations VALUES ('20221114143410');
INSERT INTO auth.schema_migrations VALUES ('20221125140132');
INSERT INTO auth.schema_migrations VALUES ('20221208132122');
INSERT INTO auth.schema_migrations VALUES ('20221215195500');
INSERT INTO auth.schema_migrations VALUES ('20221215195800');
INSERT INTO auth.schema_migrations VALUES ('20221215195900');
INSERT INTO auth.schema_migrations VALUES ('20230116124310');
INSERT INTO auth.schema_migrations VALUES ('20230116124412');
INSERT INTO auth.schema_migrations VALUES ('20230131181311');
INSERT INTO auth.schema_migrations VALUES ('20230322519590');
INSERT INTO auth.schema_migrations VALUES ('20230402418590');
INSERT INTO auth.schema_migrations VALUES ('20230411005111');
INSERT INTO auth.schema_migrations VALUES ('20230508135423');
INSERT INTO auth.schema_migrations VALUES ('20230523124323');
INSERT INTO auth.schema_migrations VALUES ('20230818113222');
INSERT INTO auth.schema_migrations VALUES ('20230914180801');
INSERT INTO auth.schema_migrations VALUES ('20231027141322');
INSERT INTO auth.schema_migrations VALUES ('20231114161723');
INSERT INTO auth.schema_migrations VALUES ('20231117164230');
INSERT INTO auth.schema_migrations VALUES ('20240115144230');
INSERT INTO auth.schema_migrations VALUES ('20240214120130');
INSERT INTO auth.schema_migrations VALUES ('20240306115329');
INSERT INTO auth.schema_migrations VALUES ('20240314092811');
INSERT INTO auth.schema_migrations VALUES ('20240427152123');
INSERT INTO auth.schema_migrations VALUES ('20240612123726');
INSERT INTO auth.schema_migrations VALUES ('20240729123726');
INSERT INTO auth.schema_migrations VALUES ('20240802193726');
INSERT INTO auth.schema_migrations VALUES ('20240806073726');
INSERT INTO auth.schema_migrations VALUES ('20241009103726');
INSERT INTO auth.schema_migrations VALUES ('20250717082212');
INSERT INTO auth.schema_migrations VALUES ('20250731150234');
INSERT INTO auth.schema_migrations VALUES ('20250804100000');
INSERT INTO auth.schema_migrations VALUES ('20250901200500');
INSERT INTO auth.schema_migrations VALUES ('20250903112500');
INSERT INTO auth.schema_migrations VALUES ('20250904133000');
INSERT INTO auth.schema_migrations VALUES ('20250925093508');
INSERT INTO auth.schema_migrations VALUES ('20251007112900');
INSERT INTO auth.schema_migrations VALUES ('20251104100000');
INSERT INTO auth.schema_migrations VALUES ('20251111201300');
INSERT INTO auth.schema_migrations VALUES ('20251201000000');
INSERT INTO auth.schema_migrations VALUES ('20260115000000');
INSERT INTO auth.schema_migrations VALUES ('20260121000000');
INSERT INTO auth.schema_migrations VALUES ('20260219120000');
INSERT INTO auth.schema_migrations VALUES ('20260302000000');
INSERT INTO auth.schema_migrations VALUES ('20260625000000');
INSERT INTO auth.schema_migrations VALUES ('20260821000000');
INSERT INTO auth.schema_migrations VALUES ('20260821010000');
INSERT INTO auth.schema_migrations VALUES ('20260824000000');
INSERT INTO auth.schema_migrations VALUES ('20260824000001');
INSERT INTO auth.schema_migrations VALUES ('20260831180000');


--
-- Data for Name: scim_tokens; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: scim_users; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: sso_domains; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: webauthn_challenges; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: webauthn_credentials; Type: TABLE DATA; Schema: auth; Owner: -
--



--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.cache VALUES ('portfolioapi-cache-JTSVPINqr0su4NM2', 's:7:"forever";', 2098555145);
INSERT INTO public.cache VALUES ('portfolioapi-cache-ZiRpQR2eUSOqhkiq', 's:7:"forever";', 2098555586);


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.users VALUES (1, 'Pial Mahmud', 'pialmahmud80@gmail.com', NULL, 'pialmahmud5299@pialdev', '+8801853754763', 'https://cdn.phototourl.com/free/2026-07-03-6cb2123a-b4d8-4632-9d13-e8cae8fba3cb.jpg', 'admin', 'active', NULL, '2026-07-04 19:56:23', '2026-07-04 19:57:00');


--
-- Data for Name: posts; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: comments; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: contacts; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: likes; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.migrations VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO public.migrations VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO public.migrations VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO public.migrations VALUES (4, '2026_03_14_191936_add_role_and_phone_to_users_table', 1);
INSERT INTO public.migrations VALUES (5, '2026_03_14_203344_create_skills_table', 1);
INSERT INTO public.migrations VALUES (6, '2026_03_14_203345_create_categories_table', 1);
INSERT INTO public.migrations VALUES (7, '2026_03_14_203345_create_posts_table', 1);
INSERT INTO public.migrations VALUES (8, '2026_03_14_203345_create_projects_table', 1);
INSERT INTO public.migrations VALUES (9, '2026_03_14_203345_create_tags_table', 1);
INSERT INTO public.migrations VALUES (10, '2026_03_14_203346_create_comments_table', 1);
INSERT INTO public.migrations VALUES (11, '2026_03_14_203346_create_contacts_table', 1);
INSERT INTO public.migrations VALUES (12, '2026_03_14_203346_create_likes_table', 1);
INSERT INTO public.migrations VALUES (13, '2026_03_14_203999_create_post_tag_table', 1);


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: tags; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: post_tag; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: projects; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.projects VALUES (5, 'OnionTrade Pro', 'OnionTrade Pro is a production-ready intelligence platform built to bridge the information gap in agricultural trading. By providing real-time price recording, multi-market comparisons, and predictive analytics, it empowers traders and field agents to make data-backed arbitrage decisions.', NULL, NULL, 'https://github.com/mahmudpial/onion-trading-app', 'Laravel Web Application', false, 5, '2026-07-05 18:09:56', '2026-07-05 18:09:56');
INSERT INTO public.projects VALUES (6, 'Job Portal Application', 'A full-featured, role-based job portal where employers post jobs, employees apply, and admins manage the platform — built with Laravel 13.', NULL, NULL, 'https://github.com/mahmudpial/Job_Portal_Appliction_Laravel', 'Laravel Web Application', false, 6, '2026-07-05 18:12:48', '2026-07-05 18:12:48');
INSERT INTO public.projects VALUES (7, 'Non-profit Organization Website', 'The official website for EKOJ, a Bangladeshi non-profit organization — built as a fast, modern, bilingual (Bangla/English) single-page site with Vue 3, Vite, and Tailwind CSS.', NULL, 'https://remarkable-cat-64bfeb.netlify.app/', NULL, 'Frontend Web Application', false, 7, '2026-07-05 18:19:51', '2026-07-05 18:19:51');
INSERT INTO public.projects VALUES (4, 'Commercia Pro', 'A modern Vue 3 frontend application for managing an e-commerce platform — built with Vite, Pinia, Vue Router, and Bootstrap for a fast, responsive admin/storefront experience.', NULL, 'https://commerciapro.netlify.app/', 'https://github.com/mahmudpial/Ecommerce-Management-Web', 'Frontend Web  Application', false, 4, '2026-07-05 18:01:56', '2026-07-05 18:23:01');
INSERT INTO public.projects VALUES (9, 'ProTeam Website UI', 'An elegant, production-ready SaaS landing page designed to feel fast, modern, and polished from the first scroll. Built with plain HTML, Tailwind CSS, and lightweight JavaScript, this project keeps the experience simple to run while still delivering a premium, component-based interface.', NULL, 'https://mahmudpial.github.io/ProTeam_Website_UI/', 'https://github.com/mahmudpial/ProTeam_Website_UI', 'Frontend Website UI', false, 9, '2026-07-05 18:29:51', '2026-07-05 18:29:51');
INSERT INTO public.projects VALUES (10, 'Professional Footer Design with Tailwind CSS', 'A comprehensive collection of modern, professional footer layouts built with Tailwind CSS. Choose from multiple styles to match your project needs.', NULL, 'https://mahmudpial.github.io/Footer-pro/', 'https://github.com/mahmudpial/Footer-pro', 'Frontend Website UI', false, 11, '2026-07-05 18:34:19', '2026-07-05 18:34:19');
INSERT INTO public.projects VALUES (11, 'Modern Full-Stack Portfolio Template', 'A premium, high-performance frontend portfolio designed for software engineers and developers.
Built with a "Modern Monolith" philosophy—seamless, mobile-first UI today with architectural hooks for Laravel, React, or Vue backends tomorrow.', NULL, 'https://mahmudpial.github.io/Modern-Full-Stack-Portfolio-Template/', NULL, NULL, false, 12, '2026-07-05 18:37:08', '2026-07-05 18:37:08');
INSERT INTO public.projects VALUES (13, 'PHP Contact Management Apps', 'Contact management applications — a simple procedural version and an enhanced object-oriented version with persistent storage, CRUD operations, validation, and JSON-based data storage. Both projects are designed for beginners who want to practice core PHP concepts before moving into advanced frameworks like Laravel and frontend technologies such as Vue.js.', NULL, NULL, 'https://github.com/mahmudpial/php_contact_manager_project', 'Simple CLI App', false, 14, '2026-07-05 18:43:59', '2026-07-05 18:43:59');
INSERT INTO public.projects VALUES (8, 'Admin Pro Dashboard', 'A modern, professional admin dashboard application built with vanilla HTML, CSS, and JavaScript. Features real-time analytics, metrics tracking, and a sleek dark-themed user interface.', NULL, 'https://mahmudpial.github.io/Admin-Dashboard/', 'https://github.com/mahmudpial/Admin-Dashboard', 'Frontend Website UI', false, 8, '2026-07-05 18:27:12', '2026-07-05 18:48:19');
INSERT INTO public.projects VALUES (2, 'envShare Vault – Encrypted Secrets Sharing Platform', 'Secure, zero-knowledge payload transfer for .env files, SSH configs, and API credentials. Encrypted, transient, and automatically destroyed after use.', NULL, 'https://envshare-vault.onrender.com/', 'https://github.com/mahmudpial/envShare-vault', 'Laravel Web Application', true, 2, '2026-07-05 15:28:57', '2026-07-05 18:49:42');
INSERT INTO public.projects VALUES (1, 'Attendify – Smart Attendance with Geofencing & Overtime', 'A complete, production-ready attendance management system built with Laravel 13, Vue 3 (Inertia.js), and Supabase (PostgreSQL). Includes role-based access (Admin/Employee), GPS location tracking, IP logging, geofencing, overtime calculation, leave management, reporting, and email notifications', NULL, 'https://attendify-smart-attendance-with.vercel.app', 'https://github.com/mahmudpial/Attendify-Smart_Attendance_with_Geofencing_-_Overtime', 'Laravel Web Application', true, 1, '2026-07-05 15:20:32', '2026-07-05 18:50:14');
INSERT INTO public.projects VALUES (14, 'Real-Time Ticket Booking Notification System', 'A full-stack application demonstrating real-time event broadcasting using Laravel on the backend and Pusher WebSockets on the frontend. Whenever a ticket is booked, the client portal receives an instant push notification — no page refresh required.', NULL, NULL, 'https://github.com/mahmudpial/ticket-booking-assignment', 'Laravel Web Application', false, 15, '2026-07-05 18:47:35', '2026-07-05 18:51:23');
INSERT INTO public.projects VALUES (12, 'Image Collection List Design with Vue.js', 'A sleek and responsive image collection list built using Vue 3 and Vite', NULL, 'https://mahmudpial.github.io/image-collection-list-design-with-vue-js/', 'https://github.com/mahmudpial/image-collection-list-design-with-vue-js', 'Frontend Web Application', false, 13, '2026-07-05 18:40:24', '2026-07-05 18:51:51');
INSERT INTO public.projects VALUES (3, 'Laravel AI Assistant', 'A polished Laravel-based AI chatbot application powered by the Google Gemini API. The project combines a ChatGPT-inspired workspace layout, a helpful left-side information panel, session-based conversation history, and a clean chat experience for Laravel, PHP, and general programming questions.', NULL, NULL, 'https://github.com/mahmudpial/mahmudpial-Pial_Laravel_AI_Assistant', 'Laravel Web Application', true, 3, '2026-07-05 17:24:30', '2026-07-05 18:52:14');


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.sessions VALUES ('Euj0ADLgrq0dbA6YLn4ZG3jdqepcaH7mYvEAqEgR', NULL, '127.0.0.1', 'Go-http-client/1.1', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYkJycllVRlVIY01FVXl6MmpDaXNkYlNNb24zT1djY1dwT3VqNHpGQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1783194834);
INSERT INTO public.sessions VALUES ('nlNUnuCM3W4f5yl0I1dyLjRgVabggsPObD1JFePt', NULL, '127.0.0.1', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzNrM2dtZEtPYmJ2SnpxNkUwOXR1NXVsSmxFUFdOeDdZcDg0ZXdBRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly91c2VyLW1hbmFnZW1lbnQtYXBpLW45MzYub25yZW5kZXIuY29tIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1783194838);
INSERT INTO public.sessions VALUES ('4x7mGwmKTXoCbeE80ksxukHHweK7RpbV2RITSMAO', NULL, '127.0.0.1', 'Go-http-client/1.1', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYzA4bXBMSVZCUnlhMzNST3ZDU1RTbUJKYVVIMEppU21JdTFpbUxQRSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1783194921);
INSERT INTO public.sessions VALUES ('Y14IanbEvD7RVgMUbwHv7BIpg6sbwRpsG9vlLRks', NULL, '127.0.0.1', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZkdPRnNGQkVTTEp0U3N0Y3l5OFhqY0tyYzN6TXVYU051T1RlaHRTayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly91c2VyLW1hbmFnZW1lbnQtYXBpLW45MzYub25yZW5kZXIuY29tIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1783194925);
INSERT INTO public.sessions VALUES ('BAze2zGkGXZjdwgmYgDEGZFUJSZ2JiCHVTfHSljo', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUWRWTkRUc3VDU2d1azVKcmJ0RThmWEZFNmlSZ3V6VlRuZW9nRENwUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1783459661);
INSERT INTO public.sessions VALUES ('nmaMsPZVEnAp84UgRNQ6hrevTDiLpw2X9dxe2Zo2', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoia2NrYXNCN1lLNEhsdmpKZzc4S3VQY2UyZDJqRjlsYlFObERkRHp2UiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1783459664);
INSERT INTO public.sessions VALUES ('3INXiq1eOoBFKNXseRtGg0qyPBy4WaPilRHO38WC', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib2JQdGJ6RmpoR0VQcThvQnN5YnczcEhwZk81akV4YVJ6MWtkTm84RyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly91c2VyLW1hbmFnZW1lbnQtYXBpLW45MzYub25yZW5kZXIuY29tIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1783459668);
INSERT INTO public.sessions VALUES ('uYYKLDDzMeGaIQCfLrBJ5nNpsAv5EY05NlEeZdHt', NULL, '127.0.0.1', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; ClaudeBot/1.0; +claudebot@anthropic.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ0ltSE9CeHJWTHlPMFJKMzNKMEU0bzRIVGFGczlneER0UVpOVUV5TCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly91c2VyLW1hbmFnZW1lbnQtYXBpLW45MzYub25yZW5kZXIuY29tIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1783757693);
INSERT INTO public.sessions VALUES ('bFOo8qIcSRZGOJuPGqDThSi6RKCuO6PxjNI7bz4x', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibTdWTVdRdk95dXl1TDJPSTQyMkN3aHJHYmNwTUkxU01TSmpVUnJSUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1788411232);
INSERT INTO public.sessions VALUES ('jletwSJNYYL2u15Gycg51sBy9N2ACqVbwS8kp8yZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRG15SGZGM0NwQnpyY0VzU2twTmVHRk1sNXZDQUEybVZkeFNoSFcwViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1788411236);
INSERT INTO public.sessions VALUES ('Zsmzj1gdiFXbB1QRoNXt3jsDxP3BOsSad31TB9U2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaEJRdVh0bHUxQWViMkNUUElmNDBQVlQwYUxoUmJtZFQwQnVoZ29heSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1788411240);
INSERT INTO public.sessions VALUES ('DIh0uWVH48N6ofHpmDeyCUkB5ctUG1PZ0X0mcZsI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0l1MTNyVTFISU1yVFJrUnE1UWhya3BEYjFKQWh4ZWs3d0NOdGE3TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly91c2VyLW1hbmFnZW1lbnQtYXBpLW45MzYub25yZW5kZXIuY29tIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1788411243);
INSERT INTO public.sessions VALUES ('KwOYx90dSfv9Gufemu2wIs7UG5GDZHOZM5IIHddI', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWjQzQ3AxUUdhOHVVdTJUZVNtcURrTHBTaGt6RHVTd3llVlp5cnNybCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly91c2VyLW1hbmFnZW1lbnQtYXBpLW45MzYub25yZW5kZXIuY29tIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1788642383);


--
-- Data for Name: skills; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.skills VALUES (1, 'Laravel (PHP framework)', 100, 'Backend', 'fab fa-laravel', 1, '2026-07-05 14:27:26', '2026-07-05 14:27:26');
INSERT INTO public.skills VALUES (2, 'Vue.js 3 (Composition API, Inertia.js)', 100, 'Frontend', 'fab fa-vue.js', 2, '2026-07-05 14:28:35', '2026-07-05 14:28:35');
INSERT INTO public.skills VALUES (3, 'REST API', 100, 'Backend', NULL, 3, '2026-07-05 14:31:14', '2026-07-05 14:31:14');
INSERT INTO public.skills VALUES (4, 'MySQL / Supabase', 100, 'Backend', 'fa-solid fa-database', 4, '2026-07-05 14:32:54', '2026-07-05 14:32:54');
INSERT INTO public.skills VALUES (5, 'JWT Authentication', 100, 'Backend', 'fa-solid fa-key', 5, '2026-07-05 14:34:41', '2026-07-05 14:34:41');
INSERT INTO public.skills VALUES (6, 'Tailwind CSS', 100, 'Frontend', NULL, 6, '2026-07-05 14:35:55', '2026-07-05 14:35:55');
INSERT INTO public.skills VALUES (7, 'Bootstrap5', 100, 'Frontend', NULL, 7, '2026-07-05 14:37:04', '2026-07-05 14:37:04');
INSERT INTO public.skills VALUES (12, 'Vite', 100, 'DevOps / CI-CD Platform', NULL, 11, '2026-07-05 14:45:31', '2026-07-05 14:45:31');
INSERT INTO public.skills VALUES (13, 'Eloquent ORM', 100, 'Backend', NULL, 12, '2026-07-05 14:45:57', '2026-07-05 14:45:57');
INSERT INTO public.skills VALUES (15, 'Vercel', 100, 'DevOps / CI-CD Platform', NULL, 13, '2026-07-05 14:47:06', '2026-07-05 14:47:06');
INSERT INTO public.skills VALUES (8, 'Javascript', 95, 'Frontend', NULL, 8, '2026-07-05 14:37:49', '2026-07-05 14:58:20');
INSERT INTO public.skills VALUES (9, 'Git / GitHub', 100, 'DevOps / CI-CD Platform', NULL, 9, '2026-07-05 14:39:50', '2026-07-05 15:00:03');
INSERT INTO public.skills VALUES (10, 'PHP 8', 100, 'Backend', NULL, 10, '2026-07-05 14:40:26', '2026-07-05 15:00:15');
INSERT INTO public.skills VALUES (14, 'Render', 100, 'DevOps / CI-CD Platform', NULL, 14, '2026-07-05 14:46:41', '2026-07-05 15:00:55');
INSERT INTO public.skills VALUES (16, 'Railway', 50, 'DevOps / CI-CD Platform', NULL, 15, '2026-07-05 14:47:49', '2026-07-05 15:01:08');
INSERT INTO public.skills VALUES (17, 'Postman', 100, 'DevOps / CI-CD Platform', NULL, 16, '2026-07-05 14:49:15', '2026-07-05 15:01:21');
INSERT INTO public.skills VALUES (18, 'Netlify', 100, 'DevOps / CI-CD Platform', NULL, 17, '2026-07-05 14:50:18', '2026-07-05 15:01:34');
INSERT INTO public.skills VALUES (19, 'npm', 95, 'DevOps / CI-CD Platform', NULL, 18, '2026-07-05 14:51:02', '2026-07-05 15:01:46');
INSERT INTO public.skills VALUES (20, 'Gemini API', 100, 'DevOps / CI-CD Platform', NULL, 19, '2026-07-05 14:51:41', '2026-07-05 15:01:58');
INSERT INTO public.skills VALUES (21, 'Object-Oriented Programming (OOP)', 100, 'Core CSE', NULL, 20, '2026-07-05 14:52:34', '2026-07-05 15:02:15');
INSERT INTO public.skills VALUES (22, 'Data Structures & Algorithms (DSA)', 100, 'Core CSE', NULL, 21, '2026-07-05 14:53:18', '2026-07-05 15:02:27');
INSERT INTO public.skills VALUES (23, 'Artificial intelligence (AI)', 100, 'Core CSE', NULL, 22, '2026-07-05 14:53:50', '2026-07-05 15:02:37');
INSERT INTO public.skills VALUES (24, 'Machine learning (ML)', 100, 'Core CSE', NULL, 23, '2026-07-05 14:54:30', '2026-07-05 15:02:50');
INSERT INTO public.skills VALUES (26, 'Systems & Architecture', 100, 'Core CSE', NULL, 24, '2026-07-05 14:56:21', '2026-07-05 15:03:04');
INSERT INTO public.skills VALUES (25, 'Engineering mathematics', 70, 'Core CSE', NULL, 25, '2026-07-05 14:55:12', '2026-07-05 15:03:18');
INSERT INTO public.skills VALUES (27, 'Database Management Systems (DBMS)', 100, 'Core CSE', NULL, 26, '2026-07-05 14:57:08', '2026-07-05 15:03:38');
INSERT INTO public.skills VALUES (11, 'Docker', 90, 'DevOps / CI-CD Platform', NULL, 27, '2026-07-05 14:41:29', '2026-07-05 15:04:47');


--
-- Data for Name: schema_migrations; Type: TABLE DATA; Schema: realtime; Owner: -
--

INSERT INTO realtime.schema_migrations VALUES (20211116024918, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211116045059, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211116050929, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211116051442, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211116212300, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211116213355, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211116213934, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211116214523, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211122062447, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211124070109, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211202204204, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211202204605, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211210212804, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20211228014915, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20220107221237, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20220228202821, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20220312004840, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20220603231003, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20220603232444, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20220615214548, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20220712093339, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20220908172859, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20220916233421, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20230119133233, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20230128025114, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20230128025212, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20230227211149, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20230228184745, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20230308225145, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20230328144023, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20231018144023, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20231204144023, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20231204144024, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20231204144025, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20240108234812, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20240109165339, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20240227174441, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20240311171622, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20240321100241, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20240401105812, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20240418121054, '2026-07-03 17:43:07');
INSERT INTO realtime.schema_migrations VALUES (20240523004032, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20240618124746, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20240801235015, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20240805133720, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20240827160934, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20240919163303, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20240919163305, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20241019105805, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20241030150047, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20241108114728, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20241121104152, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20241130184212, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20241220035512, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20241220123912, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20241224161212, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20250107150512, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20250110162412, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20250123174212, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20250128220012, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20250506224012, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20250523164012, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20250714121412, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20250905041441, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20251103001201, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20251120212548, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20251120215549, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260218120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260326120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260514120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260527120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260528120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260603120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260605120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260606110000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260616120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260624120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260626120000, '2026-07-03 17:43:08');
INSERT INTO realtime.schema_migrations VALUES (20260706120000, '2026-07-10 09:08:44');
INSERT INTO realtime.schema_migrations VALUES (20260707120000, '2026-08-15 12:59:30');
INSERT INTO realtime.schema_migrations VALUES (20260709120000, '2026-08-15 12:59:30');
INSERT INTO realtime.schema_migrations VALUES (20260714120000, '2026-09-05 21:11:46');
INSERT INTO realtime.schema_migrations VALUES (20260827120000, '2026-09-28 19:14:09');
INSERT INTO realtime.schema_migrations VALUES (20260914120000, '2026-09-28 19:14:09');
INSERT INTO realtime.schema_migrations VALUES (20260916120000, '2026-09-28 19:14:09');
INSERT INTO realtime.schema_migrations VALUES (20260922120000, '2026-09-28 19:14:09');


--
-- Data for Name: subscription; Type: TABLE DATA; Schema: realtime; Owner: -
--



--
-- Data for Name: buckets; Type: TABLE DATA; Schema: storage; Owner: -
--



--
-- Data for Name: buckets_analytics; Type: TABLE DATA; Schema: storage; Owner: -
--



--
-- Data for Name: buckets_vectors; Type: TABLE DATA; Schema: storage; Owner: -
--



--
-- Data for Name: migrations; Type: TABLE DATA; Schema: storage; Owner: -
--

INSERT INTO storage.migrations VALUES (0, 'create-migrations-table', 'e18db593bcde2aca2a408c4d1100f6abba2195df', '2026-07-03 15:52:54.004584');
INSERT INTO storage.migrations VALUES (1, 'initialmigration', '6ab16121fbaa08bbd11b712d05f358f9b555d777', '2026-07-03 15:52:54.078393');
INSERT INTO storage.migrations VALUES (2, 'storage-schema', 'f6a1fa2c93cbcd16d4e487b362e45fca157a8dbd', '2026-07-03 15:52:54.09097');
INSERT INTO storage.migrations VALUES (3, 'pathtoken-column', '2cb1b0004b817b29d5b0a971af16bafeede4b70d', '2026-07-03 15:52:54.115397');
INSERT INTO storage.migrations VALUES (4, 'add-migrations-rls', '427c5b63fe1c5937495d9c635c263ee7a5905058', '2026-07-03 15:52:54.127197');
INSERT INTO storage.migrations VALUES (5, 'add-size-functions', '79e081a1455b63666c1294a440f8ad4b1e6a7f84', '2026-07-03 15:52:54.129937');
INSERT INTO storage.migrations VALUES (6, 'change-column-name-in-get-size', 'ded78e2f1b5d7e616117897e6443a925965b30d2', '2026-07-03 15:52:54.133315');
INSERT INTO storage.migrations VALUES (7, 'add-rls-to-buckets', 'e7e7f86adbc51049f341dfe8d30256c1abca17aa', '2026-07-03 15:52:54.137224');
INSERT INTO storage.migrations VALUES (8, 'add-public-to-buckets', 'fd670db39ed65f9d08b01db09d6202503ca2bab3', '2026-07-03 15:52:54.139352');
INSERT INTO storage.migrations VALUES (9, 'fix-search-function', 'af597a1b590c70519b464a4ab3be54490712796b', '2026-07-03 15:52:54.141909');
INSERT INTO storage.migrations VALUES (10, 'search-files-search-function', 'b595f05e92f7e91211af1bbfe9c6a13bb3391e16', '2026-07-03 15:52:54.145857');
INSERT INTO storage.migrations VALUES (11, 'add-trigger-to-auto-update-updated_at-column', '7425bdb14366d1739fa8a18c83100636d74dcaa2', '2026-07-03 15:52:54.149556');
INSERT INTO storage.migrations VALUES (12, 'add-automatic-avif-detection-flag', '8e92e1266eb29518b6a4c5313ab8f29dd0d08df9', '2026-07-03 15:52:54.152459');
INSERT INTO storage.migrations VALUES (13, 'add-bucket-custom-limits', 'cce962054138135cd9a8c4bcd531598684b25e7d', '2026-07-03 15:52:54.155299');
INSERT INTO storage.migrations VALUES (14, 'use-bytes-for-max-size', '941c41b346f9802b411f06f30e972ad4744dad27', '2026-07-03 15:52:54.15943');
INSERT INTO storage.migrations VALUES (15, 'add-can-insert-object-function', '934146bc38ead475f4ef4b555c524ee5d66799e5', '2026-07-03 15:52:54.181648');
INSERT INTO storage.migrations VALUES (16, 'add-version', '76debf38d3fd07dcfc747ca49096457d95b1221b', '2026-07-03 15:52:54.184488');
INSERT INTO storage.migrations VALUES (17, 'drop-owner-foreign-key', 'f1cbb288f1b7a4c1eb8c38504b80ae2a0153d101', '2026-07-03 15:52:54.187956');
INSERT INTO storage.migrations VALUES (18, 'add_owner_id_column_deprecate_owner', 'e7a511b379110b08e2f214be852c35414749fe66', '2026-07-03 15:52:54.191659');
INSERT INTO storage.migrations VALUES (19, 'alter-default-value-objects-id', '02e5e22a78626187e00d173dc45f58fa66a4f043', '2026-07-03 15:52:54.195333');
INSERT INTO storage.migrations VALUES (20, 'list-objects-with-delimiter', 'cd694ae708e51ba82bf012bba00caf4f3b6393b7', '2026-07-03 15:52:54.199734');
INSERT INTO storage.migrations VALUES (21, 's3-multipart-uploads', '8c804d4a566c40cd1e4cc5b3725a664a9303657f', '2026-07-03 15:52:54.205563');
INSERT INTO storage.migrations VALUES (22, 's3-multipart-uploads-big-ints', '9737dc258d2397953c9953d9b86920b8be0cdb73', '2026-07-03 15:52:54.216996');
INSERT INTO storage.migrations VALUES (23, 'optimize-search-function', '9d7e604cddc4b56a5422dc68c9313f4a1b6f132c', '2026-07-03 15:52:54.22971');
INSERT INTO storage.migrations VALUES (24, 'operation-function', '8312e37c2bf9e76bbe841aa5fda889206d2bf8aa', '2026-07-03 15:52:54.233074');
INSERT INTO storage.migrations VALUES (25, 'custom-metadata', 'd974c6057c3db1c1f847afa0e291e6165693b990', '2026-07-03 15:52:54.237238');
INSERT INTO storage.migrations VALUES (26, 'objects-prefixes', '215cabcb7f78121892a5a2037a09fedf9a1ae322', '2026-07-03 15:52:54.240032');
INSERT INTO storage.migrations VALUES (27, 'search-v2', '859ba38092ac96eb3964d83bf53ccc0b141663a6', '2026-07-03 15:52:54.242645');
INSERT INTO storage.migrations VALUES (28, 'object-bucket-name-sorting', 'c73a2b5b5d4041e39705814fd3a1b95502d38ce4', '2026-07-03 15:52:54.244893');
INSERT INTO storage.migrations VALUES (29, 'create-prefixes', 'ad2c1207f76703d11a9f9007f821620017a66c21', '2026-07-03 15:52:54.248275');
INSERT INTO storage.migrations VALUES (30, 'update-object-levels', '2be814ff05c8252fdfdc7cfb4b7f5c7e17f0bed6', '2026-07-03 15:52:54.25007');
INSERT INTO storage.migrations VALUES (31, 'objects-level-index', 'b40367c14c3440ec75f19bbce2d71e914ddd3da0', '2026-07-03 15:52:54.252121');
INSERT INTO storage.migrations VALUES (32, 'backward-compatible-index-on-objects', 'e0c37182b0f7aee3efd823298fb3c76f1042c0f7', '2026-07-03 15:52:54.254592');
INSERT INTO storage.migrations VALUES (33, 'backward-compatible-index-on-prefixes', 'b480e99ed951e0900f033ec4eb34b5bdcb4e3d49', '2026-07-03 15:52:54.256555');
INSERT INTO storage.migrations VALUES (34, 'optimize-search-function-v1', 'ca80a3dc7bfef894df17108785ce29a7fc8ee456', '2026-07-03 15:52:54.258349');
INSERT INTO storage.migrations VALUES (35, 'add-insert-trigger-prefixes', '458fe0ffd07ec53f5e3ce9df51bfdf4861929ccc', '2026-07-03 15:52:54.260168');
INSERT INTO storage.migrations VALUES (36, 'optimise-existing-functions', '6ae5fca6af5c55abe95369cd4f93985d1814ca8f', '2026-07-03 15:52:54.262011');
INSERT INTO storage.migrations VALUES (37, 'add-bucket-name-length-trigger', '3944135b4e3e8b22d6d4cbb568fe3b0b51df15c1', '2026-07-03 15:52:54.263832');
INSERT INTO storage.migrations VALUES (38, 'iceberg-catalog-flag-on-buckets', '02716b81ceec9705aed84aa1501657095b32e5c5', '2026-07-03 15:52:54.266637');
INSERT INTO storage.migrations VALUES (39, 'add-search-v2-sort-support', '6706c5f2928846abee18461279799ad12b279b78', '2026-07-03 15:52:54.275825');
INSERT INTO storage.migrations VALUES (40, 'fix-prefix-race-conditions-optimized', '7ad69982ae2d372b21f48fc4829ae9752c518f6b', '2026-07-03 15:52:54.277845');
INSERT INTO storage.migrations VALUES (41, 'add-object-level-update-trigger', '07fcf1a22165849b7a029deed059ffcde08d1ae0', '2026-07-03 15:52:54.281626');
INSERT INTO storage.migrations VALUES (42, 'rollback-prefix-triggers', '771479077764adc09e2ea2043eb627503c034cd4', '2026-07-03 15:52:54.287811');
INSERT INTO storage.migrations VALUES (43, 'fix-object-level', '84b35d6caca9d937478ad8a797491f38b8c2979f', '2026-07-03 15:52:54.289939');
INSERT INTO storage.migrations VALUES (44, 'vector-bucket-type', '99c20c0ffd52bb1ff1f32fb992f3b351e3ef8fb3', '2026-07-03 15:52:54.29293');
INSERT INTO storage.migrations VALUES (45, 'vector-buckets', '049e27196d77a7cb76497a85afae669d8b230953', '2026-07-03 15:52:54.295944');
INSERT INTO storage.migrations VALUES (46, 'buckets-objects-grants', 'fedeb96d60fefd8e02ab3ded9fbde05632f84aed', '2026-07-03 15:52:54.304728');
INSERT INTO storage.migrations VALUES (47, 'iceberg-table-metadata', '649df56855c24d8b36dd4cc1aeb8251aa9ad42c2', '2026-07-03 15:52:54.310908');
INSERT INTO storage.migrations VALUES (48, 'iceberg-catalog-ids', 'e0e8b460c609b9999ccd0df9ad14294613eed939', '2026-07-03 15:52:54.315134');
INSERT INTO storage.migrations VALUES (49, 'buckets-objects-grants-postgres', '072b1195d0d5a2f888af6b2302a1938dd94b8b3d', '2026-07-03 15:52:54.335241');
INSERT INTO storage.migrations VALUES (50, 'search-v2-optimised', '6323ac4f850aa14e7387eb32102869578b5bd478', '2026-07-03 15:52:54.347933');
INSERT INTO storage.migrations VALUES (51, 'index-backward-compatible-search', '2ee395d433f76e38bcd3856debaf6e0e5b674011', '2026-07-03 15:52:54.736898');
INSERT INTO storage.migrations VALUES (52, 'drop-not-used-indexes-and-functions', '5cc44c8696749ac11dd0dc37f2a3802075f3a171', '2026-07-03 15:52:54.73815');
INSERT INTO storage.migrations VALUES (53, 'drop-index-lower-name', 'd0cb18777d9e2a98ebe0bc5cc7a42e57ebe41854', '2026-07-03 15:52:54.746185');
INSERT INTO storage.migrations VALUES (54, 'drop-index-object-level', '6289e048b1472da17c31a7eba1ded625a6457e67', '2026-07-03 15:52:54.747577');
INSERT INTO storage.migrations VALUES (55, 'prevent-direct-deletes', '262a4798d5e0f2e7c8970232e03ce8be695d5819', '2026-07-03 15:52:54.74869');
INSERT INTO storage.migrations VALUES (56, 'fix-optimized-search-function', 'b823ed1e418101032fa01374edc9a436e54e3ed4', '2026-07-03 15:52:54.751804');
INSERT INTO storage.migrations VALUES (57, 's3-multipart-uploads-metadata', 'f127886e00d1b374fadbc7c6b31e09336aad5287', '2026-07-03 15:52:54.755344');
INSERT INTO storage.migrations VALUES (58, 'operation-ergonomics', '00ca5d483b3fe0d522133d9002ccc5df98365120', '2026-07-03 15:52:54.757747');
INSERT INTO storage.migrations VALUES (59, 'drop-unused-functions', '38456f13e39691c2bbb4b5151d0d1cdbabd4a8c4', '2026-07-03 15:52:54.760722');
INSERT INTO storage.migrations VALUES (60, 'optimize-existing-functions-again', 'db35e1c91a9201e59f4fef8d972c2f277d68b157', '2026-07-03 15:52:54.763067');
INSERT INTO storage.migrations VALUES (61, 'mark-filename-immutable', 'fe0096517ae9d60aaec1d110172ba9036dc66bb7', '2026-08-15 12:58:56.02969');
INSERT INTO storage.migrations VALUES (62, 'object-versioning-core', '0b855f00ff3be0bfca91efee02a9858912491a9a', '2026-09-05 21:11:48.746314');
INSERT INTO storage.migrations VALUES (63, 'fix-search-name-relative-to-prefix', 'c7485e417624f795ce8bb2da21927f48e088904d', '2026-09-05 21:11:48.770539');
INSERT INTO storage.migrations VALUES (64, 'fix-search-by-timestamp-sqli', '0af424ecd388a39bb1645184b222185a12149675', '2026-09-05 21:11:48.782931');
INSERT INTO storage.migrations VALUES (65, 'objects-key-version-index', 'da319c4b89ba800ce795d1b699f3a70675138058', '2026-09-28 19:13:59.419777');
INSERT INTO storage.migrations VALUES (66, 'objects-current-version-index', '191466c93aa2c46a00e36505577c5fcab8d7cb4b', '2026-09-28 19:13:59.430807');
INSERT INTO storage.migrations VALUES (67, 'objects-null-version-index', '15bfe8c35b66642b6c78ba60060fa8793bd2207a', '2026-09-28 19:13:59.439469');
INSERT INTO storage.migrations VALUES (68, 'bucket-lifecycle-configuration', '3c08f6f889922f399519722a932b51007c11bebc', '2026-09-28 19:13:59.44123');
INSERT INTO storage.migrations VALUES (69, 'validate-bucket-lifecycle-constraints', '4febacaaaa0e61e2b783bef081fe03a287e65eb3', '2026-09-28 19:13:59.483732');
INSERT INTO storage.migrations VALUES (70, 'list-objects-with-versions', '5c17c3777616cd8d7b18b82835525fa3205af57b', '2026-09-28 19:13:59.491712');
INSERT INTO storage.migrations VALUES (71, 'objects-delete-marker-index', '6d14858e66c66f8d6accf8a2630aefd1527fddba', '2026-09-28 19:13:59.55998');
INSERT INTO storage.migrations VALUES (72, 'drop-bucketid-objname-index', '302beb09e1b469d7d4db19566f2389d280b64aa3', '2026-09-28 19:13:59.588535');


--
-- Data for Name: objects; Type: TABLE DATA; Schema: storage; Owner: -
--



--
-- Data for Name: s3_multipart_uploads; Type: TABLE DATA; Schema: storage; Owner: -
--



--
-- Data for Name: s3_multipart_uploads_parts; Type: TABLE DATA; Schema: storage; Owner: -
--



--
-- Data for Name: vector_indexes; Type: TABLE DATA; Schema: storage; Owner: -
--



--
-- Data for Name: secrets; Type: TABLE DATA; Schema: vault; Owner: -
--



--
-- Name: refresh_tokens_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: -
--

SELECT pg_catalog.setval('auth.refresh_tokens_id_seq', 1, false);


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.categories_id_seq', 1, false);


--
-- Name: comments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.comments_id_seq', 1, false);


--
-- Name: contacts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.contacts_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: likes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.likes_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 13, true);


--
-- Name: posts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.posts_id_seq', 1, false);


--
-- Name: projects_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.projects_id_seq', 14, true);


--
-- Name: skills_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.skills_id_seq', 27, true);


--
-- Name: tags_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.tags_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 3, true);


--
-- Name: subscription_id_seq; Type: SEQUENCE SET; Schema: realtime; Owner: -
--

SELECT pg_catalog.setval('realtime.subscription_id_seq', 1, false);


--
-- PostgreSQL database dump complete
--

\unrestrict 9N9VDcbbkdUFuhr739FcCSUmIyrDPv57bb0pydGznkuVxqZjUh8YrQirypBeiaT

