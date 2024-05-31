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
    to_flight character varying(70),
    date_flight date,
    airline_flight character varying(70),
    time_taken_flight character varying(100),
    price_flight money
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
-- Name: places; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.places (
    id_place integer NOT NULL,
    id_flight integer,
    photo_place character varying(255) NOT NULL,
    desc_place character varying(1000) NOT NULL,
    url_place character varying(1000),
    favorites_count integer NOT NULL
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
-- Name: favorites id_favorites; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites ALTER COLUMN id_favorites SET DEFAULT nextval('public.favorites_id_favorites_seq'::regclass);


--
-- Name: flight id_flight; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight ALTER COLUMN id_flight SET DEFAULT nextval('public.flight_id_flight_seq'::regclass);


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
-- Data for Name: favorites; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.favorites (id_favorites, id_place, id_user) FROM stdin;
\.


--
-- Data for Name: flight; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.flight (id_flight, id_user, from_flight, to_flight, date_flight, airline_flight, time_taken_flight, price_flight) FROM stdin;
\.


--
-- Data for Name: places; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.places (id_place, id_flight, photo_place, desc_place, url_place, favorites_count) FROM stdin;
\.


--
-- Data for Name: request_history; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.request_history (id_request_history, id_user, id_flight, view_date) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.users (id_user, full_name_user, email_user, password_user, role_user, photo_user, news_mailing, phone_user, birth_user, date_mail) FROM stdin;
2	Болдырев Максим Романович	yaz678@bk.ru	5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5	user	krutoi	t	\N	\N	2024-05-31
3	Кретов Игорь Олегович	knigor1337@gmail.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	ne krutoi	t	\N	\N	2024-05-31
\.


--
-- Name: favorites_id_favorites_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.favorites_id_favorites_seq', 1, false);


--
-- Name: flight_id_flight_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.flight_id_flight_seq', 1, false);


--
-- Name: places_id_place_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.places_id_place_seq', 1, false);


--
-- Name: request_history_id_request_history_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.request_history_id_request_history_seq', 1, false);


--
-- Name: users_id_user_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.users_id_user_seq', 3, true);


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
-- Name: consider_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX consider_fk ON public.places USING btree (id_flight);


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
-- Name: places fk_places_consider_flight; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.places
    ADD CONSTRAINT fk_places_consider_flight FOREIGN KEY (id_flight) REFERENCES public.flight(id_flight) ON UPDATE RESTRICT ON DELETE RESTRICT;


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
-- PostgreSQL database dump complete
--

