--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2 (Debian 16.2-1.pgdg120+2)
-- Dumped by pg_dump version 16.2 (Debian 16.2-1.pgdg120+2)

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
-- Name: product_types; Type: TABLE; Schema: public; Owner: us_postgres
--

CREATE TABLE public.product_types (
    id bigint NOT NULL,
    tax_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(500),
    prefix character varying(10),
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.product_types OWNER TO us_postgres;

--
-- Name: product_types_id_seq; Type: SEQUENCE; Schema: public; Owner: us_postgres
--

CREATE SEQUENCE public.product_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.product_types_id_seq OWNER TO us_postgres;

--
-- Name: product_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: us_postgres
--

ALTER SEQUENCE public.product_types_id_seq OWNED BY public.product_types.id;


--
-- Name: products; Type: TABLE; Schema: public; Owner: us_postgres
--

CREATE TABLE public.products (
    id bigint NOT NULL,
    product_type_id bigint NOT NULL,
    code character varying(50) NOT NULL,
    name character varying(255) NOT NULL,
    valor numeric(10,2) NOT NULL,
    description character varying(500),
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.products OWNER TO us_postgres;

--
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: us_postgres
--

CREATE SEQUENCE public.products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_id_seq OWNER TO us_postgres;

--
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: us_postgres
--

ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;


--
-- Name: taxes; Type: TABLE; Schema: public; Owner: us_postgres
--

CREATE TABLE public.taxes (
    id bigint NOT NULL,
    percent numeric(5,2) NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(500),
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.taxes OWNER TO us_postgres;

--
-- Name: taxes_id_seq; Type: SEQUENCE; Schema: public; Owner: us_postgres
--

CREATE SEQUENCE public.taxes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.taxes_id_seq OWNER TO us_postgres;

--
-- Name: taxes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: us_postgres
--

ALTER SEQUENCE public.taxes_id_seq OWNED BY public.taxes.id;


--
-- Name: transaction_items; Type: TABLE; Schema: public; Owner: us_postgres
--

CREATE TABLE public.transaction_items (
    id bigint NOT NULL,
    transaction_id bigint NOT NULL,
    product_id bigint NOT NULL,
    quantity integer NOT NULL,
    subtotal numeric(10,2) NOT NULL,
    total numeric(10,2) NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.transaction_items OWNER TO us_postgres;

--
-- Name: transaction_items_id_seq; Type: SEQUENCE; Schema: public; Owner: us_postgres
--

CREATE SEQUENCE public.transaction_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.transaction_items_id_seq OWNER TO us_postgres;

--
-- Name: transaction_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: us_postgres
--

ALTER SEQUENCE public.transaction_items_id_seq OWNED BY public.transaction_items.id;


--
-- Name: transactions; Type: TABLE; Schema: public; Owner: us_postgres
--

CREATE TABLE public.transactions (
    id bigint NOT NULL,
    total numeric(10,2) NOT NULL,
    total_tax numeric(10,2) NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.transactions OWNER TO us_postgres;

--
-- Name: transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: us_postgres
--

CREATE SEQUENCE public.transactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.transactions_id_seq OWNER TO us_postgres;

--
-- Name: transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: us_postgres
--

ALTER SEQUENCE public.transactions_id_seq OWNED BY public.transactions.id;


--
-- Name: product_types id; Type: DEFAULT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.product_types ALTER COLUMN id SET DEFAULT nextval('public.product_types_id_seq'::regclass);


--
-- Name: products id; Type: DEFAULT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);


--
-- Name: taxes id; Type: DEFAULT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.taxes ALTER COLUMN id SET DEFAULT nextval('public.taxes_id_seq'::regclass);


--
-- Name: transaction_items id; Type: DEFAULT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.transaction_items ALTER COLUMN id SET DEFAULT nextval('public.transaction_items_id_seq'::regclass);


--
-- Name: transactions id; Type: DEFAULT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.transactions ALTER COLUMN id SET DEFAULT nextval('public.transactions_id_seq'::regclass);


--
-- Data for Name: product_types; Type: TABLE DATA; Schema: public; Owner: us_postgres
--

COPY public.product_types (id, tax_id, name, description, prefix, created_at, updated_at, deleted_at) FROM stdin;
1	1	Motor	Peças relacionadas ao motor do veículo	MT	2024-05-07 04:20:39.906247	\N	\N
2	2	Transmissão	Peças relacionadas à transmissão do veículo	TR	2024-05-07 04:20:39.906247	\N	\N
3	1	Suspensão	Peças relacionadas à suspensão do veículo	PC	2024-05-07 04:20:39.906247	\N	\N
4	2	Freios	Peças relacionadas ao sistema de freios do veículo	PC	2024-05-07 04:20:39.906247	\N	\N
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: us_postgres
--

COPY public.products (id, product_type_id, code, name, valor, description, created_at, updated_at, deleted_at) FROM stdin;
1	1	ENG001	Filtro de Óleo	50.00	Filtro de óleo para motor	2024-05-07 04:20:39.906247	\N	\N
2	1	ENG002	Vela de Ignição	30.00	Vela de ignição para motor	2024-05-07 04:20:39.906247	\N	\N
3	1	ENG003	Correia Dentada	80.00	Correia dentada para motor	2024-05-07 04:20:39.906247	\N	\N
4	1	ENG004	Bomba de Água	120.00	Bomba de água para motor	2024-05-07 04:20:39.906247	\N	\N
5	2	TRANS001	Embreagem	200.00	Embreagem para transmissão	2024-05-07 04:20:39.906247	\N	\N
6	2	TRANS002	Câmbio Automático	1500.00	Câmbio automático para transmissão	2024-05-07 04:20:39.906247	\N	\N
7	3	SUSP001	Amortecedor	150.00	Amortecedor para suspensão	2024-05-07 04:20:39.906247	\N	\N
8	3	SUSP002	Mola	80.00	Mola para suspensão	2024-05-07 04:20:39.906247	\N	\N
9	4	BRAKES001	Pastilhas de Freio	70.00	Pastilhas de freio para sistema de freios	2024-05-07 04:20:39.906247	\N	\N
10	4	BRAKES002	Disco de Freio	100.00	Disco de freio para sistema de freios	2024-05-07 04:20:39.906247	\N	\N
\.


--
-- Data for Name: taxes; Type: TABLE DATA; Schema: public; Owner: us_postgres
--

COPY public.taxes (id, percent, name, description, created_at, updated_at, deleted_at) FROM stdin;
1	18.50	IVA	Imposto sobre Valor Agregado	2024-05-07 04:20:39.906247	\N	\N
2	5.00	ISS	Imposto sobre Serviços	2024-05-07 04:20:39.906247	\N	\N
3	15.00	IRPF	Imposto de Renda Pessoa Física	2024-05-07 04:20:39.906247	\N	\N
\.


--
-- Data for Name: transaction_items; Type: TABLE DATA; Schema: public; Owner: us_postgres
--

COPY public.transaction_items (id, transaction_id, product_id, quantity, subtotal, total, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: transactions; Type: TABLE DATA; Schema: public; Owner: us_postgres
--

COPY public.transactions (id, total, total_tax, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Name: product_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: us_postgres
--

SELECT pg_catalog.setval('public.product_types_id_seq', 4, true);


--
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: us_postgres
--

SELECT pg_catalog.setval('public.products_id_seq', 10, true);


--
-- Name: taxes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: us_postgres
--

SELECT pg_catalog.setval('public.taxes_id_seq', 3, true);


--
-- Name: transaction_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: us_postgres
--

SELECT pg_catalog.setval('public.transaction_items_id_seq', 1, false);


--
-- Name: transactions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: us_postgres
--

SELECT pg_catalog.setval('public.transactions_id_seq', 1, false);


--
-- Name: product_types product_types_pkey; Type: CONSTRAINT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.product_types
    ADD CONSTRAINT product_types_pkey PRIMARY KEY (id);


--
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- Name: taxes taxes_pkey; Type: CONSTRAINT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.taxes
    ADD CONSTRAINT taxes_pkey PRIMARY KEY (id);


--
-- Name: transaction_items transaction_items_pkey; Type: CONSTRAINT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.transaction_items
    ADD CONSTRAINT transaction_items_pkey PRIMARY KEY (id);


--
-- Name: transactions transactions_pkey; Type: CONSTRAINT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.transactions
    ADD CONSTRAINT transactions_pkey PRIMARY KEY (id);


--
-- Name: products product_types_product_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT product_types_product_type_id_foreign FOREIGN KEY (product_type_id) REFERENCES public.product_types(id);


--
-- Name: transaction_items products_product_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.transaction_items
    ADD CONSTRAINT products_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.products(id);


--
-- Name: product_types taxes_product_tax_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.product_types
    ADD CONSTRAINT taxes_product_tax_id_foreign FOREIGN KEY (tax_id) REFERENCES public.taxes(id);


--
-- Name: transaction_items transactions_transaction_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: us_postgres
--

ALTER TABLE ONLY public.transaction_items
    ADD CONSTRAINT transactions_transaction_id_foreign FOREIGN KEY (transaction_id) REFERENCES public.transactions(id);


--
-- PostgreSQL database dump complete
--

