--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3
-- Dumped by pg_dump version 15.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: city; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.city (
    id_city integer NOT NULL,
    name_city character varying(100),
    amount_views_city integer
);


ALTER TABLE public.city OWNER TO "user";

--
-- Name: city_id_city_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.city_id_city_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.city_id_city_seq OWNER TO "user";

--
-- Name: city_id_city_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.city_id_city_seq OWNED BY public.city.id_city;


--
-- Name: favorites; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.favorites (
    id_favorites integer NOT NULL,
    id_place integer,
    id_user integer
);


ALTER TABLE public.favorites OWNER TO "user";

--
-- Name: favorites_id_favorites_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.favorites_id_favorites_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.favorites_id_favorites_seq OWNER TO "user";

--
-- Name: favorites_id_favorites_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.favorites_id_favorites_seq OWNED BY public.favorites.id_favorites;


--
-- Name: flight; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.flight (
    id_flight integer NOT NULL,
    id_user integer,
    from_flight character varying(70),
    date_dep_flight timestamp without time zone,
    airline_flight character varying(70),
    time_taken_flight character varying(100),
    price integer,
    amount_stops integer,
    date_arr_flight timestamp without time zone,
    id_city integer,
    econom_class boolean
);


ALTER TABLE public.flight OWNER TO "user";

--
-- Name: flight_id_flight_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.flight_id_flight_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.flight_id_flight_seq OWNER TO "user";

--
-- Name: flight_id_flight_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.flight_id_flight_seq OWNED BY public.flight.id_flight;


--
-- Name: ml_request; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.ml_request (
    id_ml_request integer NOT NULL,
    price_request numeric,
    class_request character varying(255),
    position_request character varying(255),
    positionto_request character varying(255),
    amount_stops_request integer,
    date_arr_request timestamp without time zone,
    date_dep_request timestamp without time zone,
    id_user integer
);


ALTER TABLE public.ml_request OWNER TO "user";

--
-- Name: ml_request_history; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.ml_request_history (
    id_user integer,
    id_ml_request integer,
    view_date date,
    id_ml_history integer NOT NULL
);


ALTER TABLE public.ml_request_history OWNER TO "user";

--
-- Name: ml_request_history_id_ml_history_new_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.ml_request_history_id_ml_history_new_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ml_request_history_id_ml_history_new_seq OWNER TO "user";

--
-- Name: ml_request_history_id_ml_history_new_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.ml_request_history_id_ml_history_new_seq OWNED BY public.ml_request_history.id_ml_history;


--
-- Name: ml_request_history_id_ml_history_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.ml_request_history_id_ml_history_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ml_request_history_id_ml_history_seq OWNER TO "user";

--
-- Name: ml_request_id_ml_request_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.ml_request_id_ml_request_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ml_request_id_ml_request_seq OWNER TO "user";

--
-- Name: ml_request_id_ml_request_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.ml_request_id_ml_request_seq OWNED BY public.ml_request.id_ml_request;


--
-- Name: places; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.places (
    id_place integer NOT NULL,
    photo_place character varying(255),
    name_place character varying(1000) NOT NULL,
    url_place character varying(1000),
    favorites_count integer NOT NULL,
    id_city integer,
    desc_place character varying
);


ALTER TABLE public.places OWNER TO "user";

--
-- Name: places_id_place_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.places_id_place_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.places_id_place_seq OWNER TO "user";

--
-- Name: places_id_place_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.places_id_place_seq OWNED BY public.places.id_place;


--
-- Name: request_history; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.request_history (
    id_request_history integer NOT NULL,
    id_user integer,
    id_flight integer,
    view_date date
);


ALTER TABLE public.request_history OWNER TO "user";

--
-- Name: request_history_id_request_history_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.request_history_id_request_history_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.request_history_id_request_history_seq OWNER TO "user";

--
-- Name: request_history_id_request_history_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.request_history_id_request_history_seq OWNED BY public.request_history.id_request_history;


--
-- Name: users; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.users (
    id_user integer NOT NULL,
    full_name_user character varying(100) NOT NULL,
    email_user character varying(100) NOT NULL,
    password_user character varying(255) NOT NULL,
    role_user character varying(100) NOT NULL,
    photo_user character varying(100),
    news_mailing boolean NOT NULL,
    phone_user character varying(20),
    birth_user date,
    date_mail date
);


ALTER TABLE public.users OWNER TO "user";

--
-- Name: users_id_user_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.users_id_user_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_user_seq OWNER TO "user";

--
-- Name: users_id_user_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.users_id_user_seq OWNED BY public.users.id_user;


--
-- Name: city id_city; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.city ALTER COLUMN id_city SET DEFAULT nextval('public.city_id_city_seq'::regclass);


--
-- Name: favorites id_favorites; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites ALTER COLUMN id_favorites SET DEFAULT nextval('public.favorites_id_favorites_seq'::regclass);


--
-- Name: flight id_flight; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight ALTER COLUMN id_flight SET DEFAULT nextval('public.flight_id_flight_seq'::regclass);


--
-- Name: ml_request id_ml_request; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request ALTER COLUMN id_ml_request SET DEFAULT nextval('public.ml_request_id_ml_request_seq'::regclass);


--
-- Name: ml_request_history id_ml_history; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request_history ALTER COLUMN id_ml_history SET DEFAULT nextval('public.ml_request_history_id_ml_history_new_seq'::regclass);


--
-- Name: places id_place; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.places ALTER COLUMN id_place SET DEFAULT nextval('public.places_id_place_seq'::regclass);


--
-- Name: request_history id_request_history; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history ALTER COLUMN id_request_history SET DEFAULT nextval('public.request_history_id_request_history_seq'::regclass);


--
-- Name: users id_user; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.users ALTER COLUMN id_user SET DEFAULT nextval('public.users_id_user_seq'::regclass);


--
-- Data for Name: city; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.city (id_city, name_city, amount_views_city) FROM stdin;
2	Санкт-Петербург	80
3	Новосибирск	60
4	Екатеринбург	50
5	Нижний Новгород	40
6	Казань	45
7	Челябинск	35
8	Омск	30
9	Самара	55
10	Ростов-на-Дону	70
1	Москва	285
\.


--
-- Data for Name: favorites; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.favorites (id_favorites, id_place, id_user) FROM stdin;
10	14	2
12	24	2
\.


--
-- Data for Name: flight; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.flight (id_flight, id_user, from_flight, date_dep_flight, airline_flight, time_taken_flight, price, amount_stops, date_arr_flight, id_city, econom_class) FROM stdin;
14	2	Москва	2024-06-01 08:00:00	Aeroflot	2 часа	50000	0	2024-06-01 10:00:00	6	f
23	2	Москва	2024-06-10 15:00:00	Aeroflot	2 часа	50000	0	2024-06-10 17:00:00	2	f
24	3	Липецк	2024-05-31 00:00:00	Aeroflot	5 ч	30000	1	2024-06-02 12:00:00	1	t
18	6	Ростов-на-Дону	2024-06-05 09:00:00	Pobeda	2 часа	52000	0	2024-06-05 11:00:00	1	f
19	7	Москва	2024-06-06 11:00:00	Aeroflot	2 часа	51000	0	2024-06-06 13:00:00	5	t
20	8	Санкт-Петербург	2024-06-07 08:00:00	S7	5 часов	70000	2	2024-06-07 13:00:00	5	t
21	9	Москва	2024-06-08 10:00:00	Уральские авиалинии	4 часа	58000	1	2024-06-08 14:00:00	6	f
22	10	Екатеринбург	2024-06-09 13:00:00	S7	4 часа	57000	1	2024-06-09 17:00:00	1	t
1	2	Липецк	2024-05-31 00:00:00	S7	12 ч	15000	2	2024-05-31 00:00:00	5	t
2	3	Липецк	2024-05-31 00:00:00	S7	12 ч	15000	0	2024-05-31 00:00:00	1	t
3	2	Липецк	2024-05-31 00:00:00	S7	12 ч	15000	1	2024-05-31 00:00:00	2	f
15	3	Санкт-Петербург	2024-06-02 10:00:00	S7	2 часа	51000	0	2024-06-02 12:00:00	10	f
16	4	Новосибирск	2024-06-03 12:00:00	Уральские авиалинии	3 часа	55000	1	2024-06-03 15:00:00	4	t
17	5	Екатеринбург	2024-06-04 14:00:00	S7	3 часа	56000	1	2024-06-04 17:00:00	3	t
\.


--
-- Data for Name: ml_request; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.ml_request (id_ml_request, price_request, class_request, position_request, positionto_request, amount_stops_request, date_arr_request, date_dep_request, id_user) FROM stdin;
1	1500	Zero	Moscow	Bangadesh	1	2024-06-01 00:00:00	2024-05-31 00:00:00	2
\.


--
-- Data for Name: ml_request_history; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.ml_request_history (id_user, id_ml_request, view_date, id_ml_history) FROM stdin;
2	1	2024-06-01	1
3	1	2024-06-01	2
\.


--
-- Data for Name: places; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.places (id_place, photo_place, name_place, url_place, favorites_count, id_city, desc_place) FROM stdin;
14	\N	Красная площадь, Кремль, Большой театр	https://www.kreml.ru	1501	1	Исторические и архитектурные символы России, представляющие богатую культурную историю Москвы.
15	\N	Эрмитаж, Дворцовая площадь, Петропавловская крепость	https://www.hermitagemuseum.org	1200	2	Знаменитые музеи и исторические памятники, отражающие богатство культурного наследия Санкт-Петербурга.
16	\N	Зоопарк, Новосибирский музей краеведения, Новосибирская городская скульптура	https://nskzoo.ru	800	3	Интересные места и аттракции, предлагаемые к посещению в Новосибирске.
17	\N	Центральный парк культуры и отдыха им. В. В. Маяковского, Плотинка	https://www.ekatmuseum.ru	700	4	Зеленые зоны отдыха и культурные места в Екатеринбурге, привлекающие местных жителей и туристов.
18	\N	Кремль, Вечный огонь, Кладбище 90-й гвардейской дивизии	https://nnovgorod.net	600	5	Исторические места и памятники в Нижнем Новгороде, связанные с Великой Отечественной войной.
19	\N	Казанский кремль, Казанский университет, Музей натуральной истории	https://kzn.ru	500	6	Культурные и архитектурные объекты, являющиеся символами города Казани.
20	\N	Шатровая гора, Сузгун, Набережная Чебаркуля	https://chelmuseum.ru	450	7	Природные достопримечательности и зоны отдыха в Челябинске, популярные среди местных жителей и туристов.
21	\N	Парк имени 30-летия Победы, Парк культуры и отдыха Омский	https://omsktown.ru	400	8	Парки и зеленые зоны отдыха в Омске, предлагающие возможности для активного времяпрепровождения.
22	\N	Аквапарк "Акварель", Стадион "Самара-Арена", Зоопарк	https://www.samaratoday.ru	550	9	Развлекательные и культурные объекты в Самаре, привлекающие как местных жителей, так и туристов.
23	\N	Парк Горького, Заповедник "Ростовский", Парк Активного Отдыха "Зеленый Остров"	https://www.visitrostovregion.ru	900	10	Парки и природные зоны отдыха в Ростове-на-Дону, предлагающие возможности для отдыха и активного времяпрепровождения.
24	\N	Парк Горького, Третьяковская галерея, ВДНХ	https://www.mosgorpark.ru	1300	1	Парк Горького - центральный парк культуры и отдыха, Третьяковская галерея - главный музей русского изобразительного искусства, ВДНХ - выставочный центр с множеством павильонов и аттракционов.
\.


--
-- Data for Name: request_history; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.request_history (id_request_history, id_user, id_flight, view_date) FROM stdin;
1	2	1	2024-05-31
2	2	14	2024-05-31
3	3	15	2024-05-31
4	4	16	2024-05-31
5	5	17	2024-05-31
6	6	18	2024-05-31
7	7	19	2024-05-31
8	8	20	2024-05-31
9	9	21	2024-05-31
10	10	22	2024-05-31
11	11	23	2024-05-31
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.users (id_user, full_name_user, email_user, password_user, role_user, photo_user, news_mailing, phone_user, birth_user, date_mail) FROM stdin;
10	Ольга Попова	olga@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
11	Сергей Васильев	sergey@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
12	Анна Соколова	anna@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
13	Дмитрий Михайлов	dmitry@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
14	Екатерина Новикова	ekaterina@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
15	Дьяков Дмитрий Владимирович	example@bk.ru	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
3	Кретов Игорь Олегович	knigor1337@gmail.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	2024-05-31
4	Толстунов Владимир Дмитриевич	r.vladimir.tolstunov@gmail.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	2024-05-31
5	Иван Иванов	ivan@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
6	Мария Петрова	maria@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
7	Александр Сидоров	alex@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
8	Елена Смирнова	elena@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
9	Андрей Кузнецов	andrey@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
2	НеБолдырев Максим Романович	maxrox1904@gmail.com	307fd56085a6ed891cfb2c38276d7853b122968754378f1153e0127f3a764a0f	user	/20240531194345.jpg	t	9802695322	1990-01-01	2024-05-31
\.


--
-- Name: city_id_city_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.city_id_city_seq', 20, true);


--
-- Name: favorites_id_favorites_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.favorites_id_favorites_seq', 12, true);


--
-- Name: flight_id_flight_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.flight_id_flight_seq', 24, true);


--
-- Name: ml_request_history_id_ml_history_new_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.ml_request_history_id_ml_history_new_seq', 2, true);


--
-- Name: ml_request_history_id_ml_history_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.ml_request_history_id_ml_history_seq', 1, false);


--
-- Name: ml_request_id_ml_request_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.ml_request_id_ml_request_seq', 1, true);


--
-- Name: places_id_place_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.places_id_place_seq', 24, true);


--
-- Name: request_history_id_request_history_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.request_history_id_request_history_seq', 11, true);


--
-- Name: users_id_user_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.users_id_user_seq', 15, true);


--
-- Name: city city_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.city
    ADD CONSTRAINT city_pkey PRIMARY KEY (id_city);


--
-- Name: ml_request_history ml_request_history_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request_history
    ADD CONSTRAINT ml_request_history_pkey PRIMARY KEY (id_ml_history);


--
-- Name: ml_request ml_request_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request
    ADD CONSTRAINT ml_request_pkey PRIMARY KEY (id_ml_request);


--
-- Name: favorites pk_favorites; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT pk_favorites PRIMARY KEY (id_favorites);


--
-- Name: flight pk_flight; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight
    ADD CONSTRAINT pk_flight PRIMARY KEY (id_flight);


--
-- Name: places pk_places; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.places
    ADD CONSTRAINT pk_places PRIMARY KEY (id_place);


--
-- Name: request_history pk_request_history; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history
    ADD CONSTRAINT pk_request_history PRIMARY KEY (id_request_history);


--
-- Name: users pk_users; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT pk_users PRIMARY KEY (id_user);


--
-- Name: also_has_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX also_has_fk ON public.flight USING btree (id_user);


--
-- Name: are_included_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX are_included_fk ON public.favorites USING btree (id_place);


--
-- Name: favorites_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX favorites_pk ON public.favorites USING btree (id_favorites);


--
-- Name: flight_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX flight_pk ON public.flight USING btree (id_flight);


--
-- Name: has_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX has_fk ON public.request_history USING btree (id_user);


--
-- Name: have_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX have_fk ON public.favorites USING btree (id_user);


--
-- Name: include_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX include_fk ON public.request_history USING btree (id_flight);


--
-- Name: places_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX places_pk ON public.places USING btree (id_place);


--
-- Name: request_history_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX request_history_pk ON public.request_history USING btree (id_request_history);


--
-- Name: user_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX user_pk ON public.users USING btree (id_user);


--
-- Name: favorites fk_favorite_are_inclu_places; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT fk_favorite_are_inclu_places FOREIGN KEY (id_place) REFERENCES public.places(id_place) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: favorites fk_favorite_have_users; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT fk_favorite_have_users FOREIGN KEY (id_user) REFERENCES public.users(id_user) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: flight fk_flight_also_has_users; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight
    ADD CONSTRAINT fk_flight_also_has_users FOREIGN KEY (id_user) REFERENCES public.users(id_user) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: ml_request_history fk_ml_request_history_ml_request; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request_history
    ADD CONSTRAINT fk_ml_request_history_ml_request FOREIGN KEY (id_ml_request) REFERENCES public.ml_request(id_ml_request) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: ml_request_history fk_ml_request_history_user; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request_history
    ADD CONSTRAINT fk_ml_request_history_user FOREIGN KEY (id_user) REFERENCES public.users(id_user) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: request_history fk_request__has_users; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history
    ADD CONSTRAINT fk_request__has_users FOREIGN KEY (id_user) REFERENCES public.users(id_user) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: request_history fk_request__include_flight; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history
    ADD CONSTRAINT fk_request__include_flight FOREIGN KEY (id_flight) REFERENCES public.flight(id_flight) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: flight flight_id_city_fkey; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight
    ADD CONSTRAINT flight_id_city_fkey FOREIGN KEY (id_city) REFERENCES public.city(id_city);


--
-- Name: ml_request ml_request_id_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request
    ADD CONSTRAINT ml_request_id_user_fkey FOREIGN KEY (id_user) REFERENCES public.users(id_user);


--
-- Name: places places_id_city_fkey; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.places
    ADD CONSTRAINT places_id_city_fkey FOREIGN KEY (id_city) REFERENCES public.city(id_city);


--
-- PostgreSQL database dump complete
--

